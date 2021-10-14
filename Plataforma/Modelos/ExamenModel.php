<?php

class ExamenModel extends DB
{
    private $IdExamen;
    private $TipoExamen;
    private $FechaCreacion;
    private $IdPregunta;
    private $Preguntas;
    private $Puntaje;
    private $FotoPregunta;
    private $IdRespuestas;
    private $Respuesta;
    private $Correcta;
    private $Intento;
    private $Nota;
    private $IdEstudiante;
    private $Fecha;
    private $FechaFutura;
    private $Tiempo;
    private $IdDetalleExamen;
    private $IdExamenEstudiante;
    private $HoraFutura;
    private $Solofecha;
    private $Disponibilidad;

    public function setIdExamen($IdExamen)
    {
        $this->IdExamen = $IdExamen;
    }

    public function getIdExamen()
    {
        return $this->IdExamen;
    }

    public function setTipoExamen($TipoExamen)
    {
        $this->TipoExamen = $TipoExamen;
    }

    public function getTipoExamen()
    {
        return $this->TipoExamen;
    }

    public function setFechaCreacion($FechaCreacion)
    {
        $this->FechaCreacion = $FechaCreacion;
    }

    public function getFechaCreacion()
    {
        return $this->FechaCreacion;
    }

    public function setIdPregunta($IdPregunta)
    {
        $this->IdPregunta = $IdPregunta;
    }

    public function getIdPregunta()
    {
        return $this->IdPregunta;
    }

    public function setPreguntas($Preguntas)
    {
        $this->Preguntas = $Preguntas;
    }

    public function getPreguntas()
    {
        return $this->Preguntas;
    }

    public function setpuntaje($Puntaje)
    {
        $this->Puntaje = $Puntaje;
    }
    
    public function setIntento($Intento)
    {
        $this->Intento = $Intento;
    }
    public function getIntento()
    {
        return $this->Intento;
    }
    public function setNota($Nota)
    {
        $this->Nota = $Nota;
    }
    public function getNota()
    {
        return $this->Nota;
    }
    public function getFecha()
    {
        return $this->Fecha;
    }
    public function setFecha($Fecha)
    {
        $this->Fecha = $Fecha;
    }
    public function getFechaFutura()
    {
        return $this->FechaFutura;
    }
    public function setFechaFutura($FechaFutura)
    {
        $this->FechaFutura = $FechaFutura;
    }
    public function setIdEstudiante($IdEstudiante)
    {
        $this->IdEstudiante = $IdEstudiante;
    }
    public function getIdEstudiante()
    {
        return $this->IdEstudiante;
    }
    public function setIdDetalleExamen($IdDetalleExamen)
    {
        $this->IdDetalleExamen = $IdDetalleExamen;
    }
    public function getIdDetalleExamen()
    {
        return $this->IdDetalleExamen;
    }
    public function setIdExamenEstudiante($IdExamenEstudiante)
    {
        $this->IdExamenEstudiante = $IdExamenEstudiante;
    }
    public function getIdExamenEstudiante()
    {
        return $this->IdExamenEstudiante;
    }
    public function getPuntaje()
    {
        return $this->Puntaje;
    }
    public function setFotoPregunta($FotoPregunta)
    {
        $this->FotoPregunta = $FotoPregunta;
    }
    public function getFotoPregunta()
    {
        return $this->FotoPregunta;
    }
    public function setIdRespuestas($IdRespuestas)
    {
        $this->IdRespuestas = $IdRespuestas;
    }
    public function getIdRespuestas()
    {
        return $this->IdRespuestas;
    }
    public function setRespuesta($Respuesta)
    {
        $this->Respuesta = $Respuesta;
    }
    public function getRespuesta()
    {
        return $this->Respuesta;
    }
    public function setCorrecta($Correcta)
    {
        $this->Correcta = $Correcta;
    }
    public function getCorrecta()
    {
        return $this->Correcta;
    }
    public function setHoraFutura($HoraFutura)
    {
        $this->HoraFutura = $HoraFutura;
    }
    public function getHoraFutura()
    {
        return $this->HoraFutura;
    }
    public function setSolofecha($Solofecha)
    {
        $this->Solofecha = $Solofecha;
    }
    public function getSolofecha()
    {
        return $this->Solofecha;
    }



