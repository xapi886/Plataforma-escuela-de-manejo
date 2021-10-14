<?php
require_once '../Utils/configDev.php';
$productos = unserialize($_COOKIE['productos'] ?? '');
if (is_array($productos) == false) $productos = array();

$productoExiste = false;

foreach ($productos as $key => $value) {
    if ($value['id'] == $_REQUEST['id']) {
        $productos[$key]['cantidad'] = $productos[$key]['cantidad'] + $_REQUEST['cantidad'];
        $productoExiste = true;
    }
}

if (!$productoExiste) {
    $nuevo = array(
        "id" => $_REQUEST['id'],
        "nombre" => openssl_decrypt($_REQUEST['nombre'], COD, KEY),
        "precio" => openssl_decrypt($_REQUEST['precio'], COD, KEY),
        "unidadMedida" => openssl_decrypt($_REQUEST['unidadMedida'], COD, KEY), 
        "foto" => $_REQUEST['foto'], 
        "cantidad" => $_REQUEST['cantidad']
    );

    array_push($productos, $nuevo);
}

setcookie("productos", serialize($productos));
echo json_encode($productos);