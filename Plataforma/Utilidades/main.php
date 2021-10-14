<?php
    include_once 'Plataforma/Utilidades/conexion.php'; 
    include_once 'Plataforma/Utilidades/confiDev.php';
    include_once 'Plataforma/Utilidades/session.php';
    include_once 'Plataforma/Utilidades/Utilidades.php';

    include_once 'Plataforma/Modelos/EstudianteModel.php';
    include_once 'Plataforma/Modelos/InscripcionModel.php';
    include_once 'Plataforma/Modelos/HorarioModel.php';
    include_once 'Plataforma/Modelos/ExamenModel.php';


    include_once 'Plataforma/Controladores/EstudianteController.php';
    include_once 'Plataforma/Controladores/InscripcionController.php';
    include_once 'Plataforma/Controladores/HorarioController.php';
    include_once 'Plataforma/Controladores/ExamenController.php';

    $session = new Session();

    $activeUser= new EstudianteModel();

    $modeloEstudiante = new EstudianteModel();
    $modeloInscripcion = new InscripcionModel();
    $modeloHorario = new HorarioModel();
    $modeloExamen = new ExamenModel();

    $controladorEstudiante = new EstudianteController();
    $controladorHorario = new HorarioController();
    $controladorInscripcion = new InscripcionController();
    $controladorExamen = new ExamenController();




?>