    public function setTiempo($Tiempo)
    {
        $this->Tiempo = $Tiempo;
    }
    public function getTiempo()
    {
        return $this->Tiempo;
    }
    public function setDisponibilidad($Disponibilidad)
    {
        $this->Disponibilidad = $Disponibilidad;
    }
    public function getDisponibilidad()
    {
        return $this->Disponibilidad;
    }

    public function mostrarPreguntasSi($id, $IdPregunta)
    {
        $result = "";
        $consulta = "SELECT A.Preguntas as Pregunta, A.FotoPregunta as FotoPregunta from examen_preguntas A INNER JOIN examen C on C.IdExamen = A.IdExamen where C.IdExamen = $id and A.IdPregunta = $IdPregunta";
        $query = $this->connect()->prepare($consulta);
        $query->execute();
        foreach ($query as $res) {
            $result = $res['Pregunta'];
        }
        return $result;
    }

    public function obtenerTodasLasRespuestas($id, $IdRespuestas)
    {
        $result = "";
        $consulta = "SELECT B.IdRespuestas as IdRespuesta,B.Respuesta  As Respuesta,A.IdPregunta as Pregunta from examen_preguntas A 
         INNER JOIN examen_respuestas B on A.IdPregunta = B.IdPregunta INNER JOIN examen C on C.IdExamen = A.IdExamen where A.IdPregunta = $id and B.IdRespuestas = $IdRespuestas";
        $query = $this->connect()->prepare($consulta);
        $query->execute();
        foreach ($query as $res) {
            $result = $res['Respuesta'];
        }
        return $result;
    }

    public function mostrarExamen($idExamen)
    {
        $html = "";
        $consulta = "SELECT A.Preguntas as Pregunta, B.Respuesta As Respuesta from examen_preguntas A 
        INNER JOIN examen_respuestas B on A.IdPregunta = B.IdPregunta INNER JOIN examen C on C.IdExamen = A.IdExamen where C.IdExamen = . $idExamen . ";
        $query = $this->connect()->prepare($consulta);
        $query->execute();
        if ($query->rowCount() > 0) {
            foreach ($query as $row) {
                $html = '
            <div class="row align-items-start mt-5">
                <div class="col-md-8 col-sm-8 formulario-estudiante shadow">
                  <div class="container">
                    <div class="heading text-color font-weight-bold">
                      <label class="text-dark" for="">' . $row['Preguntas'] . '</label>
                    </div>
                    <div class="row ">
                      <div class="col-md-6 ">
                        <div class="form-check mt-4 ">
                          <input class="form-check-input" type="radio" name="Respuesta2" id="inlineradio1" value="option1">
                          <label class="form-check-label text-color  " for="inlineradio1">' . $row['Respuesta'] . '</label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>';
            }
        }
        if (($query->errorInfo()[2] . "") == "") {
            return $html;
        } else {
            return "Problemas al cargar el usuario, por favor, pongace en contacto con el administrador del sistema";
        }
    }

    public function CountQuestions($idExamen)
    {
        $result = "";
        $consulta = "SELECT count(*) as Numero_de_Preguntas FROM examen_preguntas A INNER JOIN examen B on A.IdExamen = B.IdExamen WHERE A.IdExamen = $idExamen ";
        $query = $this->connect()->prepare($consulta);
        $query->execute();
        foreach ($query as $res) {
            $result = $res['Numero_de_Preguntas'];
        }
        if (($query->errorInfo()[2] . "") == "") {
            return $result;
        } else {
            return false;
        }
    }

    public function ContarRespuesta($idExamen)
    {
        $result = " ";
        $html = "";
        $consulta = "SELECT count(*) as Num_Respuestas FROM examen_respuestas A 
        INNER JOIN examen_preguntas B on B.IdPregunta = A.IdPregunta WHERE B.IdPregunta = $idExamen";
        $query = $this->connect()->prepare($consulta);
        $query->execute();
        foreach ($query as $res) {
            $result = $res['Num_Respuestas'];
        }
        return $result;
    }

