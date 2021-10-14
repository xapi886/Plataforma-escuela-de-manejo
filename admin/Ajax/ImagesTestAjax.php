<?php

include_once '../Utilidades/conexion.php';

include_once '../Utilidades/confiDev.php';



if (isset($_FILES['file']['name'])) {



    /* Obteniendo el nombre de la imagen */

    $id_question = $_POST['id_question'];



    // Obteniendo extension

    $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);



    // Cambiando nombre de foto de perfil

    $filename = "QUESTION_PHOTO_" . $id_question . "." . $ext;



    /* Ubicacion */

    $location = $_SERVER['DOCUMENT_ROOT'] . "/admin/img/tests/" . $filename;

    $imageFileType = pathinfo($location, PATHINFO_EXTENSION);

    $imageFileType = strtolower($imageFileType);



    /* Extensiones validas */

    $valid_extensions = array("jpg", "jpeg", "png");



    /* Inicializacion de variable respuesta */

    $response = 0;



    /* Revisa la extension del archivo */

    if (in_array(strtolower($imageFileType), $valid_extensions)) {

        /* Sube imagen */

        if (move_uploaded_file($_FILES['file']['tmp_name'], $location)) {

            /* Instanciacion de la clase Conexion */

            $conn = new Conexion();



            /* Actualizacion de la foto de perfil */

            $query = $conn->connect()

                ->prepare('CALL update_photo_question(:id, :url)');



            /* Ejecucion del script sql */

            $response =  $query->execute([

                'id' => $id_question,

                'url' => "/admin/img/tests/" . $filename

            ]);
        }
    }

    // Retorno del resultado de la actualizacion

    echo $response;

    exit;
}

// Si hubo algun problema regresa cero como repuesta

echo 0;
