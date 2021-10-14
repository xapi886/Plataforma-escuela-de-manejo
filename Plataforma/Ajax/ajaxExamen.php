<?php

include_once '../Utilidades/confiDev.php';
include_once '../Utilidades/conexion.php';
include_once '../Utilidades/Utilidades.php';
include_once '../Utilidades/session.php';
include_once '../Controladores/EstudianteController.php';
include_once '../Modelos/EstudianteModel.php';
include_once '../Controladores/ExamenController.php';
include_once '../Modelos/ExamenModel.php';





function actualizarTiempo()
{
    $examenControler = new ExamenController();
    $session = new Session();
    $idExamen = $session->getIdExamen();
    $idEstudiante = $session->getCurrentId();
    $tiempoTranscurrido = $_POST['tiempoRestante'];
    $tiempoFormateado = $_POST['TimeStr'];

    $result = $examenControler->actualizarTiempo($tiempoTranscurrido, $tiempoFormateado, $idEstudiante, $idExamen);
    if ($result) {
        echo 'se actualizo correctamente: ' . $tiempoTranscurrido;
    } else {
        echo 'ocurrio un error';
    }
}



function insertar()
{
    $examenControler = new ExamenController();
    $session = new Session();
    $idExamen = $_POST['IdExamen'];
    $idEstudiante = $session->getCurrentId();
    $Preg1 = $_POST['preg1'];
    $Preg2 = $_POST['preg2'];
    $Preg3 = $_POST['preg3'];
    $Preg4 = $_POST['preg4'];
    $Preg5 = $_POST['preg5'];
    $Preg6 = $_POST['preg6'];
    $Preg7 = $_POST['preg7'];
    $Preg8 = $_POST['preg8'];
    $Preg9 = $_POST['preg9'];
    $Preg10 = $_POST['preg10'];
    $Preg11 = $_POST['preg11'];
    $Preg12 = $_POST['preg12'];
    $Preg13 = $_POST['preg13'];
    $Preg14 = $_POST['preg14'];
    $Preg15 = $_POST['preg15'];
    $Preg16 = $_POST['preg16'];
    $Preg17 = $_POST['preg17'];
    $Preg18 = $_POST['preg18'];
    $Preg19 = $_POST['preg19'];
    $Preg20 = $_POST['preg20'];
    //IdRespuestas seleccionadas
    $Resp1 = $_POST['resp1'] ?? '';
    $Resp2 = $_POST['resp2'] ?? '';
    $Resp3 = $_POST['resp3'] ?? '';
    $Resp4 = $_POST['resp4'] ?? '';
    $Resp5 = $_POST['resp5'] ?? '';
    $Resp6 = $_POST['resp6'] ?? '';
    $Resp7 = $_POST['resp7'] ?? '';
    $Resp8 = $_POST['resp8'] ?? '';
    $Resp9 = $_POST['resp9'] ?? '';
    $Resp10 = $_POST['resp10'] ?? '';
    $Resp11 = $_POST['resp11'] ?? '';
    $Resp12 = $_POST['resp12'] ?? '';
    $Resp13 = $_POST['resp13'] ?? '';
    $Resp14 = $_POST['resp14'] ?? '';
    $Resp15 = $_POST['resp15'] ?? '';
    $Resp16 = $_POST['resp16'] ?? '';
    $Resp17 = $_POST['resp17'] ?? '';
    $Resp18 = $_POST['resp18'] ?? '';
    $Resp19 = $_POST['resp19'] ?? '';
    $Resp20 = $_POST['resp20'] ?? '';


    $PreguntasGuardadas = [$Preg1, $Preg2, $Preg3, $Preg4, $Preg5, $Preg6, $Preg7, $Preg8, $Preg9, $Preg10, $Preg11, $Preg12, $Preg13, $Preg14, $Preg15, $Preg16, $Preg17, $Preg18, $Preg19, $Preg20];

    //Seleccionar el id de la respuesta Correcta

    $IdRespuestaCorrrecta1 = $examenControler->IdRespuestaCorrecta($Preg1);
    $IdRespuestaCorrrecta2 = $examenControler->IdRespuestaCorrecta($Preg2);
    $IdRespuestaCorrrecta3 = $examenControler->IdRespuestaCorrecta($Preg3);
    $IdRespuestaCorrrecta4 = $examenControler->IdRespuestaCorrecta($Preg4);
    $IdRespuestaCorrrecta5 = $examenControler->IdRespuestaCorrecta($Preg5);
    $IdRespuestaCorrrecta6 = $examenControler->IdRespuestaCorrecta($Preg6);
    $IdRespuestaCorrrecta7 = $examenControler->IdRespuestaCorrecta($Preg7);
    $IdRespuestaCorrrecta8 = $examenControler->IdRespuestaCorrecta($Preg8);
    $IdRespuestaCorrrecta9 = $examenControler->IdRespuestaCorrecta($Preg9);
    $IdRespuestaCorrrecta10 = $examenControler->IdRespuestaCorrecta($Preg10);
    $IdRespuestaCorrrecta11 = $examenControler->IdRespuestaCorrecta($Preg11);
    $IdRespuestaCorrrecta12 = $examenControler->IdRespuestaCorrecta($Preg12);
    $IdRespuestaCorrrecta13 = $examenControler->IdRespuestaCorrecta($Preg13);
    $IdRespuestaCorrrecta14 = $examenControler->IdRespuestaCorrecta($Preg14);
    $IdRespuestaCorrrecta15 = $examenControler->IdRespuestaCorrecta($Preg15);
    $IdRespuestaCorrrecta16 = $examenControler->IdRespuestaCorrecta($Preg16);
    $IdRespuestaCorrrecta17 = $examenControler->IdRespuestaCorrecta($Preg17);
    $IdRespuestaCorrrecta18 = $examenControler->IdRespuestaCorrecta($Preg18);
    $IdRespuestaCorrrecta19 = $examenControler->IdRespuestaCorrecta($Preg19);
    $IdRespuestaCorrrecta20 = $examenControler->IdRespuestaCorrecta($Preg20);

    $RespuestasSeleccionadas = [
        $Resp1, $Resp2, $Resp3, $Resp4, $Resp5, $Resp6, $Resp7, $Resp8, $Resp9,
        $Resp10, $Resp11, $Resp12, $Resp13, $Resp14, $Resp15, $Resp16, $Resp17,
        $Resp18, $Resp19, $Resp20
    ];



    $RespuestasCorrectas = [
        $IdRespuestaCorrrecta1, $IdRespuestaCorrrecta2, $IdRespuestaCorrrecta3, $IdRespuestaCorrrecta4, $IdRespuestaCorrrecta5,
        $IdRespuestaCorrrecta6, $IdRespuestaCorrrecta7, $IdRespuestaCorrrecta8, $IdRespuestaCorrrecta9, $IdRespuestaCorrrecta10, $IdRespuestaCorrrecta11,
        $IdRespuestaCorrrecta12, $IdRespuestaCorrrecta13, $IdRespuestaCorrrecta14, $IdRespuestaCorrrecta15, $IdRespuestaCorrrecta16, $IdRespuestaCorrrecta17, $IdRespuestaCorrrecta18, $IdRespuestaCorrrecta19, $IdRespuestaCorrrecta20
    ];

    $notaTotal = 0;
    for ($i = 0; $i <= 19; $i++) {
        if ($RespuestasSeleccionadas[$i] == $RespuestasCorrectas[$i]) {
            $notaTotal += 5;
            //echo $RespuestasSeleccionadas[$i];
        }
    }


    $actualizarNota = $examenControler->actualizarNota($notaTotal, $idEstudiante, $idExamen); // Actualiza la nota del examen anteriormente guardad que por defecto es 0
    $ExamenEstudiante = $examenControler->getExamenEstudianteById($idEstudiante, $idExamen); //Select de los datos de la tabla ExamenEstudiante
    $idExamenEstudiante = $ExamenEstudiante->getIdExamenEstudiante(); //idDelExamenEstudiante
    $Tiempo = $ExamenEstudiante->getTiempo(); //idDelExamenEstudiante
    $Disponibilidad = $ExamenEstudiante->getDisponibilidad();
    $IntentoPorExamen = $examenControler->limitarIntentoPorExamen($idEstudiante, $idExamen);

    //if (is_numeric($IntentoPorExamen) && $IntentoPorExamen == 0) {

    if ($Disponibilidad == 0 && $Disponibilidad < 1) {
        //actualizar disponibilidad
        $actualizarDisponibilidad = $examenControler->actualizarDisponibilidad($idEstudiante, $idExamen);
        if ($actualizarNota) {
            for ($i = 0; $i <= 19; $i++) {
                $InsertaDetalleExamenEstudiante = $examenControler->InsertaDetalleExamenEstudiante($PreguntasGuardadas[$i], $RespuestasSeleccionadas[$i], $idExamenEstudiante);
            }
        }
    } else {    
        $ressultMessage = 'Realizado';
        if ($ressultMessage) {
            //echo "el examen ya fue realizado";
        }
    }

    

    $result = $examenControler->RecargarResultadoExamen($idExamen, $idEstudiante);
    if ($result) {
        echo $result;
    } else {
        echo 'Hubo un error en la carga del contenido';
    }
}



/*Validador de entrada*/

if (isset($_POST['functionName'])) {
    $function = $_POST['functionName'];
    if ($function == 'actualizar') {
        actualizarTiempo();
    }
    if ($function == 'insertar') {
        insertar();
    }

}

