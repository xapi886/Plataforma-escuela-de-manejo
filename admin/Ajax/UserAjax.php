<?php

include_once '../Utilidades/conexion.php';
include_once '../Utilidades/confiDev.php';
include_once '../Controladores/UserController.php';
include_once '../Modelos/UserModel.php';

/**
 * updateInfoStudent, actualizacion de informacion de estudiante verificados y habilitados
 *
 * @param  array $data
 * @return json Datos de exito de actualizacion y conexion
 */

function updateInfoUser($data)
{
    // Instancia del controlador StudentController
    $controller = new UserController();
    // Creo un arreglo que contendra la clave y el dato que quiero remplasar dentro del arreglo original
    $replace = ["password" => openssl_encrypt($data['password'], COD, KEY)];
    // Remplazo el dato de la clave "password" y establezco de nuevo esos datos
    $data = array_replace($data, $replace);
    // Remuevo del arreglo $data la clave asociada y el dato "callback"
    unset($data['callback']);
    header('Content-type: application/json');
    echo json_encode(["updated" => $controller->updateInfoUser($data)]);
    exit;
}

if (isset($_POST['callback'])) {
    $function = $_POST['callback'];
    if ($function == 'updateInfoUser') {
        updateInfoUser($_POST);
    }
}
