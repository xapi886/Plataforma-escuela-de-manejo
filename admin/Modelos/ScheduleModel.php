<?php

/**
 * Clase modelo ScheduleModel
 */
class ScheduleModel extends Conexion
{
    //visualizar todos los horarios
    public function getAlltHorario($id)
    {
        $query = $this->connect()->prepare('SELECT h.IdHorario,e.Nombre,e.Apellido,h.FechaCreacion,h.FechaInicio,
                                            h.FechaFin,h.HoraInicio,h.HoraFin,h.IdEstudiante,h.IdUsuario
                                            FROM horario h INNER JOIN estudiante e 
                                            ON h.IdEstudiante=e.IdEstudiante
                                            INNER JOIN instructor i 
                                            ON i.IdInstructor = e.idInstructor WHERE e.idInstructor = ' . $id .' ;');
        $query->execute();
        return $query->fetchAll();
    }

    /***SELECT e.IdEstudiante, i.IdInstructor,h.IdHorario,e.Nombre,e.Apellido,
     *  h.FechaCreacion,h.FechaInicio,h.FechaFin,h.HoraInicio,h.HoraFin 
     * from estudiante e inner JOIN instructor i on e.idInstructor = i.IdInstructor 
     * inner JOIN horario h on e.IdEstudiante = h.IdEstudiante where e.idInstructor = 2 */

    public function getHorarioByStudent($id)
    {

        $query = $this->connect()->prepare('SELECT h.IdHorario,e.Nombre,e.Apellido,h.Color,h.FechaCreacion,h.FechaInicio,
                                             h.FechaFin,h.HoraInicio,h.HoraFin,h.IdEstudiante,h.IdUsuario
                                             FROM horario h INNER JOIN estudiante e 
                                             ON h.IdEstudiante=e.IdEstudiante INNER JOIN 
                                             usuario u ON h.IdUsuario = u.IdUsuario
                                             WHERE h.IdEstudiante=' . $id . ';');
        $query->execute();
        return $query->fetchAll();
    }

    //Añadir horario
    public function addSchedule($fechaIncio, $fechaFin,$fechaFinForm, $horaInicio, $horaFin, $idEstudiante, $idUsuario)
    {

        $fecha = date("Y-m-d H:i:s");
        $consulta = "INSERT INTO `horario`( `FechaCreacion`,
        `FechaInicio`, `FechaFin`,`FechaFinForm`, `HoraInicio`, `HoraFin`,`IdEstudiante`, `IdUsuario`)
         VALUES (:fechaCreacion,:fechaInicio,:fechaFin,:fechaFinForm,:horaInicio,:horaFin,:idEstudiante,:idUsuario)";

        $query = $this->connect()->prepare($consulta);
        $query->execute([
            'fechaCreacion' =>  $fecha,
            'fechaInicio' => $fechaIncio,
            'fechaFin' => $fechaFin,
            'fechaFinForm' => $fechaFinForm,
            'horaInicio' => $horaInicio,
            'horaFin' =>  $horaFin,
            'idEstudiante' => $idEstudiante,
            'idUsuario' => $idUsuario,

        ]);

        if (($query->errorInfo()[2] . "") == "") {
            return true;
        } else {
            return false;
        }
    }

    //editar fecha de los horarios

    public function editEventDate($id, $start, $end)
    {
        $consulta = "UPDATE `horario` SET FechaInicio='$start', FechaFin='$end' WHERE IdHorario='$id'";
        $query = $this->connect()->prepare($consulta);
        $query->execute();

        if (($query->errorInfo()[2] . "") == "") {
            return true;
        } else {
            return false;
        }
    }


    public function deleteSchedule($id)
    {
        $consulta = "DELETE FROM `horario` WHERE IdHorario='$id'";
        $query = $this->connect()->prepare($consulta);
        $query->execute();
    }

    public function updateSchedule($id, $horaInicio, $horaFin,$fechaInicio,$fechaFin,$fechaFinForm)
    {
        $consulta = "UPDATE horario SET HoraInicio='$horaInicio', HoraFin='$horaFin',
        FechaInicio = '$fechaInicio', FechaFin='$fechaFin',FechaFinForm='$fechaFinForm' WHERE IdHorario='$id'";
        $query = $this->connect()->prepare($consulta);
        $query->execute();

    }

    public function rowCountSchedules()
    {
        $consulta = "SELECT COUNT(DISTINCT `IdEstudiante` )AS Num_Estdudiantes FROM horario";
        $query = $this->connect()->prepare($consulta);
        $query->execute();

        return $query->fetchColumn();
    }


    public function getNextSchedule($offset, $id)
    {

        $query = $this->connect()
            ->prepare("CALL get_next_schedule(:offset,:id);");
        $query->execute(
            [
                'offset' => $offset,
                'id' =>  $id
            ]
        );
        return $query->fetchAll();
    }

    public function getNoRepeatSchedule($offset)
    {
        $query = $this->connect()
            ->prepare("SELECT DISTINCT h.IdEstudiante 
            AS Id, CONCAT_WS(' ',e.Nombre, e.Apellido) AS NombreCompleto
             FROM horario h INNER JOIN estudiante e 
             ON h.IdEstudiante = e.IdEstudiante LIMIT $offset,6
             ;");
        $query->execute();
        return $query->fetchAll();
    }

    public function buscar($texto)
    {
        $dia = "";
        $html = "";
        $consulta = "SELECT DISTINCT(e.IdEstudiante) as Id,
         (CONCAT_WS(' ', e.Nombre, e.Apellido)) as NombreCompleto         
         FROM estudiante e INNER JOIN horario h ON e.Idestudiante = h.IdEstudiante
         WHERE CONCAT_WS(' ', e.Nombre, e.Apellido) LIKE CONCAT('%','$texto', '%') group by e.IdEstudiante";

        $query = $this->connect()->prepare($consulta);
        $query->execute();
        foreach ($query as $res) {
            $id = $res['Id'];
            // $html .= '<label> ' . $res['Id'] . '</label>';
            $data = $this->getNextSchedule(0, $id);
            $html .= '<div class="card bg-light m-2" style="width:18rem; max-height: 20rem; height: auto;">';
            $html .= '<div class="card-header text-center">' . $res['NombreCompleto'] . '</div>';
            $html .= '<div class="card-body">';
            $html .= '<div>';
            $html .= '<dl class="row mb-0" style="font-size: 12px;">';
            $html .= '<dt class="col-sm-8">Horario:</dt>';
            $html .= '<dd class="col-sm-4 ">Práctico</dd>';
            $html .= '</dl>';
            //$dia = date("d", strtotime($star));
            //$diaSemana = $this->dia_semana($star);
            foreach ($data as $item) {
                $arrH = explode(":", $item['HoraInicio']);
                $arrHF = explode(":", $item['HoraFin']);
                $fecha1 = $item['FechaInicio'];
                $fecha2 = $item['FechaFin'];
                if ($fecha1  == date("Y-m-d", strtotime($fecha2 . "- 1 days"))) {
                    $html .= '<dl class="row mb-0 " style="font-size: 12px;">';
                    $diaSemana =  $this->dia_semana($fecha1);
                    $html .=  $diaSemana;
                    $html .= '<dd class="col-sm-4 ">' . $arrH['0'] . ':' . $arrH['1'] . '-' . $arrHF['0'] . ':' . $arrHF['1'] . ' </dd>';
                    $html .= '</dl>';
                } else if ($fecha1 < date("Y-m-d", strtotime($fecha2 . "- 1 days"))){
                    $html .= '<dl class="row mb-0 " style="font-size: 12px;">';
                    //dia_semana($i);
                    $fechaFin = date("Y-m-d", strtotime($fecha2 . "- 1 days"));
                    $html .= $this->dia_semana_fin($fecha1, $fechaFin);
                    $html .= '<dd class="col-sm-4 ">' . $arrH['0'] . ':' . $arrH['1'] . '-' . $arrHF['0'] . ':' . $arrHF['1'] . ' </dd>';
                    $html .= '</dl>';
                }
            }
            $html .= '</div>';
            $html .= '</div>';
            $html .= '<div class="card-footer bg-transparent text-right">';
            $html .= '<a href="/admin/vistas/gestion-horario.php?data=' . $res['Id'] . '" class="btn btn-primary btn-sm">Ver detalle</a>';
            $html .= '</div>';
            $html .= '</div>';
        }


        if (($query->errorInfo()[2] . "") == "") {
            return $html;
        } else {
            return false;
        }
    }


    public function reloadSchedule($offset, $id)
    {
        $html = "";
        $dia = "";
        $Info = $this->getNoRepeatSchedule($offset);
        foreach ($Info as $res) {
            $id = $res['Id'];
            //  echo $id;
            //$dia="";
            //$dia=date("D", strtotime("2021-03-16"));    
            //echo $dia;
            // echo $id;
            $data = $this->getNextSchedule(0, $id);
            $html .=  '<div class="card schedule-reload bg-light m-2" style="width:18rem; max-height: 20rem; height: auto;">';
            $html .=  '<div class="card-header text-center">' . $res['NombreCompleto'] . '</div>';
            $html .=  '<div class="card-body">';
            $html .=  '<div>';
            $html .=  '<dl class="row mb-0" style="font-size: 12px;">';
            $html .=  '<dt class="col-sm-8">Horario:</dt>';
            $html .=  '<dd class="col-sm-4 ">Práctico</dd>';
            $html .=  '</dl>';
            foreach ($data as $item) {
                $arrH = explode(":", $item['HoraInicio']);
                $arrHF = explode(":", $item['HoraFin']);
                $fecha1 = $item['FechaInicio'];
                $fecha2 = $item['FechaFin'];

                if ($fecha1  == date("Y-m-d", strtotime($fecha2 . "- 1 days"))) {
                    $html .= '<dl class="row mb-0 " style="font-size: 12px;">';
                    $diaSemana =  $this->dia_semana($fecha1);
                    $html .=  $diaSemana;
                    $html .=  '<dd class="col-sm-4 ">' . $arrH['0'] . ':' . $arrH['1'] . '-' . $arrHF['0'] . ':' . $arrHF['1'] . ' </dd>';
                    $html .=  '</dl>';
                } else if ($fecha1 < date("Y-m-d", strtotime($fecha2 . "- 1 days"))) {
                    $html .=  '<dl class="row mb-0 " style="font-size: 12px;">';
                    //dia_semana($i);
                    $fechaFin = date("Y-m-d", strtotime($fecha2 . "- 1 days"));
                    $diaSemanaFin = $this->dia_semana_fin($fecha1, $fechaFin);
                    $html .=  $diaSemanaFin;
                    $html .=  '<dd class="col-sm-4 ">' . $arrH['0'] . ':' . $arrH['1'] . '-' . $arrHF['0'] . ':' . $arrHF['1'] . ' </dd>';
                    $html .=  '</dl>';
                }
                //echo '<dt class="col-sm-12">'.$item['FechaInicio'].' hasta '.$item['FechaFin'].'</dt>';
                //echo '<dd class="col-sm-12">'.$arrH ['0'].':'.$arrH['1'].' a '.$arrHF ['0'].':'.$arrHF['1'].' </dd>';
            }
            $html .=  '</div>';
            $html .=  '</div>';
            $html .=  '<div class="card-footer bg-transparent text-right">';
            $html .=  '<a href="/admin/vistas/gestion-horario.php?data=' . $id . '" class="btn btn-primary btn-sm">Editar</a>';
            $html .=  '</div>';
            $html .=  '</div>';
            $html .=  '<input id="id" type="hidden" name="offset" value=' . $res['Id'] . ' >';
        }

        return $html;
    }


    function dia_semana($fecha)
    {
        $dia = date("d", strtotime($fecha));

        $dias = array('', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo');
        $dia_semana = $dias[date('N', strtotime($fecha))];
        //                echo $dia_semana.' '.$dia;

        return '<dt class="col-sm-8">' . $dia_semana . ' ' . $dia . '</dt>';
    }

    function dia_semana_fin($fecha1, $fecha2)
    {
        $diaIncio = date("d", strtotime($fecha1));
        $diaFin = date("d", strtotime($fecha2));

        $dias = array('', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo');
        $dia_semana_Incio = $dias[date('N', strtotime($fecha1))];
        $dia_semana_Fin = $dias[date('N', strtotime($fecha2))];

        //                echo $dia_semana.' '.$dia;

        return '<dt class="col-sm-8 text-left ">' . $dia_semana_Incio . ' ' . $diaIncio  . ' - ' . $dia_semana_Fin . ' ' . $diaFin . '</dt>';
    }

    public function scheduleAvailability($fechaIncio, $fechaFin, $horaInicio, $horaFin)
    {
        $id = '';
        $consulta = "SELECT `IdHorario`FROM `horario`
                     WHERE `FechaInicio` = '$fechaIncio' AND `FechaFin`='$fechaFin'
                     AND `HoraInicio`='$horaInicio' AND `HoraFin`='$horaFin';";

        $query = $this->connect()->prepare($consulta);
        $query->execute();

        foreach ($query as $res) {
            $id = $res['IdHorario'];
        }

        if (($query->errorInfo()[2] . "") == "") {
            return $id;
        } else {
            return false;
        }
    }

    public function hourIsBetween($from, $to, $input)
    {
        $dateFrom = DateTime::createFromFormat('!H:i:s', $from); //hora inicial
        $dateTo = DateTime::createFromFormat('!H:i:s', $to); //hora final
        $dateInput = DateTime::createFromFormat('!H:i:s', $input); //hora introducida
        if ($dateFrom > $dateTo) $dateTo->modify('+1 day'); //verificar diferencia de un dia
        return ($dateFrom <= $dateInput && $dateInput <= $dateTo) || ($dateFrom <= $dateInput->modify('+1 day') && $dateInput <= $dateTo);
    }

    public function dateStartIsBetween($fechaInicio, $fechaFin){
        $consulta = "SELECT `IdHorario`,`HoraInicio`,`HoraFin`,`FechaInicio`,`FechaFin`
                     FROM `horario` WHERE `FechaInicio` BETWEEN '$fechaInicio' AND '$fechaFin';
                     ";    
        $query = $this->connect()->prepare($consulta);
        $query->execute();
        return $query->fetchAll();
    }

    public function dateEndIsBetween($fechaInicio, $fechaFin){
        $consulta = "SELECT `IdHorario`,`HoraInicio`,`HoraFin`,`FechaInicio`,`FechaFin`
                     FROM `horario` WHERE `FechaFinForm` BETWEEN '$fechaInicio' AND '$fechaFin';
                     ";    
        $query = $this->connect()->prepare($consulta);
        $query->execute();
        return $query->fetchAll();

    }






}
