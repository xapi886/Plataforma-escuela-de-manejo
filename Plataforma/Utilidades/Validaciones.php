<?php

        if(isset($_POST["acepto-condiciones"]) && $_POST["acepto-condiciones"] == 1){
            echo "El elemento Checbox ha sido seleccionado";
            header('location: ../../Plataforma/Vistas/FinRegistro.php');
        }else{
            echo "El elemento Checbox no ha sido seleccionado";     
        }
?>



