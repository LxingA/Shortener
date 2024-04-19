<?php
/*
@author LxingA
@project CodeInk
@name Shortener
@date 17/03/24 03:00AM
@description Definición de los Componentes HTML de Píe de Página para la Plantilla Global de la Aplicación
*/

/** Componente Global para el Píe de Página de la Aplicación */
function html_component_footer(){
    global $object_global_application;
    $current_year = date("Y",time());
    $project_alternative = $object_global_application["project"]["alternative"][2];
    $author = $object_global_application["project"]["name"];
    $base = <<<EOF
    <div class="container">
        <footer class="py-2 my-4">
            <p class="text-center text-body-secondary">
                &copy; 2012 ~ $current_year - <strong>$project_alternative</strong> por <strong>$author</strong>
            </p>
        </footer>
    </div>
    EOF;return $base;
}
?>