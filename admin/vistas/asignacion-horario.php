<?php

include_once '../Utilidades/session.php';

$session = new Session();



if (isset($_SESSION['idUserAdmin'])) {

    session_regenerate_id(true);

    require_once "templates/asignacion-horario.php";

} else {

    header('Location: /admin');

}

