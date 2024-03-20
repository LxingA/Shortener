<?php
/*
@author LxingA
@project CodeInk
@name Shortener
@date 25/02/24 08:40PM
@description Implementación de la Clase para el Anidar los Errores de los Throws de la Aplicación
*/
namespace Shortener\Handler;

/**
 * Funcionalidad Esencial para Establecer el Mensaje de Error Global
 * @param string $message Definición del Mensaje a Establecer en el Cuerpo
 * @param string $context Definición del Contexto del Mensaje
 * @param int $case Establecer el Tipo de Error en el Cuerpo
 */
function structure(string $message, string $context = "initial", int $case = 0, string $file = "", int $line = 0): string {
    $types = ["critic","warn","error","info","success","fatal"];
    return sprintf("[%s::%s->at(%s)::%s(%s)] %s",$context,$types[$case],(date("Y/m/d\:\:h:i:sA",time())),$file,$line,$message);
}

/** Clase Global para el Handler de los Throws de la Aplicación */
class Error extends \Exception {
    /** Definir el Contexto del Error en el Cuerpo */
    private string $context;
    public function __construct(string $message, string $context = "initial", int $code = 0){
        parent::__construct($message,$code);
        $this->message = $message;
        $this->code = $code;
        $this->context = $context;
        $this->file = parent::getFile();
        $this->line = parent::getLine();
    }
    /** Método Esencial para Retornar la Definición de la Estructura del Error Personalizado de la Aplicación */
    public function __toString(): string {
        return structure(message:$this->message,case:$this->code,context:$this->context,line:$this->line,file:$this->file);
    }
}
?>