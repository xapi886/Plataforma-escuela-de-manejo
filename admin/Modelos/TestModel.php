<?php

/**
 * Clase modelo TestModel
 */
class TestModel extends Conexion
{
    /**
     * getTestQuestionsById, Obtencion de las preguntas del examen
     *
     * @param  int $id Id del examen
     * @return array Arreglo de datos de todas las preguntas del examen
     */
    public function getTestQuestionsById($id)
    {
        $query = $this->connect()
            ->prepare('CALL get_test_questions(:id)');
        $query->execute(["id" => $id]);
        return $query->fetchAll();
    }

    /**
     * getQuestionAnswersById, Obtencion de los items de cada pregunta
     *
     * @param  int $id Id de la pregunta
     * @return array Arreglo de datos de todos los items de cada pregunta
     */
    public function getQuestionAnswersById($id)
    {
        $query = $this->connect()
            ->prepare('CALL get_question_answers(:id)');
        $query->execute(["id" => $id]);
        return $query->fetchAll();
    }

    /**
     * getTypeOfTest, Obtiene el tipo de examen A, B, C, D, E
     *
     * @param  int $id Id del axamen
     * @return array Array de datos del tipo de examen
     */
    public function getTypeOfTest($id)
    {
        $query = $this->connect()
            ->prepare('SELECT TipoExamen FROM examen WHERE IdExamen = :id');
        $query->execute(["id" => $id]);
        return $query->fetchColumn();
    }

    /**
     * getQuestionById, Este metodo solo filtra una pregunta segun el id de la misma
     *
     * @param  int $id
     * @return array Array de datos
     */
    public function getQuestionById($id)
    {
        $query = $this->connect()
            ->prepare('SELECT Preguntas FROM examen_preguntas WHERE IdPregunta = :id');
        $query->execute(["id" => $id]);
        return $query->fetchColumn();
    }

    /**
     * getImageURL, este metodo regresa la url de la imagen de la pregunta asociada
     *
     * @param  int $id
     * @return array Array de datos
     */
    public function getImageURL($id)
    {
        $query = $this->connect()
            ->prepare('SELECT FotoPregunta FROM examen_preguntas WHERE IdPregunta = :id');
        $query->execute(["id" => $id]);
        return $query->fetchColumn();
    }

    /**
     * updateQuestion, actualizacion de pregunta de un examen
     *
     * @param  int $id Identificador de pregunta
     * @param  string $question Pregunta a editar
     * @return boolean
     */
    public function updateQuestion($id, $question)
    {
        $query = $this->connect()
            ->prepare('CALL update_question(:id, :question)');
        return $query->execute([
            "id" => $id,
            "question" => $question
        ]);
    }

    /**
     * deleteQuestion, eliminacion completa de registro de pregunta
     *
     * @param  int $id Identificador de pregunta
     * @return boolean
     */
    public function deleteQuestion($id)
    {
        $query = $this->connect()
            ->prepare('CALL delete_question(:id)');
        return $query->execute(['id' => $id]);
    }

    /**
     * getAnswerById, Este metodo solo filtra el item de una pregunta segun el id 
     *
     * @param  int $id Identificador de item de pregunta
     * @return array Array de datos
     */
    public function getAnswerById($id)
    {
        $query = $this->connect()
            ->prepare('SELECT Respuesta FROM examen_respuestas WHERE IdRespuestas = :id');
        $query->execute(['id' => $id]);
        return $query->fetchColumn();
    }


    /**
     * updateAnswer, Actualizacion de item de pregunta
     *
     * @param  int $id Identificador de item de pregunta 
     * @param  string $answer Item de pregunta a actualizar
     * @return boolean
     */
    public function updateAnswer($id, $answer)
    {
        $query = $this->connect()
            ->prepare('CALL update_answer(:id, :answer)');
        return $query->execute([
            'id' => $id,
            'answer' => $answer
        ]);
    }

    /**
     * deleteAnswer, Eliminacion de item de pregunta
     *
     * @param  int $id
     * @return boolean
     */
    public function deleteAnswer($id)
    {
        $query = $this->connect()
            ->prepare('CALL delete_answer(:id)');
        return $query->execute([
            'id' => $id
        ]);
    }

    /**
     * setCorrectAnswer, Establece como respuesta correcta a un item de una pregunta
     *
     * @param  int $id_question
     * @param  int $id_answer
     * @return boolean
     */
    public function setCorrectAnswer($id_question, $id_answer)
    {
        $query = $this->connect()
            ->prepare('CALL set_as_correct_answer(:id_question, :id_answer)');
        return $query->execute([
            'id_question' => $id_question,
            'id_answer' => $id_answer
        ]);
    }

