<?php

/**
 * Clase modelo StudentModel
 */
class StudentModel extends Conexion
{
    /**
     * rowCountStudents, Metodo que devuelve el numero de registros total de
     * tabla estudiante.
     *
     * @return int Numero de registros
     */
    public function rowCountStudents()
    {
        $query = $this->connect()->prepare("SELECT COUNT(*) FROM estudiante");
        $query->execute();
        // fetchColumn($column_number = 0) 
        // por defecto solo devuelve la primera columna
        return $query->fetchColumn();
    }

    /**
     * searchStudent, Metodo de busqueda de registros de estudiante por texto.
     *
     * @param  string $search_text
     * @return array Datos de Array Asociativo.
     */
    public function searchStudent($search_text)
    {
        $query = $this->connect()
            ->prepare("CALL search_student_by_text(:search)");
        $query->execute(['search' => $search_text]);
        return $query->fetchAll();
    }

    /**
     * getNextStudents, Metodo obtiene los siguientes registros de estudiantes
     * en la vista de gestion de Estudiantes cuando se deja de buscar por texto, 
     * tambien obtiene los siguientes registros de estudiantes
     * en la vista de gestion de Estudiantes al paginar.
     *
     * @param  int $offset Numero referido al posicionamiento 
     * del registro de una fila en la base de datos.
     * @return array Datos de Array Asociativo.
     */
    public function getNextStudents($offset)
    {
        $query = $this->connect()
            ->prepare("CALL get_next_students(:offset);");
        $query->execute(['offset' => $offset]);
        return $query->fetchAll();
    }

    /**
     * getInfoStudentById, Metodo obtiene un recurso o registro estudiante de la base de datos.
     *
     * @param  int $id ID del registro.
     * @return array Datos de array asociativo.
     */
    public function getInfoStudentById($id)
    {
        $query = $this->connect()
            ->prepare('CALL get_info_student_by_id(:id)');
        $query->execute(['id' => $id]);
        return $query->fetchAll();
    }

    /**
     * updateInfoStudent, actualizacion de informacion de estudiante verificados y habilitados
     *
     * @param  array $data
     * @return array Arreglo con datos si hubo exito
     */
    public function updateInfoStudent($data)
    {
        $query = $this->connect()
            ->prepare('CALL update_info_student(
                                :id, :name, :last, 
                                :birthdate, :gender, :idcard, 
                                :passport, :email, :password, 
                                :phone, :address, :state, 
                                :beginner, :license, :category,
                                :old_modality, :new_modality,
                                :testdate,:practicedate,:level,
                                :transito_test_date,:transito_practice_date)');
        return $query->execute($data);
    }

    /**
     * updateInfoStudent, actualizacion de informacion de estudiante solo registrados
     *
     * @param  array $data
     * @return array Arreglo con datos si hubo exito
     */
    public function updateInfoStudentRegisteredOnly($data)
    {
        $query = $this->connect()
            ->prepare('CALL update_info_student_registered(
                                :id, :name, :last, 
                                :birthdate, :gender, :idcard, 
                                :passport, :email, :password, 
                                :phone, :address)');
        return $query->execute($data);
    }

    /**
     * getWeekModalities, Obtencion de las modalidades segun el turno
     *
     * @param  string $turn Turno Matutino o Vespertino
     * @return array Arreglo de datos
     */
    public function getWeekModalities($turn)
    {
        $query = $this->connect()
            ->prepare('CALL get_week_modalities(:turn)');
        $query->execute(['turn' => $turn]);
        return $query->fetchAll();
    }

    /**
     * isModalityAvailable, Retorna verdadero si hay disponibilidad dentro de esa modalidad
     *
     * @param  string $modality
     * @return array
     */
    public function isModalityAvailable($modality)
    {
        $query = $this->connect()
            ->prepare('CALL is_modality_available(:modality)');
        $query->execute(['modality' => $modality]);
        return $query->fetchAll();
    }

    /**
     * getCourseLevels, Obtiene todos los niveles de curso
     *
     * @return array Array de datos
     */
    public function getCourseLevels()
    {
        $query = $this->connect()
            ->prepare('CALL get_course_levels()');
        $query->execute();
        return $query->fetchAll();
    }

