<?php
include_once '../Utilidades/conexion.php';
include_once '../Utilidades/confiDev.php';
include_once '../Controladores/StudentController.php';
include_once '../Modelos/StudentModel.php';

/**
 * searchStudentByFulltext, Filtro de registros de estudiantes
 * en la tabla de gestion estudiantes.
 *
 * @param string $text
 * @return json Datos JSON de registros de estudiante
 */
function searchStudentByFulltext($text)
{
    $controller = new StudentController();
    header('Content-type: application/json');
    echo json_encode(["students" => $controller->searchStudent($text)]);
    exit;
}

/**
 * getNextStudents, Mertodo devuelve los registros en JSON
 * despues de haber terminado una busqueda
 *
 * @param  int $offset
 * @return json Datos JSON de registros de estudiante
 */
function getNextStudents($offset)
{
    $controller = new StudentController();
    header('Content-type: application/json');
    echo json_encode(["students" => $controller->getNextStudents($offset)]);
    exit;
}

/**
 * updateInfoStudent, actualizacion de informacion de estudiante verificados y habilitados
 *
 * @param  array $data
 * @return json Datos de exito de actualizacion y conexion
 */
function updateInfoStudent($data)
{
    // Instancia del controlador StudentController
    $controller = new StudentController();

    // Creo un arreglo que contendra la clave y el dato que quiero remplasar dentro del arreglo original
    $replace = ["password" => openssl_encrypt($data['password'], COD, KEY)];

    // Remplazo el dato de la clace "password" y establezco de nuevo esos datos
    $data = array_replace($data, $replace);

    // Remuevo del arreglo $data la clave asociada y el dato "callback"
    unset($data['callback']);

    header('Content-type: application/json');
    echo json_encode(["updated" => $controller->updateInfoStudent($data)]);
    exit;
}

/**
 * updateInfoStudent, actualizacion de informacion de estudiante solo registrados
 *
 * @param  array $data
 * @return json Datos de exito de actualizacion y conexion
 */
function updateInfoStudentRegisteredOnly($data)
{
    // Instancia del controlador StudentController
    $controller = new StudentController();

    // Creo un arreglo que contendra la clave y el dato que quiero remplasar dentro del arreglo original
    $replace = ["password" => openssl_encrypt($data['password'], COD, KEY)];

    // Remplazo el dato de la clave "password" y establezco de nuevo esos datos
    $data = array_replace($data, $replace);

    // Remuevo del arreglo $data la clave asociada y el dato "callback"
    unset($data['callback']);

    header('Content-type: application/json');
    echo json_encode(["updated" => $controller->updateInfoStudentRegisteredOnly($data)]);
    exit;
}

/**
 * getWeekModalities, Obtencion de las modalidades segun el turno
 *
 * @param  string $turn Turno Matutino o Vespertino
 * @return json Arreglo de datos
 */
function getWeekModalities($turno)
{
    $controller = new StudentController();
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
    $controller = new StudentController();
    header('Content-type: application/json');
    echo json_encode(["isAvailable" => $controller->isModalityAvailable($modality)]);
    exit;
}


/**
 * isModalityAvailable, Retorna verdadero si hay disponibilidad dentro de esa modalidad
 *
 * @param  string $modality
 * @return json
 */
function updateMoreInfoStudentById($data)
{
    $controller = new StudentController();
    // Remuevo del arreglo $data la clave asociada y el dato "callback"
    unset($data['callback']);
    header('Content-type: application/json');
    echo json_encode(["updated" => $controller->updateMoreInfoStudentById($data)]);
    exit;
}

function getInfoStudentById($id)
{
    //$turno = $_POST['turno'];
    $controller = new StudentController();
    header('Content-type: application/json');
    echo json_encode(["info" => $controller->getInfoStudentById($id)]);
    exit;
    
}


function verificarSeminario()
{
    $id = $_POST['id'];
    //$turno = $_POST['turno'];
    $modalidad = $_POST['modalidad'];
    $controller = new StudentController();
    $result = $controller->verificarSeminario($id);
    if ($result) {
        $data = $controller->getDisponibilidadByCodigo($modalidad);
        $disponibilidad = $data[0]['Disponibilidad'];

        if ($disponibilidad <= 1) {
            $update = $controller->updateDisponibilidad($modalidad, $disponibilidad + 1);
            if ($update) {
                echo 'Seminario actualizado correctamente';
            } else {
                echo 'Ocurrio un error al momento de actualizar los datos';
            }
        } else if ($disponibilidad >= 2) {
            $update = $controller->updateDisponibilidad($modalidad,$disponibilidad);
            if ($update) {
                echo 'Seminario actualizado correctamente';
            } else {
                echo 'Ocurrio un error al momento de actualizar los datos';
            }
        }
    } else {
        echo 'Ocurrio un error al momento de actualizar los datos';
    }
}



/**
 * Estructura de comparacion para las funciones llamadas por AJAX.
 */
if (isset($_POST['callback'])) {
    $function = $_POST['callback'];

    if ($function == 'searchStudentByFulltext') {
        searchStudentByFulltext($_POST['text']);
    }

    if ($function == 'getNextStudents') {
        getNextStudents($_POST['offset']);
    }

    if ($function == 'updateInfoStudent') {
        updateInfoStudent($_POST);
    }

    if ($function == 'updateInfoStudentRegisteredOnly') {
        updateInfoStudentRegisteredOnly($_POST);
    }

    if ($function == 'getWeekModalities') {
        getWeekModalities($_POST['turno']);
    }
    if ($function == 'isModalityAvailable') {
        isModalityAvailable($_POST['modality']);
    }

    if ($function == 'updateMoreInfoStudentById') {
        updateMoreInfoStudentById($_POST);
    }
    if ($function == 'verificarSeminario') {
        verificarSeminario();
    }
    if ($function == 'getInfoStudentById') {
        getInfoStudentById($_POST['id']);
    }
}
