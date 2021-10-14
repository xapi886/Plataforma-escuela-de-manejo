<?php

include '../Utilidades/conexion.php';
include '../Utilidades/confiDev.php';
include '../Controladores/EstudianteController.php';
include '../Modelos/EstudianteModel.php';
include '../Modelos/InscripcionModel.php';
include '../Controladores/InscripcionController.php';

if (isset($_POST['callback'])) {
    $function = $_POST['callback'];
    if ($function == 'getWeekModalities') {
        getWeekModalities($_POST['turno']);
    }
    if ($function == 'isModalityAvailable') {
        isModalityAvailable($_POST['modality']);
    }
}