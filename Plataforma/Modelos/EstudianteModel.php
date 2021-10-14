<?php

class EstudianteModel extends DB
{

    private $idEstudiante;
    private $nombre;
    private $apellido;
    private $email;
    private $password;
    private $cedula;
    private $pasaporte;
    private $sexo;
    private $fechaNacimiento;
    private $telefono;
    private $direccion;
    private $foto;
    private $estado;
    private $fotoCedulaDelante;
    private $fotoCedulaDetras;
    private $controldePago;
    private $examenTeorico;
    private $examenPractico;
    private $fotoBaucher;
    private $metodoPago;
    private $FechaETT;
    private $FechaEPT;
    



    public function __construct()
    {
        ini_set('date.timezone', 'America/Costa_Rica');
    }

    public function setIdEstudiante($idEstudiante) // 1
    {
        $this->idEstudiante = $idEstudiante;
    }

    public function setNombre($nombre) //2
    {
        $this->nombre = $nombre;
    }

    public function setApellido($apellido) //3
    {
        $this->apellido = $apellido;
    }

    public function setEmail($email) //4
    {
        $this->email = $email;
    }

    public function setPassword($password) //5
    {
        $this->password = $password;
    }

    public function setCedula($cedula)
    { //6
        $this->cedula = $cedula;
    }

    public function setPasaporte($pasaporte)
    { //7
        $this->pasaporte = $pasaporte;
    }

    public function setSexo($sexo)
    { //8
        $this->sexo = $sexo;
    }

    public function setFechaNacimiento($fechaNacimiento)
    { //9
        $this->fechaNacimiento = $fechaNacimiento;
    }

    public function setTelefono($telefono)
    { //10
        $this->telefono = $telefono;
    }
    public function  setDireccion($direccion)
    { //11
        $this->direccion = $direccion;
    }
    public function setFoto($foto)
    { //12
        $this->foto = $foto;
    }

    public function setEstado($estado)
    { //13
        $this->estado = $estado;
    }

    public function setFotoCedulaDelante($fotoCedulaDelante)
    { //14
        $this->fotoCedulaDelante = $fotoCedulaDelante;
    }
    public function setFotoCedulaDetras($fotoCedulaDetras)
    { //15
        $this->fotoCedulaDetras = $fotoCedulaDetras;
    }

    public function setControldePago($controldePago)
    { //16
        $this->controldePago = $controldePago;
    }

    public function setExamenTeorico($examenTeorico)
    { //17
        $this->examenTeorico = $examenTeorico;
    }

    public function setExamenPractico($examenPractico)
    { //18
        $this->examenPractico = $examenPractico;
    }

    public function setFotoBaucher($fotoBaucher)
    { //19
        $this->fotoBaucher = $fotoBaucher;
    }
    
      public function setMetodoPago($metodoPago)
    { //19
        $this->metodoPago = $metodoPago;
    }
    public function setFechaExamenTtransito($FechaETT)
    { //19
        $this->FechaETT = $FechaETT;
    }
    public function setFechaExamenPtransito($FechaEPT)
    { //19
        $this->FechaEPT = $FechaEPT;
    }
    
    /*** GET */
    public function getIdEstudiante() //1
    {
        return $this->idEstudiante;
    }

    public function getNombre() //2
    {
        return $this->nombre;
    }

    public function getApellido() //3
    {
        return $this->apellido;
    }
    public function getEmail() //4
    {
        return $this->email;
    }

    public function getPassword() //5
    {
        return $this->password;
    }

    public function getCedula() //6
    {
        return $this->cedula;
    }

    public function getPasaporte() //7
    {
        return $this->pasaporte;
    }

    public function getSexo() //8
    {
        return $this->sexo;
    }

    public function getFechaNacimiento() //9
    {
        return $this->fechaNacimiento;
    }

    public function getTelefono() //10
    {
        return $this->telefono;
    }
    public function getDireccion()
    { //11
        return $this->direccion;
    }
    public function getFoto() //15
    {
        return $this->foto;
    }
    public function getEstado() //14
    {
        return $this->estado;
    }

