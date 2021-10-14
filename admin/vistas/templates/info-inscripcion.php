<?php
try {
    // Obtengo el id del estudiante desde la peticion get
    $id = $_REQUEST['additional'] ?? '';

    // Inclusion de clases modelos, controladoras y de conexion
    include_once('../Utilidades/conexion.php');
    include_once('../Utilidades/confiDev.php');
    include_once('../Controladores/StudentController.php');
    include_once('../Controladores/InscriptionController.php');
    include_once('../Modelos/StudentModel.php');
    include_once('../Modelos/InscriptionModel.php');
    include_once('../Utilidades/Utilidades.php');

    // Instancia de la clase contralodora StudentController
    $inscripcionController = new InscriptionController();
    $studentController = new StudentController();

    // Obtencion de los datos de estudiante
    $Estudiante = $studentController->getInfoStudentById($id);

    /** */
    $estado = $Estudiante[0]['Estado'] ?? "";
    $nombre = $Estudiante[0]['Nombre'];
    $apellido = $Estudiante[0]['Apellido'];
    $email = $Estudiante[0]['Email'];
    $telefono = $Estudiante[0]['Telefono'];
    $cedula = $Estudiante[0]['Cedula'];
    $estado = $Estudiante[0]['Estado'] ?? "";

    //echo $estado;

    //Datos del estudiante
    $dataInscripcion =  $studentController->getMoreInfoStudentById($id) ?? '';

    //Datos del turno
    $data =  $studentController->getTurno();

    $modalities = $studentController->getWeekModalities($data[0]['Tipo'])  ?? '';
    $utilidades = new Utilidades();

    if (isset($_POST["btn-submit"])) {
        $Principiante = $_POST['inscripcion-principiante'] ?? '';  //principiante 1
        $LC = $_POST['inscripcion-licencia-de-conducir'] ?? ''; //Licencia de conducir 2
        $Categoria = $_POST['txt-categoria']; //Categoria 3
        $NombreCE = $_POST['txt-nombreCE']; // nombreCE 4
        $ApellidoCE = $_POST['txt-apellidoCE']; //ApellidoCE 5
        $TelefonoCE = $_POST['txt-telefonoCE']; //TelefonoCE 6
        $EmailCE = $_POST['txt-emailCE']; //EmailCE 7
        $DireccionCE = $_POST['txt-direccionCE']; //DireccionCE 8
        $LT = $_POST['txt-LT'] ?? ''; //LT 9
        $TelefonoLT = $_POST['txt-telefonoLT'] ?? ''; //telefonoLT 10
        $EmailLT = $_POST['txt-emailLT'] ?? ''; //EmailLT 11
        $DireccionLT = $_POST['txt-direccionLT'] ?? ''; //DirecccionLT 12
        $Observaciones = $_POST['txt-observaciones'] ?? ''; //ObservacionesLT 13
        $Codigo = $_POST['select-modalidades']; // Modalidades 14
        $componentes_inscripcion = [$Principiante, $LC, $Categoria, $Codigo, $NombreCE, $ApellidoCE, $TelefonoCE, $EmailCE, $DireccionCE, $id];

        if (!$utilidades->camposVacios($componentes_inscripcion)) {
            if (!$utilidades->campoInyecciones($componentes_inscripcion)) {
                $IdInscripcion = $inscripcionController->getIdInscripcionByIdEstudiante($id);
                if ((is_numeric($IdInscripcion)) && $IdInscripcion != '') {
                    $IdTurno = $inscripcionController->getIdTurnoByCodigo($Codigo); //Obtengo el id del turno
                    $Disponibilidad = $inscripcionController->getDisponibilidadByIdTurno($IdTurno); //Obtengo la disponibilidad actual de ese turno
                    echo  $Disponibilidad . " ";
                    // echo $IDTurno;
                    if (is_numeric($Disponibilidad) && $Disponibilidad >= 1 && $Disponibilidad <= 2) {
                        $result = $inscripcionController->actualizar($Principiante, $LC, $Categoria, $NombreCE, $ApellidoCE, $TelefonoCE, $EmailCE, $DireccionCE, $LT, $TelefonoLT, $EmailLT, $DireccionLT, $Observaciones, $IdTurno, $id);
                        if ($result) {
                            $updateDisponibilidad = $inscripcionController->updateDisponibilidad(($Disponibilidad - 1), $IdTurno);
                            echo '<script> alert("se ha inscrito correctamente");</script>';
                            if ($updateDisponibilidad) { //Actualizo la disponibilidad de ese horario
                               // echo '<script> alert("se ha inscrito correctamente y la disponibilidad se ha actualizado  la disponibilidad actual es=' . $updateDisponibilidad . '");</script>';
                                //estudianteInscrito($nombre, $apellido, $email, $telefono, $cedula);
                                $inscripcionController->updateEstado($id);
                               // echo '<script> alert("Estudiante Inscrito");</script>';
                                header("Location: /admin/vistas/info-estudiante.php?info=".$id);
                            } else {
                                echo '<script> alert("Ocurrio un error, recargue la pagina e intentelo de nuevo");</script>';;
                            }
                        } else {
                            echo '<script> alert("Ocurrio un error, recargue la pagina e intentelo de nuevo");</script>';
                        }
                    } else {
                        echo '<script> alert("Ya no hay cupos disponibles para este horario, intente con otro");</script>';
                    }
                } else {
                    echo '<script> alert("Su cuenta aun no ha sido verificada por el Docente");</script>';
                }
            } else {
                echo '<script> alert("no se aceptan caracteres especiales");</script>';
            }
        } else {
            echo '<script> alert("no puede dejar los campos vacios");</script>';
        }
    } else if ($estado == 1) {
        header("Location: ../../../index.php?result=inscripcionExitosa");
    }
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

                        <!-- Division de informacion -->
                        <div style="margin-bottom: 50px;">
                            <h5 class="pr-4 pl-4 font-weight-bold">Detalles del curso(*) </h5>

                            <!-- Division de entrada de datos -->
                            <div class="form-group principal row pr-4 pl-4 mr-0 ml-0 border-bottom">
                                <label for="" class="col-sm-3 col-form-label text-uppercase font-weight-bold text-muted d-flex align-items-center" style="font-size: 10px; padding: 0;">Principiante</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input ml-5" type="radio" name="inscripcion-principiante" id="inlineRadio1" value="Si">
                                    <label class="form-check-label text-color mr-2" for="inlineRadio1">Si</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input ml-4" type="radio" name="inscripcion-principiante" id="inlineRadio2" value="No">
                                    <label class="form-check-label text-color mr-2" for="inlineRadio2">No</label>
                                </div>
                            </div>
                            <!-- Division de entrada de datos -->
                            <div class="form-group principal row pr-4 pl-4 mr-0 ml-0 border-bottom">
                                <label for="" class="col-sm-3 col-form-label text-uppercase font-weight-bold text-muted d-flex align-items-center" style="font-size: 10px; padding: 0;">¿Posee licencia de conducir?</label>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input ml-5" type="radio" name="inscripcion-licencia-de-conducir" id="inlineRadio3" value="Si">
                                    <label class="form-check-label text-color mr-2" for="inlineRadio3">Si</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input ml-4" type="radio" name="inscripcion-licencia-de-conducir" id="inlineRadio4" value="No">
                                    <label class="form-check-label text-color mr-2" for="inlineRadio4">No</label>
                                </div>

                            </div>
                            <!-- Division de entrada de datos -->
                            <div class="form-group principal row pr-4 pl-4 mr-0 ml-0 border-bottom">
                                <label for="" class="col-sm-3 col-form-label text-uppercase font-weight-bold text-muted d-flex align-items-center" style="font-size: 10px; padding: 0;">Categoria</label>
                                <div class="col">
                                    <input type="text" required class="form-control-plaintext form-control-sm" placeholder="Categoria" id="txt-categoria" name="txt-categoria">
                                </div>
                            </div>
                            <!-- Division de entrada de datos -->
                            <div class="form-group principal row pr-4 pl-4 mr-0 ml-0 border-bottom">
                                <label for="" class="col-sm-3 col-form-label text-uppercase font-weight-bold text-muted d-flex align-items-center" style="font-size: 10px; padding: 0;">Turno</label>
                                <!--Opciones de los tipos de turno -->
                                <div class="col">
                                    <select id="select-turno" name="select-turno" class="text-color form-control-plaintext form-control-sm" readonly>
                                        <option value="Matutino" <?php echo $data[0]['Tipo'] == 'Matutino' ? 'selected' : ''; ?>>Matutino</option>
                                        <option value="Vespertino" <?php echo $data[0]['Tipo'] == 'Vespertino' ? 'selected' : ''; ?>>Vespertino</option>
                                    </select>
                                </div>
                                <!--Opciones de los tipos de horario-->
                                <div class="col">
                                    <select id="select-modalidades" name="select-modalidades" class="text-color form-control-plaintext form-control-sm" readonly>
                                        <?php foreach ($modalities as $item) : ?>
                                            <option value="<?php echo $item['CodigoTurno']; ?>" <?php echo $data[0]['Descripcion'] == $item['Descripcion'] ? 'selected' : ''; ?>> <?php echo $item['Descripcion']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Division de informacion -->
                        <div style="margin-bottom: 50px;">
                            <h5 class="pr-4 pl-4 font-weight-bold">Contacto de emergencia(*)</h5>

                            <!-- Division de entrada de datos -->
                            <div class="form-group principal row pr-4 pl-4 mr-0 ml-0 border-bottom">
                                <label for="" class="col-sm-3 col-form-label text-uppercase font-weight-bold text-muted d-flex align-items-center" style="font-size: 10px; padding: 0;">Nombre</label>
                                <div class="col">
                                    <input type="text" required class="form-control-plaintext form-control-sm" id="txt-nombreCE" name="txt-nombreCE" placeholder="Nombre">
                                </div>
                            </div>
                            <!-- Division de entrada de datos -->
                            <div class="form-group principal row pr-4 pl-4 mr-0 ml-0 border-bottom">
                                <label for="" class="col-sm-3 col-form-label text-uppercase font-weight-bold text-muted d-flex align-items-center" style="font-size: 10px; padding: 0;">Apellido</label>
                                <div class="col">
                                    <input type="text" required class="form-control-plaintext form-control-sm" id="txt-apellidoCE" name="txt-apellidoCE" placeholder="Apellido">
                                </div>
                            </div>
                            <!-- Division de entrada de datos -->
                            <div class="form-group principal row pr-4 pl-4 mr-0 ml-0 border-bottom">
                                <label for="" class="col-sm-3 col-form-label text-uppercase font-weight-bold text-muted d-flex align-items-center" style="font-size: 10px; padding: 0;">Telefono</label>
                                <div class="col">
                                    <input type="text" required class="form-control-plaintext form-control-sm" placeholder="telefono" id="txt-telefonoCE" name="txt-telefonoCE">
                                </div>
                            </div>
                            <!-- Division de entrada de datos -->
                            <div class="form-group principal row pr-4 pl-4 mr-0 ml-0 border-bottom">
                                <label for="" class="col-sm-3 col-form-label text-uppercase font-weight-bold text-muted d-flex align-items-center" style="font-size: 10px; padding: 0;">Correo Electrónico</label>
                                <div class="col">
                                    <input type="email" required class="form-control-plaintext form-control-sm" id="txt-emailCE" name="txt-emailCE" placeholder="Email">
                                </div>
                            </div>

                            <!-- Division de entrada de datos -->
                            <div class="form-group principal row pr-4 pl-4 mr-0 ml-0 border-bottom">
                                <label for="" class="col-sm-3 col-form-label text-uppercase font-weight-bold text-muted d-flex align-items-center" style="font-size: 10px; padding: 0;">Direccion</label>
                                <div class="col">
                                    <input type="text" required class="form-control-plaintext form-control-sm" id="txt-direccionCE" name="txt-direccionCE" placeholder="Dirección">
                                </div>
                            </div>

                        </div>
                        <!-- Division de informacion -->
                        <div style="margin-bottom: 50px;">
                            <h5 class="pr-4 pl-4 font-weight-bold">Información laboral</h5>
                            <!-- Division de entrada de datos -->
                            <div class="form-group principal row pr-4 pl-4 mr-0 ml-0 border-bottom">
                                <label for="" class="col-sm-3 col-form-label text-uppercase font-weight-bold text-muted d-flex align-items-center" style="font-size: 10px; padding: 0;">Lugar de trabajo</label>
                                <div class="col">
                                    <input type="text" class="form-control-plaintext form-control-sm" id="txt-LT" name="txt-LT" placeholder="Lugar de trabajo">
                                </div>
                            </div>
                            <!-- Division de entrada de datos -->
                            <div class="form-group principal row pr-4 pl-4 mr-0 ml-0 border-bottom">
                                <label for="" class="col-sm-3 col-form-label text-uppercase font-weight-bold text-muted d-flex align-items-center" style="font-size: 10px; padding: 0;">Teléfono / Celular</label>
                                <div class="col">
                                    <input type="tel" class="form-control-plaintext form-control-sm" id="txt-telefonoLT" name="txt-telefonoLT" placeholder="Teléfono o Celular">
                                </div>
                            </div>
                            <!-- Division de entrada de datos -->
                            <div class="form-group principal row pr-4 pl-4 mr-0 ml-0 border-bottom">
                                <label for="" class="col-sm-3 col-form-label text-uppercase font-weight-bold text-muted d-flex align-items-center" style="font-size: 10px; padding: 0;">Correo Electrónico</label>
                                <div class="col">
                                    <input type="email" class="form-control-plaintext form-control-sm" id="txt-emailLT" name="txt-emailLT" placeholder="Email">
                                </div>
                            </div>
                            <!-- Division de entrada de datos -->
                            <div class="form-group principal row pr-4 pl-4 mr-0 ml-0 border-bottom">
                                <label for="" class="col-sm-3 col-form-label text-uppercase font-weight-bold text-muted d-flex align-items-center" style="font-size: 10px; padding: 0;">Dirección</label>
                                <div class="col">
                                    <input type="text" class="form-control-plaintext form-control-sm" id="txt-direccionLT" name="txt-direccionLT" placeholder="Dirección">
                                </div>
                            </div>
                        </div>
                        <!-- Division de informacion -->
                        <div style="margin-bottom: 50px;">
                            <h5 class="pr-4 pl-4 font-weight-bold">Observaciones</h5>
                            <!-- Division de entrada de datos -->
                            <div class="form-group principal row pr-4 pl-4 mr-0 ml-0 border-bottom">
                                <label for="" class="col-sm-3 col-form-label text-uppercase font-weight-bold text-muted d-flex align-items-center" style="font-size: 10px; padding: 0;">Observaciones</label>
                                <div class="col">
                                    <input type="text" class="form-control-plaintext form-control-sm" id="txt-observaciones" placeholder="Observaciones">
                                </div>
                            </div>
                        </div>

                        <!-- Botones del formulario -->
                        <div class="modal-footer border-0 d-flex justify-content-center">
                            <a href="/admin/?modulo=estudiantes" type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancelar</a>
                            <button id="btn-submit" name="btn-submit" type="submit" class="btn btn-primary btn-sm" value="Actualizar">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="../js/info-inscripcion.js"></script>
</body>

</html>