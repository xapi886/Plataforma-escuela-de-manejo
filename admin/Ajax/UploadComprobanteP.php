<?php

include_once '../Utilidades/conexion.php';
include_once '../Utilidades/confiDev.php';

if (isset($_FILES['file']['name'])) {
    /* Obteniendo el nombre de la imagen */
    $id_card = $_POST['idcard'];
    $filename = "ComprobanteEP" . $id_card . "." . "pdf";
    /* Ubicacion */
    $location = $_SERVER['DOCUMENT_ROOT'] . "/Plataforma/File/Comprobante/ComprobanteEP/" . $filename;
    $imageFileType = pathinfo($location, PATHINFO_EXTENSION);
    $imageFileType = strtolower($imageFileType);
    /* Extensiones validas */
    $valid_extensions = array("pdf");
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
                ->prepare('UPDATE estudiante set ComprobanteEP = :urlComprobanteEP WHERE IdEstudiante = :idcard');

            /* Ejecucion del script sql */
            $response =  $query->execute([
                'idcard' => $id_card,
                'urlComprobanteEP' => "Plataforma/File/Comprobante/ComprobanteEP/" . $filename
            ]);
        }
    }
    // Retorno del resultado de la actualizacion
    echo $response;
    exit;
}