    public function getFotoCedulaDelante() //12
    {
        return $this->fotoCedulaDelante;
    }

    public function getFotoCedulaDetras() //13
    {
        return $this->fotoCedulaDetras;
    }

    public function getControldePago() //16
    {
        return $this->controldePago;
    }

    public function getExamenTeorico() //17
    {
        return $this->examenTeorico;
    }

    public function getExamenPractico() //18
    {
        return $this->examenPractico;
    }

    public function getFotoBaucher() //19
    {
        return $this->fotoBaucher;
    }

    public function getMetodoPago() //19
    {
        return $this->metodoPago;
    }

        public function getFechaExamenTtransito() //19
    {
        return $this->FechaETT;
    }

    public function getFechaExamenPtransito() //19
    {
        return $this->FechaEPT;
    }

    

    //Realizacion del login
    public function login($email, $password)
    {
        $md5password = openssl_encrypt($password, COD, KEY);
        $query = $this->connect()->prepare("SELECT * FROM estudiante WHERE email = :user AND Password = :password AND Estado='1'");
        $query->execute([
            'user' => $email,
            'password' => $md5password
        ]);
        if ($query->rowCount()) {
            return true;
        } else {
            return false;
        }
    }

    //Obtener estudiante por email
    public function getEstudianteByEmail($email)
    {

        $query = $this->connect()->prepare('SELECT * FROM estudiante where email = :userName;');
        $query->execute(['userName' => $email]);

        $EstudianteResult = new EstudianteModel();

        foreach ($query as $currentEstudiante) {
            $EstudianteResult->setIdEstudiante($currentEstudiante['IdEstudiante']);
            $EstudianteResult->setNombre($currentEstudiante['Nombre']);
            $EstudianteResult->setApellido($currentEstudiante['Apellido']);
            $EstudianteResult->setEmail($currentEstudiante['email']);
            $EstudianteResult->setPassword($currentEstudiante['Password']);
            $EstudianteResult->setCedula($currentEstudiante['Cedula']);
            $EstudianteResult->setPasaporte($currentEstudiante['Pasaporte']);
            $EstudianteResult->setSexo($currentEstudiante['Sexo']);
            $EstudianteResult->setFechaNacimiento($currentEstudiante['FechaNacimiento']);
            $EstudianteResult->setTelefono($currentEstudiante['Telefono']);
            $EstudianteResult->setDireccion($currentEstudiante['Direccion']);
            $EstudianteResult->setFoto($currentEstudiante['Foto']);
            $EstudianteResult->setEstado($currentEstudiante['Estado']);
            $EstudianteResult->setFotoCedulaDelante($currentEstudiante['FotoCedulaDelante']);
            $EstudianteResult->setFotoCedulaDetras($currentEstudiante['FotoCedulaDetras']);
            $EstudianteResult->setControldePago($currentEstudiante['ControldePago']);
            $EstudianteResult->setExamenTeorico($currentEstudiante['ExamenTeorico']);
            $EstudianteResult->setExamenPractico($currentEstudiante['ExamenPractico']);
            $EstudianteResult->setFotoBaucher($currentEstudiante['FotoBaucher']);
        }
        return $EstudianteResult;
        echo "<script> alert('Hubo un Error') </script>";
    }

    //CRUD estudiante

    //insertar nuevo estudiante
    //Metodo para insertar al estudiante

    /* */

