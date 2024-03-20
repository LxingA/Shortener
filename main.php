<?php
/*
@author LxingA
@project CodeInk
@name Shortener
@date 25/02/24 07:20PM
@description Configuración Inicial del Proyecto 
*/
error_reporting(0);
date_default_timezone_set("America/Monterrey");
require_once(__DIR__."/vendor/autoload.php");

/** Inicializar la Carga de las Clases Esenciales para el Funcionamiento de la Aplicación */
foreach(glob(__DIR__."/class/*") as $class) include($class);

/** Verificar la Integridad de la Aplicación */
include_once(__DIR__."/initial.php");

/** Cargar las Variables de Entorno de la Aplicación */
Dotenv\Dotenv::createImmutable(__DIR__)->load();

/** Obtener la Información Global de la Aplicación */
$object_global_application = (new \Shortener\API\Main("GET"))::request("/v1/global",["context"=>"service"]);

/** Cargar Todos los Módulos Esenciales para la Plantilla HTML de la Aplicación */
foreach(glob(__DIR__."/modules/html.*.php") as $module) include($module);

require_once(__DIR__."/html.php");
?>