    public function getIdRespuestasByIdPregunta($id)
    {
        $result = "";
        $consulta = "SELECT B.IdRespuestas as IdRespuesta,B.Respuesta As Respuesta from examen_preguntas A 
        INNER JOIN examen_respuestas B on A.IdPregunta = B.IdPregunta INNER JOIN examen C on C.IdExamen = A.IdExamen where A.IdPregunta = $id ";
        $query = $this->connect()->prepare($consulta);
        // $query->execute();
        return $query;
    }

    public function getIdPreguntabyExamen($id)
    {
        $result = "";
        $consulta = "SELECT A.IdPregunta as IdPregunta, C.IdExamen as IdExamen, A.Preguntas as Pregunta, A.FotoPregunta as FotoPregunta from examen_preguntas A INNER JOIN examen C on C.IdExamen = A.IdExamen where A.IdExamen = $id";
        $query = $this->connect()->prepare($consulta);
        // $query->execute();
        return $query;
    }

    public function Examen_2($idExamen)
    {
        $result = " ";
        $html = "";
        $IdRespuestas = " ";
        $numPreguntas = $this->CountQuestions($idExamen);
        $numRespuestas = $this->ContarRespuesta($idExamen);
        //  for ($j = 1; $j <= $numPreguntas; $j++) 
        $IdPRegunta = $this->getIdPreguntabyExamen($idExamen);
        $IdPRegunta->execute();
        $num = 0;
        foreach ($IdPRegunta as $row) {
            $num += 1;
            $Preguntas = $this->mostrarPreguntasSi($idExamen, $row['IdPregunta']);
            echo ' <div class="formulario-examen mb-4 shadow">';
            echo '<div class="heading text-color font-weight-bold">';
            echo '<label class="text-dark" for="">' . " Pregunta ."  . $num . " " . $Preguntas  . '</label>';
            echo '<div class ="align-items-center text-center" >';
            echo '<img class="foto-pregunta" src="' . $row['FotoPregunta'] . '" alt="">';
            echo '</div>';
            echo '</div>';
            echo '<input type="hidden" id="idExamen" name="exam' . $row['IdExamen'] . '" value="' . $row['IdExamen'] . '">';
            $numRespuestas = $this->ContarRespuesta($row['IdPregunta']);
            $IdRespuestas = $this->getIdRespuestasByIdPregunta($row['IdPregunta']);
            $IdRespuestas->execute();
            foreach ($IdRespuestas as $row2) {
                $Respuesta = $this->obtenerTodasLasRespuestas($row['IdPregunta'], $row2['IdRespuesta']);
                echo '<div class="row">';
                echo '<div class="col-md-12">';
                echo '<div class="form-check mt-2">';
                echo '<input class="form-check-input" type="radio" id="Resp' . $num . '" name="Resp' . $num . '" value="' . $row2['IdRespuesta'] . '">';
                echo '<label class="form-check-label text-color"  " name="' . $row2['IdRespuesta'] . '" >' /*. $j ." "  . " " .$numRespuestas . " "  $row['IdRespuesta'] . */ . $Respuesta . '</label>';
                echo  '</div>';
                echo '</div>';
                echo '</div>';
                echo '<input type="hidden" id="' . $num . '" name="' . $num . '" value="' . $row['IdPregunta'] . '">';
            }
            echo '</br>';
            echo '</div>';
        }
    }

