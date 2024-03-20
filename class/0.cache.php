<?php
/*
@author LxingA
@project CodeInk
@name Shortener
@date 16/03/24 11:00PM
@description Implementación de la Clase para la Definción del Sistema Cache en la Aplicación
*/
namespace Shortener\Cache;
define("CACHE_DIR_LOCAL",__DIR__. DIRECTORY_SEPARATOR .".." . DIRECTORY_SEPARATOR . "cache");
define("CACHE_FILE_SUFFIX","%s_%s.ckc");

/** Clase para el Acceso al Cache Local de la Aplicación */
class Main {
    static private string $suffix;
    static private string $context;
    function __construct(string $sufix, string $context = "json"){
        self::$suffix = $sufix;
        self::$context = $context;
    }
    /** Función Esencial para la Verificación del Entorno para el Cache */
    static private function check(){
        $__context = [
            "code" => 5,
            "context" => __CLASS__ . "\\" . __FUNCTION__
        ];
        try{
            if(!file_exists(CACHE_DIR_LOCAL)) throw new \Shortener\Handler\Error(...$__context,message:"El directorio para la creación de los archivos en cache, no existe");
            elseif(!is_dir(CACHE_DIR_LOCAL)) throw new \Shortener\Handler\Error(...$__context,message:"El directorio que supuestamente es un directorio para el almacenamiento de los archivos en cache, no es un directorio");
            elseif(!is_writable(CACHE_DIR_LOCAL)) throw new \Shortener\Handler\Error(...$__context,message:"El directorio con los archivos para el almacenaje en cache, no tiene permisos de escritura");
            elseif(!is_readable(CACHE_DIR_LOCAL)) throw new \Shortener\Handler\Error(...$__context,message:"El directorio con los archivos para el almacenaje en cache, no tiene permisos de lectura");
        }catch(\Shortener\Handler\Error $error){
            exit($error->getMessage());
        }
    }
    /** Crear el Dato Solicitado en Cache Local */
    static public function set(string $name, mixed $value): void {
        self::check();
        $filename = md5(sprintf(CACHE_FILE_SUFFIX,self::$suffix,$name));
        switch(self::$context){
            case "json":
                $file_content_define = json_encode(serialize($value));
            break;
        }$file = fopen(CACHE_DIR_LOCAL.DIRECTORY_SEPARATOR.$filename,"w") or die("No se pudo crear el archivo $filename debido a un error en la ejecución de creación...");
        fwrite($file,$file_content_define) or die("Hubo un error a realizar la escritura de la información del contexto " . self::$context . "solicitado...");
        fclose($file);
    }
    /** Verificar mediante un Nombre de Archivo la Existencia de Cache de lo Solicitado */
    static public function has(string $name): bool {
        self::check();
        $filename = md5(sprintf(CACHE_FILE_SUFFIX,self::$suffix,$name));
        if(!is_file(CACHE_DIR_LOCAL.DIRECTORY_SEPARATOR.$filename)) return false;
        elseif(!file_exists(CACHE_DIR_LOCAL.DIRECTORY_SEPARATOR.$filename)) return false;
        else return true;
    }
    /** Obtener el Valor Guardado en Cache del Archivo Solicitado */
    static public function get(string $name): mixed {
        self::check();
        $filename = md5(sprintf(CACHE_FILE_SUFFIX,self::$suffix,$name));
        if(self::has($name))switch(self::$context){
            case "json":
                return unserialize(json_decode((@file_get_contents(CACHE_DIR_LOCAL.DIRECTORY_SEPARATOR.$filename)),true));
            default:
                return NULL;
        }else return NULL;
    }
}
?>