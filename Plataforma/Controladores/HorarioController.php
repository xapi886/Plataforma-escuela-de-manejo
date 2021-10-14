<?php
class HorarioController
{
    public function getHorarioByStudent($id)
    {
        $scheduleModel  = new HorarioModel();
        return $scheduleModel->getHorarioByStudent($id);
    }
}