    public function Insertar($objEstudiante)
    {
        $consulta = "";
        $consulta = "INSERT INTO estudiante (`Nombre`, `Apellido`, `email`, `Password`, `Cedula`, `Pasaporte`, `Sexo`, `FechaNacimiento`, `Telefono`, `Direccion`,`Foto`,`Estado`,`FotoCedulaDelante`,`FotoCedulaDetras`,`ControldePago`,`MetodoPago`,`ExamenTeorico`,`ExamenPractico`,`FotoBaucher`,`ExamenTeoricoTransito`,`ExamenPracticoTransito`)
        VALUES (:nombre, :apellido, :email, :password, :cedula, :pasaporte, :sexo ,:fechaNacimiento, :telefono, :direccion, :foto,:estado,:fotoCedulaDelante,:FotoCedulaDetras,:controldePago,:MetodoPago,:ExamenTeorico,:ExamenPractico,:FotoBaucher,:ExamenTeoricoTransito,:ExamenPracticoTransito);";
        $query = $this->connect()->prepare($consulta);
        $query->execute([
            'nombre' => $objEstudiante->getNombre(),
            'apellido' => $objEstudiante->getApellido(),
            'email' => $objEstudiante->getEmail(),
            'password' => openssl_encrypt($objEstudiante->getPassword(), COD, KEY),
            'cedula' => $objEstudiante->getCedula(),
            'pasaporte' => $objEstudiante->getPasaporte(),
            'sexo' => $objEstudiante->getSexo(),
            'fechaNacimiento' => $objEstudiante->getFechaNacimiento(),
            'telefono' => $objEstudiante->getTelefono(),
            'direccion' => $objEstudiante->getDireccion(),
            'MetodoPago'=> $objEstudiante->getMetodoPago(),
            'foto' => "",
            'estado' => "",
            'fotoCedulaDelante' => "",
            'FotoCedulaDetras' => "",
            'controldePago' => "",
            'ExamenTeorico' => "",
            'ExamenPractico' => "",
            'FotoBaucher' => "",
            'ExamenTeoricoTransito' =>"",
            'ExamenPracticoTransito' =>""

        ]);

        if (($query->errorInfo()[2] . "") == "") {
            return true;
        } else {
            return false;
        }
    }

    //Actualizar
    public function actualizar($objEstudiante)
    {
        $consulta = "";

        if (($objEstudiante->getPassword()) === "") {
            $consulta = "  UPDATE `estudiante` 
            SET 
            `Pasaporte` = :pasaporte,
            `Telefono` = :telefono,
            `Password` = :password,
            `Direccion` = :direccion,
            WHERE 
            `IdEstudiante` = :idEstudiante;";
        } else {
            $consulta = " UPDATE `estudiante` 
            SET 
            `Pasaporte` = :pasaporte,
            `Telefono` = :telefono,
            `Password` = :password,
            `Direccion` = :direccion
            WHERE 
            `IdEstudiante` = :idEstudiante;";
        }
        $query = $this->connect()->prepare($consulta);

        if ($objEstudiante->getPassword() === "") {
            $query->execute([
                'idEstudiante' => $objEstudiante->getIdEstudiante(),
                'pasaporte' => $objEstudiante->getPasaporte(),
                'telefono' => $objEstudiante->getTelefono(),
                'password' => $objEstudiante->getPassword(),
                'direccion' => $objEstudiante->getDireccion()

            ]);
        } else {
            $query->execute([
                'idEstudiante' => $objEstudiante->getIdEstudiante(),
                'pasaporte' => $objEstudiante->getPasaporte(),
                'telefono' => $objEstudiante->getTelefono(),
                'password' => openssl_encrypt($objEstudiante->getPassword(), COD, KEY),
                'direccion' => $objEstudiante->getDireccion()
            ]);
        }

        if (($query->errorInfo()[2] . "") == "") {
            return true;
        } else {
            return false;
        }
    }

    public function getQuantityEstudiantes()
    {
        $result = 0;
        $query = $this->connect()->prepare("SELECT count(*) AS CantidadEstudiante FROM estudiante WHERE Estado = 'Habilitado';");
        $query->execute();

        foreach ($query as $res) {
            $result = $res['CantidadEstudiantes'];
        }

        return $result;
    }

    public function getIdByEmail($userName)
    {
        $id = "";
        $consulta = "SELECT * FROM estudiante WHERE email = :email";
        $query = $this->connect()->prepare($consulta);

        $query->execute([
            "email" => $userName
        ]);
        //$estudiante = new EstudianteModel();
        foreach ($query as $res) {      //Psara por todos los datos del idEstudiante para encontrar al selecionado
            $id = $res['IdEstudiante'];
        }

        return $id;         //retorna al estudiante con el id Seleccionado
    }

