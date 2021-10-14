<?php
$result = $_REQUEST['result'] ?? '';
 //echo "<script> alert('Id de la info: $result') </script>";

 try {
    // Obtengo el id del estudiante desde la peticion get
    $id = $_REQUEST['result'] ?? '';

    // Inclusion de clases modelos, controladoras y de conexion
    include_once('../Utilidades/conexion.php');
    include_once('../Utilidades/confiDev.php');
    include_once('../Controladores/StudentController.php');
    include_once('../Modelos/StudentModel.php');
    include_once('../Modelos/TestModel.php');
    include_once('../Controladores/TestController.php');

    // Instancia de la clase contralodora StudentController
    $studentController = new StudentController();
    $testController = new TestController();

    // Obtencion de los datos de estudiante
    $data = $testController->getInfoResultadoExamen($id) ?? '';

} catch (Throwable $th) {
    // Mensaje de error
    echo "<script>alert('" . $th->getMessage() . "');</script>";
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

    <script src="../../js/jquery-3.5.1.min.js"></script>
    <script src="../../js/popper.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <script src="../../js/aos.js"></script>
    <script src="../../js/fontawesome.js"></script>

    <title>Escuela de Manejo Century</title>
</head>

<body background="../img/backgrounds/info-min.png">
    <!-- Contenedor de la ventana Modal -->
    <div class="modal show" id="estudiante-modal" tabindex="-1" role="dialog">
        <!-- Ventana Modal -->
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <a href="/admin/?modulo=examenes" id="btn-back" class="btn btn-primary btn-sm">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <h4 class="modal-title m-auto font-weight-bold" style="text-align: center;">Resultados de exámenes</h4>
                </div>
                <div class="modal-body principal">
                    <form class="" action="" method="post" enctype="multipart/form-data">
                        <!-- Division de informacion -->
                        <div style="margin-bottom: 50px;">
                            <h5 class="pr-4 pl-4 font-weight-bold">Información básica</h5>
                            <!-- Division de entrada de datos -->
                            <div class="form-group principal row pr-4 pl-4 mr-0 ml-0 border-bottom">
                                <label for="" class="col-form-label text-uppercase font-weight-bold text-muted d-flex align-items-center" style="font-size: 10px; padding: 0;">Foto</label>
                                <div class="p-0 text-right" style="width: 93%;">
                                    <img id="profile-photo" src="<?php echo "../../" . $data[0]['Foto'] ?> " alt="Foto de perfil">
                                </div>
                            </div>
                            <!-- Division de entrada de datos -->
                            <div class="form-group principal row pr-4 pl-4 mr-0 ml-0 border-bottom">
                                <label for="" class="col-sm-3 col-form-label text-uppercase font-weight-bold text-muted d-flex align-items-center" style="font-size: 10px; padding: 0;">Nombres</label>
                                <div class="col-sm-8">
                                    <input type="text" value=<?php echo  $data[0]['Nombre'] ?> readonly class="form-control-plaintext form-control-sm" id="" placeholder="Nombres">
                                </div>
                            </div>
                            <!-- Division de entrada de datos -->
                            <div class="form-group principal row pr-4 pl-4 mr-0 ml-0 border-bottom">
                                <label for="" class="col-sm-3 col-form-label text-uppercase font-weight-bold text-muted d-flex align-items-center" style="font-size: 10px; padding: 0;">Apellidos</label>
                                <div class="col-sm-8">
                                    <input type="text"  value=<?php echo $data[0]['Apellido'] ?> readonly class="form-control-plaintext form-control-sm" id="" placeholder="Apellidos">
                                </div>
                            </div>

                        </div>

                        <div style="min-height: 15rem;">
                            <h5 class="pr-4 pl-4 font-weight-bold">Resultados</h5>
                            <!-- Division de entrada de datos -->
                            <?php foreach($data as $item) : ?>
                            <div class="form-group principal row pr-4 pl-4 mr-0 ml-0 border-bottom">
                                <label for="" class="col-sm-3 col-form-label text-uppercase font-weight-bold text-muted d-flex align-items-center" style="font-size: 10px; padding: 0;">Examen <?php echo $item['TipoExamen'] ?></label>
                                <div class="col" style="font-size: 13px; padding-top: 7px; padding-bottom: 7px;">
                                    <span class="align-items-center"> <?php echo $item['Fecha'] ?> </span>
                                </div>
                                <div class="col" style="font-size: 13px; padding-top: 7px; padding-bottom: 7px;">
                                    <span class="align-items-center"><?php echo $item['Nota'] ?></span>
                                </div>
                                <div class="col" style="font-size: 13px; padding-top: 7px; padding-bottom: 7px;">
                                    <span class="align-items-center"><?php echo $item['Resultado'] ?></span>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <!-- Botones del formulario -->
                        <div class="modal-footer border-0 d-flex justify-content-center">
                            <a href="/admin/?modulo=estudiantes" type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Regresar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>