    public function verificarEstudiante($idEstudiante, $idNivel, $pago, $codigoDeVerificacion)
    {
        $query = $this->connect()
            ->prepare('CALL verificarEstudiante(:idEstudiante,:idNivel,:pago,:codigoDeVerificacion)');
        $query->execute([
            'idEstudiante' => $idEstudiante,
            'idNivel' => $idNivel,
            'pago' => $pago,
            'codigoDeVerificacion' => $codigoDeVerificacion
        ]);
        if (($query->errorInfo()[2] . "") == "") {
            return true;
        } else {
            return false;
        };
    }


    public function getIdByCodigo($codigoDeVerificacion)
    {
        $query = $this->connect()
            ->prepare("SELECT * FROM estudiante WHERE codigoDeVerificacion= $codigoDeVerificacion");
        $query->execute([
            'codigoDeVerificacion' => $codigoDeVerificacion
        ]);
        if (($query->errorInfo()[2] . "") == "") {
            return $query->fetchAll();
        } else {
            return false;
        };
    }

    public function getMoreInfoStudentById($id)
    {
        $query = $this->connect()
            ->prepare('CALL get_more_info_student_by_Id(:id)');
        $query->execute(['id' => $id]);
        return $query->fetchAll();
    }

    public function updateMoreInfoStudentById($data)
    {
        $query = $this->connect()
            ->prepare('CALL update_more_info_student_by_Id(
                                     :id,:nameCE,:lastCE,:direccionCE,
                                     :phoneCE,:emailCE,:LT,:direccionLT,
                                     :telefonoLT,:emailLT,:observaciones);');
        $query->execute($data);
        return $query;
    }
    
    public function getTurno()
    {
        $query = $this->connect()
            ->prepare("SELECT * FROM turno");
        $query->execute();
        if (($query->errorInfo()[2] . "") == "") {
            return $query->fetchAll();
        } else {
            return false;
        };
    }
    public function verificarSeminario($id){
        $consulta = "UPDATE estudiante set Seminario = 1 WHERE IdEstudiante = $id;";    
        $query = $this->connect()->prepare($consulta);
        $query->execute();

        if (($query->errorInfo()[2] . "") == "") {
            return true;
        } else {
            return false;
        };
    }

    public function updateDisponibilidad($codigo,$disponibilidad){
        $consulta = "UPDATE turno set Disponibilidad = '$disponibilidad' WHERE Codigo = '$codigo';";    
        $query = $this->connect()->prepare($consulta);
        $query->execute();

        if (($query->errorInfo()[2] . "") == "") {
            return true;
        } else {
            return false;
        };
    }

    public function getDisponibilidadByCodigo($codigo){
        
        $consulta = "SELECT * FROM turno WHERE Codigo = '$codigo'";
        $query = $this->connect()->prepare($consulta);
        $query->execute();
        return $query->fetchAll();
    }

    public function uploadComprobanteET($ComprobanteET,$id){
        $consulta = "UPDATE estudiante set ComprobanteET = '$ComprobanteET' WHERE IdEstudiante = '$id'";
        $query = $this->connect()->prepare($consulta);
        $query->execute();

        if (($query->errorInfo()[2] . "") == "") {
            return true;
        } else {
            return false;
        };
    }

    public function uploadComprobanteEP($ComprobanteEP,$id){
        $consulta = "UPDATE estudiante set Comprobante = '$ComprobanteEP' WHERE IdEstudiante = '$id'";
        $query = $this->connect()->prepare($consulta);
        $query->execute();

        if (($query->errorInfo()[2] . "") == "") {
            return true;
        } else {
            return false;
        };
    }

    public function assignTutor($idInstructor,$id){
        $consulta = "UPDATE estudiante set idInstructor = '$idInstructor' WHERE IdEstudiante = '$id'";
        $query = $this->connect()->prepare($consulta);
        $query->execute();

        if (($query->errorInfo()[2] . "") == "") {
            return true;
        } else {
            return false;
        };
    }

    public function showTutor($id){
        $data = '';
        $consulta = "SELECT i.Nombre,i.Apellido,i.IdInstructor 
                    FROM estudiante e INNER JOIN instructor i WHERE e.IdEstudiante = $id 
                    and i.IdInstructor = e.idInstructor";
        $query = $this->connect()->prepare($consulta);
        $query->execute();
        return $query->fetchAll();

       
    }



}
