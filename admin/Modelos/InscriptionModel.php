<?php



class InscriptionModel extends Conexion{

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





    public function getInscripcionByEstudiante($id){



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



    public function updateEstado($id){

        $consulta = "UPDATE `estudiante` SET `Estado` = 1 WHERE IdEstudiante= ". $id . "";

        $query = $this->connect()->prepare($consulta);

        $query->execute();



        if (trim($query->errorInfo()[2] . "") == "") {

            return true;

        } else {

            return $query->errorInfo()[2];

        } 

    }





    //Metodo para actualizar la inscripcion

    public function actualizar($Inscripcion,$idEstudiante)

    {

        $fechaInscripcion =date("Y-m-d H:i:s");

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

            'fechaInscripcion'=> $fechaInscripcion,

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





}





?>



