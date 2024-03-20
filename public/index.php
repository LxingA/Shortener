<?php
/*
@author LxingA
@project CodeInk
@name Shortener
@date 25/02/24 08:00PM
@description Inicialización de la Aplicación en el Contexto DOM
*/
require_once(__DIR__."/../main.php");
$define_header_global = html_component_header();
$define_footer_global = html_component_footer();
$endpoint_asset = $object_global_application["endpoint"]["asset"];
$endpoint_shortener = $object_global_application["endpoint"]["shortener"];
$cdn_key = $_ENV["CkEnvironmentParamURLCDNCacheID"];
$application_name = $object_global_application["name"];
$application_slogan = $object_global_application["slogan"];
$application_identified = $object_global_application["identified"];
$application_last_identified = explode("-",$application_identified)[1];
$project_name = $object_global_application["project"]["name"];
$project_email = $object_global_application["project"]["mail"];
if(isset($_GET["key"]) && !empty($_GET["key"]))switch($_GET["key"]){
    default:
        $current_key_shortener = $_GET["key"];
        $check = (new \Shortener\API\Main("GET"))::request("/v1/".$application_last_identified,["context"=>"link","key"=>$current_key_shortener]);
        if($check["\$st$"]){
            $short_link_content = $check["\$rs$"][0];
            (new \Shortener\API\Main("PUT"))::request("/v1/".$application_last_identified,["context"=>"link","action"=>"increment_view","key"=>$current_key_shortener,"current_value"=>$short_link_content["view"]]);
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: " . $short_link_content["uri"]);
        }else print_r(html_template(title:"Enlace no Encontrado",render:<<<EOF
        $define_header_global
        <div class="px-4 my-4 text-center border-bottom">
            <h1 class="display-4 fw-bold text-body-emphasis">
                Enlace no Encontrado
            </h1>
            <div class="col-lg-6 mx-auto">
                <p class="lead mb-4">
                    Lo sentimos, el enlace <strong>"$current_key_shortener"</strong> no existe en nuestra base de datos
                </p>
                <div class="d-grid gap-2 d-sm-flex justify-content-sm-center mb-5">
                    <button type="button" class="btn btn-primary btn-lg px-4 me-sm-3" onclick="window['open']('./','_self')">
                        Página Principal
                    </button>
                    <button type="button" class="btn btn-outline-secondary btn-lg px-4" onclick="window['open']('$endpoint_shortener/portal','_self')">
                        Documentación
                    </button>
                </div>
            </div>
            <div class="overflow-hidden" style="max-height:30vh;">
                <div class="container px-5">
                    <img src="$endpoint_asset/background/notfound.webp?v=$cdn_key" class="img-fluid border rounded-3 shadow-lg mb-4" loading="lazy"/>
                </div>
            </div>
        </div>
        $define_footer_global
        EOF));
    break;
}else{
    print_r(html_template(title:$object_global_application["slogan"],render:<<<EOF
    $define_header_global
    <div class="container my-5">
        <div class="p-5 text-center bg-body-tertiary rounded-3">
            <img class="bi mt-2 mb-3" src="$endpoint_asset/logo.webp?v=$cdn_key" width="64" loading="lazy"/>
            <h1 class="text-body-emphasis">
                $project_name $application_name
            </h1>
            <p class="col-lg-8 mx-auto fs-5 text-muted">
                $application_slogan
            </p>
            <div class="d-inline-flex gap-2 mb-2">
                <button class="btn btn-outline-secondary btn-lg px-4 rounded-pill" onclick="window['open']('mailto:$project_email','_self')">
                    Contacto
                </button>
            </div>
        </div>
    </div>
    $define_footer_global
    EOF));
}
?>