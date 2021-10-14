<?php
class ExamenController 
{
    public function RespuestaCorrecta($IdPregunta,$IdRespuesta){
        $Examen = new ExamenModel();
        return  $Examen ->RespuestaCorrecta($IdPregunta,$IdRespuesta);
    }
    public function IdRespuestaCorrecta($idPregunta){
        $Examen = new ExamenModel();
        return  $Examen ->IdRespuestaCorrecta($idPregunta);
    }

    public function InsertaExamenEstudiante($Fecha,$fechaFutura,$Intento,$Nota,$IdExamen,$IdEstudiante,$Tiempo,$Disponibilidad){   
        $Examen = new ExamenModel();
        $Examen->setFecha($Fecha);
        $Examen->setFechaFutura($fechaFutura);
        $Examen->setIntento($Fecha);
        $Examen->setIntento($Intento);
        $Examen->setNota($Nota);
        $Examen->setIdExamen($IdExamen);
        $Examen->setIdEstudiante($IdEstudiante);
        $Examen->setTiempo($Tiempo);
        $Examen->setDisponibilidad($Disponibilidad);
        return $Examen->InsertaExamenEstudiante($Examen);
    }

    public function getExamenByID($Id){
        $Examen = new ExamenModel();
        return $Examen->getExamenByID($Id);
    }

    public function CantidadIntentoExamen($Id){  
        $Examen = new ExamenModel();
        return $Examen->CantidadIntentoExamen($Id);
    }

    public function limitarIntentoPorExamen($IdEstudiante,$IdExamen){
        $Examen = new ExamenModel();
        return $Examen->limitarIntentoPorExamen($IdEstudiante,$IdExamen);
    }
    public function ValidarRealizarExamen($IdEstudiante,$Intento){  
        $Examen = new ExamenModel();
        return $Examen->ValidarRealizarExamen($IdEstudiante,$Intento);
    }

    public function getExamenEstudianteById($IdEstudiante,$IdExamen){
        $Examen = new ExamenModel();
        return $Examen->getExamenEstudianteById($IdEstudiante,$IdExamen);
    }

    public function HoraFecha($IdEstudiante,$intento){  
        $Examen = new ExamenModel();
        return $Examen->HoraFecha($IdEstudiante,$intento);
    }

    public function actualizarNota($Nota,$IdEstudiante,$IdExamen){     
        $Examen = new ExamenModel();
        return $Examen->actualizarNota($Nota,$IdEstudiante,$IdExamen);
    }

    public function InsertaDetalleExamenEstudiante($Pregunta,$Respuesta,$IdExamenEstudiante){    
        $Examen = new ExamenModel();
        $Examen->setPreguntas($Pregunta);
        $Examen->setRespuesta($Respuesta);
        $Examen->setIdExamenEstudiante($IdExamenEstudiante);   
        return $Examen->InsertaDetalleExamenEstudiante($Examen);
    }

    public function actualizarTiempo($tiempo,$tiempoFormateado,$IdEstudiante,$IdExamen){
        $Examen = new ExamenModel();
        return $Examen->actualizarTiempo($tiempo,$tiempoFormateado,$IdEstudiante,$IdExamen);
    }

    public function actualizarDisponibilidad($IdEstudiante,$IdExamen){
        $Examen = new ExamenModel();
        return $Examen->actualizarDisponibilidad($IdEstudiante,$IdExamen);
    }

    public function RecargarResultadoExamen($IdExamen,$idEstudiante){ 
        $Examen = new ExamenModel();
        return $Examen->RecargarResultadoExamen($IdExamen,$idEstudiante);
    }
}

