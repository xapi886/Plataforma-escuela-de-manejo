<?php

include_once '../Utilidades/conexion.php';
include_once '../Utilidades/confiDev.php';
include_once '../Controladores/ScheduleController.php';
include_once '../Modelos/ScheduleModel.php';

function addSchedule()
{

    $idUser = $_POST['idUser'];
    $idEstudiante = $_POST['idEstudiante'];
    $fechaIncio = $_POST['start'];
    $fechaFin = $_POST['end'];
    $horaInicio = $_POST['horaInicio'];
    $horaFin = $_POST['horaFin'];

    $scheduleController = new ScheduleController();
    /**Variables de fecha inicial */
    // Obtiene el rango de fechas iniciales que se encuentra en el rango de la fecha inicial y fecha final otorgadas
    $horaInicioFormateada = date("H:i:s", strtotime($horaInicio . '+ 1 minute')); //fecha en formato 00:00:00
    $horaFinFormateada = date("H:i:s", strtotime($horaFin . '- 1 minute')); //fecha en formato 00:00:00
    $fechaFinFormateada = date("Y-m-d", strtotime($fechaFin . '- 1 days')); // fecha fin - 1 day
    $dateStartIsBetween = $scheduleController->dateStartIsBetween($fechaIncio, $fechaFinFormateada);
    $cantidadFI = 0; // Cantidad de fechas inicales en ese rango;
    $disponibilidadFI = 0;
    /**Variables de fecha final */
    // Obtiene el rango de fechas finales que se encuentra en el rango de la fecha inicial y fecha final otorgadas
    $dateEndIsBetween = $scheduleController->dateEndIsBetween($fechaIncio, $fechaFinFormateada);
    $cantidadFF = 0; // Cantidad de fechas finales  en ese rango;
    $disponibilidadFF = 0;
    //echo 'fecha Fin real= ' .$fechaFin. ' Fecha Final - 1 dia = ' .  $fechaFinFormateada. '* ';
    /**
     * comienzo de foreach con las horas
     *  comprendidas en la fecha Inicial
     */
    foreach ($dateStartIsBetween as $dataStart) { //Para todo el rango de horas en la fecha inicial
        $cantidadFI += 1;
        $hourStart1 = $dataStart['HoraInicio'];
        $hourEnd1 = $dataStart['HoraFin'];
        //echo $dataStart['FechaInicio'] . '  ';
        $hourStartBetween  = $scheduleController->hourIsBetween($hourStart1,  $hourEnd1, $horaInicioFormateada) ? 'Yes' : 'No';  //echo $horaEntre;   
        $hourEndBetween = $scheduleController->hourIsBetween($hourStart1,  $hourEnd1, $horaFinFormateada) ? 'Yes' : 'No';  //echo $horaEntre;

        // echo 'Start ';
        // echo $dataStart['FechaInicio'] . ' ';
        // echo "$hourStart1 <= $horaInicioFormateada <= $hourEnd1 -> " . ($scheduleController->hourIsBetween($hourStart1, $hourEnd1, $horaInicioFormateada) ? 'Yes' : 'No') . "\n";
        //echo $dataStart['FechaFin'] . ' ';
        // echo "$hourStart1 <= $horaFinFormateada <= $hourEnd1 -> " . ($scheduleController->hourIsBetween($hourStart1, $hourEnd1, $horaFinFormateada) ? 'Yes' : 'No') . "\n";
        //echo $dataStart['FechaInicio'] . '  ';
        if (
            $hourStartBetween == 'Yes' && $hourEndBetween == 'Yes' || $hourEndBetween == 'Yes' &&  $hourEndBetween == 'No'
            || $hourStartBetween == 'No' && $hourEndBetween == 'Yes'
        ) {
            $disponibilidadFI += 1;
        } else if ($hourStartBetween == 'No' &&  $hourEndBetween == 'No') {
            //  echo 'Si hay disponibilidad en la hora que escogio 14:00:00 - 15:00:00  en esa fecha esta disponible ' . $dataStart['IdHorario'] . ' ' . $hourStart1 . '-' . $hourEnd1;
            // echo '<br>';
            //$disponibilidadFechaInicio = 'Yes';
        }
    }
    //echo '*********************************************';
    /**
     * comienzo de foreach con las horas 
     * comprendidas en la fecha final
     */

    foreach ($dateEndIsBetween as $dataEnd) {

        $cantidadFF += 1;
        $hourStart2 = $dataEnd['HoraInicio'];
        $hourEnd2 = $dataEnd['HoraFin'];
        //echo $dataEnd['FechaFin'] . '  ';
        //echo $hourEnd2. '  ';
        $hourStartBetween2  = $scheduleController->hourIsBetween($hourStart2,  $hourEnd2, $horaInicioFormateada) ? 'Yes' : 'No';  //echo $horaEntre;
        $hourEndBetween2 = $scheduleController->hourIsBetween($hourStart2,  $hourEnd2, $horaFinFormateada) ? 'Yes' : 'No';  //echo $horaEntre;
        //echo 'End ';
        // echo $dataEnd['FechaInicio'] . ' ';
        //echo "$hourStart2 <= $horaInicioFormateada <= $hourEnd2 -> " . ($scheduleController->hourIsBetween($hourStart2, $hourEnd2, $horaInicioFormateada) ? 'Yes' : 'No') . "\n";
        // echo $dataEnd['FechaFin'] . ' ';
        // echo "$hourStart2 <= $horaFinFormateada <= $hourEnd2 -> " . ($scheduleController->hourIsBetween($hourStart2, $hourEnd2, $horaFinFormateada) ? 'Yes' : 'No') . "\n";
        if (
            $hourStartBetween2 == 'Yes' &&  $hourEndBetween2 == 'Yes' || $hourStartBetween2 == 'Yes' &&  $hourEndBetween2 == 'No'
            || $hourStartBetween2 == 'No' &&  $hourEndBetween2 == 'Yes'
        ) {
            $disponibilidadFF += 1;
        } else if ($hourStartBetween2 == 'No' &&  $hourEndBetween2 == 'No') {
            // echo 'Si hay disponibilidad en la hora que escogio 14:00:00 - 15:00:00  en esa fecha esta disponible ' . $dataEnd['IdHorario'] . ' ' . $hourStart2 . '-' . $hourEnd2;
            //echo '<br>';
            //$disponibilidadFechaInicio = 'Yes';
        }
    }
    $cantidadDisponibleFI = $cantidadFI - $disponibilidadFI;
    $cantidadDisponibleFF = $cantidadFF - $disponibilidadFF;

    if ($cantidadDisponibleFI ==  $cantidadFI) {
        //echo 'disponibilidad en Fecha de incio: ' . $cantidadDisponibleFI;
        //echo   $cantidadFI . ' == ó !=  ' . $disponibilidadFI;;
        // echo ' ';
        if ($cantidadDisponibleFF == $cantidadFF) {
            // echo $cantidadFF  . ' == ó != ' . $disponibilidadFF;
            // echo ' ';
            // echo  $horaFin;
            if ($cantidadDisponibleFI ==  $cantidadFI  && $cantidadDisponibleFF == $cantidadFF) {
                //echo 'Si existe disponibilidad en ese horario ' . $cantidadDisponibleFI  . '  ' .  $cantidadDisponibleFF;
                $result = $scheduleController->addSchedule($fechaIncio, $fechaFin, $fechaFinFormateada, $horaInicio, $horaFin, $idEstudiante, $idUser);
                if ($result) {
                    echo 'Horario agregado exitosamente';
                } else {
                    echo 'hubo un error al agregar los datos';
                }
            } else {
                echo 'Lo sentimos, no existe disponibilidad en ese horario intente con otro';
            }
        } else {
            echo 'Lo sentimos, no existe disponibilidad en ese horario intente con otro';
        }
    } else {
        echo 'Lo sentimos, no existe disponibilidad en ese horario intente con otro';
    }

    /*$result = $scheduleController->addSchedule($color, $fechaIncio, $fechaFin, $horaInicio, $horaFin, $idEstudiante, $idUser);
    if ($result) {
        echo 'Horario agregado exitosamente';
    } else {
        echo "hubo un error al agregar los datos";
    }*/
}
function editEventDate()

