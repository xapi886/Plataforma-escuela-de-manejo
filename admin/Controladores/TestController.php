<?php

/**
 * Clase controladora TestController
 */
class TestController
{
    /**
     * getTestQuestionsById, Obtencion de las preguntas del examen
     *
     * @param  int $id Id del examen
     * @return array Arreglo de datos de preguntas
     */
    public function getTestQuestionsById($id)
    {
        $testModel = new TestModel();
        return $testModel->getTestQuestionsById($id);
    }

    /**
     * getQuestionAnswersById, Obtencion de los items de cada pregunta
     *
     * @param  int $id Id de la pregunta
     * @return array Arreglo de datos de items
     */
    public function getQuestionAnswersById($id)
    {
        $testModel = new TestModel();
        return $testModel->getQuestionAnswersById($id);
    }

    /**
     * getTypeOfTest, Obtiene el tipo de examen A, B, C, D, E
     *
     * @param  int $id Id del axamen
     * @return array Array de datos del tipo de examen
     */
    public function getTypeOfTest($id)
    {
        $testModel = new TestModel();
        return $testModel->getTypeOfTest($id);
    }

    /**
     * getQuestionById, Este metodo solo filtra una pregunta segun el id de la misma
     *
     * @param  int $id
     * @return array Array de datos
     */
    public function getQuestionById($id)
    {
        $testModel = new TestModel();
        return $testModel->getQuestionById($id);
    }

    /**
     * getImageURL, este metodo regresa la url de la imagen de la pregunta asociada
     *
     * @param  int $id
     * @return array Array de datos
     */
    public function getImageURL($id)
    {
        $testModel = new TestModel();
        return $testModel->getImageURL($id);
    }

    /**
     * updateQuestion, actualizacion de pregunta de un examen
     *
     * @param  int $id Identificador de pregunta
     * @return boolean
     */
    public function updateQuestion($id, $question)
    {
        $testModel = new TestModel();
        return $testModel->updateQuestion($id, $question);
    }

    /**
     * deleteQuestion, eliminacion completa de registro de pregunta
     *
     * @param  int $id Identificador de pregunta
     * @return boolean
     */
    public function deleteQuestion($id)
    {
        $testModel = new TestModel();
        return $testModel->deleteQuestion($id);
    }

    /**
     * getAnswerById, Este metodo solo filtra el item de una pregunta segun el id 
     *
     * @param  int $id Identificador de item de pregunta
     * @return array Array de datos
     */
    public function getAnswerById($id)
    {
        $testModel = new TestModel();
        return $testModel->getAnswerById($id);
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
        $testModel = new TestModel();
        return $testModel->updateAnswer($id, $answer);
    }

    /**
     * deleteAnswer, Eliminacion de item de pregunta
     *
     * @param  int $id
     * @return boolean
     */
    public function deleteAnswer($id)
    {
        $testModel = new TestModel();
        return $testModel->deleteAnswer($id);
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
        $testModel = new TestModel();
        return $testModel->setCorrectAnswer($id_question, $id_answer);
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
        $testModel = new TestModel();
        return $testModel->addQuestion($id_test, $question);
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
        $testModel = new TestModel();
        return $testModel->addAnswer($id_question, $answer);
    }

    /**Aqui inicia el codigo de xochilt */
        /**
     * Count de todos los estudiantes que han realizado examenes de 
     * la tabla examen_estudiante
     *
     * @param  int $id_question
     * @param  string $answer
     * @return boolean
     */
    public function rowCountStudentExams()
    {
        $testModel = new TestModel();
        return $testModel->rowCountStudentExams();
    }

    /**Aqui inicia el codigo de xochilt */
    /**
     * Count de todos los estudiantes que han realizado examenes de 
     * la tabla examen_estudiante
     *
     * @param  int $id_question
     * @param  string $answer
     * @return boolean
     */
    public function getNextStudentExam($offset, $id)
    {
        $testModel = new TestModel();
        return $testModel->getNextStudentExam($offset, $id);
    }
    /***Obtener estudiante By Id */

    public function getInfoStudentExams($id)
    {
        $testModel = new TestModel();
        return $testModel->getInfoStudentExams($id);
    }

    public function getInfoResultadoExamen($id)
    {
        $testModel = new TestModel();
        return $testModel->getInfoResultadoExamen($id);
    }

    public function search_student_exams_by_text($text)
    {
        $testModel = new TestModel();
        return $testModel->search_student_exams_by_text($text);
    }

    public function buscar($texto){
        $testModel = new TestModel();
        return $testModel->buscar($texto);
    }

    public function MostrarReCargarEstudianteExamen($offset,$id){
        $testModel = new TestModel();
        return $testModel->MostrarReCargarEstudianteExamen($offset,$id);
    }



    
}