    public function ResultadoExamen($idExamen)
    {
        $result = " ";
        $html = "";
        $IdRespuestas = " ";
        $numPreguntas = $this->CountQuestions($idExamen);
        $numRespuestas = $this->ContarRespuesta($idExamen);
        //  for ($j = 1; $j <= $numPreguntas; $j++) 
        $IdPRegunta = $this->getIdPreguntabyExamen($idExamen); //Obtiene el id de la pregunta para poder mostrarla
        $IdPRegunta->execute();
        $num = 0;
        foreach ($IdPRegunta as $row) { //for each para imprimir cada pregunta
            $num += 1;
            $EstadoDeRespuesta = $this->CompararRespuesta($row['IdPregunta']);
            $IdRespuestaCorrecta = $this->IdRespuestaCorrecta($row['IdPregunta']);
            $IdRespuestaSeleccionada = $this->IdRespuestaSeleccionada($row['IdPregunta']);
            $RespuestaCorrecta = $this->RespuestaCorrecta($row['IdPregunta'], $IdRespuestaCorrecta);
            if ($IdRespuestaSeleccionada != "") {
                $RespuestaSeleccionada = $this->RespuestaSeleccionada($row['IdPregunta'], $IdRespuestaSeleccionada);
            } else {
                $RespuestaSeleccionada = "No eligio ninguna respuesta";
            }
            $Preguntas = $this->mostrarPreguntasSi($idExamen, $row['IdPregunta']);
            echo '<div class="mb-4 shadow formulario-examen-' . $EstadoDeRespuesta . '">';
            echo '<div class="heading text-color font-weight-bold ">';
            echo '<label class="text-dark" for="">' . " Pregunta ."  . $num . " " . $Preguntas  . '</label>';
            echo '<div class ="align-items-center text-center" >';
            echo '<img class="foto-pregunta" src="' . $row['FotoPregunta'] . '" alt="">';
            echo '</div>';
            echo '</div>';
            echo '<input type="hidden" name="exam' . $row['IdExamen'] . '" value="' . $row['IdExamen'] . '">';
            $numRespuestas = $this->ContarRespuesta($row['IdPregunta']);
            $IdRespuestas = $this->getIdRespuestasByIdPregunta($row['IdPregunta']); //Obtiene el id de la respuesta de esa pregunta por medio del id de la pregunta
            $IdRespuestas->execute();                                               //De esta manera se pueden imprimir todas las respuestas de esa pregunta
            foreach ($IdRespuestas as $row2) {
                $Respuesta = $this->obtenerTodasLasRespuestas($row['IdPregunta'], $row2['IdRespuesta']); //En esta parte se pasa el id de la pregunta y el id de la respuesta
                echo '<div class="row">';                                                               //Para obtener todas las respuesta e imprimirlas
                echo '<div class="col-md-12">';
                echo '<div class="form-check mt-2">';
                echo '<input class="form-check-input" type="radio" disabled="disabled" name="' . $row['IdPregunta'] . '" value="' . $row2['IdRespuesta'] . '">';
                echo '<label class="form-check-label text-color"  " name="' . $row2['IdRespuesta'] . '" >' /*. $j ." "  . " " .$numRespuestas . " "  $row['IdRespuesta'] . */ . $Respuesta . '</label>';
                echo  '</div>';
                echo '</div>';
                echo '</div>';
                echo '<input type="hidden" name="preg' . $row['IdPregunta'] . '" value="' . $row['IdPregunta'] . '">';
            }
            echo '</br>';
            echo '</div>';
            echo ' <div class= "formulario-estudiante my-3">';
            echo '<label>La respuesta correcta es:  ' .  $RespuestaCorrecta . ' </label>';
            echo '</br>';
            echo '<label>La respuesta seleccionada fue:  ' .  $RespuestaSeleccionada . ' </label>';
            echo '</div>';
        }
    }





