<?php

/**
 * Clase contralodora StudentController
 */
class StudentController
{
    /**
     * rowCountStudents, Metodo que devuelve el numero de registros total de
     * tabla estudiante.
     *
     * @return int Numero de registros
     */
    public function rowCountStudents()
    {
        $studentModel = new StudentModel();
        return $studentModel->rowCountStudents();
    }

    /**
     * searchStudent, Metodo de busqueda de registros de estudiante por texto.
     *
     * @param  string $search_text
     * @return array Datos de Array Asociativo.
     */
    public function searchStudent($search_text)
    {
        $studentModel = new StudentModel();
        return $studentModel->searchStudent($search_text);
    }

    /**
     * getNextStudents, Metodo obtiene los siguientes registros de estudiantes
     * en la vista de gestion de Estudiantes cuando se deja de buscar por texto o paginacion.
     *
     * @param  int $offset Numero referido al posicionamiento 
     * del registro de una fila en la base de datos.
     * @return array Datos de Array Asociativo.
     */
    public function getNextStudents($offset)
    {
        $studentModel = new StudentModel();
        return $studentModel->getNextStudents($offset);
    }

    /**
     * getInfoStudentById, Metodo obtiene un recurso o registro estudiante de la base de datos.
     *
     * @param  int $id ID del registro.
     * @return array Datos de array asociativo.
     */
    public function getInfoStudentById($id)
    {
        $studentModel = new StudentModel();
        return $studentModel->getInfoStudentById($id);
    }
    
    /**
     * updateInfoStudent, actualizacion de informacion de estudiante verificados y habilitados
     *
     * @param  array $data
     * @return array Arreglo con datos si hubo exito
     */
    public function updateInfoStudent($data)
    {
        $studentModel = new StudentModel();
        return $studentModel->updateInfoStudent($data);
    }
    
/**
     * updateInfoStudent, actualizacion de informacion de estudiante solo registrados
     *
     * @param  array $data
     * @return array Arreglo con datos si hubo exito
     */
    public function updateInfoStudentRegisteredOnly($data)
    {
        $studentModel = new StudentModel();
        return $studentModel->updateInfoStudentRegisteredOnly($data);
    }

    /**
     * getWeekModalities, Obtencion de las modalidades segun el turno
     *
     * @param  string $turn Turno Matutino o Vespertino
     * @return array Arreglo de datos
     */
    public function getWeekModalities($turn)
    {
        $studentModel = new StudentModel();
        return $studentModel->getWeekModalities($turn);
    }

    /**
     * isModalityAvailable, Retorna verdadero si hay disponibilidad dentro de esa modalidad
     *
     * @param  string $modality
     * @return array
     */
    public function isModalityAvailable($modality)
    {
        $studentModel = new StudentModel();
        return $studentModel->isModalityAvailable($modality);
    }

    /**
     * getCourseLevels, Obtiene todos los niveles de curso
     *
     * @return array Array de datos
     */
    public function getCourseLevels()
    {
        $studentModel = new StudentModel();
        return $studentModel->getCourseLevels();
    }

    public function verificarEstudiante($idEstudiante,$idNivel,$pago,$codigoDeVerificacion)
    {
        $studentModel = new StudentModel();
        return $studentModel->verificarEstudiante($idEstudiante,$idNivel,$pago,$codigoDeVerificacion);
    }

    public function getIdByCodigo($codigoDeVerificacion)
    {
        $studentModel = new StudentModel();
        return $studentModel->getIdByCodigo($codigoDeVerificacion);
    }

    public function getMoreInfoStudentById($id)
    {
        $studentModel = new StudentModel();
        return $studentModel->getMoreInfoStudentById($id);
        
    }

    public function updateMoreInfoStudentById($data)
    {
        $studentModel = new StudentModel();
        return $studentModel->updateMoreInfoStudentById($data);
        
    }
    public function getTurno()
    {
        $studentModel = new StudentModel();
        return $studentModel->getTurno();
    }

    public function verificarSeminario($id){
        $studentModel = new StudentModel();
        return $studentModel->verificarSeminario($id);
    }

    public function updateDisponibilidad($codigo,$disponibilidad){
        $studentModel = new StudentModel();
        return $studentModel->updateDisponibilidad($codigo,$disponibilidad);
    }

    public function getDisponibilidadByCodigo($codigo){
        $studentModel = new StudentModel();
        return $studentModel->getDisponibilidadByCodigo($codigo);
    }

    public function uploadComprobanteET($ComprobanteET,$id){
        $studentModel =  new StudentModel();
        return $studentModel->uploadComprobanteET($ComprobanteET,$id);
    } 

    public function uploadComprobanteEP($ComprobanteET,$id){
        $studentModel =  new StudentModel();
        return $studentModel->uploadComprobanteEP($ComprobanteET,$id);
    }

    public function assignTutor($idInstructor,$id){
        $studentModel =  new StudentModel();
        return $studentModel->assignTutor($idInstructor,$id);
    }

    public function showTutor($id){
        $studentModel =  new StudentModel();
        return $studentModel->showTutor($id);
    }


    
}
