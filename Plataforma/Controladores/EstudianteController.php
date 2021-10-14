<?php



class EstudianteController

{
    public function Insertar($nombre, $apellido, $email, $password, $cedula, $pasaporte, $fechaNacimiento, $sexo, $telefono, $direccion, $metodoPago)
    {
        $objEstudiante = new EstudianteModel();
        $objEstudiante->setNombre($nombre);
        $objEstudiante->setApellido($apellido);
        $objEstudiante->setEmail($email);
        $objEstudiante->setPassword($password);
        $objEstudiante->setCedula($cedula);
        $objEstudiante->setPasaporte($pasaporte);
        $objEstudiante->setSexo($sexo);
        $objEstudiante->setFechaNacimiento($fechaNacimiento);
        $objEstudiante->setTelefono($telefono);
        $objEstudiante->setDireccion($direccion);
        $objEstudiante->setMetodoPago($metodoPago);

        return $objEstudiante->Insertar($objEstudiante);
    }

    public function actualizar(
        $id,
        $actualizarPasaporte,
        $actualizarTelefono,
        $actualizarPassword,
        $actualizarDireccion

    ) {

        $objEstudiante = new EstudianteModel();
        $objEstudiante->setIdEstudiante($id);
        $objEstudiante->setPasaporte($actualizarPasaporte);
        $objEstudiante->setTelefono($actualizarTelefono);
        $objEstudiante->setPassword($actualizarPassword);
        $objEstudiante->setDireccion($actualizarDireccion);

        return $objEstudiante->actualizar($objEstudiante);
    }

    public function countInicial()
    {
        $objEstudiante = new EstudianteModel();
        return $objEstudiante->countInicial();
    }
    public function getIdByEmail($userName)
    {
        $objEstudiante = new EstudianteModel();
        return $objEstudiante->getIdByEmail($userName);
    }

    public function editarDatosEstudiante($id)
    {
        $objEstudiante =  new EstudianteModel();
        return $objEstudiante->editarDatosEstudiante($id);
    }

    public function actualizarUrlFoto($id, $Foto, $tag)
    {
        $obEstudiante = new EstudianteModel();
        return $obEstudiante->actualizarUrlFoto($id, $Foto, $tag);
    }

    public function  actualizarUrlFotoCedulaDelante($id, $Foto)
    {
        $obEstudiante = new EstudianteModel();
        return $obEstudiante->actualizarUrlFotoCedulaDelante($id, $Foto);
    }

    public function  actualizarUrlFotoCedulaDetras($id, $Foto)
    {
        $obEstudiante = new EstudianteModel();
        return $obEstudiante->actualizarUrlFotoCedulaDetras($id, $Foto);
    }

    public function  actualizarUrlFotoBaucher($id, $Foto)
    {
        $obEstudiante = new EstudianteModel();
        return $obEstudiante->actualizarUrlFotoBaucher($id, $Foto);
    }

    public function UsuarioRegistrado($email)
    {
        $objEstudiante = new EstudianteModel();
        return $objEstudiante->UsuarioRegistrado($email);
    }
    public function getFototEstudianteById($id)
    {
        $objEstudiante = new EstudianteModel();
        return $objEstudiante->getFototEstudianteById($id);
    }
    public function getEstudianteById($id)
    {
        $objEstudiante = new EstudianteModel();
        return $objEstudiante->getEstudianteById($id);
    }

    public function registrarRecuperacion($email, $code)
    {
        $objEstudiante  = new EstudianteModel();
        return $objEstudiante->registrarRecuperacion($email, $code);
    }
    public function actualizarContrasenia($password, $id)
    {
        $objEstudiante  = new EstudianteModel();
        return $objEstudiante->actualizarContrasenia($password, $id);
    }
    public function VerificarUsuarioActivoById($email)
    {
        $objEstudiante  = new EstudianteModel();
        return $objEstudiante->VerificarUsuarioActivoById($email);
    }
    public function VerificarUsuarioNoActivoById($email)
    {
        $objEstudiante  = new EstudianteModel();
        return $objEstudiante->VerificarUsuarioNoActivoById($email);
    }
    public function estadoActivoPagoNOrealizado($email)
    {
        $objEstudiante  = new EstudianteModel();
        return $objEstudiante->estadoActivoPagoNOrealizado($email);
    }

    public function estadoNOActivoPagoRealizado($email)
    {
        $objEstudiante  = new EstudianteModel();
        return $objEstudiante->estadoNOActivoPagoRealizado($email);
    }

    public function getIdByCodigoContrasenia($code)
    {
        $objEstudiante  = new EstudianteModel();
        return $objEstudiante->getIdByCodigoContrasenia($code);
    }

    public function CedulaRepetida($cedula)
    {
        $objEstudiante  = new EstudianteModel();
        return $objEstudiante->CedulaRepetida($cedula);
    }

    public function getIdByCodVerificacion($code)
    {
        $objEstudiante  = new EstudianteModel();
        return $objEstudiante->getIdByCodVerificacion($code);
    }
    /**
     * getWeekModalities, Obtencion de las modalidades segun el turno
     *
     * @param  string $turn Turno Matutino o Vespertino
     * @return array Arreglo de datos
     */
    public function getWeekModalities($turn)
    {
        $studentModel = new EstudianteModel();
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
        $studentModel = new EstudianteModel();
        return $studentModel->isModalityAvailable($modality);
    }

    /**
     * getInfoStudentById, Metodo obtiene un recurso o registro estudiante de la base de datos.
     *
     * @param  int $id ID del registro.
     * @return array Datos de array asociativo.
     */
    public function getInfoStudentById($id)
    {
        $studentModel = new EstudianteModel();
        return $studentModel->getInfoStudentById($id);
    }
    /*** codifo de xochilt Otra vez*/
    public function getIdByCodigo($codigoDeVerificacion)
    {
        $studentModel = new EstudianteModel();
        return $studentModel->getIdByCodigo($codigoDeVerificacion);
    }
    public function getTurno()
    {
        $studentModel = new EstudianteModel();
        return $studentModel->getTurno();
    }
}
