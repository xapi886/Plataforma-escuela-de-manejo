<?php



/**

 * Clase controladora ScheduleController

 */

class ScheduleController

{



    public function getAllHorario($id)

    {

        $scheduleModel  = new ScheduleModel();



        return $scheduleModel->getAlltHorario($id);

    }



    public function addSchedule($fechaIncio,$fechaFin,$fechaFinForm,$horaInicio,$horaFin,$idEstudiante,$idUsuario) {



        $scheduleModel  = new ScheduleModel();

        return $scheduleModel->addSchedule($fechaIncio,$fechaFin,$fechaFinForm,$horaInicio,$horaFin,$idEstudiante,$idUsuario);

    }



    public function editEventdate($id, $start, $end)

    {



        $scheduleModel  = new ScheduleModel();

        return $scheduleModel->editEventDate($id, $start, $end);

    }





    public function updateSchedule($id, $horaInicio, $horaFin,$fechaInicio,$fechaFin,$fechaFinForm)

    {



        $scheduleModel  = new ScheduleModel();

        return $scheduleModel->updateSchedule($id, $horaInicio, $horaFin,$fechaInicio,$fechaFin,$fechaFinForm);

    }



    public function deleteSchedule($id)

    {



        $scheduleModel  = new ScheduleModel();

        return $scheduleModel->deleteSchedule($id);

    }



    public function getHorarioByStudent($id)

    {



        $scheduleModel  = new ScheduleModel();

        return $scheduleModel->getHorarioByStudent($id);

    }



    public function rowCountSchedules()

    {



        $scheduleModel  = new ScheduleModel();

        return $scheduleModel->rowCountSchedules();

    }



    public function getNextSchedule($offset, $id)

    {

        $scheduleModel  = new ScheduleModel();

        return $scheduleModel->getNextSchedule($offset, $id);

    }



    public function getNoRepeatSchedule($offset)

    {

        $scheduleModel  = new ScheduleModel();

        return $scheduleModel->getNoRepeatSchedule($offset);

    }



    public function scheduleAvailability($fechaIncio, $fechaFin, $horaInicio, $horaFin)

    {

        $scheduleModel  = new ScheduleModel();

        return $scheduleModel->scheduleAvailability($fechaIncio, $fechaFin, $horaInicio, $horaFin);

    }



    public function buscar($texto)

    {

        $scheduleModel  = new ScheduleModel();

        return $scheduleModel->buscar($texto);

    }



    public function reloadSchedule($offset, $id)

    {

        $scheduleModel  = new ScheduleModel();

        return $scheduleModel->reloadSchedule($offset, $id);

    }

    // Verificacion de disponibilidad

    public function hourIsBetween($desde, $hasta, $input)

    {

        $scheduleModel  = new ScheduleModel();

        return $scheduleModel->hourIsBetween($desde, $hasta, $input);

    }



    public function dateEndIsBetween($fechaInicio, $fechaFin)

    {

        $scheduleModel  = new ScheduleModel();

        return $scheduleModel->dateEndIsBetween($fechaInicio, $fechaFin);

    }

    public function dateStartIsBetween($fechaInicio, $fechaFin)

    {

        $scheduleModel  = new ScheduleModel();

        return $scheduleModel->dateStartIsBetween($fechaInicio, $fechaFin);

    }

}

