<?php
/*
@author LxingA
@project CodeInk
@name Shortener
@date 13/04/24 10:00PM
@description Definición de la API Local para la Petición con el Cliente de la Aplicación
*/
require_once(__DIR__ . "/../main.php");

/** Definición de la Función para Retonar el Objeto en Formato JSON */
function SEND(array $object = [], bool $state, string $message, int $status = 400): string {
    http_response_code($status);
    return json_encode([
        "state" => $state,
        "message" => $message,
        "timeline" => time(),
        "response" => $object,
        "identified" => uniqid()
    ]);
}

if(isset($_GET["context"]))switch($_GET["context"]){
    case "check_exists_user":
        echo "ok";
    break;
    default:
        echo SEND(state:false,message:"El contexto \"" . $_GET["context"] . "\" no existe en el Contexto de la API Local",object:[],status:404);
    break;
}else echo SEND(state:false,message:"No se ha especificado un contexto para la petición",object:[],status:404);
?>