    public function countInicial()
    {
        $result = " ";
        $consulta = "SELECT count(*) AS Cantidad FROM estudiante WHERE Estado = 'Habilitado' ORDER BY Nombre ASC";
        $query = $this->connect()->prepare($consulta);
        $query->execute();

        foreach ($query as $res) {
            $result = $res['Cantidad'];
        }

        if (($query->errorInfo()[2] . "") == "") {
            return $result;
        } else {
            return false;
        }
    }


    public function editarDatosEstudiante($id)
    {
        $html = "<script>";
        $consulta = "SELECT e.Nombre,e.Apellido,e.email,e.Password,e.Cedula,e.Pasaporte,
        e.Sexo,e.FechaNacimiento,e.Telefono,e.Direccion, e.Foto, 
        e.Estado,e.ExamenTeorico,e.ExamenPractico,e.ExamenTeoricoTransito,e.ExamenPracticoTransito,e.FotoCedulaDelante,e.FotoCedulaDetras,e.FotoBaucher,
        e.ComprobanteET,e.ComprobanteEP,t.Descripcion, CONCAT_WS (' / ', n.Nivel, n.HorasPracticas) AS NivelCurso FROM inscripcion i
        INNER JOIN turno t ON i.IdTurno = t.IdTurno
        INNER JOIN nivel_curso n ON i.IdNivel = n.IdNivel
        INNER JOIN estudiante e ON e.IdEstudiante  = i.IdEstudiante
        WHERE i.IdEstudiante=:id";

        $query = $this->connect()->prepare($consulta);
        $query->execute([
            "id" => $id
        ]);

        foreach ($query as $res) {
            $html .= '
            document.getElementById("editar-nombre").innerHTML = "' . $res['Nombre'] . '";
            document.getElementById("editar-apellido").innerHTML = "' . $res['Apellido'] . '"; 
            document.getElementById("editar-cedula").innerHTML = "' . $res['Cedula'] . '";
            document.getElementById("editar-sexo").innerHTML = "' . $res['Sexo'] . '";
            document.getElementById("editar-email").innerHTML = "' . $res['email'] . '";        
            document.getElementById("editar-contrasenia").value = "' . openssl_decrypt($res['Password'], COD, KEY) . '";
            document.getElementById("editar-fecha-nacimiento").innerHTML = "' . $res['FechaNacimiento'] . '";      
            document.getElementById("editar-telefono").value = "' . $res['Telefono'] . '";
            document.getElementById("editar-pasaporte").value = "' . $res['Pasaporte'] . '";
            document.getElementById("editar-direccion").value = "' . $res['Direccion'] . '";  
            document.getElementById("turno").innerHTML = "' . $res['Descripcion'] . '";   
            document.getElementById("nivel").innerHTML = "' . $res['NivelCurso'] . '";   
            document.getElementById("foto-cedula-delante").src = "' . $res['FotoCedulaDelante'] . "?" . date("h.i.s") . '";
            document.getElementById("foto-cedula-detras").src = "' . $res['FotoCedulaDetras'] . "?" . date("h.i.s") . '";
            document.getElementById("foto-Boucher").src = "' . $res['FotoBaucher'] . "?" . date("h.i.s") . '";
            document.getElementById("fecha-examen-teorico").innerHTML = "' . $res['ExamenTeorico'] . '";        
            document.getElementById("fecha-examen-practico").innerHTML = "' . $res['ExamenPractico'] . '"; 
            document.getElementById("fecha-examen-teorico-transito").innerHTML = "' . $res['ExamenTeoricoTransito'] . '";        
            document.getElementById("fecha-examen-practico-transito").innerHTML = "' . $res['ExamenPracticoTransito'] . '"; 
            document.getElementById("template").src = "' . $res['Foto'] . "?" . date("h.i.s") . '";
            
            document.getElementById("ComprobanteETme").href = "' . $res['ComprobanteET'] .'";
            document.getElementById("ComprobanteETPme").href = "' . $res['ComprobanteEP'] .'";

            document.getElementById("ComprobanteET").href = "' . $res['ComprobanteET'] .'";
            document.getElementById("ComprobanteEP").href = "' . $res['ComprobanteEP'] .'";

            document.getElementById("ComprobanteEPV").src = "' . $res['ComprobanteEP'] . "?" . date("h.i.s") . '";
            document.getElementById("ComprobanteETV").src = "' . $res['ComprobanteET'] . "?" . date("h.i.s") . '";

          

            ';
        }
        $html .= "</script>";

        if (($query->errorInfo()[2] . "") == "") {
            return $html;
        } else {
            return "Problemas al cargar el usuario, por favor, pongace en contacto con el administrador del sistema";
        }
    }

