<?php

class HorarioModel extends db{



    private $idHorario;
    private $fechaCreacion;
    private $fechaInicio;
    private $fechaFin;
    private $idEstudiante;
    private $idUsuario;

    public function _Construct(){
    }

    public function setIdHorario($idHorario){
        $this->idHorario = $idHorario;
    }

    public function setFechaCreacion($fechaCreacion){
        $this->fechaCreacion = $fechaCreacion;
    }

    public function setFechaInicio($fechaInicio){
        $this->fechaInicio = $fechaInicio;
    }

    public function setFechaFin($fechaFin){
        $this->fechaFin = $fechaFin;
    }

    public function setidEstudiante($idEstudiante){
        $this->idEstudiante = $idEstudiante;
    }

    public function setIdUsuario($idUsuario){
        $this->idUsuario = $idUsuario;
    }

    public function getIdHorario(){
       return $this->idHorario;
    }

    public function getFechaCreacion(){
        return $this->fechaCreacion;
    }

    public function getFechaInicio(){
      return  $this->fechaInicio;
    }

    public function getFechaFin(){
        return $this->fechaFin;
    }

    public function getIdEstudiante(){
        return $this->idEstudiante;
    }

    public function getIdUsuario(){
        $this->idUsuario;
    }

    public function insertar($Horario)
    {
        $consulta = "
            INSERT INTO Horario (`FechaCreacion`, `FechaInicio`,`FechaFin`, `IdEstudiante`, `IdUsuario`) 
            VALUES (:fechaCreacion, :fechaInicio, :fechaFin, :IdEstudiante, :IdUsuario);";
        $query = $this->connect()->prepare($consulta);
        $query->execute([
            'FechaCreacion' => $Horario->getFechaCreacion(),
            'FechaInicio' => $Horario->getFechaInicio(),
            'FechaFin' => $Horario->getFechaFin(),
            'IdEstudiante' => openssl_decrypt($Horario->getIdEstudiante(), COD, KEY),
            'IdUsuario' => openssl_decrypt($Horario->getIdUsuario(), COD, KEY),
        ]);

        if (($query->errorInfo()[2] . "") == "") {
            return true;
        } else {
            return false;
        }
    }

    public function actualizar($Horario)
    {
            $consulta = "UPDATE `horario` 
            SET 
            `FechaCreacion` = :fechaCreacion, 
            `FechaInicio` = :fechainicio, 
            `FechaFin` = :fechafin,
            WHERE 
            (`IdHorario` = :idHorario);";
            $query = $this->connect()->prepare($consulta);
            $query->execute([   
                'fechaCreacion' => $Horario->getApellido(),
                'fechaInicio' => $Horario->getCedula(),
                'fechafin' => $Horario->getFechaFin(),
                ]);
            if (($query->errorInfo()[2] . "") == "") {
                $success = true;
            } else {
                $success = false;
            }
    }

    public function getHorarioById($id){
        $consulta = "SELECT * FROM Horario WHERE IdHorario = :IdHorario ;";
        $query = $this->connect()->prepare($consulta);
        $query->execute(['IdHorario' => $id]);
        $Horario = new HorarioModel();
        foreach ($query as $res) {
            $Horario->setIdHorario($res['IdHorario']);
            $Horario->setFechaCreacion($res['FechaCreacion']);
            $Horario->setFechaInicio($res['FechaInicio']);
            $Horario ->setFechaFin($res['FechaFin']); 
            $Horario ->setIdEstudiante($res['IdEstudiante']); 
            $Horario ->setIdUsuario($res['IdUsuario']); 
        }
        return $Horario;
    }
  
    public function getIdByHorario($Horario) {
        $consulta = "SELECT * FROM Horario  
                    WHERE  
                    IdHorario = :IdHorario AND  
                    FechaCreacion = :FechaCreacion AND 
                    FechaInicio = :FechaInicio AND 
                    FechaFin = :FechaFin ";
        $query = $this->connect()->prepare($consulta);
        $query->execute([
            'fechaCreacion' => $Horario->getApellido(),
            'fechaInicio' => $Horario->getCedula(),
            'fechafin' => $Horario->getFechaFin(),
            'IdEstudiante' => $Horario->getIdEstudiante(),
            'IdUsuario' => $Horario->getIdUsuario(),
        ]);
        foreach ($query as $res) {
            $result = $res['IdHorario'];
        }
        return $result;
    }

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









    

}



?>