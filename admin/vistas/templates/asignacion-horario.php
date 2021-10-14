<?php
$data = $_REQUEST['data'] ?? '';
//echo $data;
include_once('../Utilidades/conexion.php');
include_once('../Utilidades/confiDev.php');
include_once('../Controladores/StudentController.php');
include_once('../Modelos/StudentModel.php');
include_once('../Modelos/ScheduleModel.php');
include_once('../Controladores/ScheduleController.php');
include_once('../Modelos/UserModel.php');

if(isset($_POST['btn-guardar-tutor'])){
    $tutor = $_POST['IdInstructor'];
    $controladorEstudiante = new StudentController();
    $assignTutor = $controladorEstudiante->assignTutor($tutor,$data);
    
    if($assignTutor){
        header('location: /admin/vistas/gestion-horario.php?data='.$data.'&Instructor='.$tutor);
    }else{
        echo '<script> alert("Ha succedido un error);</script>';
    }

    

}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="Plataforma en linea, escuela de manejo century" content="">
    <meta name="century creativa" content="">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">

    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <link href="../../css/font-awesome.min.css" rel="stylesheet">
    <link href="../../css/aos.css" rel="stylesheet">
    <link href="../css/modal.css" rel="stylesheet">
    <link href="../../css/fullcalendar.css" rel="stylesheet">
    <link href="../../css/fullcalendar.min.css" rel="stylesheet">

    <script src="../../js/popper.min.js"></script>
    <script src="../../js/aos.js"></script>
    <script src="../../js/fontawesome.js"></script>
    <script src="../../js/jquery-3.5.1.min.js"></script>

    <script src="../../js/jquery.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <script src="../../js/moment.min.js"></script>
    <script src="../../js/fullcalendar/fullcalendar.min.js"></script>
    <script src="../../js/fullcalendar/fullcalendar.js"></script>
    <script src="../../js/fullcalendar/locale/es.js"></script>
    <title>Escuela de Manejo Century</title>
</head>

<body background="../img/backgrounds/info-min.png">
    <!-- Contenedor de ventana Modal -->


    <div class="modal show" id="estudiante-modal" tabindex="-1" role="dialog">
        <!-- Ventana Modal -->
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <a href="/admin/?modulo=horarios" id="btn-back" class="btn btn-primary btn-sm">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <h4 class="modal-title m-auto font-weight-bold" style="text-align: center;">Asignar Instructor</h4>
                </div>
                <div class="modal-body principal">
                    <form class="" action="" method="post" enctype="multipart/form-data">
                        <!-- Division de informacion -->
                        <!-- Division de informacion -->
                        <!-- Calendario FullCalendar-->
                        <div style="margin-bottom: 50px;">
                            <h5 class="pr-4 pl-4 font-weight-bold">Seleccion Instructor</h5>
                            <!-- Division de entrada de datos -->
                            <div class="form-group principal row pr-4 pl-4 mr-0 ml-0 border-bottom">
                                <label for="" class="col-sm-3 col-form-label text-uppercase font-weight-bold text-muted d-flex align-items-center" style="font-size: 10px; padding: 0;">Seleccion de Instructor</label>
                                <div class="col-sm-8">
                                    <select name="IdInstructor" class="custom-select my-1 mr-sm-2" id="IdInstructor">
                                        <option selected>Seleccione al instructor...</option>
                                        <option value="1">Jorge Rodriguez</option>
                                        <option value="2">Enrique Medano</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 pr-4 text-right">
                        <button type="submit" class="btn bg-success text-light pl-4 pr-4 " name="btn-guardar-tutor" id="btn-guardar-tutor">Asignar</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>





</body>

</html>