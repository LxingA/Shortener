<?php
/*
@author LxingA
@project CodeInk
@name Shortener
@date 16/03/24 04:00AM
@description Implementación de la Clase para los Métodos a la API Global del Proyecto
*/
namespace Shortener\API;

/** Clase Esencial para el Acceso a la API Global */
class Main extends \Shortener\Fetch\Main {
    static private string $method;
    static private array $headers = [];
    function __construct(string $method, array $headers = []){
        self::$headers = ["X-CKeyP-H" => $_ENV["CkEnvironmentParamURLApplicationID"],...$headers];
        self::$method = $method;
        parent::__construct($_ENV["CkEnvironmentParamURLEndPointAPI"],self::$method,self::$headers);
    }
    /** Método GET para la Obtención de Información a la API */
    final static public function request(string $path, array $query = []): array {
        $define_name_cache = preg_replace("/\//","_",$path) . "_" . hash("crc32b",(json_encode($query)));
        $cache_instance_define = new \Shortener\Cache\Main("api");
        if($cache_instance_define::has($define_name_cache)) return $cache_instance_define::get($define_name_cache);
        else{
            $get_value_request = json_decode(parent::__init__($path,$query),true);
            (self::$method != "PUT" && self::$method != "POST") && $cache_instance_define::set($define_name_cache,$get_value_request);
            return $get_value_request;
        }
    }
}
?>