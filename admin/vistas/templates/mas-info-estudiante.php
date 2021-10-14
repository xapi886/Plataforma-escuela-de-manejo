<?php
try {
    // Obtengo el id del estudiante desde la peticion get
    $id = $_REQUEST['additional'] ?? '';

    // Inclusion de clases modelos, controladoras y de conexion
    include_once('../Utilidades/conexion.php');
    include_once('../Utilidades/confiDev.php');
    include_once('../Controladores/StudentController.php');
    include_once('../Modelos/StudentModel.php');
    // Instancia de la clase contralodora StudentController
    $studentController = new StudentController();

    // Obtencion de los datos de estudiante
    $dataInscripcion =  $studentController->getMoreInfoStudentById($id) ?? '';

} catch (Throwable $th) {
    // Mensaje de error
    echo "<script>alert('" . $th->getMessage() . "');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="Plataforma en linea, escuela de manejo century" content="">
    <meta name="century creativa" content="">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">

    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <link href="../../css/font-awesome.min.css" rel="stylesheet">
    <link href="../../css/aos.css" rel="stylesheet">
    <link href="../css/modal.css" rel="stylesheet">
    <link href="../css/info-estudiante.css" rel="stylesheet">

    <script src="../../js/jquery-3.5.1.min.js"></script>
    <script src="../../js/popper.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <script src="../../js/aos.js"></script>
    <script src="../../js/fontawesome.js"></script>

    <title>Escuela de Manejo Century</title>
</head>

<body background="../img/backgrounds/info-min.png">

<div class="modal show" id="estudiante-modal" tabindex="-1" role="dialog">
        <!-- Ventana Modal -->
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <a href="/admin/?modulo=estudiantes" id="btn-back" class="btn btn-primary btn-sm">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <h4 class="modal-title m-auto font-weight-bold" style="text-align: center;">Mas Información</h4>
                </div>
                <div class="modal-body principal">
                    <!-- Ejemplo de como moverse entre directorios a partir de aquí ../Ajax/StudentAjax.php -->
                    <form id="form-mas-info-estudiante" method="post" enctype="multipart/form-data" autocomplete="off">
                        <input id="id-estudiante" type="hidden" name="id-estudiante" value="<?php echo $id; ?>">
                        <input id="id-inscripcion" type="hidden" name="id-inscripcion" value="<?php echo $dataInscripcion[0]['IdInscripcion']; ?>">
                        <!-- Division de informacion -->
                        <div style="margin-bottom: 50px;">
                            <h5 class="pr-4 pl-4 font-weight-bold">Contacto de emergencia</h5>
                         
                            <!-- Division de entrada de datos -->
                            <div class="form-group principal row pr-4 pl-4 mr-0 ml-0 border-bottom">
                                <label for="" class="col-sm-3 col-form-label text-uppercase font-weight-bold text-muted d-flex align-items-center" style="font-size: 10px; padding: 0;">Nombre</label>
                                <div class="col">
                                    <input type="text" readonly required class="form-control-plaintext form-control-sm" id="txt-nombreCE" placeholder="Nombre" value="<?php echo $dataInscripcion[0]['NombreCE']; ?>">
                                </div>
                                <span>
                                    <button id="btn-one" class="btn btn-light d-inline-block d-flex justify-content-center align-items-center" style="width: 33px; height: 33px; border-radius: 100%;">
                                        <img class="img-edit-field" src="../img/icons/edit.svg" alt="Editar">
                                    </button>
                                </span>
                            </div>
                            <!-- Division de entrada de datos -->
                            <div class="form-group principal row pr-4 pl-4 mr-0 ml-0 border-bottom">
                                <label for="" class="col-sm-3 col-form-label text-uppercase font-weight-bold text-muted d-flex align-items-center" style="font-size: 10px; padding: 0;">Apellido</label>
                                <div class="col">
                                    <input type="text" readonly required class="form-control-plaintext form-control-sm" id="txt-apellidoCE" placeholder="Apellido" value="<?php echo $dataInscripcion[0]['ApellidoCE']; ?>">
                                </div>
                                <span>
                                    <button id="btn-two" class="btn btn-light d-inline-block d-flex justify-content-center align-items-center" style="width: 33px; height: 33px; border-radius: 100%;">
                                        <img class="img-edit-field" src="../img/icons/edit.svg" alt="Editar">
                                    </button>
                                </span>
                            </div>
                            <!-- Division de entrada de datos -->
                            <div class="form-group principal row pr-4 pl-4 mr-0 ml-0 border-bottom">
                                <label for="" class="col-sm-3 col-form-label text-uppercase font-weight-bold text-muted d-flex align-items-center" style="font-size: 10px; padding: 0;">Telefono</label>
                                <div class="col">
                                    <input type="text" readonly required class="form-control-plaintext form-control-sm" id="txt-telefonoCE" value="<?php echo $dataInscripcion[0]['TelefonoCE']; ?>">
                                </div>
                                <span>
                                    <button id="btn-three" class="btn btn-light d-inline-block d-flex justify-content-center align-items-center" style="width: 33px; height: 33px; border-radius: 100%;">
                                        <img class="img-edit-field" src="../img/icons/edit.svg" alt="Editar">
                                    </button>
                                </span>
                            </div>
                             <!-- Division de entrada de datos -->
                             <div class="form-group principal row pr-4 pl-4 mr-0 ml-0 border-bottom">
                                <label for="" class="col-sm-3 col-form-label text-uppercase font-weight-bold text-muted d-flex align-items-center" style="font-size: 10px; padding: 0;">Correo Electrónico</label>
                                <div class="col">
                                    <input type="email" readonly required class="form-control-plaintext form-control-sm" id="txt-emailCE" placeholder="Email" value="<?php echo $dataInscripcion[0]['EmailCE']; ?>">
                                </div>
                                <span>
                                    <button id="btn-five" class="btn btn-light d-inline-block d-flex justify-content-center align-items-center" style="width: 33px; height: 33px; border-radius: 100%;">
                                        <img class="img-edit-field" src="../img/icons/edit.svg" alt="Editar">
                                    </button>
                                </span>
                            </div>

                            <!-- Division de entrada de datos -->
                            <div class="form-group principal row pr-4 pl-4 mr-0 ml-0 border-bottom">
                                <label for="" class="col-sm-3 col-form-label text-uppercase font-weight-bold text-muted d-flex align-items-center" style="font-size: 10px; padding: 0;">Direccion</label>
                                <div class="col">
                                    <input type="text" readonly required class="form-control-plaintext form-control-sm" id="txt-direccionCE" placeholder="Dirección" value="<?php echo $dataInscripcion[0]['DireccionCE']; ?>">
                                </div>
                                <span>
                                    <button id="btn-six" class="btn btn-light d-inline-block d-flex justify-content-center align-items-center" style="width: 33px; height: 33px; border-radius: 100%;">
                                        <img class="img-edit-field" src="../img/icons/edit.svg" alt="Editar">
                                    </button>
                                </span>
                            </div>
                            
                        </div>
                        <!-- Division de informacion -->
                        <div style="margin-bottom: 50px;">
                            <h5 class="pr-4 pl-4 font-weight-bold">Información laboral</h5>
                            <!-- Division de entrada de datos -->
                            <div class="form-group principal row pr-4 pl-4 mr-0 ml-0 border-bottom">
                                <label for="" class="col-sm-3 col-form-label text-uppercase font-weight-bold text-muted d-flex align-items-center" style="font-size: 10px; padding: 0;">Lugar de trabajo</label>
                                <div class="col">
                                    <input type="text" readonly class="form-control-plaintext form-control-sm" id="txt-LT" placeholder="Lugar de trabajo" value="<?php echo $dataInscripcion[0]['Lugar_de_trabajo']; ?>">
                                </div>
                                <span>
                                    <button id="btn-seven" class="btn btn-light d-inline-block d-flex justify-content-center align-items-center" style="width: 33px; height: 33px; border-radius: 100%;">
                                        <img class="img-edit-field" src="../img/icons/edit.svg" alt="Editar">
                                    </button>
                                </span>
                            </div>
                             <!-- Division de entrada de datos -->
                             <div class="form-group principal row pr-4 pl-4 mr-0 ml-0 border-bottom">
                                <label for="" class="col-sm-3 col-form-label text-uppercase font-weight-bold text-muted d-flex align-items-center" style="font-size: 10px; padding: 0;">Teléfono / Celular</label>
                                <div class="col">
                                    <input type="tel" readonly  class="form-control-plaintext form-control-sm" id="txt-telefonoLT" placeholder="Teléfono o Celular" value="<?php echo  $dataInscripcion[0]['TelefonoLT']; ?>">
                                </div>
                                <span>
                                    <button id="btn-eight" class="btn btn-light d-inline-block d-flex justify-content-center align-items-center" style="width: 33px; height: 33px; border-radius: 100%;">
                                        <img class="img-edit-field" src="../img/icons/edit.svg" alt="Editar">
                                    </button>
                                </span>
                            </div>
                            <!-- Division de entrada de datos -->
                            <div class="form-group principal row pr-4 pl-4 mr-0 ml-0 border-bottom">
                                <label for="" class="col-sm-3 col-form-label text-uppercase font-weight-bold text-muted d-flex align-items-center" style="font-size: 10px; padding: 0;">Correo Electrónico</label>
                                <div class="col">
                                    <input type="email" readonly  class="form-control-plaintext form-control-sm" id="txt-emailLT" placeholder="Email" value="<?php echo  $dataInscripcion[0]['EmailLT'];?>">
                                </div>
                                <span>
                                    <button id="btn-nine" class="btn btn-light d-inline-block d-flex justify-content-center align-items-center" style="width: 33px; height: 33px; border-radius: 100%;">
                                        <img class="img-edit-field" src="../img/icons/edit.svg" alt="Editar">
                                    </button>
                                </span>
                            </div>
                            <!-- Division de entrada de datos -->
                            <div class="form-group principal row pr-4 pl-4 mr-0 ml-0 border-bottom">
                                <label for="" class="col-sm-3 col-form-label text-uppercase font-weight-bold text-muted d-flex align-items-center" style="font-size: 10px; padding: 0;">Dirección</label>
                                <div class="col">
                                    <input type="text" readonly class="form-control-plaintext form-control-sm" id="txt-direccionLT" placeholder="Dirección" value="<?php echo $dataInscripcion[0]['DireccionLT']; ?>">
                                </div>
                                <span>
                                    <button id="btn-ten" class="btn btn-light d-inline-block d-flex justify-content-center align-items-center" style="width: 33px; height: 33px; border-radius: 100%;">
                                        <img class="img-edit-field" src="../img/icons/edit.svg" alt="Editar">
                                    </button>
                                </span>
                            </div>
                        </div>
                        <!-- Division de informacion -->
                        <div style="margin-bottom: 50px;">
                            <h5 class="pr-4 pl-4 font-weight-bold">Observaciones</h5>
                            <!-- Division de entrada de datos -->
                            <div class="form-group principal row pr-4 pl-4 mr-0 ml-0 border-bottom">
                                <label for="" class="col-sm-3 col-form-label text-uppercase font-weight-bold text-muted d-flex align-items-center" style="font-size: 10px; padding: 0;">Observaciones</label>
                                <div class="col">
                                    <input type="text" readonly class="form-control-plaintext form-control-sm" id="txt-observaciones" placeholder="Observaciones" value="<?php echo $dataInscripcion[0]['Observaciones']; ?>">
                                </div>
                                <span>
                                    <button id="btn-eleven" class="btn btn-light d-inline-block d-flex justify-content-center align-items-center" style="width: 33px; height: 33px; border-radius: 100%;">
                                        <img class="img-edit-field" src="../img/icons/edit.svg" alt="Editar">
                                    </button>
                                </span>
                            </div>
                        </div>

                                                <!-- Botones del formulario -->
                        <div class="modal-footer border-0 d-flex justify-content-center">
                            <a href="/admin/?modulo=estudiantes" type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancelar</a>
                            <button id="btn-submit" type="submit" class="btn btn-primary btn-sm" value="Actualizar" disabled>Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="../js/mas-info-estudiante.js"></script>
</body>
</html>