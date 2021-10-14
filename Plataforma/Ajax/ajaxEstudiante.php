<?php

include '../Utilidades/conexion.php';
include '../Utilidades/confiDev.php';
include '../Controladores/EstudianteController.php';
include '../Modelos/EstudianteModel.php';
/**
 * getWeekModalities, Obtencion de las modalidades segun el turno
 *
 * @param  string $turn Turno Matutino o Vespertino
 * @return json Arreglo de datos
 */
function getWeekModalities($turno)
{
    $controller = new EstudianteController();
    header('Content-type: application/json');
    echo json_encode(["modalities" => $controller->getWeekModalities($turno)]);
    exit;
}

/**
 * isModalityAvailable, Retorna verdadero si hay disponibilidad dentro de esa modalidad
 *
 * @param  string $modality
 * @return json
 */
function isModalityAvailable($modality)
{
    $controller = new EstudianteController();
    header('Content-type: application/json');
    echo json_encode(["isAvailable" => $controller->isModalityAvailable($modality)]);
    exit;
}

/**
 * array_push_assoc
 *
 * @param  mixed $array
 * @param  mixed $key
 * @param  mixed $value
 * @return void
 */

function array_push_assoc($array, $key, $value)
{
    $array[$key] = $value;
    return $array;
}

if (isset($_POST['callback'])) {
    $function = $_POST['callback'];
    if ($function == 'getWeekModalities') {
        getWeekModalities($_POST['turno']);
    }
    if ($function == 'isModalityAvailable') {
        isModalityAvailable($_POST['modality']);
    }
}
