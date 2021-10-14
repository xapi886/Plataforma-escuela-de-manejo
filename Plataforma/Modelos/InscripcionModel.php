<?php

class InscripcionModel extends DB
{

    private $idInscripcion;
    private $fechaInscripcion;
    private $principiante;
    private $licenciadeconducir;
    private $categoria;
    private $lugardeTrabajo;
    private $direccionLT;
    private $telefonoLT;
    private $emailLT;
    private $nombreCE;
    private $apellidoCE;
    private $direccionCE;
    private $telefonoCE;
    private $emailCE;
    private $observaciones;
    private $idEstudiante;
    private $idNivelCurso;
    private $idTurno;
    public function __construct()
    {

    }
    //Metodos SET
    public function setIdInscripcion($idInscripcion)
    {
        $this->idInscripcion = $idInscripcion;
    }
    public function setIdEstudiante($idEstudiante)
    {
        $this->idEstudiante = $idEstudiante;
    }
    public function setFechaInscripcion($fechaInscripcion)
    {
       $this->idfechaInscripcion = $fechaInscripcion;
    }
    public function setPrinciante($principiante)
    {
        $this->principiante = $principiante;
    }
    public function setlicenciadeconducir($licenciadeconducir)
    {
        $this->licenciadeconducir = $licenciadeconducir;
    }
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;
    }

    public function setLugardeTrabajo($lugardeTrabajo)
    {
        $this->lugardeTrabajo = $lugardeTrabajo;
    }
    public function setdireccionLT($direccionLT)
    {
        $this->direccionLT = $direccionLT;
    }
    public function setTelefonoLT($telefonoLT)
    {
        $this->telefonoLT = $telefonoLT;
    }
    public function setEmailLT($emailLT)
    {
        $this->emailLT = $emailLT;
    }
    public function setNombreCE($nombreCE)
    {
        $this->nombreCE = $nombreCE;
    }

    public function setApellidoCE($apellidoCE)
    {
        $this->apellidoCE = $apellidoCE;
    }

    public function setDireccionCE($direccionCE)
    {
        $this->direccionCE = $direccionCE;
    }
    public function setEmailCE($emailCE)
    {
        $this->emailCE = $emailCE;
    }
    public function setTelefonoCE($telefonoCE)
    {
        $this->telefonoCE = $telefonoCE;
    }
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;
    }
    public function setIdTurno($idTurno)
    {
        $this->idTurno = $idTurno;
    }
    public function setIdHorario($idNivelCurso)
    {
        $this->idNivelCurso = $idNivelCurso;
    }
    // METODOS GET
    public function getIdInscripcion()
    {
        return $this->idInscripcion;
    }
    public function getFechaInscripcion()
    {
        return $this->fechaInscripcion;
    }

    public function getPrinciante()
    {
       return $this->principiante;
    }

    public function getLicenciadeconducir()
    {
        return $this->licenciadeconducir;
    }
    public function getCategoria()
    {
        return $this->categoria;
    }
    public function getLugardeTrabajo()
    {
        return $this->lugardeTrabajo;
    }
    public function getDireccionLT()
    {
        return  $this->direccionLT;
    }
    public function getTelefonoLT()
    {
        return $this->telefonoLT;
    }
    public function getEmailLT()
    {
        return $this->emailLT;
    }
    public function getNombreCE()
    {
        return $this->nombreCE;
    }
    public function getApellidoCE()
    {
        return $this->apellidoCE;
    }
    public function getDireccionCE()
    {
        return $this->direccionCE;
    }
    public function getTelefonoCE()
    {
        return $this->telefonoCE;
    }
    public function getEmailCE()
    {
        return $this->emailCE;
    }
    public function getObservaciones()
    {
        return $this->observaciones;
    }
    public function getIdEstudiante()
    {
        return $this->idEstudiante;
    }
    public function getIdTurno()
    {
        return $this->idTurno;
    }
    public function getIdHorario()
    {
        return $this->idNivelCurso;
    }
    //Metodo para insertar la inscripcion
    public function insertar($Inscripcion)
    {
        $fechaInscripcion = date('y-m-d');
        $consulta =
            "INSERT INTO inscripcion (`FechaInscripcion`,`Principiante`,`LicenciadeConducir`,`Categoria`,`LugardeTrabajo`,`DireccionLT`,`TelefonoLT` ,`EmailLT`,`NombreCE`,`ApellidoCE`,`DireccionCE`,`TelefonoCE`, `EmailCE`,`Observaciones`,`IdEstudiante`,`IdTurno`,`IdNivel`) 
            VALUES (:fechaInscripcion,:principiante, :licenciadeconducir,:categoria,:lugardeTrabajo, :DireccionLT, :TelefonoLT,:emailLT,:nombreCE, :apellidoCE ,:direccionCE, :telefonoCE, :emailCE, :observaciones, :idEstudiante,:idTurno,:idnivel);";
        $query = $this->connect()->prepare($consulta);
        $query->execute([
            'fechaInscripcion' => $fechaInscripcion,
            'principiante' => $Inscripcion->getPrinciante(),
            'licenciadeconducir' => $Inscripcion->getLicenciadeconducir(),
            'categoria' => $Inscripcion->getCategoria(),
            'lugardeTrabajo' => $Inscripcion->getLugardeTrabajo(),
            'DireccionLT' => $Inscripcion->getDireccionLT(),
            'TelefonoLT' => $Inscripcion->getTelefonoLT(),
            'emailLT' => $Inscripcion->getEmailLT(),
            'nombreCE' => $Inscripcion->getNombreCE(),
            'apellidoCE' => $Inscripcion->getApellidoCE(),
            'direccionCE' => $Inscripcion->getDireccionCE(),
            'telefonoCE' => $Inscripcion->getTelefonoCE(),
            'emailCE' => $Inscripcion->getEmailCE(),
            'observaciones' => $Inscripcion->getObservaciones(),
            'idEstudiante' => $Inscripcion->getIdEstudiante(),
            'idTurno' => $Inscripcion->getIdTurno(),
            'idnivel' => $Inscripcion->getIdHorario()
        ]);

        if (($query->errorInfo()[2] . "") == "") {
            return true;
        } else {
            return false;
        }
    }

    public function getIdEstudianteBynombre($nombre)
    {
        $id = "";
        $consulta = "SELECT IdEstudiante from estudiante where Nombre = :nombre;";
        $query = $this->connect()->prepare($consulta);
        $query->execute(["nombre" => $nombre]);
        foreach ($query as $res) {
            $id = $res['IdEstudiante'];
        }
        return $id;
    }

    //Metodo para actualizar la inscripcion
    public function actualizar($Inscripcion, $idEstudiante)
    {
        $fechaInscripcion = date("Y-m-d H:i:s");
        $consulta = "UPDATE `inscripcion` 
            SET `FechaInscripcion` = :fechaInscripcion,
            `Principiante` = :principiante,
            `Licenciadeconducir` = :licenciadeConducir,
            `Categoria` = :categoria,
            `LugardeTrabajo` = :lugarderabajo,
            `DireccionLT` = :direccionLT,
            `TelefonoLT` = :telefonoLT,
            `EmailLT` = :emailLT,
            `NombreCE` = :nombreCE,
            `ApellidoCE` = :apellidoCE,
            `DireccionCE` = :direccionCE,
            `TelefonoCE` = :telefonoCE,
            `EmailCE` = :emailCE,
            `Observaciones` = :observaciones,
            `IdTurno` = :idTurno
            WHERE IdEstudiante = :idEstudiante;
            ";
        $query = $this->connect()->prepare($consulta);
        $query->execute([
            'idEstudiante' => $idEstudiante,
            'fechaInscripcion' => $fechaInscripcion,
            'principiante' => $Inscripcion->getPrinciante(),
            'licenciadeConducir' => $Inscripcion->getlicenciadeconducir(),
            'categoria' => $Inscripcion->getCategoria(),
            'lugarderabajo' => $Inscripcion->getLugardeTrabajo(),
            'direccionLT' => $Inscripcion->getDireccionLT(),
            'telefonoLT' => $Inscripcion->getTelefonoLT(),
            'emailLT' => $Inscripcion->getEmailLT(),
            'nombreCE' => $Inscripcion->getNombreCE(),
            'apellidoCE' => $Inscripcion->getApellidoCE(),
            'direccionCE' => $Inscripcion->getDireccionCE(),
            'telefonoCE' => $Inscripcion->getTelefonoCE(),
            'emailCE' => $Inscripcion->getEmailCE(),
            'observaciones' => $Inscripcion->getObservaciones(),
            'idTurno' => $Inscripcion->getIdTurno(),
        ]);

        if (trim($query->errorInfo()[2] . "") == "") {
            return true;
        } else {
            return $query->errorInfo()[2];
        }
    }

    public function getInscripcionById($id)
    {
        $consulta = "SELECT inscripcion a 
                    inner join estudiante e 
                     on a.IdEstudiante = e.IdEstudiante,
                     FechaInscripcion = :FechaInscripcion,
                     Principiante = :Principiante,
                     LicenciadeConducir = :LicenciadeConducir,
                     Categoria = :Categoria,
                     LugardeTrabajo = :LugardeTrabajo,
                     DireccionLT = :DireccionLT,
                     EmailLT = :EmaiLLT,
                     NombreCE = :NombreCE,
                     ApellidoCE = :ApellidoCE,
                     DireccionCE = :DireccionCE,
                     TelefonoCE = :TelefnoCE,
                     EmailCE = :EmailCE,
                     Observaciones = :Observaciones
                     IdEstudiante = :IdEstudiante
                     from inscripcion I 
                     inner join estudiante E on I.IdEstudiante = E.IdEstudiante                           
                        ";
        $query = $this->connect()->prepare($consulta);
        $query->execute(['IdInscripcion' => $id]);
        $Inscripcion = new InscripcionModel();
        foreach ($query as $res) {
            $Inscripcion->setIdInscripcion($res['IdInscripcion']);
            $Inscripcion->setlicenciadeconducir($res['LicenciadeConducir']);
            $Inscripcion->setCategoria($res['Categoria']);
            $Inscripcion->setLugardeTrabajo($res['LugardeTrabajo']);
            $Inscripcion->setdireccionLT($res['DireccionLT']);
            $Inscripcion->setEmailLT($res['EmailLT']);
            $Inscripcion->setNombreCE($res['NombreCE']);
            $Inscripcion->setApellidoCE($res['ApellidoCE']);
            $Inscripcion->setTelefonoCE($res['direccionCE']);
            $Inscripcion->setEmailCE($res['EmailCE']);
            $Inscripcion->setObservaciones($res['Observaciones']);
            $Inscripcion->setIdEstudiante($res['IdEstudiante']);
        }
        return $Inscripcion;
    }

    public function getIdByInscripcion($Inscripcion)
    {
        $consulta = "SELECT * FROM inscripcion  a 
                     inner join estudiante e 
                     on a.IdEstudiante = e.IdEstudiante,
                    WHERE  
                    Principiante = :principiante AND 
                    Licenciadeconducir = :Licenciadeconducir AND
                    Categoria = : categoria AND
                    LugardeTrabajo = :lugardeTrabajo AND
                    DireccionLT = :direccionLT AND
                    TelefonoLT = :telefonoLT AND
                    EmailLT = :emailLT AND
                    NombreCE = :nombreCE AND
                    ApellidoCE = :apellidoCE AND
                    DireccionCE = :direccionCE AND
                    TelefonoCE = :telefonoCE AND
                    EmailCE = :emailCE AND
                    Observaciones = :observaciones AND 
                    FechaCreacion = :FechaCreacion AND 
                    FechaInicio = :FechaInicio AND 
                    FechaFin = :FechaFin  AND 
                    IdEstudiante = :IdEstudiante";
        $query = $this->connect()->prepare($consulta);
        $query->execute([
            'Principiante' => $Inscripcion->getPrinciante(),
            'LicenciadeConducir' => $Inscripcion->getlicenciadeconducir(),
            'Categoria' => $Inscripcion->getCategoria(),
            'LugardeTrabajo' => $Inscripcion->getLugardeTrabajo(),
            'DireccionLT' => $Inscripcion->getDireccionLT(),
            'TelefonoLT' => $Inscripcion->getTelefonoLT(),
            'EmailLT' => $Inscripcion->getEmailLT(),
            'NombreCE' => $Inscripcion->getNombreCE(),
            'ApellidoCE' => $Inscripcion->getApellidoCE(),
            'DireccionCE' => $Inscripcion->getDireccionCE(),
            'TelefonoCE' => $Inscripcion->getTelefonoCE(),
            'EmailCE' => $Inscripcion->getEmailCE(),
            'Observaciones' => $Inscripcion->getObservaciones(),
            'IdEstudiante'  => $Inscripcion->getIdEstudiante(),
        ]);
        foreach ($query as $res) {
            $result = $res['IdInscripcion'];
        }
        return $result;
    }
    public function getIdEstudianteByInscripcion($email)
    {
        $result = "";
        $consulta = "select * from estudiante where email = :Email";
        $query = $this->connect()->prepare($consulta);
        $query->execute([
            $email => "Email"
        ]);
        foreach ($query as $res) {
            $result = $res['IdEstudiante'];
        }

        return $result;
    }

    public function getIdByEmail($userName)
    {
        $id = "";
        $consulta = "SELECT * FROM estudiante WHERE email = :Email";
        $query = $this->connect()->prepare($consulta);
        $query->execute([
            "Email" => $userName
        ]);
        //$estudiante = new EstudianteModel();
        foreach ($query as $res) {      //Psara por todos los datos del idEstudiante para encontrar al selecionado
            $id = $res['IdEstudiante'];
        }
        return $id;         //retorna al estudiante con el id Seleccionado
    }
    //Obtener el IdTurnoPorCodigo
    public function getIdTurnoByCodigo($Codigo)
    {
       $id = "";
        $consulta = "SELECT * FROM `turno`  WHERE `Codigo`='$Codigo'";
        $query = $this->connect()->prepare($consulta);
        $query->execute();
        foreach ($query as $res) {
            $id = $res['IdTurno'];
        }
        return $id;         //retorna al estudiante con el id Seleccionado
    }

    //Obtener el IdInscripcion By IdEstudiante
    public function getIdInscripcionByIdEstudiante($idEstudiante)
    {
        $id = "";
        $consulta = "SELECT * FROM `inscripcion` WHERE `IdEstudiante`='$idEstudiante'";
        $query = $this->connect()->prepare($consulta);
        $query->execute();
        foreach ($query as $res) {
            $id = $res['IdInscripcion'];
        }
        return $id;         //retorna al estudiante con el id Seleccionado
    }

   public function getInscripcionByEstudiante($id)
    {
        $id = "";
        $consulta = "SELECT t.Descripcion as Descripcion, n.Nivel, n.HorasPracticas 
                    FROM inscripcion i INNER JOIN turno t ON i.IdTurno = t.IdTurno
                    INNER JOIN nivel_curso n ON i.IdNivel = N.IdNivel
                    WHERE i.IdEstudiante='$id' ;";
        $query = $this->connect()->prepare($consulta);
        $query->execute();
        return $query;
    }

    public function updateDisponibilidad($Disponibilidad, $idturno)
    {
        $DispActualizada = "";
        $consulta = "UPDATE `turno` SET `Disponibilidad` = " . $Disponibilidad . " WHERE `IdTurno`=" . $idturno . ";";
        $query = $this->connect()->prepare($consulta);
        $query->execute();
        /*foreach ($query as $res) {     
            $DispActualizada = $res['Disponibilidad'];
        }*/
        if (trim($query->errorInfo()[2] . "") == "") {
            return true;
        } else {
            return $query->errorInfo()[2];
        }       //retorna al estudiante con el id Seleccionado
    }

    public function getDisponibilidadByIdTurno($idturno)
    {
        $DispActual = "";
        $consulta = "SELECT `Disponibilidad` FROM `turno` WHERE `IdTurno`=$idturno;";
        $query = $this->connect()->prepare($consulta);
        $query->execute();
        foreach ($query as $res) {
            $DispActual = $res['Disponibilidad'];
        }
        return $DispActual;         //retorna al estudiante con el id Seleccionado
    }



    public function updateEstado($id)
    {
        $consulta = "UPDATE `estudiante` SET `Estado` = 1 WHERE IdEstudiante= " . $id . "";
        $query = $this->connect()->prepare($consulta);
        $query->execute();
        if (trim($query->errorInfo()[2] . "") == "") {
            return true;
        } else {
            return $query->errorInfo()[2];
        }
    }

    public function disponibilidadByCodigo($codigo)
    {
        //$codigo = '';
        $codigoMatutino = '';
        $codigoVespertino = '';
        $idMatutino = '';
        $idVespertino = '';
        $result = '';
        $disponibilidadTurnoM = '';
        $disponibilidadTurnoV = '';
        if ($codigo == 'M_LUNES') { // verificando estudiante inscrito en turno Vespertino 1
            $codigoVespertino = 'V_LUNES';
           // $disponibilidadTurnoM = $this->disponibilidadByTurno($codigo);
            $disponibilidadTurnoV = $this->disponibilidadByTurno($codigoVespertino);
            if ($disponibilidadTurnoV <= 1) {
                $result = 0;  // No existe disponibilidad en este horario intente con otro
            } else if ($disponibilidadTurnoV == 2) {
                $result = 1;     //Si existe disponibilidad
            }
        } else if ($codigo == 'M_MARTES') { // 2
            $codigoVespertino = 'V_MARTES';
            //$disponibilidadTurnoM = $this->disponibilidadByTurno($codigo);
            $disponibilidadTurnoV = $this->disponibilidadByTurno($codigoVespertino);
            if ($disponibilidadTurnoV <= 1) {
                $result = 0;  // No existe disponibilidad en este horario intente con otro
            } else if ($disponibilidadTurnoV == 2) {
                $result = 1;     //Si existe disponibilidad
            }
        } else if ($codigo == 'M_MIERCOLES') { // 3
            $codigoVespertino = 'V_MIERCOLES';
            //$disponibilidadTurnoM = $this->disponibilidadByTurno($codigo);
            $disponibilidadTurnoV = $this->disponibilidadByTurno($codigoVespertino);
            if ($disponibilidadTurnoV <= 1) {
                $result = 0;  // No existe disponibilidad en este horario intente con otro
            } else if ($disponibilidadTurnoV == 2) {
                $result = 1;     //Si existe disponibilidad
            }
        } else if ($codigo == 'M_JUEVES') { //4
            $codigoVespertino = 'V_JUEVES';
            $disponibilidadTurnoM = $this->disponibilidadByTurno($codigo);
            $disponibilidadTurnoV = $this->disponibilidadByTurno($codigoVespertino);
            if ($disponibilidadTurnoV <= 1) {
                $result = 0;  // No existe disponibilidad en este horario intente con otro
            } else if ($disponibilidadTurnoV == 2) {
                $result = 1;     //Si existe disponibilidad
            }
        } else if ($codigo == 'M_VIERNES') { //5
            $codigoVespertino = 'V_JUEVES';
            $disponibilidadTurnoM = $this->disponibilidadByTurno($codigo);
            $disponibilidadTurnoV = $this->disponibilidadByTurno($codigoVespertino);
            if ($disponibilidadTurnoV <= 1) {
                $result = 0;  // No existe disponibilidad en este horario intente con otro
            } else if ($disponibilidadTurnoV == 2) {
                $result = 1;     //Si existe disponibilidad
            }
        } else if ($codigo == 'V_LUNES') { // verificando estudiante inscrito en turno Matutino 1 
            $codigoMatutino = 'M_LUNES';
            $disponibilidadTurnoV = $this->disponibilidadByTurno($codigo);
            $disponibilidadTurnoM = $this->disponibilidadByTurno($codigoMatutino);
            if ($disponibilidadTurnoM <= 1) {
                $result = 0;  // No existe disponibilidad en este horario intente con otro Existe un estudiante inscrito
            } else if ($disponibilidadTurnoM == 2) {
                $result = 1;     //Si existe disponibilidad
            }
        } else if ($codigo == 'V_MARTES') {  //2 
            $codigoMatutino = 'M_MARTES';
            $disponibilidadTurnoM = $this->disponibilidadByTurno($codigo);
            $disponibilidadTurnoV = $this->disponibilidadByTurno($codigoMatutino);
            if ($disponibilidadTurnoM <= 1) {
                $result = 0;  // No existe disponibilidad en este horario intente con otro
            } else if ($disponibilidadTurnoM == 2) {
                $result = 1;     //Si existe disponibilidad
            }
        } else if ($codigo == 'V_MIERCOLES') { //3 
            $codigoMatutino = 'M_MIERCOLES';
            $disponibilidadTurnoV = $this->disponibilidadByTurno($codigo);
            $disponibilidadTurnoM = $this->disponibilidadByTurno($codigoMatutino);
            if ($disponibilidadTurnoM <= 1) {
                $result = 0;  // No existe disponibilidad en este horario intente con otro
            } else if ($disponibilidadTurnoM == 2) {
                $result = 1;     //Si existe disponibilidad
            }
        } else if ($codigo == 'V_JUEVES') { // 4
            $codigoMatutino = 'M_JUEVES';
            $disponibilidadTurnoV = $this->disponibilidadByTurno($codigo);
            $disponibilidadTurnoM = $this->disponibilidadByTurno($codigoMatutino);
            if ($disponibilidadTurnoM <= 1) {
                $result = 0;  // No existe disponibilidad en este horario intente con otro
            } else if ($disponibilidadTurnoM == 2) {
                $result = 1;     //Si existe disponibilidad
            }
        } else if ($codigo == 'V_VIERNES') { // 5
            $codigoMatutino = 'M_VIERNES';
            $disponibilidadTurnoV = $this->disponibilidadByTurno($codigo);
            $disponibilidadTurnoM = $this->disponibilidadByTurno($codigoMatutino);
            if ($disponibilidadTurnoM <= 1) {
                $result = 0;  // No existe disponibilidad en este horario intente con otro
            } else if ($disponibilidadTurnoM == 2) {
                $result = 1;     //Si existe disponibilidad
            }
        }
        return $result;
    }
    public function disponibilidadByTurno($codigo)
    {
        $consulta = "SELECT `Disponibilidad` FROM turno WHERE `Codigo` = '$codigo'";
        $query = $this->connect()->prepare($consulta);
        $query->execute();
        foreach ($query as $res) {
            $disponibilidad = $res['Disponibilidad'];
        }

        if (trim($query->errorInfo()[2] . "") == "") {
           return $disponibilidad;
        } else {
            return $query->errorInfo()[2];
        }
    }
}