    public function RecargarResultadoExamen($idExamen, $idEstudiante)
    {
        $result = " ";
        $html = "";
        $IdRespuestas = " ";
        $numPreguntas = $this->CountQuestions($idExamen);
        $numRespuestas = $this->ContarRespuesta($idExamen);
        //  for ($j = 1; $j <= $numPreguntas; $j++) 
        $IdPRegunta = $this->getIdPreguntabyExamen($idExamen); //Obtiene el id de la pregunta para poder mostrarla
        $IdPRegunta->execute();
        $num = 0;
        $nota = 0;
        $html .= '<div class="row mt-2">';
        $html .= '<div class="col-xl-9 col-lg-9 col-md-9 col-sm-7 col-xs-5 ">';
        foreach ($IdPRegunta as $row) { //for each para imprimir cada pregunta
            $num += 1;
            $EstadoDeRespuesta = $this->CompararRespuesta2($row['IdPregunta'], $idEstudiante, $idExamen);
            if ($EstadoDeRespuesta == 'correcta') {
                $nota += 5;
            }
            $IdRespuestaCorrecta = $this->IdRespuestaCorrecta($row['IdPregunta']);
            $IdRespuestaSeleccionada = $this->IdRespuestaSeleccionada($row['IdPregunta']);
            $RespuestaCorrecta = $this->RespuestaCorrecta($row['IdPregunta'], $IdRespuestaCorrecta);
            if ($IdRespuestaSeleccionada != "") {
                $RespuestaSeleccionada = $this->RespuestaSeleccionada($row['IdPregunta'], $IdRespuestaSeleccionada);
            } else {
                $RespuestaSeleccionada = "No eligio ninguna respuesta";
            }
            $Preguntas = $this->mostrarPreguntasSi($idExamen, $row['IdPregunta']);
            $html .= '<div class="mb-4 shadow formulario-examen-' . $EstadoDeRespuesta . '">';
            $html .= '<div class="heading text-color font-weight-bold ">';
            $html .= '<label class="text-dark" for="">' . " Pregunta ."  . $num . " " . $Preguntas  . '</label>';
            $html .= '<div class ="align-items-center text-center" >';
            $html .= '<img class="foto-pregunta" src="' . $row['FotoPregunta'] . '" alt="">';
            $html .= '</div>';
            $html .= '</div>';
            $html .= '<input type="hidden" name="exam' . $row['IdExamen'] . '" value="' . $row['IdExamen'] . '">';
            $numRespuestas = $this->ContarRespuesta($row['IdPregunta']);
            $IdRespuestas = $this->getIdRespuestasByIdPregunta($row['IdPregunta']); //Obtiene el id de la respuesta de esa pregunta por medio del id de la pregunta
            $IdRespuestas->execute();                                               //De esta manera se pueden imprimir todas las respuestas de esa pregunta
            foreach ($IdRespuestas as $row2) {
                $Respuesta = $this->obtenerTodasLasRespuestas($row['IdPregunta'], $row2['IdRespuesta']); //En esta parte se pasa el id de la pregunta y el id de la respuesta
                $html .= '<div class="row">';                                                               //Para obtener todas las respuesta e imprimirlas
                $html .= '<div class="col-md-12">';
                $html .= '<div class="form-check mt-2">';
                $html .= '<input class="form-check-input" type="radio" disabled="disabled" name="' . $row['IdPregunta'] . '" value="' . $row2['IdRespuesta'] . '">';
                $html .= '<label class="form-check-label text-color"  " name="' . $row2['IdRespuesta'] . '" >' /*. $j ." "  . " " .$numRespuestas . " "  $row['IdRespuesta'] . */ . $Respuesta . '</label>';
                $html .=  '</div>';
                $html .= '</div>';
                $html .= '</div>';
                $html .= '<input type="hidden" name="preg' . $row['IdPregunta'] . '" value="' . $row['IdPregunta'] . '">';
            }
            $html .= '</br>';
            $html .= '</div>';
            $html .= ' <div class= "formulario-estudiante my-3">';
            $html .= '<label>La respuesta correcta es:  ' .  $RespuestaCorrecta . ' </label>';
            $html .= '</br>';
            $html .= '<label>La respuesta seleccionada fue:  ' .  $RespuestaSeleccionada . ' </label>';
            $html .= '</div>';
        }

        $html .= '</div>';
        $this->actualizarNota($nota, $idEstudiante, $idExamen);
        $ExamenEstudiante = $this->getExamenEstudianteById($idEstudiante, $idExamen);
        $nota = $ExamenEstudiante->getNota();
        $html .= '<div class="col-xl-3 col-lg-3 col-md-3 col-sm-5 col-xs-5">';
        $html .= '<div class="container text-justify formulario-estudiante shadow">';
        $html .= '<label class="strong" for="">Las preguntas marcadas en verde fueron correctas<span class="mx-1 py-0 correcta"></span></label>';
        $html .= '<label class="strong" for="">Las preguntas marcadas en rojo fueron incorrectas<span class="mx-1 py-0 incorrecta"></span></label>';
        $html .= '<label class="strong">La nota obtenida fue: ' . $nota . '</label>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        return $html;
    }

