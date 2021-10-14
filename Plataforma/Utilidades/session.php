<?php

class Session

{



    //Creacion de la session

    public function __construct()

    {

        if (!(session_status() == PHP_SESSION_ACTIVE)) {
            session_start();

        }

    }



    //set de valores de sesion del usuario logeado

    public function setCurrentId($idUser)

    {

        $_SESSION['idUser'] = $idUser;

    }



    public function setCurrentEmail($emailUser)

    {

        $_SESSION['email'] = $emailUser;

    }



    public function setCurrentName($name,$lastName)

    {

        $_SESSION['fullName'] = $name." ".$lastName;

    }



    public function setCurrentPhoto($foto)

    {

        $_SESSION['foto'] = $foto;

    }

    public function setIdExamen($idExamen)

    {

        $_SESSION['idExamen'] = $idExamen;

    }



    //get de valores de sesion del usuario logeado

    public function getCurrentId()

    {

        return $_SESSION['idUser'];

    }



    public function getCurrentEmail()

    {

        return $_SESSION['email'];

    }



    public function getCurrentName()

    {

        return $_SESSION['fullName'];

    }



    public function getCurrentPhoto()

    {

        return $_SESSION['foto'].'?'.date('h:i:s');

    }



    public function getIdExamen()

    {

        return $_SESSION['idExamen'];

    }







    //Destruccion de la session

    public function closeSession()

    {

        session_unset();

        session_destroy();

    }

}

?>