<?php
/* Inicializacion de variable respuesta */
$response = ['state' => 0,  'message' => 'Ha ocurrido un error al subir banners'];
/**
 * saveBanners, Metodo guarda la imagen banner en el servidor
 *
 * @param  mixed $key Nombre clave del FormData append desde el javascript
 * @param  mixed $file_name Nombre del archivo  001, 002, 003, 004
 * @return void
 */

function saveBanners($key, $file_name)
{
    global $response;
    // Obteniendo extension
    $ext = pathinfo($_FILES[$key]['name'], PATHINFO_EXTENSION);
    // Cambiando nombre de foto de perfil
    $full_name = $file_name . "." . $ext;
    /* Ubicacion */
    $location = $_SERVER['DOCUMENT_ROOT'] . "/admin/img/banners/" . $full_name;
    $image_file_type = pathinfo($location, PATHINFO_EXTENSION);
    $image_file_type = strtolower($image_file_type);
    /* Extensiones validas */
    $valid_extensions = array("png");
    /* Revisa la extension del archivo */
    if (in_array(strtolower($image_file_type), $valid_extensions)) {
        /* Sube imagen */
        if (move_uploaded_file($_FILES[$key]['tmp_name'], $location)) {
            /* Repuesta */
            $response =  ['state' => 1,  'message' => 'Imagenes de banners actualizadas'];
        }
    } else {
        $response = ['state' => 2,  'message' => 'Por favor subir imagenes de banners en formato *.png'];
    }
}

if (isset($_FILES['banner_one']['name'])) {
    saveBanners('banner_one', '001');
}

if (isset($_FILES['banner_two']['name'])) {
    saveBanners('banner_two', '002');
}

if (isset($_FILES['banner_three']['name'])) {
    saveBanners('banner_three', '003');
}
if (isset($_FILES['banner_four']['name'])) {
    saveBanners('banner_four', '004');
}



// Retorno del resultado de la actualizacion
header('Content-type: application/json');
echo json_encode($response);

exit;
