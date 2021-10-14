<?php
class InscripcionController{
        public function insertar($InscripcionPrincipiante, $InscripcionLC, $InscripcionCategoria, $nombreCE,
         $ApellidoCE, $TelefonoCE, $EmailCE, $DireccionCE, $InscripcionLT, $InscripcionTelefonoLT, 
         $IncripcionEmailLT, $InscripcionDireccionLT, $InscripcionObservaciones, $idEstudiante, $Horario, $Curso)
        {
            $objInscripcion = new InscripcionModel();                      
            //$objInscripcion->setCategoria($Categoria);
            $objInscripcion ->setPrinciante($InscripcionPrincipiante);
            $objInscripcion ->setlicenciadeconducir($InscripcionLC);
            $objInscripcion->setCategoria($InscripcionCategoria);
            $objInscripcion->setLugardeTrabajo($InscripcionLT);
            $objInscripcion->setDireccionLT($InscripcionDireccionLT);
            $objInscripcion->setTelefonoLT($InscripcionTelefonoLT);
            $objInscripcion->setEmailLT($IncripcionEmailLT);
            $objInscripcion->setNombreCE($nombreCE);
            $objInscripcion->setApellidoCE($ApellidoCE);
            $objInscripcion->setDireccionCE($DireccionCE);
            $objInscripcion->setTelefonoCE($TelefonoCE);
            $objInscripcion->setEmailCE($EmailCE);
            $objInscripcion->setObservaciones($InscripcionObservaciones);
            $objInscripcion->setIdEstudiante($idEstudiante);
            $objInscripcion->setIdTurno($Horario);
            $objInscripcion->setIdHorario($Curso);

            return $objInscripcion->insertar($objInscripcion);
        }

        public function actualizar($principiante,$licenciadeConducir,$categoria,$nombreCE,$apellidoCE,$telefonoCE,$emailCE,
        $direccionCE,$LT,$telefonoLT,$emailLT,$direccionLT,$observaciones,$idturno,$idEstudiante)
        {
            $objInscripcion = new InscripcionModel();
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
        public function getIdTurnoByCodigo($Codigo)
        {
            $objInscripcion = new InscripcionModel();
            return $objInscripcion->getIdTurnoByCodigo($Codigo);    
        }

        public function getIdInscripcionByIdEstudiante($idEstudiante)
        {
            $objInscripcion = new InscripcionModel();
            return $objInscripcion->getIdInscripcionByIdEstudiante($idEstudiante);           
        }
        public function updateDisponibilidad($Disponibilidad,$idturno)
        {
            $objInscripcion = new InscripcionModel();
            return $objInscripcion->updateDisponibilidad($Disponibilidad,$idturno);
        }
        public function getDisponibilidadByIdTurno($idturno)
        {
            $objInscripcion = new InscripcionModel();
            return $objInscripcion->getDisponibilidadByIdTurno($idturno);              
        }
        public function updateEstado($id)
        {
            $objInscripcion = new InscripcionModel();
            return $objInscripcion->updateEstado($id);
        }
        public function getInscripcionByEstudiante($id)
        {
            $objInscripcion = new InscripcionModel();
            return $objInscripcion->getInscripcionByEstudiante($id);
        }
        public function disponibilidadByCodigo($codigo)
        {
            $objInscripcion = new InscripcionModel();
            return $objInscripcion->disponibilidadByCodigo($codigo);
        }
}