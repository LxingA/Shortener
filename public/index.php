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
    case "panel":
        session_start();
        if($_SESSION["authentic"]){
            echo "Autenticado";
        }else echo(html_template(title:"Autenticación",render:<<<EOF
        $define_header_global
        <main class="form-signin w-100 m-auto d-flex align-items-center justify-content-center py-4">
            <form>
                <center>
                    <img class="mb-4" width="64" src="$endpoint_asset/logo.webp?v=$cdn_key"/>
                </center>
                <h1 class="h3 mb-3 fw-normal">Se requiere de autenticación</h1>
                <div class="form-floating">
                    <input id="ckshortenerauthinuser" min="8" max="64" class="form-control" type="email" placeholder="Correo Electrónico" required/>
                    <label for="ckshortenerauthinuser">Correo Electrónico</label>
                </div>
                <div class="form-floating mt-3">
                    <input id="ckshortenerauthinpass" min="8" max="64" class="form-control" type="password" placeholder="Contraseña" required disabled/>
                    <label for="ckshortenerauthinpass">Contraseña</label>
                </div>
                <div class="form-check text-start my-3">
                    <input id="ckshortenerauthinremember" class="form-check-input" type="checkbox" checked/>
                    <label class="form-check-label" for="ckshortenerauthinremember">Recordarme</label>
                </div>
                <button id="ckshortenerauthinsubmit" class="btn btn-outline-primary w-100 py-2" type="submit" disabled>Autenticarse</button>
            </form>
        </main>
        <script type="text/javascript">
            /* Código Implementado por LxingA el 09/04/24 07:00PM */
            const inputValidator = (container = [], action) => container["forEach"](__key__ => {
                const __element__ = document["getElementById"](__key__);
                if("value" in __element__) __element__["value"] = "";
                switch(action){
                    case true:
                        __element__["setAttribute"]("disabled","");
                    break;
                    case false:
                        __element__["removeAttribute"]("disabled");
                    break;
                }
            });
            const validatorInput = (ev, mode = true, message = "", input = []) => {
                const containerID = ev["id"] + "_container";
                ev["classList"]["remove"]("is-valid","is-invalid");
                switch(mode){
                    case true:
                        ev["classList"]["add"]("is-valid");
                        inputValidator(input,false);
                    break;
                    case false:
                        if(document["getElementById"](containerID)) document["getElementById"](containerID)["innerHTML"] = message;
                        else{
                            const container = document["createElement"]("div");
                            container["id"] = containerID;
                            container["classList"]["add"]("invalid-feedback");
                            container["innerHTML"] = message;
                            ev["parentElement"]["append"](container);
                        }
                        ev["classList"]["add"]("is-invalid");
                        inputValidator(input,true);
                    break;
                }
            };
            document["getElementById"]("ckshortenerauthinuser")["addEventListener"]("change",(ev) => {
                if(ev["target"]["value"]["length"] == 0){
                    ev["target"]["classList"]["remove"]("is-valid","is-invalid");
                    (document["getElementById"](ev["target"]["id"] + "_container")) && document["getElementById"](ev["target"]["id"] + "_container")["remove"]();
                    inputValidator(["ckshortenerauthinpass","ckshortenerauthinsubmit"],true);
                }else if(ev["target"]["value"]["length"] < ev["target"]["min"]) validatorInput(ev["target"],false,"Se requiere de % de longitud para el correo"["replace"]("%",String(ev["target"]["min"])),["ckshortenerauthinpass","ckshortenerauthinsubmit"]);
                else if(ev["target"]["value"]["length"] > ev["target"]["max"]) validatorInput(ev["target"],false,"Se requiere cómo máximo % de longitud para el correo"["replace"]("%",String(ev["target"]["max"])),["ckshortenerauthinpass","ckshortenerauthinsubmit"]);    
                else if(!(/^([a-z0-9A-Z\_]+)\@([a-z0-9]+)\.([a-z]){2,3}(\.([a-z0-9]+))?$/["test"](ev["target"]["value"]))) validatorInput(ev["target"],false,"El correo dado no tiene un formato valído",["ckshortenerauthinpass","ckshortenerauthinsubmit"]);
                else{
                    validatorInput(ev["target"]);
                    document["getElementById"]("ckshortenerauthinpass")["removeAttribute"]("disabled");
                }
            });
            document["getElementById"]("ckshortenerauthinpass")["addEventListener"]("change",(ev) => {
                if(ev["target"]["value"]["length"] == 0){
                    ev["target"]["classList"]["remove"]("is-valid","is-invalid");
                    (document["getElementById"](ev["target"]["id"] + "_container")) && document["getElementById"](ev["target"]["id"] + "_container")["remove"]();
                    inputValidator(["ckshortenerauthinsubmit"],true);
                }else if(ev["target"]["value"]["length"] < ev["target"]["min"]) validatorInput(ev["target"],false,"Se requiere de % de longitud para la contraseña"["replace"]("%",String(ev["target"]["min"])),["ckshortenerauthinsubmit"]);
                else if(ev["target"]["value"]["length"] > ev["target"]["max"]) validatorInput(ev["target"],false,"Se requiere cómo máximo % de longitud para la contraseña"["replace"]("%",String(ev["target"]["max"])),["ckshortenerauthinsubmit"]);    
                else if(!(/^[a-zA-Z0-9\!\#\&]+$/["test"](ev["target"]["value"]))) validatorInput(ev["target"],false,"La contraseña no tiene un formato valído",["ckshortenerauthinsubmit"]);
                else{
                    validatorInput(ev["target"]);
                    document["getElementById"]("ckshortenerauthinsubmit")["removeAttribute"]("disabled");
                }
            });
            document["getElementById"]("ckshortenerauthinsubmit")["addEventListener"]("click",async (ev) => {
                ev["preventDefault"]();
                const elements_refered = [document["getElementById"]("ckshortenerauthinuser"),document["getElementById"]("ckshortenerauthinpass")];
                const defined_requested = (await fetch("/api.php?context=check_exists_user",{method:"POST",mode:"cors",cache:"no-cache",credentials:"same-origin",body:JSON["stringify"]({username:elements_refered[0]["value"],password:elements_refered[1]["value"]})}));
            });
        </script>
        $define_footer_global
        EOF));
    break;
    default:
        $current_key_shortener = $_GET["key"];
        $check = (new \Shortener\API\Main("GET"))::request("/v1/".$application_last_identified,["context"=>"link","key"=>$current_key_shortener]);
        if($check["\$st$"]){
            $short_link_content = $check["\$rs$"][0];
            (new \Shortener\API\Main("PUT"))::request("/v1/".$application_last_identified,["context"=>"link","action"=>"increment_view","key"=>$current_key_shortener,"current_value"=>$short_link_content["view"]]);
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: " . $short_link_content["uri"]);
        }else echo(html_template(title:"Enlace no Encontrado",render:<<<EOF
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
    echo(html_template(title:$object_global_application["slogan"],render:<<<EOF
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