    public function CompararRespuesta($IdPregunta)
    {
        $Estado = "";
        $RespuestaCorrecta = $this->IdRespuestaCorrecta($IdPregunta);
        $RespuestaSeleccionada = $this->IdRespuestaSeleccionada($IdPregunta);
        if ($RespuestaCorrecta === $RespuestaSeleccionada) {
            $Estado = "correcta";
        } else {
            $Estado = "incorrecta";
        }
        return $Estado;
    }

    public function CompararRespuesta2($IdPregunta, $idEstudiante, $idExamen)
    {
        $Estado = "";
        $nota = 0;
        $RespuestaCorrecta = $this->IdRespuestaCorrecta($IdPregunta);
        $RespuestaSeleccionada = $this->IdRespuestaSeleccionada($IdPregunta);
        if ($RespuestaCorrecta === $RespuestaSeleccionada) {
            $Estado = "correcta";
            //     $nota += 5;
        } else {
            $Estado = "incorrecta";
        }
        // $this->actualizarNota($nota,$idEstudiante,$idExamen);
        return $Estado;
    }

    public function IdRespuestaCorrecta($IdPregunta)
    {
        $result = "";
        $consulta = "SELECT Correcta,IdRespuestas FROM examen_respuestas where IdPregunta = $IdPregunta and Respuesta = Correcta";
        $query = $this->connect()->prepare($consulta);
        $query->execute();
        foreach ($query as $res) {
            $result = $res['IdRespuestas'];
        }
        return $result;
    }
    public function IdRespuestaSeleccionada($IdPregunta)
    {
        $result = "";
        $consulta = "SELECT IdRespuesta FROM detalleexamenestudiante where IdPregunta = $IdPregunta";
        $query = $this->connect()->prepare($consulta);
        $query->execute();
        foreach ($query as $res) {
            $result = $res['IdRespuesta'];
        }
        return $result;
    }
    public function RespuestaCorrecta($IdPregunta, $IdRespuesta)
    {
        $result = " ";
        $consulta = "SELECT Respuesta as respuestaCorrecta FROM examen_respuestas where IdPregunta = $IdPregunta and IdRespuestas = $IdRespuesta";
        $query = $this->connect()->prepare($consulta);
        $query->execute();
        foreach ($query as $res) {
            $result = $res['respuestaCorrecta'];
        }
        return $result;
    }

    public function RespuestaSeleccionada($IdPregunta, $IdRespuesta)
    {
        $result = " ";
        $consulta = "SELECT Respuesta as respuestaSeleccionada FROM examen_respuestas where IdPregunta = $IdPregunta and IdRespuestas=$IdRespuesta";
        $query = $this->connect()->prepare($consulta);
        $query->execute();
        foreach ($query as $res) {
            $result = $res['respuestaSeleccionada'];
        }
        return $result;
    }

    public function InsertaExamenEstudiante($Examen)
    {
        $Consulta = "INSERT INTO examen_estudiante(`Fecha`,`FechaFutura`,`Intento`,`Nota`,`IdEstudiante`,`IdExamen`,`TiempoTranscurrido`,`Disponibilidad`)VALUE
        (:Fecha,:FechaFutura,:Intento,:Nota,:IdEstudiante,:IdExamen,:TiempoTranscurrido,:Disponibilidad)";
        $query = $this->connect()->prepare($Consulta);
        $query->execute([
            'Fecha' =>  $Examen->getFecha(),
            'FechaFutura' => $Examen->getFechaFutura(),
            'Intento' => $Examen->getIntento(),
            'Nota' => $Examen->getNota(),
            'IdEstudiante' => $Examen->getIdEstudiante(),
            'IdExamen' => $Examen->getIdExamen(),
            'TiempoTranscurrido' => $Examen->getTiempo(),
            'Disponibilidad' => $Examen->getDisponibilidad()
        ]);

        if (($query->errorInfo()[2] . "") == "") {
            return true;
        } else {
            return false;
        }
    }

