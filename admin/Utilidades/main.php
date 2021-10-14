<?php
include_once 'Utilidades/conexion.php';
include_once 'Utilidades/confiDev.php';
include_once 'Utilidades/session.php';

include_once 'Modelos/UserModel.php';
include_once 'Modelos/StudentModel.php';
include_once 'Modelos/ScheduleModel.php';
include_once 'Modelos/TestModel.php';
include_once 'Modelos/InscriptionModel.php';

include_once 'Controladores/UserController.php';
include_once 'Controladores/StudentController.php';
include_once 'Controladores/ScheduleController.php';
include_once 'Controladores/TestController.php';
include_once 'Controladores/InscriptionController.php';



$session = new Session();

$activeUser = new UserModel();
$studentModel = new StudentModel();
$scheduleModel = new ScheduleModel();
$testModel = new TestModel();
$InscrptionModel = new InscriptionModel();

$userController = new UserController();
$studentController = new StudentController();
$scheduleController = new ScheduleController();
$testController = new TestController();
$InscriptionController = new InscriptionController();
