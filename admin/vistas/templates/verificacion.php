<?php
include_once('../Utilidades/conexion.php');
include_once('../Utilidades/confiDev.php');
include_once('../Utilidades/email.php');
include_once('../Utilidades/Utilidades.php');
include_once('../Controladores/StudentController.php');
include_once('../Modelos/StudentModel.php');

$info = $_REQUEST['data'] ?? '';

$utilidades = new Utilidades();
$studentController = new StudentController();

$Estudiante = $studentController->getInfoStudentById($info);
$email = $Estudiante[0]['Email'];
$metodoPago = $Estudiante[0]['MetodoPago'];


//echo $email;
if (isset($_POST['btn-verificar'])) {
    $verificarCurso = $_POST['select-curso'];
    $verificarInformacion = $_POST['verificar-informacion'];
    $data = [$verificarCurso, $verificarInformacion];
    if (!$utilidades->camposVacios($data)) {
        if (!$utilidades->campoInyecciones($data)) {
            //actualizar e insertar en tabla estudiante e inscripcion
            $codigoDeVerificacion = md5(uniqid(rand(), true));
            $verificacion = $studentController->verificarEstudiante($info,$verificarCurso,$verificarInformacion,$codigoDeVerificacion);
            if($verificacion){
                echo "<script>alert('se verifo correctamente')</script>"; 
                verificarInscripcion($codigoDeVerificacion,$email);
                header("Location: /admin?modulo=estudiantes");
            }else{
                echo "<script>alert('Hubo un error en la verificacion de los datos')</script>"; 
            }
        } else {
            header("Location: ../../Plataforma/Vistas/Registrarse.php?result=loginFaileCaracteres");
        }
    } else {
        header("Location: ../../Plataforma/Vistas/Registrarse.php?result=loginFaileVacios");
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
    <link href="../css/verificacion.css" rel="stylesheet">
    <link href="../css/viewer.css" rel="stylesheet">

    <script src="../../js/jquery-3.5.1.min.js"></script>
    <script src="../../js/popper.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <script src="../../js/aos.js"></script>
    <script src="../../js/fontawesome.js"></script>

    <title>Escuela de Manejo Century</title>
</head>

<body background="../img/backgrounds/info-min.png">
    <!-- Contenedor de ventana Modal -->
    <div class="modal show" id="estudiante-modal" tabindex="-1" role="dialog">
        <!-- Ventana Modal -->
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <a href="/admin/?modulo=estudiantes" id="btn-back" class="btn btn-primary btn-sm">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <h4 class="modal-title w-100 font-weight-bold" style="text-align: center;">Información de verificación</h4>
                </div>
                <div class="modal-body principal docs-pictures">
                    <form class="" action="" method="post" enctype="multipart/form-data">
                        <!-- Division de informacion -->
                        <div style="margin-bottom: 50px;">
                            <h5 class="pr-4 pl-4 font-weight-bold">Información básica</h5>
                            <!-- Division de entrada de datos -->
                            <div class="form-group principal row pr-4 pl-4 mr-0 ml-0 border-bottom">
                                <label for="" class="col-form-label text-uppercase font-weight-bold text-muted d-flex align-items-center" style="font-size: 10px; padding: 0;">Foto</label>
                                <div class="p-0 text-right" style="width: 93%;">
                                    <img id="profile-photo" src="<?php echo "../../" . $Estudiante[0]['Foto']; ?>" alt="Foto de perfil">
                                </div>
                            </div>
                            <!-- Division de entrada de datos -->
                            <div class="form-group principal row pr-4 pl-4 mr-0 ml-0 border-bottom">
                                <label for="" class="col-sm-3 col-form-label text-uppercase font-weight-bold text-muted d-flex align-items-center" style="font-size: 10px; padding: 0;">Nombres</label>
                                <div class="col-sm-8">
                                    <input type="text" readonly class="form-control-plaintext form-control-sm" id="" placeholder="Nombres" value="<?php echo $Estudiante[0]['Nombre']; ?>">
                                </div>
                            </div>
                            <!-- Division de entrada de datos -->
                            <div class="form-group principal row pr-4 pl-4 mr-0 ml-0 border-bottom">
                                <label for="" class="col-sm-3 col-form-label text-uppercase font-weight-bold text-muted d-flex align-items-center" style="font-size: 10px; padding: 0;">Apellidos</label>
                                <div class="col-sm-8">
                                    <input type="text" readonly class="form-control-plaintext form-control-sm" id="" placeholder="Apellidos" value="<?php echo $Estudiante[0]['Apellido']; ?>">
                                </div>
                            </div>
                        </div>
                        <!-- Division de informacion -->
                        <div style="margin-bottom: 50px;">
                            <h5 class="pr-4 pl-4 font-weight-bold">Metodo de pago: <?php echo $metodoPago ?></h5>

                            <?php if ($metodoPago == 'Efectivo Cordobas (C$)') : ?>
                                <h6 class="pr-4 pl-4 font-weight-bold">Foto de la Factura</h6>
                            <?php elseif ($metodoPago == 'Transferencia Bancaria') : ?>
                                <h6 class="pr-4 pl-4 font-weight-bold">Foto del voucher</h6>
                            <?php elseif ($metodoPago == 'Tarjeta') : ?>
                                <h6 class="pr-4 pl-4 font-weight-bold">Foto del recibo</h6>
                            <?php endif; ?>                            <!-- Division de entrada de datos -->
                            <div class="form-group principal pr-4 pl-4 mr-0 ml-0 border-bottom">
                                <div class="w-100" style="height: 450px;">
                                    <img data-original="<?php echo "../../" . $Estudiante[0]['FotoBaucher']; ?>" src="<?php echo "../../" . $Estudiante[0]['FotoBaucher']; ?>" alt="Foto de voucher de pago">
                                </div>
                            </div>
                            <div class="container">
                             <div class="row mb-5 px-3" style = "border-bottom: #ffd21f 3px solid;">
                                    <div class="col-md-6">
                                    <label class="font-weight-bold" for="">Ingrese el curso al que aplico el estudiante: </label>
                                    </div>
                                    <div class="col-md-4">
                                        <select name="select-curso" class="text-color form-control-plaintext form-control-sm" required>
                                            <option value="1">1-Basico 10hrs</option>
                                            <option value="2">2-Plus 15hrs</option>
                                            <option value="3">3-Intermedio 8hrs</option>
                                            <option value="4">4-Avanzado 2hrs</option>
                                            <option value="5">5-Paquete 1-30hrs</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div style="margin-bottom: 50px;">
                            <h5 class="pr-4 pl-4 font-weight-bold">Foto de cédula frontal</h5>
                            <!-- Division de entrada de datos -->
                            <div class="form-group principal pr-4 pl-4 mr-0 ml-0 border-bottom">
                                <p>Parte <mark>frontal</mark> de la cédula de identidad del estudiante.</p>
                                <div class="w-100" style="height: 450px;">
                                    <img data-original="<?php echo "../../" . $Estudiante[0]['FotoCedulaDelante']; ?>" src="<?php echo "../../" . $Estudiante[0]['FotoCedulaDelante']; ?>" alt="Foto de cédula frontal">
                                </div>
                            </div>
                        </div>
                        <!-- Division de informacion -->
                        <div style="margin-bottom: 20px;">
                            <h5 class="pr-4 pl-4 font-weight-bold">Foto de cédula reverso</h5>
                            <!-- Division de entrada de datos -->
                            <div class="form-group principal pr-4 pl-4 mr-0 ml-0 border-bottom">
                                <p>Parte <mark>reverso</mark> de la cédula de identidad del estudiante.</p>
                                <div class="w-100" style="height: 450px;">
                                    <img data-original="<?php echo "../../" . $Estudiante[0]['FotoCedulaDetras']; ?>" src="<?php echo "../../" . $Estudiante[0]['FotoCedulaDetras']; ?>" alt="Foto de cédula reverso">
                                </div>
                            </div>
                        </div>
                        <!-- Checkbox de verificacion -->
                        <div class="m-3">
                            <div class="custom-control custom-checkbox">
                                <input name="verificar-informacion" value="1" type="checkbox" class="custom-control-input" id="customCheck1" required>
                                <label class="custom-control-label" for="customCheck1" title="marca la casilla para continuar">Verificar información de inscripción</label>
                            </div>
                        </div>
                        <!-- Botones del formulario -->
                        <div class="modal-footer border-0 d-flex justify-content-center">
                            <a href="/admin/?modulo=estudiantes" type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancelar</a>
                            <button type="submit" id="btn-verificar" name="btn-verificar" class="btn btn-primary btn-sm">Aceptar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="../js/viewer.js"></script>
    <script src="../js/main-viewer.js"></script>


    <script>
        $(document).ready(function() {
            $("#btn-verificar").on("click", function() {
                var respuesta = confirm("¿Todos los datos del cliente fueron correctamente verificados");
                if (respuesta == true) {
                    return true;
                } else {
                    return false;
                }
            });
        });
    </script>
</body>

</html>