    public function InsertaDetalleExamenEstudiante($Examen)
    {
        $consulta = "INSERT INTO `detalleexamenestudiante`(`IdPregunta`, `IdRespuesta`, `IdExamenEstudiante`) VALUES 
        (:pregunta,:respuesta,:idExamenEstudiante);";
        $query = $this->connect()->prepare($consulta);
        $query->execute([
            'pregunta' =>  $Examen->getPreguntas(),
            'respuesta' => $Examen->getRespuesta(),
            'idExamenEstudiante' => $Examen->getIdExamenEstudiante()
        ]);
        if (($query->errorInfo()[2] . "") == "") {
            return true;
        } else {
            return false;
        }
    }

    public function getExamenById($IdExamen)
    {
        $Consulta = "SELECT * FROM examen WHERE IdExamen = :IdExamen";
        $query = $this->connect()->prepare($Consulta);
        $query->execute([
            "IdExamen" => $IdExamen
        ]);
        $Examen = new ExamenModel();
        foreach ($query as $res) {
            $Examen->setTipoExamen($res['TipoExamen']);
            $Examen->setFechaCreacion($res['FechaCreacion']);
        }
        return $Examen;
    }

    function limitarIntentoPorExamen($IdEstudiante, $IdExamen)
    {
        $Consulta = "SELECT count(*) as RealizoExamen FROM examen_estudiante WHERE IdEstudiante = :IdEstudiante and IdExamen = :IdExamen";
        $query = $this->connect()->prepare($Consulta);
        $query->execute([
            "IdEstudiante" => $IdEstudiante,
            "IdExamen" => $IdExamen
        ]);

        foreach ($query as $res) {
            $result = $res['RealizoExamen'];
        }
        return $result;
    }

    function CantidadIntentoExamen($IdEstudiante)
    {
        $Consulta = "SELECT count(*) as Intento FROM examen_estudiante WHERE IdEstudiante = :IdEstudiante";
        $query = $this->connect()->prepare($Consulta);
        $query->execute([
            "IdEstudiante" => $IdEstudiante
        ]);

        $Examen = new ExamenModel();
        foreach ($query as $res) {
            $Examen = $res['Intento'];
        }

        return $Examen;
    }

    function AcualizarExamenEstudiante($IdEstudiante)
    {
        $Consulta = "UPDATE examen_estudiante SET ";
        $query = $this->connect()->prepare($Consulta);
        $query->execute([
            "IdEstudiante" => $IdEstudiante
        ]);
        $Examen = new ExamenModel();
        foreach ($query as $res) {
            $Examen->setTipoExamen($res['TipoExamen']);
            $Examen->setFechaCreacion($res['FechaCreacion']);
        }
        return $Examen;
    }

    public function getExamenEstudianteById($IdEstudiante, $IdExamen)
    {
        $consulta = "SELECT * FROM examen_estudiante WHERE IdEstudiante =:idEstudiante and IdExamen =:idExamen";
        $query = $this->connect()->prepare($consulta);
        $query->execute([
            "idEstudiante" => $IdEstudiante,
            "idExamen" => $IdExamen
        ]);

        $ExamenEstudiante = new ExamenModel();
        foreach ($query as $res) {
            $ExamenEstudiante->setFecha($res['Fecha']);
            $ExamenEstudiante->setFechaFutura($res['FechaFutura']);
            $ExamenEstudiante->setIntento($res['Intento']);
            $ExamenEstudiante->setNota($res['Nota']);
            $ExamenEstudiante->setIdEstudiante($res['IdEstudiante']);
            $ExamenEstudiante->setIdExamen($res['IdExamen']);
            $ExamenEstudiante->setIdExamenEstudiante($res['IdExamenEstudiante']);
            $ExamenEstudiante->setTiempo($res['TiempoTranscurrido']);
            $ExamenEstudiante->setDisponibilidad($res['Disponibilidad']);
        }
        return $ExamenEstudiante;
    }

