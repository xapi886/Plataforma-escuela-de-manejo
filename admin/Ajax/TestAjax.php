<?php

include_once '../Utilidades/conexion.php';
include_once '../Utilidades/confiDev.php';
include_once '../Controladores/TestController.php';
include_once '../Modelos/TestModel.php';

/**
 * getQuestionById, Este metodo solo filtra una pregunta segun el id de la misma
 *
 * @param  int $id
 * @return array Array de datos
 */

function getQuestionById($id)
{
    $controller = new TestController();
    header('Content-type: application/json');
    echo json_encode(["question" => $controller->getQuestionById($id)]);
    exit;
}
/**
 * getImageURL, este metodo regresa la url de la imagen de la pregunta asociada
 *
 * @param  int $id
 * @return array Array de datos
 */
function getImageURL($id)
{
    $controller = new TestController();
    header('Content-type: application/json');
    echo json_encode(["url" => $controller->getImageURL($id)]);
    exit;
}

/**
 * updateQuestion, actualizacion de pregunta de un examen
 *
 * @param  int $id Identificador de pregunta
 * @return boolean
 */

function updateQuestion($id, $question)

{
    $controller = new TestController();
    header('Content-type: application/json');
    echo json_encode(["status" => $controller->updateQuestion($id, $question)]);
    exit;
}

/**
 * deleteQuestion, eliminacion completa de registro de pregunta
 *
 * @param  int $id Identificador de pregunta
 * @return boolean
 */

function deleteQuestion($id)
{
    $controller = new TestController();
    header('Content-type: application/json');
    echo json_encode(["status"  => $controller->deleteQuestion($id)]);
    exit;
}
/**
 * getAnswerById, Este metodo solo filtra el item de una pregunta segun el id 
 *
 * @param  int $id Identificador de item de pregunta
 * @return array Array de datos
 */

function getAnswerById($id)
{
    $controller = new TestController();
    header('Content-type: application/json');
    echo json_encode(["answer"  => $controller->getAnswerById($id)]);
    exit;
}

/**
 * updateAnswer, Actualizacion de item de pregunta
 *
 * @param  int $id Identificador de item de pregunta 
 * @param  string $answer Item de pregunta a actualizar
 * @return boolean
 */

function updateAnswer($id, $answer)
{
    $controller = new TestController();
    header('Content-type: application/json');
    echo json_encode(["status"  => $controller->updateAnswer($id, $answer)]);
    exit;
}

/**
 * deleteAnswer, Eliminacion de item de pregunta
 *
 * @param  int $id
 * @return boolean
 */
function deleteAnswer($id)
{
    $controller = new TestController();
    header('Content-type: application/json');
    echo json_encode(["status"  => $controller->deleteAnswer($id)]);
    exit;
}

/**
 * setCorrectAnswer, Establece como respuesta correcta a un item de una pregunta
 *
 * @param  int $id_question
 * @param  int $id_answer
 * @return boolean
 */

function setCorrectAnswer($id_question, $id_answer)
{
    $controller = new TestController();
    header('Content-type: application/json');
    echo json_encode(["status"  => $controller->setCorrectAnswer($id_question, $id_answer)]);
    exit;
}

/**
 * addQuestion, Inserta un recurso de bases de datos a
 * la tabla examen_preguntas
 *
 * @param  int $id_test Identificador de examen
 * @param  string $question Pregunta nueva de un examen
 * @return boolean
 */
function addQuestion($id_test, $question)
{
    $controller = new TestController();
    header('Content-type: application/json');
    echo json_encode(["status"  => $controller->addQuestion($id_test, $question)]);
    exit;
}

/**
 * addAnswer, Inserta un recurso de bases de datos a 
 * la tabla examen_respuestas
 *
 * @param  int $id_question
 * @param  string $answer
 * @return boolean
 */

function addAnswer($id_question, $answer)
{
    $controller = new TestController();
    header('Content-type: application/json');
    echo json_encode(["status"  => $controller->addAnswer($id_question, $answer)]);
    exit;
}

/**
 * searchStudentByFulltext, Filtro de registros de estudiantes
 * en la tabla de gestion estudiantes.
 *
 * @param string $text
 * @return json Datos JSON de registros de estudiante
 */

function searchStudenExamtByFulltext($text)
{
    $controller = new TestController();
    header('Content-type: application/json');
    echo json_encode(["studentExam" => $controller->search_student_exams_by_text($text)]);
    exit;
}

/**
 * searchStudentByFulltext, Filtro de registros de estudiantes
 * en la tabla de gestion estudiantes.
 *
 * @param string $text
 * @return json Datos JSON de registros de estudiante
 */

function getNextStudentExam($offset, $id)
{
    $controller = new TestController();
    header('Content-type: application/json');
    echo json_encode(["nextStudent" => $controller->getNextStudentExam($offset, $id)]);
    exit;
}

function buscar()
{
    $texto = $_POST['textoBusqueda'];
    $controller = new TestController();
    $result = $controller->buscar($texto);
    if (!$result) {
        echo 'No se encuentra ningun estudiante con ese nombre...';
    } else {
        echo $result;
    }
}

function ReCargarEstudianteExamen()
{
    $offset = $_POST['offset'];
    $id = $_POST['id'];
    $controller = new TestController();
    $result = $controller->MostrarReCargarEstudianteExamen($offset, $id);
    if (!$result) {
        echo 'No hay datos disponibles...';
    } else {
        echo $result;
    }
}

/**
 * Estructura de comparacion para las funciones llamadas por AJAX.

 */
if (isset($_POST['callback'])) {
    $function = $_POST['callback'];
    if ($function == 'getQuestionById') {
        getQuestionById($_POST['id']);
    }
    if ($function == 'getImageURL') {
        getImageURL($_POST['id']);
    }
    if ($function == 'updateQuestion') {
        updateQuestion($_POST['id_question'], $_POST['new_question']);
    }
    if ($function == 'deleteQuestion') {
        deleteQuestion($_POST['id_question']);
    }
    if ($function == 'getAnswerById') {
        getAnswerById($_POST['id_answer']);
    }
    if ($function == 'updateAnswer') {
        updateAnswer($_POST['id_answer'], $_POST['new_answer']);
    }
    if ($function == 'deleteAnswer') {
        deleteAnswer($_POST['id_answer']);
    }
    if ($function == 'setCorrectAnswer') {
        setCorrectAnswer($_POST['id_question'], $_POST['id_answer']);
    }
    if ($function == 'addQuestion') {
        addQuestion($_POST['id_test'], $_POST['question']);
    }
    if ($function == 'addAnswer') {
        addAnswer($_POST['id_question'], $_POST['answer']);
    }
    if ($function == 'searchStudenExamtByFulltext') {
        searchStudenExamtByFulltext($_POST['text']);
    }
    if ($function == 'getNextStudentExam') {
        getNextStudentExam($_POST['offset'], $_POST['id']);
    }
    if ($function == 'buscar') {
        buscar();
    }
    if ($function == 'ReCargarEstudianteExamen') {
        ReCargarEstudianteExamen();
    }
}
