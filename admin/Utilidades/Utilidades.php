<?php
class Utilidades
{
    function camposVacios($componentes)
    {
        $evaluar = $componentes;
        $success = false;

        foreach ($evaluar as $text) {
            if (trim($text) === "") {
                $success = true;
            }
        }
        unset($text);
        return $success;
    }

   function campoInyecciones($componentes)
    {
        $evaluar = $componentes;
        $success = false;

        foreach ($evaluar as $text2) {
            if (preg_match('/[^a-zA-Z0-9á-ú_\-\.\,\@\ñ\s]+/', $text2)) {
                $success = true;
            }
        }
        unset($text2);
        return $success;
    }

}

?>