    /**
     * addQuestion, Inserta un recurso de bases de datos a
     * la tabla examen_preguntas
     *
     * @param  int $id_test Identificador de examen
     * @param  string $question Pregunta nueva de un examen
     * @return boolean
     */
    public function addQuestion($id_test, $question)
    {
        $query = $this->connect()
            ->prepare('CALL add_question(:id_test, :question)');
        return $query->execute([
            'id_test' => $id_test,
            'question' => $question
        ]);
    }

    /**
     * addAnswer, Inserta un recurso de bases de datos a 
     * la tabla examen_respuestas
     *
     * @param  int $id_question
     * @param  string $answer
     * @return boolean
     */
    public function addAnswer($id_question, $answer)
    {
        $query = $this->connect()
            ->prepare('CALL add_answer(:id_question, :answer)');
        return $query->execute([
            'id_question' => $id_question,
            'answer' => $answer
        ]);
    }

    public function getStudentExams()
    {
        $query = $this->connect()->prepare("SELECT * FROM examen_estudiante");
        $query->execute();
        // fetchColumn($column_number = 0) 
        // por defecto solo devuelve la primera columna
        return $query->fetchAll();
    }
    /**
     * rowCountExamenEstudiante, Metodo que devuelve el numero de registros total de
     * la tabla Examen_Estudiante.
     *
     * @return int Numero de registros
     */
    public function rowCountStudentExams()
    {
        $query = $this->connect()->prepare("SELECT COUNT(DISTINCT `IdEstudiante` )AS Num_Estdudiantes
         FROM examen_estudiante
        ");
        $query->execute();
        // fetchColumn($column_number = 0) 
        // por defecto solo devuelve la primera columna
        return $query->fetchColumn();
    }



    public function getNextStudentExam($offset, $id)
    {

        $query = $this->connect()
            ->prepare("CALL get_next_student_exams(:offset,:id);");
        $query->execute(
            [
                'offset' => $offset,
                'id' =>  $id
            ]
        );
        return $query->fetchAll();
    }


    public function getInfoStudentExams($id)
    {

        $query = $this->connect()
            ->prepare("	SELECT  e.IdEstudiante as Id, ex.TipoExamen, es.Fecha FROM examen_estudiante es 
            INNER JOIN estudiante e ON e.IdEstudiante = es.IdEstudiante INNER JOIN examen ex 
            ON ex.IdExamen = es.IdExamen where e.IdEstudiante = :Id;");
        $query->execute(['Id' => $id]);
        return $query->fetchAll();
    }



    public function getNoRepeatStudenTExam($offset)
    {
        $query = $this->connect()
            ->prepare("SELECT DISTINCT ex.IdEstudiante AS Id,
                        CONCAT_WS(' ',e.Nombre, e.Apellido) AS NombreCompleto FROM examen_estudiante ex INNER JOIN estudiante e
            ON  ex.IdEstudiante = e.IdEstudiante LIMIT $offset,6;");
        $query->execute();
        return $query->fetchAll();
    }

    public function getInfoResultadoExamen($id)
    {
        $query = $this->connect()
            ->prepare("CALL get_Info_Resultado_Examen(:id)");
        $query->execute(['id' => $id]);
        return $query->fetchAll();
    }
    public function search_student_exams_by_text($text)
    {
        $query = $this->connect()
            ->prepare("CALL search_student_exams_by_text(:text)");
        $query->execute(['text' => $text]);
        $html = '';

        foreach ($query as $res) {
            $html .= '<label>' . $res['NombreCompleto'] . '</label>';
            $html .= '<label>' . $res['Fecha'] . '</label>';
            $html .= '<label>' . $res['TipoExamen'] . '</label>';
            $html .= '<label>' . $res['Id'] . '</label>';
        }
        if (($query->errorInfo()[2] . "") == "") {
            return $html;
        } else {
            return false;
        }
    }

    public function buscar($texto)
    {

        $html = "";
        $consulta = "SELECT DISTINCT(e.IdEstudiante) as Id,(CONCAT_WS(' ', e.Nombre, e.Apellido)) as NombreCompleto, 
                GROUP_CONCAT(ex.TipoExamen SEPARATOR '|') as Tipo, GROUP_CONCAT(ee.Fecha SEPARATOR '|')as Fecha FROM estudiante e
                INNER JOIN examen_estudiante ee ON e.Idestudiante = ee.IdEstudiante
                INNER JOIN examen ex ON ex.IdExamen = ee.IdExamen
                WHERE CONCAT_WS(' ', e.Nombre, e.Apellido)
                LIKE CONCAT('%','$texto', '%') group by e.IdEstudiante";

        $query = $this->connect()->prepare($consulta);
        $query->execute();
        foreach ($query as $res) {
           // $html .= '<label> ' . $res['Id'] . '</label>';
            $html .= '<div class="result-examenes-students card bg-light m-2" id="result-examenes" style="width: 18rem;">';
            $html .= '<div class="card-header text-center">' . $res['NombreCompleto'] . '</div>';
            $html .= '<div class="card-body p-3">';
            $html .= '<dt style="font-size: 13px; margin-bottom: 12px;">Fechas Realización:</dt>';
            $arrLibros = explode("|", $res["Tipo"]);
            $arrFecha = explode("|", $res["Fecha"]);
            $html .= '<div class="row">';
            $html .= '<div class="col p-0 pl-1">';

            foreach ($arrLibros as $libro) {
                $html .= '<table class="table table-striped table-sm" style="font-size: 12px;">';
                $html .= '<tbody>';
                $html .= '<tr align="center">';
                $html .= '<th scope="row">' . $libro . '&#8594;</th>';
                $html .= '</tbody>';
                $html .= '</table>';
            }
            $html .= '</div>';
            $html .= '<div class="col p-0 pr-1">';
            foreach ($arrFecha as $fecha) {
                //   $html .= '<th scope="row">' . $libro . '&#8594;</th>';
                $html .= '<table class="table table-striped table-sm" style="font-size: 12px;">';
                $html .= '<tbody>';
                //$html .= '<th scope="row">' . $fecha . '&#8594;</th>';
                $html .= '<th></th>';
                $html .= '<td>' . $fecha .  '</td>';
                $html .= '</tr>';
                $html .= '</tbody>';
                $html .= '</table>';
            }
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</div>';
            $html .= '<div class="card-footer bg-transparent text-right">';
            $html .= '<a href="/admin/vistas/resultados-examen.php?result=' . $res['Id'] . '" class="btn btn-primary btn-sm">Ver detalle</a>';
            $html .= '</div>';
            $html .= '</div>';
        }


        if (($query->errorInfo()[2] . "") == "") {
            return $html;
        } else {
            return false;
        }
    }

    public function getNombreByText($id)
    {
        $consulta = "SELECT CONCAT_WS('',Nombre, Apellido) as NombreCompleto WHERE IdEstudiante";
        $query = $this->connect()->prepare($consulta);
        $query->execute();
        return $query;
    }


    public function ReCargarEstudianteExamen($offset, $id)
    {

        $consulta = "SELECT ex.TipoExamen, es.Fecha FROM  examen_estudiante es 
        INNER JOIN estudiante e ON e.IdEstudiante = es.IdEstudiante INNER JOIN examen ex 
        ON ex.IdExamen = es.IdExamen WHERE e.IdEstudiante=$id LIMIT 0,6";
        $query = $this->connect()->prepare($consulta);
        $query->execute();

        if (($query->errorInfo()[2] . "") == "") {
            return $query;
        } else {
            return false;
        }
    }

    public function  MostrarReCargarEstudianteExamen($offset, $id)
    {
        $Info = $this->getNoRepeatStudenTExam($offset);
        $html = "";
        foreach ($Info as $res) {
            $idEstudiante = $res['Id'];
            //echo $id;
            $html .= '<input id="id" type="hidden" name="offset" value=' . $res['Id'] . ' >';
            $data = $this->ReCargarEstudianteExamen($offset, $idEstudiante);
            $html .= '<div class="result-examenes-students-recargar card bg-light m-2" id="result-examenes" style="width: 18rem;">';
            $html .= '<div class="card-header text-center">' . $res['NombreCompleto'] . '</div>';
            $html .= '<div class="card-body p-3">';
            $html .= '<dt style="font-size: 13px; margin-bottom: 12px;">Fechas Realización:</dt>';
            foreach ($data as $item) {
                $html .= '<table class="table table-striped table-sm" style="font-size: 12px;">';
                $html .= '<tbody>';
                $html .= '<tr align="center">';
                $html .= '<th scope="row">' . $item['TipoExamen'] . '&#8594;</th>';
                $html .= '<th></th>';
                $html .= '<td>' . $item['Fecha'] . '</td>';
                $html .= '</tr>';
                $html .= '</tbody>';
                $html .= '</table>';
            }
            $html .= '</div>';
            $html .= '<div class="card-footer bg-transparent text-right">';
            $html .= '<a href="/admin/vistas/resultados-examen.php?result=' . $idEstudiante . '" class="btn btn-primary btn-sm">Ver detalle</a>';
            $html .= '</div>';
            $html .= '</div>';
        }

        return $html;
    }
}
