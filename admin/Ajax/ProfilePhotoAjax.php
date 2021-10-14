<?php
include_once '../Utilidades/conexion.php';
include_once '../Utilidades/confiDev.php';

if (isset($_FILES['file']['name'])) {

    /* Obteniendo el nombre de la imagen */
    $id_card = $_POST['idcard'];    // Obteniendo extension
    $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
    // Cambiando nombre de foto de perfil
    $filename = "PROFILE_PHOTO_" . $id_card . "." . "png";
    /* Ubicacion */
    $location = $_SERVER['DOCUMENT_ROOT'] . "/Plataforma/Imagenes/Estudiante/Perfil/" . $filename;
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
                ->prepare('CALL update_photo_student(:idcard, :url)');
            /* Ejecucion del script sql */
            $response =  $query->execute([
                'idcard' => $id_card,
                'url' => "Plataforma/Imagenes/Estudiante/Perfil/" . $filename
            ]);
        }
    }
    // Retorno del resultado de la actualizacion
    echo $response;
    exit;
}
// Si hubo algun problema regresa cero como repuesta
echo 0;
