<?php

include_once '../../Plataforma/Utilidades/conexion.php';
include_once '../../Plataforma/Utilidades/Utilidades.php';
include_once '../../Plataforma/Controladores/InscripcionController.php';
include_once '../../Plataforma/Modelos/InscripcionModel.php';
include_once '../../Plataforma/Modelos/EstudianteModel.php';
include_once '../../Plataforma/Controladores/EstudianteController.php';
include_once '../../Plataforma/Utilidades/session.php';
include_once '../../Plataforma/Utilidades/conexion.php';
include_once '../../Plataforma/Utilidades/conexion.php';
$utilidades = new Utilidades();
$session = new Session();
$modeloInscripcion = new InscripcionModel();
$controladorInscripcion = new InscripcionController();
$controladorEstudiante = new EstudianteController();
$resultMessage = $_REQUEST['result'] ?? '';

if (isset($_SESSION['idUser'])) {
  session_regenerate_id(true);
  header("Location: ../");
} else {
  if ($resultMessage != "") {
    $ControladorEstudiante = new EstudianteController();
    $controladorInscripcion = new InscripcionController();
    $id = $ControladorEstudiante->getIdByCodigoContrasenia($resultMessage);
    if (!(is_numeric($id) && $id > 0)) {
      echo "  <script>
                        alert('Lo sentimos su cuenta aun no ha sido verificada');
                    </script>";
    } else {
      echo '<!DOCTYPE html>
            <html lang="en">    
            <head>
              <meta charset="UTF-8">
              <meta name="viewport" content="width=device-width, initial-scale=1.0">
              <script src="js/jquery-3.5.1.min.js"></script>
              <script src="js/popper.min.js"></script>
              <script src="js/bootstrap.min.js"></script>
              <script src="js/aos.js"></script>
              <script src="js/kit-fontawesome.js"></script>
              <script src="Plataforma/js/estudiante.js"></script>
              <script src="Plataforma/js/VerExamen.js"></script>
              <link href="Plataforma/css/bootstrap.min.css" rel="stylesheet"/>
              <link href="Plataforma/css/bootstrap-datepicker3.min.css" rel="stylesheet"/>
              <link href="Plataforma/css/bootstrap-datepicker3.standalone.min.css" rel="stylesheet"/>
              <!-- Nuestro css-->
              <link rel="stylesheet" href="../../Plataforma/css/Inscripcion.css">
              <title>Inscripcion</title>
            </head>    
            <body class="h-100">
              <div class="container  h-100  mt-5" id="fondo">
                <div class="row justify-content-center h-100 my-5 ">
                  <div class=" col-md-6   justify-content-center my-5 align-items-center formulario" text-color>
                    <form method="POST" autocomplete="off" enctype="multipart/form-data">
                      <div class="form-group  text-center" id="registro">
                        <h3>INSCRIPCIÓN</h3>
                      </div>
                      <div class="row ">
                        <div class="col-md-12 mt-2">
                          <div class="detalle mt-2 font-weight-bold" style="color:#001D67">
                            Detalles del Curso
                          </div>
                          <div class="heading text-color my-2">
                            Principiante
                          </div>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inscripcion-principiante" id="inlineRadio1" value="Si" checked>
                            <label class="form-check-label text-color mr-2" for="inlineRadio1">Si</label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inscripcion-principiante" id="inlineRadio2" value="No">
                            <label class="form-check-label text-color mr-2" for="inlineRadio2">No</label>
                          </div>
                          <div class="heading text-color my-2">
                            ¿Posee licencia de conducir?
                          </div>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inscripcion-licencia-de-conducir" id="inlineRadio3" value="Si" checked>
                            <label class="form-check-label text-color mr-2" for="inlineRadio3">Si</label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inscripcion-licencia-de-conducir" id="inlineRadio4" value="No">
                            <label class="form-check-label text-color mr-2" for="inlineRadio4">No</label>
                          </div>
                          <div class="heading text-color my-2">
                            Categoría
                            <div class="form-group">
                              <input type="text" name="inscripcion-categoria" class="form-control" id="guardar-categoria">
                            </div>
                          </div>
                          <div>
                          <div class="form-group row pr-4 pl-4 mr-0 ml-0 border-bottom">
                                            <label for="" class="col-sm-3 col-form-label text-uppercase font-weight-bold text-muted d-flex align-items-center" style="font-size: 10px; padding: 0;">Turno</label>
                                            <div class="col">
                                                <select class="form-control-plaintext form-control-sm" readonly>
                                                    <option>Matutino</option>
                                                    <option>Vespertino</option>
                                                </select>
                                            </div>
                                        </div>
                            <div class="form-group select-Horario" id="cont-horario">    
                              <select class="custom-select select-Horario" name="select-horario" id="select-horario">
                                <option value="Lunes 9:00 am a 12:00 pm">Lunes 9:00 am a 12:00 pm </option>
                                <option value="Lunes 1:30 pm a 4:00 pm">Lunes 1:30 pm a 4:00 pm</option>
                                <option value="Martes de 9:00 am a 12:pm">Martes de 9:00 am a 12:pm</option>
                                <option value="Martes 1:30 pm a 4:00 pm">Martes 1:30 pm a 4:00 pm</option>
                                <option value="Miercoles de 9:00 am a 12:pm">Miercoles de 9:00 am a 12:pm</option>
                                <option value="Miercoles 1:30 pm a 4:00 pm">Miercoles 1:30 pm a 4:00 pm</option>
                                <option value="Jueves de 9:00 am a 12:pm">Jueves de 9:00 am a 12:pm</option>
                                <option value="Jueves de 1:30 pm a 4:pm">Jueves de 1:30 pm a 4:pm</option>
                                <option value="Viernes de 9:00 am a 12:pm">Viernes de 9:00 am a 12:pm</option>
                                <option value="Viernes de 9:00 am a 12:pm">Viernes de 9:00 am a 12:pm</option>
                                <option value="Sabado de 9:00 am a 12:pm">Sabado de 9:00 am a 12:pm</option>
                              </select>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row ">
                        <div class="col-md-12 mt-2">
                          <div class="detalle mt-2 font-weight-bold" style="color:#001D67 ">
                            Contacto de emergencia
                          </div>
                          <div class="row ">
                            <div class="col-md-6 mt-2">
                              <div class="form-group">
                                <label class="title text-color">Nombre</label>
                                <input type="text" class="form-control  prueba text-color" id="inscripcion-nombreCE" name="inscripcion-nombreCE">
                              </div>
                            </div>
                            <div class="col-md-6 mt-2">
                              <div class="form-group ">
                                <label class="title text-color">Apellido</label>
                                <input type="text" class="form-control text-color" id="inscripcion-apellidoCE" name="inscripcion-apellidoCE">
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6 ">
                              <div class="form-group  ">
                                <label class="title text-color">Télefono</label>
                                <input type="text" class="form-control text-color" name="inscripcion-telefonoCE" id="inscripcion-telefonoCE">
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group ">
                                <label class="title text-color">Email</label>
                                <input type="email" class="form-control text-color" name="inscripcion-emailCE" id="inscripcion-emailCE">
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-12">
                              <div class="form-group  ">
                                <label class="title text-color">Dirección</label>
                                <input type="text" class="form-control text-color" name="inscripcion-direccionCE" id="inscripcion-direccionCE">
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row ">
                        <div class="col-md-12 mt-2">
                          <div class="detalle mt-2 font-weight-bold" style="color:#001D67 ">
                            Información laboral
                          </div>
                          <div class="row ">
                            <div class="col-md-12 mt-2">
                              <div class="form-group">
                                <label class="title text-color">Lugar de Trabajo</label>
                                <input type="text" class="form-control  prueba text-color" id="inscripcion-nombreLT" name="inscripcion-nombreLT">
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6 ">
                              <div class="form-group  ">
                                <label class="title text-color">Télefono</label>
                                <input type="text" class="form-control text-color" id="incripcion-telefonoLT" name="incripcion-telefonoLT">
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group ">
                                <label class="title text-color">Email</label>
                                <input type="email" class="form-control text-color" id="incripcion-emailLT" name="incripcion-EmailLT">
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-12">
                              <div class="form-group  ">
                                <label class="title text-color">Dirección</label>
                                <input type="text" class="form-control text-color" id="incripcion-direccionLT" name="incripcion-direccionLT">
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>        
                      <div class="row ">
                        <div class="col-md-12 mt-2">
                          <div class="detalle mt-2 font-weight-bold" style="color:#001D67 ">
                            Observaciones
                          </div>
                          <div class="row">
                            <div class="col-md-12 mt-2">
                              <div class="form-group  ">
                                <input type="text" class="form-control text-color" id="inscripcion-observaciones" name="inscripcion-observaciones">
                                <input type="hidden" name="IdEstudiante">
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="form-group text-center  mt-4 ">
                        <input type="submit" class="btn ingresar" name="btn-enviar-inscripcion" id="btn-enviar-inscripcion" value="ENVIAR">
                      </div>
                  </div>
                  </form>
                </div>
              </div>
            </body>
            </html>';
   }
  } else if (isset($_POST['btn-enviar-inscripcion']) && isset($_POST['CODE'])) {
    $InscripcionPrincipiante = $_POST['inscripcion-principiante'];  //15 datos
    $InscripcionLC = $_POST['inscripcion-licencia-de-conducir'];
    $InscripcionCategoria = $_POST['inscripcion-categoria'];
    $selectHorario = $_POST['select-horario'];
    $nombreCE = $_POST['inscripcion-nombreCE'];
    $ApellidoCE = $_POST['inscripcion-apellidoCE'];
    $TelefonoCE = $_POST['inscripcion-telefonoCE'];
    $EmailCE = $_POST['inscripcion-emailCE'];
    $DireccionCE = $_POST['inscripcion-direccionCE'];
    $InscripcionLT = $_POST['inscripcion-nombreLT'];
    $InscripcionTelefonoLT = $_POST['incripcion-telefonoLT'];
    $IncripcionEmailLT = $_POST['incripcion-EmailLT'];
    $InscripcionDireccionLT = $_POST['incripcion-direccionLT'];
    $InscripcionObservaciones = $_POST['inscripcion-observaciones'];
    $idEstudiante = $_POST['IdEstudiante'];
    $componentes_inscripcion = [
      $InscripcionPrincipiante, $InscripcionLC, $InscripcionCategoria, $selectHorario, $nombreCE, $ApellidoCE, $TelefonoCE, $EmailCE, $DireccionCE,
      $InscripcionLT, $InscripcionTelefonoLT, $IncripcionEmailLT, $InscripcionDireccionLT, $InscripcionObservaciones, $idEstudiante
    ];
    $id = $_GET['idEstudiante'];
    $userRegistrado = $controladorEstudiante->UsuarioRegistrado($txtEmail); //usuarioRegistrado;
    $usuarioConfirmado = $controladorEstudiante->VerificarUsuarioActivoById($id);
    if (!$utilidades->camposVacios($componentes_inscripcion)) {
      if (!$utilidades->campoInyecciones($componentes_inscripcion)) {
        $idEstudiante = $session->getCurrentId();
        $result = "";
        // $result = $controladorInscripcion->insertar($InscripcionPrincipiante, $InscripcionLC, $InscripcionCategoria, $selectHorario, $nombreCE, $ApellidoCE, $TelefonoCE, $EmailCE, $DireccionCE, $InscripcionLT, $InscripcionTelefonoLT, $IncripcionEmailLT, $InscripcionDireccionLT, $InscripcionObservaciones, $idEstudiante);
        if ($result) {
          echo "exito";
        } else {
          echo "fallo al final";
        }
      } else {
        echo "fallo";
      }
    } else
      echo "fallo fatal";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="js/jquery-3.5.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/kit-fontawesome.js"></script>
  <script src="Plataforma/js/estudiante.js"></script>
  <script src="Plataforma/js/VerExamen.js"></script>
  <link href="Plataforma/css/bootstrap.min.css" rel="stylesheet" />
  <link href="Plataforma/css/bootstrap-datepicker3.min.css" rel="stylesheet" />
  <link href="Plataforma/css/bootstrap-datepicker3.standalone.min.css" rel="stylesheet" />
  <!-- Nuestro css-->
  <link rel="stylesheet" href="../../Plataforma/css/Inscripcion.css">
  <title>Inscripcion</title>
</head>
<body class="h-100">
  <div class="container  h-100  mt-5" id="fondo">
    <div class="row justify-content-center h-100 my-5 ">
      <div class=" col-md-6   justify-content-center my-5 align-items-center formulario" text-color>
        <form method="POST" autocomplete="off" enctype="multipart/form-data">
          <div class="form-group  text-center" id="registro">
            <h3>INSCRIPCIÓN</h3>
          </div>
          <div class="row ">
            <div class="col-md-12 mt-2">
              <div class="detalle mt-2 font-weight-bold" style="color:#001D67">
                Detalles del Curso
              </div>
              <div class="heading text-color my-2">
                Principiante
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="inscripcion-principiante" id="inlineRadio1" value="Si" checked>
                <label class="form-check-label text-color mr-2" for="inlineRadio1">Si</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="inscripcion-principiante" id="inlineRadio2" value="No">
                <label class="form-check-label text-color mr-2" for="inlineRadio2">No</label>
              </div>
              <div class="heading text-color my-2">
                ¿Posee licencia de conducir?
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="inscripcion-licencia-de-conducir" id="inlineRadio3" value="Si" checked>
                <label class="form-check-label text-color mr-2" for="inlineRadio3">Si</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="inscripcion-licencia-de-conducir" id="inlineRadio4" value="No">
                <label class="form-check-label text-color mr-2" for="inlineRadio4">No</label>
              </div>
              <div class="heading text-color my-2">
                Categoría
                <div class="form-group">
                  <input type="text" name="inscripcion-categoria" class="form-control" id="guardar-categoria">
                </div>
              </div>
              <div>
                <div class="form-group row pr-4 pl-4 mr-0 ml-0 border-bottom">
                  <label for="" class="col-sm-3 col-form-label text-uppercase font-weight-bold text-muted d-flex align-items-center" style="font-size: 10px; padding: 0;">Turno</label>
                  <div class="col">
                    <select class="form-control-plaintext form-control-sm" readonly>
                      <option>Matutino</option>
                      <option>Vespertino</option>
                    </select>
                  </div>
                </div>
                <div class="form-group select-Horario" id="cont-horario">
                  <select class="custom-select select-Horario" name="select-horario" id="select-horario">
                    <option value="Lunes 9:00 am a 12:00 pm">Lunes 9:00 am a 12:00 pm </option>
                    <option value="Lunes 1:30 pm a 4:00 pm">Lunes 1:30 pm a 4:00 pm</option>
                    <option value="Martes de 9:00 am a 12:pm">Martes de 9:00 am a 12:pm</option>
                    <option value="Martes 1:30 pm a 4:00 pm">Martes 1:30 pm a 4:00 pm</option>
                    <option value="Miercoles de 9:00 am a 12:pm">Miercoles de 9:00 am a 12:pm</option>
                    <option value="Miercoles 1:30 pm a 4:00 pm">Miercoles 1:30 pm a 4:00 pm</option>
                    <option value="Jueves de 9:00 am a 12:pm">Jueves de 9:00 am a 12:pm</option>
                    <option value="Jueves de 1:30 pm a 4:pm">Jueves de 1:30 pm a 4:pm</option>
                    <option value="Viernes de 9:00 am a 12:pm">Viernes de 9:00 am a 12:pm</option>
                    <option value="Viernes de 9:00 am a 12:pm">Viernes de 9:00 am a 12:pm</option>
                    <option value="Sabado de 9:00 am a 12:pm">Sabado de 9:00 am a 12:pm</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="row ">
            <div class="col-md-12 mt-2">
              <div class="detalle mt-2 font-weight-bold" style="color:#001D67 ">
                Contacto de emergencia
              </div>
              <div class="row ">
                <div class="col-md-6 mt-2">
                  <div class="form-group">
                    <label class="title text-color">Nombre</label>
                    <input type="text" class="form-control  prueba text-color" id="inscripcion-nombreCE" name="inscripcion-nombreCE">
                  </div>
                </div>
                <div class="col-md-6 mt-2">
                  <div class="form-group ">
                    <label class="title text-color">Apellido</label>
                    <input type="text" class="form-control text-color" id="inscripcion-apellidoCE" name="inscripcion-apellidoCE">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 ">
                  <div class="form-group  ">
                    <label class="title text-color">Télefono</label>
                    <input type="text" class="form-control text-color" name="inscripcion-telefonoCE" id="inscripcion-telefonoCE">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="title text-color">Email</label>
                    <input type="email" class="form-control text-color" name="inscripcion-emailCE" id="inscripcion-emailCE">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group  ">
                    <label class="title text-color">Dirección</label>
                    <input type="text" class="form-control text-color" name="inscripcion-direccionCE" id="inscripcion-direccionCE">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row ">
            <div class="col-md-12 mt-2">
              <div class="detalle mt-2 font-weight-bold" style="color:#001D67 ">
                Información laboral
              </div>
              <div class="row ">
                <div class="col-md-12 mt-2">
                  <div class="form-group">
                    <label class="title text-color">Lugar de Trabajo</label>
                    <input type="text" class="form-control  prueba text-color" id="inscripcion-nombreLT" name="inscripcion-nombreLT">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 ">
                  <div class="form-group  ">
                    <label class="title text-color">Télefono</label>
                    <input type="text" class="form-control text-color" id="incripcion-telefonoLT" name="incripcion-telefonoLT">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group ">
                    <label class="title text-color">Email</label>
                    <input type="email" class="form-control text-color" id="incripcion-emailLT" name="incripcion-EmailLT">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group  ">
                    <label class="title text-color">Dirección</label>
                    <input type="text" class="form-control text-color" id="incripcion-direccionLT" name="incripcion-direccionLT">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row ">
            <div class="col-md-12 mt-2">
              <div class="detalle mt-2 font-weight-bold" style="color:#001D67 ">
                Observaciones
              </div>
              <div class="row">
                <div class="col-md-12 mt-2">
                  <div class="form-group  ">
                    <input type="text" class="form-control text-color" id="inscripcion-observaciones" name='inscripcion-observaciones'>
                    <input type="hidden" name="IdEstudiante">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group text-center  mt-4 ">
            <input type="submit" class="btn ingresar" name="btn-enviar-inscripcion" id="btn-enviar-inscripcion" value="ENVIAR">
          </div>
      </div>
      </form>
    </div>
  </div>
</body>
</html>