    public function ValidarRealizarExamen($IdEstudiante, $Intento)
    {
        $result = "";
        $consulta = "SELECT * FROM examen_estudiante WHERE IdEstudiante =:idEstudiante and Intento =:intento";
        $query = $this->connect()->prepare($consulta);
        $query->execute([
            "idEstudiante" => $IdEstudiante,
            "intento" => $Intento
        ]);
        $ExamenEstudiante = new ExamenModel();
        foreach ($query as $res) {
            $ExamenEstudiante->setFecha($res['Fecha']);
            $ExamenEstudiante->setFechaFutura($res['FechaFutura']);
            $ExamenEstudiante->setIntento($res['Intento']);
            $ExamenEstudiante->setNota($res['Nota']);
            $ExamenEstudiante->setIdEstudiante($res['IdEstudiante']);
            $ExamenEstudiante->setIdExamen($res['IdExamen']);
        }

        return $ExamenEstudiante;
    }



    //**** Sacar la diferencia entre el intento actual y el ultimo para mostrale al usuario cuanto falta para que vuelva a realizar un intento*/
    function ultimoIntento($userName)
    {
        $FechaHora = "";
        $consulta = "SELECT FechaHora FROM LoginCheckCliente WHERE UserName = :userName";
        $query = $this->connect()->prepare($consulta);
        $query->execute([
            "userName" => $userName
        ]);

        foreach ($query as $res) {
            $FechaHora = $res['FechaHora'];
        }

        $query->errorInfo()[2];
        return $FechaHora;
    }

    /**mostrar una ventana advirtiendo desde el momento en que de clikc y aceptar solo tendra ese intento para realizar ese examen
     en un lapso de 20 minutos*/
    function HoraFecha($IdEstudiante, $Intento)
    {
        $FechaHora = "";
        $consulta = "SELECT DATE_FORMAT(FechaFutura, '%Y-%m-%d') FechaStr, 
                    DATE_FORMAT(FechaFutura,'%H:%i:%s') HoraStr, DATE(FechaFutura) Fecha, 
                    TIME(FechaFutura) Hora FROM examen_estudiante WHERE IdEstudiante = $IdEstudiante and Intento = $Intento";
        $query = $this->connect()->prepare($consulta);
        $query->execute();
        $ExamenEstudiante = new ExamenModel();
        foreach ($query as $res) {
            $ExamenEstudiante->setHoraFutura($res['Hora']);
            $ExamenEstudiante->setSolofecha($res['Fecha']);
        }
        return $ExamenEstudiante;
    }

    function actualizarNota($Nota, $IdEstudiante, $IdExamen)
    {
        $consulta = "UPDATE `examen_estudiante` SET `Nota`= $Nota WHERE `IdEstudiante`=$IdEstudiante AND `IdExamen`=$IdExamen";
        $query = $this->connect()->prepare($consulta);
        $query->execute();
        if (($query->errorInfo()[2] . "") == "") {
            return true;
        } else {
            return false;
        }
    }

    function actualizarTiempo($tiempo, $tiempoFormateado, $IdEstudiante, $IdExamen)
    {
        $consulta = "UPDATE `examen_estudiante` SET 
                    `TiempoTranscurrido`= '$tiempo', 
                    `TiempoFormateado` = '$tiempoFormateado'
                    WHERE `IdEstudiante`=$IdEstudiante AND `IdExamen`=$IdExamen";
        $query = $this->connect()->prepare($consulta);
        $query->execute();
        if (($query->errorInfo()[2] . "") == "") {
            return true;
        } else {
            return false;
        }
    }

    function actualizarDisponibilidad($IdEstudiante, $IdExamen)
    {
        $consulta = "UPDATE `examen_estudiante` SET `Disponibilidad`= 1 WHERE `IdEstudiante`=$IdEstudiante AND `IdExamen`=$IdExamen";
        $query = $this->connect()->prepare($consulta);
        $query->execute();
        if (($query->errorInfo()[2] . "") == "") {
            return true;
        } else {
            return false;
        }
    }



    /**

     * updateInfoStudent, actualizacion de informacion de estudiante

     *

     * @param  array $data

     * @return array Arreglo con datos si hubo exito

     */

    public function updateTime($data)

    {

        $query = $this->connect()

            ->prepare('CALL update_time(

                                :id, :name, :last, 

                                :birthdate, :gender, :idcard, 

                                :passport, :email, :password, 

                                :phone, :address, :state, 

                                :beginner, :license, :category, 

                                :modality, :testdate)');

        return $query->execute($data);
    }
}
