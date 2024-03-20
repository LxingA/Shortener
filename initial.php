<?php
/*
@author LxingA
@project CodeInk
@name Shortener
@date 26/02/24 11:00PM
@description Verificación de Integridad de la Inicialización de la Aplicación
*/
if(!file_exists(__DIR__."/vendor")) exit(Shortener\Handler\structure(message:"No se encontró la carpeta con las dependencias esenciales para la aplicación",case:5));
elseif(version_compare(PHP_VERSION,"8.0.0","<")) exit(\Shortener\Handler\structure(message:"La versión actual que está ejecutando es la versión \"".PHP_VERSION."\" y se requiere de una versión superior a la versión \"8.0.0\"",case:5));
elseif(!extension_loaded("curl")) exit(\Shortener\Handler\structure(message:"Para ejecutar la aplicación se requiere del módulo PHP \"cURL\" para realizar las peticiones a la API Global del Proyecto",case:5));
elseif(!file_exists(__DIR__."/cache")) exit(\Shortener\Handler\structure(message:"No se encontró la carpeta para el almacenamiento de los archivo en cache de la aplicación",case:5));
?>