<?php
/*
@author LxingA
@project CodeInk
@name Shortener
@date 16/03/24 09:30PM
@description Definición de la Plantilla DOM HTML para la Aplicación
*/
/**
 * Definición de la Plantilla HTML Global de la Aplicación
 */
function html_template(string $title,string $language = "es",string $render = ""): string {
    global $object_global_application;
    $html_version = $object_global_application["version"];
    $html_author = $object_global_application["project"]["name"];
    $html_application_name = $object_global_application["name"];
    $html_endpoint_asset = $object_global_application["endpoint"]["asset"];
    $html_endpoint_api = $_ENV["CkEnvironmentParamURLEndPointAPI"];
    $html_endpoint_analytic = $object_global_application["analytic"]["endpoint"];
    $html_endpoint_analytic_preconnect = substr($html_endpoint_analytic,0,(strrpos($html_endpoint_analytic,"/")-5));
    $html_endpoint_analytic_script = str_replace("k",$object_global_application["analytic"]["key"],$html_endpoint_analytic);
    $html_analytic_key = $object_global_application["analytic"]["key"];
    $html_seo_description = $object_global_application["description"];
    $html_cdn_key = $_ENV["CkEnvironmentParamURLCDNCacheID"];
    $html_seo_keywords = "";
    if(count($object_global_application["keywords"]) > 0){
        $container_keywords = "";for($o = 0; $o < (count($object_global_application["keywords"]) - 1); $o++) $container_keywords .= array_values($object_global_application["keywords"])[$o] . ($o == (count($object_global_application["keywords"]) - 1) ? "" : ", ");
        $html_seo_keywords = "<meta name=\"keywords\" content=\"$container_keywords\"/>";
    }$html_attributes = "";
    for($y = 0; $y <= (count($object_global_application["option"]["\$html$"]) - 1); $y++) $html_attributes .= array_keys($object_global_application["option"]["\$html$"])[$y] . "=\"return " . ((boolval(intval(array_values($object_global_application["option"]["\$html$"])[$y]))) ? "true" : "false") . "\"" .  (($y == (count($object_global_application["option"]["\$html$"]) - 1)) ? "" : " ");
    $base = <<<EOF
    <!DOCTYPE html>
    <html lang="$language" $html_attributes author="$html_author" version="$html_version" data-bs-theme="light">
        <head>
            <link rel="dns-prefetch" href="$html_endpoint_api"/>
            <link rel="dns-prefetch" href="$html_endpoint_analytic_preconnect"/>
            <link rel="preconnect" href="https://cdnjs.cloudflare.com"/>
            <link rel="preconnect" href="$html_endpoint_asset"/>
            <meta charset="utf8"/>
            <meta name="viewport" content="initial-scale=1.0,width=device-width,user-scalable=no"/>
            <meta name="description" content="$html_seo_description"/>$html_seo_keywords
            <meta name="google" content="nopagereadaloud"/>
            <meta name="google" content="nositelinkssearchbox"/>
            <meta name="googlebot" content="notranslate"/>
            <title>$title - $html_author $html_application_name</title>
            <link rel="icon" href="$html_endpoint_asset/favicon.ico?v=$html_cdn_key" type="image/x-icon"/>
            <link rel="stylesheet" href="$html_endpoint_asset/style.css?v=$html_cdn_key" type="text/css"/>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" type="text/css"/>
        </head>
        <body>
            <main>
            $render
            </main>
            <script type="text/javascript" src="$html_endpoint_analytic_script" async></script>
            <script type="text/javascript">window.dataLayer=window.dataLayer||[];function gtag(){dataLayer["push"](arguments)};gtag("js",(new Date()));gtag("config","$html_analytic_key")</script>
            <script type="text/javascript" src="$html_endpoint_asset/script.js?v=$html_cdn_key"></script>
            <script type="text/javascript">
                /* Código Implementado por $html_author el 17/03/24 04:30AM */
                const ck_bt_thm = document["getElementById"]("cksh_button_theme");
                let ck_bt_thm_active = (Boolean(parseInt(ck_bt_thm["getAttribute"]("data-active"))));
                let ck_bt_thm_class = ck_bt_thm["children"][0]["getAttribute"]("class");
                ck_bt_thm["addEventListener"]("click",\$event$ => {
                    \$event$["preventDefault"]();
                    ck_bt_thm_active = !ck_bt_thm_active;
                    ck_bt_thm_class = ck_bt_thm_active ? "moon" : "sun";
                    ck_bt_thm["setAttribute"]("data-active",ck_bt_thm_active);
                    document["documentElement"]["setAttribute"]("data-bs-theme",(ck_bt_thm_active ? "dark" : "light"));
                    ck_bt_thm["children"][0]["setAttribute"]("class",`fa-regular fa-\${ck_bt_thm_class}`);
                });
            </script>
        </body>
    </html>
    EOF;return $base;
}
?>