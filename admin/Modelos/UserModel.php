<?php

/**
 * Modelo UserModel o Administrador
 */
class UserModel extends Conexion
{
    // Atributos de la clase
    private $idUsuario;
    private $nombre;
    private $apellido;
    private $email;
    private $password;
    private $estado;
    private $fechaCreacion;
    private $fechaModificacion;
    private $foto;

    /**
     * __construct Metodo constructor del modelo UserModel
     *
     * @return void
     */
    public function __construct()
    {
        ini_set('date.timezone', 'America/Managua');
    }

    // ---------SETTERS----------    
    /**
     * Metodo setters setIdUsuario
     *
     * @param  int $idUsuario
     * @return void
     */
    public function setIdUsuario($idUsuario)
    {
        $this->idUsuario = $idUsuario;
    }

    /**
     * Metodo setters setNombre
     *
     * @param string $nombre
     * @return void
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * Metodo setters setApellido
     *
     * @param  string $apellido
     * @return void
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;
    }

    /**
     * Metodo setters setEmail
     *
     * @param  string $email
     * @return void
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Metodo setters setPassword
     *
     * @param  string $password
     * @return void
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Metodo setters setEstado
     *
     * @param  string $estado
     * @return void
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    /**
     * Metodo setters setFechaCreacion
     *
     * @param  date $fechaCreacion
     * @return void
     */
    public function setFechaCreacion($fechaCreacion)
    {
        $this->fechaCreacion = $fechaCreacion;
    }

    /**
     * Metodo setters setFechaModificacion
     *
     * @param  date $fechaModificacion
     * @return void
     */
    public function setFechaModificacion($fechaModificacion)
    {
        $this->fechaModificacion = $fechaModificacion;
    }

    /**
     * Metodo setters setFoto
     *
     * @param  string $foto
     * @return void
     */
    public function setFoto($foto)
    {
        $this->foto = $foto;
    }

    // ---------GETTERS----------

    /**
     * Metodo getters getIdUsuario
     *
     * @return int
     */
    public function getIdUsuario()
    {
        return $this->idUsuario;
    }

    /**
     * Metodo getters getNombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Metodo getters getApellido
     *
     * @return string
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * Metodo getters getEmail
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Metodo getters getPassword
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Metodo getters getEstado
     *
     * @return bool
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Metodo getters getFechaCreacion
     *
     * @return date
     */
    public function getFechaCreacion()
    {
        return $this->fechaCreacion;
    }

    /**
     * Metodo getters getFechaModificacion
     *
     * @return date
     */
    public function getFechaModificacion()
    {
        return $this->fechaModificacion;
    }

    /**
     * Metodo getters getFoto
     *
     * @return string
     */
    public function getFoto()
    {
        return $this->foto;
    }

    /**
     * Funcion de logeo para administrador.
     *
     * @param  mixed $email Correo del usuario.
     * @param  mixed $password Password del usuario -> CenturyEscuelaManejo2021.
     * @return bool Retorna verdadero si las credenciales son correctas, de lo contrario falso. 
     */
    public function login($email, $password): bool
    {
        $password_encrypt = openssl_encrypt($password, COD, KEY);
        $query = $this->connect()
            ->prepare('SELECT `Nombre` FROM usuario WHERE `Email` = :user AND `Password` = :pass');
        $query->execute([
            'user' => $email,
            'pass' => $password_encrypt
        ]);

        if ($query->rowCount()) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * Metodo getUserByEmail, Obtiene al usuario administrador desde el gestor de la DB.
     *
     * @param  string $email
     * @return UserModel Regresa una instancia del modelo UserModel
     */
    public function getUserByEmail($email)
    {

        $query = $this->connect()->prepare('SELECT * FROM usuario WHERE `Email` = :email');
        $query->execute(['email' => $email]);

        $user = new UserModel();

        foreach ($query as $item) {
            $user->setIdUsuario($item['IdUsuario']);
            $user->setNombre($item['Nombre']);
            $user->setApellido($item['Apellido']);
            $user->setEmail($item['Email']);
            $user->setPassword($item['Password']);
            $user->setEstado($item['Estado']);
            $user->setFechaCreacion($item['FechaCreacion']);
            $user->setFechaModificacion($item['FechaModificacion']);
            $user->setFoto($item['Foto']);
        }
        return $user;
    }

    public function getallUser(){

        $consulta = "SELECT * FROM `usuario`";
        $query = $this->connect()->prepare( $consulta);
        $query->execute();

        return $query;


    }
        /**
     * updateInfoStudent, actualizacion de informacion de estudiante verificados y habilitados
     *
     * @param  array $data
     * @return array Arreglo con datos si hubo exito
     */
    public function updateInfoUser($data)
    {
        $query = $this->connect()
            ->prepare('CALL update_info_user(:id,:name,:last,:password)');
        return $query->execute($data);
    }



}
