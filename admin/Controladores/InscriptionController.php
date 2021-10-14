<?php


class InscriptionController
{

    public function getIdTurnoByCodigo($Codigo)
    {
        $objInscripcion = new InscriptionModel();
        return $objInscripcion->getIdTurnoByCodigo($Codigo);
    }

    public function getIdInscripcionByIdEstudiante($idEstudiante)
    {
        $objInscripcion = new InscriptionModel();
        return $objInscripcion->getIdInscripcionByIdEstudiante($idEstudiante);
    }

    public function updateDisponibilidad($Disponibilidad, $idturno)
    {
        $objInscripcion = new InscriptionModel();
        return $objInscripcion->updateDisponibilidad($Disponibilidad, $idturno);
    }

    public function getDisponibilidadByIdTurno($idturno)
    {
        $objInscripcion = new InscriptionModel();
        return $objInscripcion->getDisponibilidadByIdTurno($idturno);
    }

    public function updateEstado($id)
    {
        $objInscripcion = new InscriptionModel();
        return $objInscripcion->updateEstado($id);
    }

    public function getInscripcionByEstudiante($id)
    {
        $objInscripcion = new InscriptionModel();
        return $objInscripcion->getInscripcionByEstudiante($id);
    }


    public function actualizar($principiante,$licenciadeConducir,$categoria,$nombreCE,$apellidoCE,$telefonoCE,$emailCE,
    $direccionCE,$LT,$telefonoLT,$emailLT,$direccionLT,$observaciones,$idturno,$idEstudiante)
    {
        $objInscripcion = new InscriptionModel();

        $objInscripcion->setPrinciante($principiante); //1
        $objInscripcion->setlicenciadeconducir($licenciadeConducir); //2
        $objInscripcion->setCategoria($categoria); //3
        $objInscripcion->setLugardeTrabajo($LT);//4
        $objInscripcion->setDireccionLT($direccionLT);//5
        $objInscripcion->setTelefonoLT($telefonoLT); //6
        $objInscripcion->setEmailLT($emailLT);//7
        $objInscripcion->setNombreCE($nombreCE);//8
        $objInscripcion->setApellidoCE($apellidoCE);//9
        $objInscripcion->setDireccionCE($direccionCE);//10
        $objInscripcion->setTelefonoCE($telefonoCE);//11
        $objInscripcion->setEmailCE($emailCE);//12
        $objInscripcion->setObservaciones($observaciones);//13
        $objInscripcion->setIdTurno($idturno);//14

        return $objInscripcion->actualizar($objInscripcion,$idEstudiante);
    }
}
