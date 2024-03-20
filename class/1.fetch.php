<?php
/*
@author LxingA
@project CodeInk
@name Shortener
@date 27/02/24 04:00PM
@description Implementación de la Clase para el Fetcher Personalizado para la Conexión a la API de la Aplicación
*/
namespace Shortener\Fetch;
use CurlHandle;

/** Clase Principal para la Implementación del Fetcher */
class Main {
    static private string $url = "";
    static private string $method = "";
    static private array $headers = [];
    /** Inicialización de la Clase */
    function __construct(string $url, string $method, array $headers = []){
        self::$url = $url;
        self::$method = $method;
        self::$headers = $headers;
    }
    /** 
     * Función Esencial para la Inicialización del Fetcher
     */
    protected static function __init__(string $path, array $query = []): bool | string {
        $instance = curl_init();
        try{
            self::__option__(client: $instance, parameters: [
                "method_http" => strtolower(self::$method),
                "http_uri" => self::$url,
                "header_container" => self::$headers,
                "params_container" => $query,
                "http_path" => $path
            ]);
            if($execute = curl_exec($instance)) return $execute;
            else throw new \Shortener\Handler\Error(message:"Hubo un error a realizar la consulta HTTP con el siguiente mensaje \"" . curl_error($instance) . "\"",context:__CLASS__ . "\\" . __FUNCTION__,code:5);
        }catch(\Shortener\Handler\Error $error){
            curl_close($instance);
            exit($error->__toString());
        }
    }
    /** Función Esencial para la Inicialización de la Configuración del Fetcher 
     * @param CurlHandle $client Referencía al Cliente del Fetcher a Alterar
     * @param array $parameters Contenedor con Todas las Opciones Variantes a la Alteración del Cliente Fetcher
     * @var $parameters[method_http] string, required Método HTTP a realizar en la petición a la API
     * @var $parameters[http_uri] string, required Ruta Absoluta HTTP de la API
     * @var $parameters[header_container] array Contenedor con las Cabeceras Esenciales para la Petición a la API
     * @var $parameters[params_container] array Contenedor con los Argumentos Adicionales para la Petición a la API
    */
    private static function __option__(CurlHandle &$client, array $parameters = []): void {
        $__context__ = [
            "context" => __CLASS__ . "\\" . __FUNCTION__,
            "code" => 5
        ];
        try{
            if(gettype($parameters) != "array" || empty($parameters) || !is_array($parameters) || !isset($parameters)) throw new \Shortener\Handler\Error(...$__context__,message:"El tipo de dato del contenedor con los parámetros es invalido o se encuentra vacío");
            else{
                $important_keys = (array)["method_http"=>"method_http","http_uri"=>"http_uri","header_container"=>"header_container","params_container"=>"params_container","http_path"=>"http_path"];
                foreach($parameters as $key => $value){
                    if(array_key_exists($key,$important_keys)) switch($key){
                        case "method_http":
                            $method_allowed_http = ["get" => NULL,"post" => NULL,"delete" => NULL,"put" => NULL];
                            if(gettype($value) != "string") throw new \Shortener\Handler\Error(...$__context__,message:"El método HTTP a establecer en la consulta, no cumple con el tipo de dato");
                            elseif(empty($value)) throw new \Shortener\Handler\Error(...$__context__,message:"No se ha especificado un método HTTP para realizar la petición solicitada");
                            elseif(!array_key_exists($value,$method_allowed_http)) throw new \Shortener\Handler\Error(...$__context__,message:"El método HTTP \"$value\" no se encuentra en la lista de los métodos permitidos");
                            elseif(!preg_match(flags:PREG_UNMATCHED_AS_NULL,subject:$value,pattern:"/[a-z]+/")) throw new \Shortener\Handler\Error(...$__context__,message:"El método HTTP no tiene un formato valído");
                            else curl_setopt($client,CURLOPT_CUSTOMREQUEST,strtoupper($value));
                        break;
                        case "http_uri":
                            if(gettype($value) != "string") throw new \Shortener\Handler\Error(...$__context__,message:"La dirección HTTP absoluta para la conexión al punto final no cuenta con un tipo de dato valído");
                            elseif(!preg_match(pattern:"/http(s)?\:\/\/((localhost\:([0-9]{3,4})|([a-z]+\.)?([a-z]+)\.([a-z]){2,3})(\.([a-z]){2,3})?)\/?/",flags:PREG_UNMATCHED_AS_NULL,subject:$value)) throw new \Shortener\Handler\Error(...$__context__,message:"La dirección HTTP absoluta no cumple con el formato establecido");
                            elseif(empty($value)) throw new \Shortener\Handler\Error(...$__context__,message:"No se ha especificado una dirección HTTP absoluta para realizar las peticiones");
                        break;
                        case "header_container":
                            if(!is_array($value) || gettype($value) != "array") throw new \Shortener\Handler\Error(...$__context__,message:"El contenedor con las cabeceras para la solicitud no cumple con el tipo de dato valído");
                        break;
                        case "params_container":
                            if(!is_array($value) || gettype($value) != "array") throw new \Shortener\Handler\Error(...$__context__,message:"El contenedor con los parámetros adicionales para la consulta de la petición no es un contenedor valído");
                        break;
                        case "http_path":
                            if(empty($value) || strlen($value) == 0) throw new \Shortener\Handler\Error(...$__context__,message:"La ruta relativa para la petición a la API no se ha especificado");
                        break;
                    }else throw new \Shortener\Handler\Error(...$__context__,message:"El argumento \"$key\" no existe en el contexto de la configuración del fetcher");
                }
                $defined_array_headers = array("Content-Type: application/json");
                $defiend_array_values = [array_keys($parameters[$important_keys["header_container"]]),array_values($parameters[$important_keys["header_container"]])];
                for($v = 0; $v <= (count($defiend_array_values[0]) - 1); $v++) $defined_array_headers[] = $defiend_array_values[0][$v] . ": " . $defiend_array_values[1][$v];
                curl_setopt($client,CURLOPT_HTTPHEADER,$defined_array_headers);
                curl_setopt($client,CURLOPT_RETURNTRANSFER,true);
                $current_requested_uri = $parameters[$important_keys["http_uri"]] . $parameters[$important_keys["http_path"]];
                if(array_key_exists($important_keys["params_container"],$parameters)) switch(strtoupper($parameters[$important_keys["method_http"]])){
                    case "POST": case "PUT":
                        curl_setopt($client,CURLOPT_POSTFIELDS,json_encode($parameters[$important_keys["params_container"]]));
                    break;
                    default:
                        $defined_string_query_params = "";
                        $defined_container_params_array = [array_keys($parameters[$important_keys["params_container"]]),array_values($parameters[$important_keys["params_container"]])];
                        for($y = 0; $y <= (count($parameters[$important_keys["params_container"]]) - 1); $y++){
                            $current_value = $defined_container_params_array[1][$y];
                            $current_key = $defined_container_params_array[0][$y];
                            if(gettype($current_value) == "array") $current_value = json_encode($current_value);
                            else $current_value = strval($current_value);
                            if($y == 0) $defined_string_query_params .= "?$current_key=$current_value";
                            elseif($y <= intval((count($parameters[$important_keys["params_container"]]) - 1))) $defined_string_query_params .= "&$current_key=$current_value";
                            else $defined_string_query_params .= "&$current_key=$current_value";
                        }
                        $current_requested_uri .= $defined_string_query_params;
                    break;
                }
                curl_setopt($client,CURLOPT_URL,$current_requested_uri);
                curl_setopt($client,CURLOPT_SSL_VERIFYHOST,0);
                curl_setopt($client,CURLOPT_SSL_VERIFYPEER,0);
                curl_setopt($client,CURLOPT_FRESH_CONNECT,0);
            }
        }catch(\Shortener\Handler\Error $error){
            exit($error->__toString());
        }
    }
}
?>