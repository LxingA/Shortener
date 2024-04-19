<?php
/*
@author LxingA
@project CodeInk
@name Shortener
@date 17/03/24 03:00AM
@description Definición de los Componentes HTML de la Cabecera para la Plantilla Global de la Aplicación
*/

/** Componente Global para la Cabecera de la Aplicación */
function html_component_header(): string {
    global $object_global_application;
    $endpoint_asset = $object_global_application["endpoint"]["asset"];
    $cdn_key = $_ENV["CkEnvironmentParamURLCDNCacheID"];
    $base = <<<EOF
    <header class="p-3 text-bg-dark">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <a href="./" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                    <img class="bi me-2" src="$endpoint_asset/logo.webp?v=$cdn_key" width="48" alt="Logotipo Oficial"/>
                </a>
                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0"></ul>
                <div class="text-end">
                    <button type="button" class="btn btn-outline-light me-2" id="cksh_button_theme">
                        <i class="fa-regular fa-sun"></i>
                    </button>
                </div>
            </div>
        </div>
    </header>
    EOF;return $base;
}
?>