{
    if (isset($_POST['Event'][0]) && isset($_POST['Event'][1]) && isset($_POST['Event'][2])) {
        $id = $_POST['Event'][0];
        $start = $_POST['Event'][1];
        $end = $_POST['Event'][2];
        $rep = "";

        $scheduleController = new ScheduleController();
        $result = $scheduleController->editEventDate($id, $start, $end);
        //echo $result;
        if ($result) {
            echo "se actualizo correctamente la fecha";
            $rep = "ok";
        } else {
            echo "hubo un error al actualizar la fecha";
        }
    }
}



function delete()

{
    // Conexion a la base de datos
    if (isset($_POST['delete']) && isset($_POST['id'])) { //Eliminar horario
        $id = $_POST['id'];
        $scheduleController = new ScheduleController();
        $result = $scheduleController->deleteSchedule($id);
        if ($result) {
            echo "Horario eliminado";
        } else {

            echo "hubo un error al eliminar el horario";
        }
    }
}



function actualizar()
{
    $id = $_POST['id'];
    $horaInicio = $_POST['horaInicio'];
    $horaFin = $_POST['horaFin'];
    $fechaIncio = $_POST['start'];
    $fechaFin = $_POST['end'];
    /**Datos*/
    $scheduleController = new ScheduleController();
    $horaInicioFormateada = date("H:i:s", strtotime($horaInicio . '+ 1 minute')); //fecha en formato 00:00:00
    $horaFinFormateada = date("H:i:s", strtotime($horaFin . '- 1 minute')); //fecha en formato 00:00:00
    $fechaFinFormateada = date("Y-m-d", strtotime($fechaFin . '- 1 days')); // fecha fin - 1 day
    $dateStartIsBetween = $scheduleController->dateStartIsBetween($fechaIncio, $fechaFinFormateada);
    $cantidadFI = 0; // Cantidad de fechas inicales en ese rango;
    $disponibilidadFI = 0;
    /**Variables de fecha final */
    // Obtiene el rango de fechas finales que se encuentra en el rango de la fecha inicial y fecha final otorgadas
    $dateEndIsBetween = $scheduleController->dateEndIsBetween($fechaIncio, $fechaFinFormateada);
    $cantidadFF = 0; // Cantidad de fechas finales  en ese rango;
    $disponibilidadFF = 0;
    foreach ($dateStartIsBetween as $dataStart) { //Para todo el rango de horas en la fecha inicia
        $cantidadFI += 1;
        $hourStart1 = $dataStart['HoraInicio'];
        $hourEnd1 = $dataStart['HoraFin'];
        $hourStartBetween  = $scheduleController->hourIsBetween($hourStart1,  $hourEnd1, $horaInicioFormateada) ? 'Yes' : 'No';  //echo $horaEntre;   
        $hourEndBetween = $scheduleController->hourIsBetween($hourStart1,  $hourEnd1, $horaFinFormateada) ? 'Yes' : 'No';  //echo $horaEntre;
        if (
            $hourStartBetween == 'Yes' && $hourEndBetween == 'Yes' || $hourEndBetween == 'Yes' &&  $hourEndBetween == 'No'
            || $hourStartBetween == 'No' && $hourEndBetween == 'Yes'
        ) {
            $disponibilidadFI += 1;
        } else if ($hourStartBetween == 'No' &&  $hourEndBetween == 'No') {
        }
    }

    foreach ($dateEndIsBetween as $dataEnd) {
        $cantidadFF += 1;
        $hourStart2 = $dataEnd['HoraInicio'];
        $hourEnd2 = $dataEnd['HoraFin'];
        $hourStartBetween2  = $scheduleController->hourIsBetween($hourStart2,  $hourEnd2, $horaInicioFormateada) ? 'Yes' : 'No';  //echo $horaEntre;
        $hourEndBetween2 = $scheduleController->hourIsBetween($hourStart2,  $hourEnd2, $horaFinFormateada) ? 'Yes' : 'No';  //echo $horaEntre;
        if (
            $hourStartBetween2 == 'Yes' &&  $hourEndBetween2 == 'Yes' || $hourStartBetween2 == 'Yes' &&  $hourEndBetween2 == 'No'
            || $hourStartBetween2 == 'No' &&  $hourEndBetween2 == 'Yes'
        ) {
            $disponibilidadFF += 1;
        } else if ($hourStartBetween2 == 'No' &&  $hourEndBetween2 == 'No') {
        }
    }

    $cantidadDisponibleFI = $cantidadFI - $disponibilidadFI;
    $cantidadDisponibleFF = $cantidadFF - $disponibilidadFF;

    if ($cantidadDisponibleFI ==  $cantidadFI) {
        if ($cantidadDisponibleFF == $cantidadFF) {
            if ($cantidadDisponibleFI ==  $cantidadFI  && $cantidadDisponibleFF == $cantidadFF) {
                //echo 'Si existe disponibilidad en ese horario ' . $cantidadDisponibleFI  . '  ' .  $cantidadDisponibleFF;
                $result = $scheduleController->updateSchedule($id, $horaInicio, $horaFin, $fechaIncio, $fechaFin, $fechaFinFormateada);
                if ($result) {
                    echo 'Horario actualizado exitosamente';
                } else {
                    echo 'Horario actualizado exitosamente';
                }
            } else {
                echo 'Lo sentimos, no existe disponibilidad en ese horario intente con otro';
            }
        } else {
            echo 'Lo sentimos, no existe disponibilidad en ese horario intente con otro';
        }
    } else {
        echo 'Lo sentimos, no existe disponibilidad en ese horario intente con otro';
    }
}



function buscar()
{
    $texto = $_POST['texto'];
    $controller = new ScheduleController();
    $result = $controller->buscar($texto);
    if (!$result) {
        echo 'No se encuentra ningun estudiante con ese nombre...';
    } else {
        echo $result;
    }
}

function ReCargarEstudianteHorario()
{
    $offset = $_POST['offset'];
    $id = $_POST['id'];
    $controller = new ScheduleController();
    $result = $controller->reloadSchedule($offset, $id);
    if (!$result) {
        echo 'No se encuentra ningun estudiante con ese nombre...';
    } else {
        echo $result;
    }
}

if (isset($_POST['callback'])) {
    $function = $_POST['callback'];
    if ($function == 'addSchedule') {
        addSchedule();
    }
    if ($function == 'editEventDate') {
        editEventDate();
    }
    if ($function == 'actualizar') {
        actualizar();
    }
    if ($function == 'buscar') {
        buscar();
    }
    if ($function == 'delete') {
        delete();
    }
    if ($function == 'ReCargarEstudianteHorario') {
        ReCargarEstudianteHorario();
    }
}