    public function actualizarUrlFoto($id, $Foto, $tag)
    {
        $consulta = "";
        if ($tag == "Nuevo") {
            if ($Foto != null) {
                $consulta = "UPDATE estudiante SET Foto = 'Plataforma/Imagenes/Estudiante/Perfil/" . "PROFILE_PHOTO_" . $id . ".png' WHERE IdEstudiante = " . $id . ";";
                $query = $this->connect()->prepare($consulta);
                $query->execute();

                if (($query->errorInfo()[2] . "") == "") {
                    return true;
                } else {
                    return false;
                }
            } else {
                $consulta = "UPDATE estudiante SET Foto = 'Plataforma/Imagenes/template1.png' WHERE IdEstudiante = " . $id . ";";
                $query = $this->connect()->prepare($consulta);
                $query->execute();

                if (($query->errorInfo()[2] . "") == "") {
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            if ($Foto != null) {
                $consulta = "UPDATE estudiante SET Foto = 'Plataforma/Imagenes/Estudiante/Perfil/" . "PROFILE_PHOTO_" . $id . ".png' WHERE IdEstudiante = " . $id . ";";
                $query = $this->connect()->prepare($consulta);
                $query->execute();

                if (($query->errorInfo()[2] . "") == "") {
                    return true;
                } else {
                    return false;
                }
            }


        }
    } 

    public function actualizarUrlFotoCedulaDelante($id, $Foto)
    {
        $consulta = "";
        //$id= $this->getIdByEmail($email);
        if ($Foto["tmp_name"] != null) {
            $consulta = "UPDATE estudiante SET FotoCedulaDelante = 'Plataforma/Imagenes/Estudiante/" . "Cedula-delante" . $id . ".png' WHERE IdEstudiante = " . $id . ";";
        } else {
            $consulta = "UPDATE estudiante SET FotoCedulaDelante = 'Plataforma/Imagenes/template.png' WHERE IdEstudiante = " . $id . ";";
        }
        //echo $consulta;

        $query = $this->connect()->prepare($consulta);
        $query->execute();

        if ($query->rowCount()) {
            return true;
        } else {
            return false;
        }
    }

    public function actualizarUrlFotoCedulaDetras($id, $Foto)
    {
        $consulta = "";
        //$id= $this->getIdByEmail($email);
        if ($Foto["tmp_name"] != null) {
            $consulta = "UPDATE estudiante SET FotoCedulaDetras = 'Plataforma/Imagenes/Estudiante/" . "Cedula-detras" . $id . ".png' WHERE IdEstudiante = " . $id . ";";
        } else {
            $consulta = "UPDATE estudiante SET FotoCedulaDetras = 'Plataforma/Imagenes/template.png' WHERE IdEstudiante = " . $id . ";";
        }
        echo $consulta;

        $query = $this->connect()->prepare($consulta);
        $query->execute();

        if ($query->rowCount()) {
            return true;
        } else {
            return false;
        }
    }

    public function actualizarUrlFotoBaucher($id, $Foto)
    {
        $consulta = "";
        //$id= $this->getIdByEmail($email);
        if ($Foto["tmp_name"] != null) {
            $consulta = "UPDATE estudiante SET FotoBaucher = 'Plataforma/Imagenes/Estudiante/" . "Pago" . $id . ".png' WHERE IdEstudiante = " . $id . ";";
        } else {
            $consulta = "UPDATE estudiante SET FotoBaucher = 'Plataforma/Imagenes/template.png' WHERE IdEstudiante = " . $id . ";";
        }
        echo $consulta;

        $query = $this->connect()->prepare($consulta);
        $query->execute();

        if ($query->rowCount()) {
            return true;
        } else {
            return false;
        }
    }

    public function UsuarioRegistrado($email)
    {
        $succes = true;
        $consulta = "SELECT IdEstudiante FROM estudiante WHERE email =:Email";
        $query = $this->connect()->prepare($consulta);
        $query->execute([
            "Email" => $email
        ]);

        foreach ($query as $res) {
            if ($res['IdEstudiante'] != 0) {
                $succes = true;
            } else {
                $succes = false;
            }
        }

        //$query->errorInfo()[2];
        return $succes;
    }

    public function VerificarUsuarioActivoById($email){
        $id="";
        $consulta = "SELECT * FROM estudiante Where email = :email AND ControldePago =1 AND Estado =1 ";
        $query = $this->connect()->prepare($consulta);
        $query->execute([
            "email" => $email
        ]);

        foreach ($query as $res) {
            $id = $res['IdEstudiante'];
        }

            return $id; 
    }

    public function VerificarUsuarioNoActivoById($emai)
    {
        $id = "";
        $consulta = "SELECT * FROM estudiante WHERE email = :email AND ControldePago =0 AND Estado =0";
        $query = $this->connect()->prepare($consulta);
        $query->execute([
            "email" => $emai
        ]);

        foreach ($query as $res) {
            $id = $res['IdEstudiante'];
        }

        return $id;
    }

    public function estadoActivoPagoNOrealizado($emai)
    {
        $id = "";
        $consulta = "SELECT * FROM estudiante WHERE email = :email AND ControldePago = 0 AND Estado =1";
        $query = $this->connect()->prepare($consulta);
        $query->execute([
            "email" => $emai
        ]);

        foreach ($query as $res) {
            $id = $res['IdEstudiante'];
        }


        return $id;
    }

    public function estadoNOActivoPagoRealizado($emai)
    {
        $id = "";
        $consulta = "SELECT * FROM estudiante WHERE email = :email AND ControldePago = 1 AND Estado = 0";
        $query = $this->connect()->prepare($consulta);
        $query->execute([
            "email" => $emai
        ]);

        foreach ($query as $res) {
            $id = $res['IdEstudiante'];
        }

        return $id;
    }

    public function getFototEstudianteById($id)
    {

        $consulta = "SELECT * FROM estudiante WHERE IdEstudiante =:id";
        $query = $this->connect()->prepare($consulta);
        $query->execute([
            "id" => $id
        ]);

        foreach ($query as $res) {
            if ($res['Foto'] != null) {
                return "Existe";
            } else {
                return "Nuevo";
            }
        }
    }

    public function getEstudianteById($id)
    {

        $consulta = "SELECT e.Nombre,e.Apellido,e.email,e.Password,e.Cedula,e.Pasaporte,
        e.Sexo,e.FechaNacimiento,e.Telefono,e.Direccion, e.Foto, 
        e.Estado,e.ExamenTeorico,e.ExamenPractico,e.ExamenTeoricoTransito,
        e.ExamenPracticoTransito,e.FotoCedulaDelante,e.FotoCedulaDetras,e.FotoBaucher,
        t.Descripcion, CONCAT_WS (' / ', n.Nivel, n.HorasPracticas) AS NivelCurso FROM inscripcion i
        INNER JOIN turno t ON i.IdTurno = t.IdTurno
        INNER JOIN nivel_curso n ON i.IdNivel = n.IdNivel
        INNER JOIN estudiante e ON e.IdEstudiante  = i.IdEstudiante
        WHERE i.IdEstudiante=:id";
        $query = $this->connect()->prepare($consulta);
        $query->execute([
            "id" => $id
        ]);

            $Estudiante = new EstudianteModel();

        foreach ($query as $res) {
            $Estudiante->setNombre($res['Nombre']);
            $Estudiante->setApellido($res['Apellido']);
            $Estudiante->setEmail($res['email']);
            $Estudiante->setPassword($res['Password']);
            $Estudiante->setCedula($res['Cedula']);
            $Estudiante->setPasaporte($res['Pasaporte']);
            $Estudiante->setFechaNacimiento($res['FechaNacimiento']);
            $Estudiante->setSexo($res['Sexo']);
            $Estudiante->setTelefono($res['Telefono']);
            $Estudiante->setExamenPractico($res['ExamenPractico']);
            $Estudiante->setExamenTeorico($res['ExamenTeorico']);
            $Estudiante->setFoto($res['Foto']);
            $Estudiante->setFotoBaucher($res['FotoBaucher']);
            $Estudiante->setFotoCedulaDelante($res['FotoCedulaDelante']);
            $Estudiante->setFotoCedulaDetras($res['FotoCedulaDetras']);
            $Estudiante->setFechaExamenTtransito($res['ExamenTeoricoTransito']);
            $Estudiante->setFechaExamenPtransito($res['ExamenPracticoTransito']);

        }

        return $Estudiante;
    }

    public function registrarRecuperacion($email, $code)
    {

        $date_now = date('d-m-Y');
        $date_future = strtotime('+1 day', strtotime($date_now));
        $date_future = getdate($date_future);
        $fechaFormateada = "$date_future[year]-$date_future[mon]-$date_future[mday]";

        $consulta = "UPDATE estudiante SET CodigoContrasenia = :codigo, CodigoContraseniaDate = :fecha WHERE email = :email AND Estado = 1 AND ControlDePago = 1";
        $query = $this->connect()->prepare($consulta);
        $query->execute([
            'email' => $email,
            'codigo' => $code,
            'fecha' => $fechaFormateada
        ]);

        if ($query->rowCount()) {
            return true;
        } else {
            return false;
        }
    }

    public function actualizarContrasenia($password, $id)
    {
        $consulta = "UPDATE estudiante SET Password = :password WHERE IdEstudiante = :idEstudiante";
        $query = $this->connect()->prepare($consulta);
        $query->execute([
            'idEstudiante' => $id,
            'password' => openssl_encrypt($password, COD, KEY)
        ]);

        if ($query->rowCount()) {
            return true;
        } else {
            return false;
        }
    }

    public function getIdByCodigoContrasenia($code)
    {
        $fecha = getdate();
        $fechaFormateada = "$fecha[year]-$fecha[mon]-$fecha[mday]";

        $id = "";
        $consulta = "SELECT IdEstudiante FROM estudiante WHERE CodigoContrasenia = :code AND CodigoContraseniaDate > " . $fechaFormateada . "";
        $query = $this->connect()->prepare($consulta);
        $query->execute([
            "code" => $code
        ]);

        foreach ($query as $res) {
            $id = $res['IdEstudiante'];
        }

        

        return $id;
    }
        
    public function CedulaRepetida($cedula)
    {
        $id="";
        $consulta = "SELECT * FROM estudiante where Cedula = :cedula";
        $query = $this->connect()->prepare($consulta);
        $query->execute([
            'cedula' =>$cedula
        ]);
        foreach ($query as $res) {
            $id = $res['IdEstudiante'];
        }
        return $id;
    }
                    
    public function getIdByCodVerificacion($code)
    {

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


    public function getIdByCodigo($codigoDeVerificacion)
    {
        $query = $this->connect()
            ->prepare("SELECT * FROM estudiante WHERE CodigoVerificacion = :CodigoVerificacion");
        $query->execute([
            'CodigoVerificacion' => $codigoDeVerificacion
        ]);
        if (($query->errorInfo()[2] . "") == "") {
            return $query->fetchAll();
        } else {
            return false;
        };
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

    
    
}
