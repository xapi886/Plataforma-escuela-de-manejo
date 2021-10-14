<?php
try {
  // Obtengo el id del estudiante desde la peticion get
  
  $resultMessage = $_REQUEST['result'] ?? '';
  //echo $resultMessage;
  // Inclusion de clases modelos, controladoras y de conexion
  include_once('../Utilidades/conexion.php');
  include_once('../Utilidades/confiDev.php');
  include_once('../Utilidades/email.php');
  include_once('../Controladores/EstudianteController.php');
  include_once('../Modelos/EstudianteModel.php');
  include_once('../Modelos/InscripcionModel.php');
  include_once('../Controladores/InscripcionController.php');
  include_once('../Utilidades/Utilidades.php');
  include_once('../Utilidades/session.php');


  // Instancia de la clase contralodora StudentController
  $studentController = new EstudianteController();
  $inscripcionController = new InscripcionController();

  // Obtencion de los datos de estudiante
  $Estudiante = $studentController->getIdByCodigo($resultMessage);

  $estado = $Estudiante[0]['Estado'] ?? "";
  $nombre = $Estudiante[0]['Nombre'] ?? "";
  $apellido = $Estudiante[0]['Apellido'] ?? "";
  $email = $Estudiante[0]['email'] ?? "";
  $telefono = $Estudiante[0]['Telefono'] ?? "";
  $cedula = $Estudiante[0]['Cedula'] ?? "" ;
  $idEstudiante = $Estudiante[0]['IdEstudiante'] ?? "";

$date = date('Y-m-d');

  //echo $estado;

  //echo $estado;



  //echo $estado;


  //echo $idEstudiante;
  $data =  $studentController->getTurno();

  //$data = $studentController->getInfoStudentById($idEstudiante) ?? '';

  //Obtencion de la modalidades de la semana segun turno vespertino o matutino
  $modalities = $studentController->getWeekModalities($data[0]['Tipo'])  ?? '';

  $codigoP = 'M_MARTES';
  $dispByCodigo = $inscripcionController->disponibilidadByCodigo($codigoP);
  //echo $codigoP . '  ';

  //echo $dispByCodigo;

  if (isset($_POST["btn-enviar-inscripcion"])) {
    $utilidades = new Utilidades();
    $InscripcionPrincipiante = $_POST['inscripcion-principiante'] ?? '';  //principiante 1
    $InscripcionLC = $_POST['inscripcion-licencia-de-conducir'] ?? ''; //Licencia de conducir 2
    $InscripcionCategoria = $_POST['inscripcion-categoria']; //Categoria 3
    $NombreCE = $_POST['inscripcion-nombreCE']; // nombreCE 4
    $ApellidoCE = $_POST['inscripcion-apellidoCE']; //ApellidoCE 5
    $TelefonoCE = $_POST['inscripcion-telefonoCE']; //TelefonoCE 6
    $EmailCE = $_POST['inscripcion-emailCE']; //EmailCE 7
    $DireccionCE = $_POST['inscripcion-direccionCE']; //DireccionCE 8
    $InscripcionLT = $_POST['inscripcion-nombreLT'] ?? ''; //LT 9
    $InscripcionTelefonoLT = $_POST['incripcion-telefonoLT'] ?? ''; //telefonoLT 10
    $IncripcionEmailLT = $_POST['incripcion-EmailLT'] ?? ''; //EmailLT 11
    $InscripcionDireccionLT = $_POST['incripcion-direccionLT'] ?? ''; //DirecccionLT 12
    $InscripcionObservaciones = $_POST['inscripcion-observaciones'] ?? ''; //ObservacionesLT 13
    $Codigo = $_POST['select-modalidades']; // Modalidades 14

    $componentes_inscripcion = [
      $InscripcionPrincipiante, $InscripcionLC, $InscripcionCategoria, $Codigo, $NombreCE, $ApellidoCE,
      $TelefonoCE, $EmailCE, $DireccionCE, $idEstudiante
    ];
    if (!$utilidades->camposVacios($componentes_inscripcion)) {
      if (!$utilidades->campoInyecciones($componentes_inscripcion)) {
        $IdInscripcion = $inscripcionController->getIdInscripcionByIdEstudiante($idEstudiante);
        if ((is_numeric($IdInscripcion)) && $IdInscripcion != '') {

          $IdTurno = $inscripcionController->getIdTurnoByCodigo($Codigo); //Obtengo el id del turno

          /**Verificar que no haya un estudiante inscrito en la mañana o tarde */
          $dispByCodigo = $inscripcionController->disponibilidadByCodigo($Codigo);

          if ($dispByCodigo == 1 && is_numeric($dispByCodigo)) {

            $Disponibilidad = $inscripcionController->getDisponibilidadByIdTurno($IdTurno); //Obtengo la disponibilidad actual de ese turno
            echo  $Disponibilidad . " ";
            echo $IDTurno;

            if (is_numeric($Disponibilidad) && $Disponibilidad >= 1 && $Disponibilidad <= 2) {
              $result = $inscripcionController->actualizar(
                $InscripcionPrincipiante,
                $InscripcionLC,
                $InscripcionCategoria,
                $NombreCE,
                $ApellidoCE,
                $TelefonoCE,
                $EmailCE,
                $DireccionCE,
                $InscripcionLT,
                $InscripcionTelefonoLT,
                $IncripcionEmailLT,
                $InscripcionDireccionLT,
                $InscripcionObservaciones,
                $IdTurno,
                $idEstudiante
              );
              if ($result) {
                echo '<script> alert("se ha inscrito correctamente");</script>';
                $updateDisponibilidad = $inscripcionController->updateDisponibilidad(($Disponibilidad - 1), $IdTurno);
                if ($updateDisponibilidad) { //Actualizo la disponibilidad de ese horario
                  echo '<script> alert("se ha inscrito correctamente y la disponibilidad se ha actualizado  la disponibilidad actual es=' . $updateDisponibilidad . '");</script>';
                  estudianteInscrito($nombre, $apellido, $email, $telefono, $cedula);
                  $inscripcionController->updateEstado($idEstudiante);
                  header("Location: ../../../index.php?result=inscripcionExitosa");
                  include_once '../../Plataforma/Vistas/login.php';
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
            echo '<script> alert("En este horario no se puede inscribir intente con otro");</script>';
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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!--JQUERY-->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="../../js/jquery-3.5.1.min.js"></script>
  <script src="../../js/popper.min.js"></script>
  <script src="../../js/bootstrap.min.js"></script>
  <script src="../../js/aos.js"></script>
  <script src="../../js/kit-fontawesome.js"></script>
  <script src="../js/estudiante.js"></script>
  <!-- FRAMEWORK BOOTSTRAP para el estilo de la pagina-->
  <link href="../css/bootstrap.min.css" rel="stylesheet" />
  <!-- Los iconos tipo Solid de Fontawesome-->
  <!-- Nuestro css-->
  <link rel="stylesheet" href="../../Plataforma/css/inscripcion.css">
  <title>INSCRIPCIÓN</title>
</head>

<body id="fondo" class=" h-100">
  <div class="container">
    <div class="row justify-content-center my-5">
      <div class="col-xl-7 col-lg-8 col-md-10 col-11 justify-content-center my-5  formulario">
        <form method="POST" enctype="multipart/form-data">
          <div class="form-group  text-center" id="registro">
            <h3>INSCRIPCIÓN</h3>
          </div>
          <div class="container-fluid text-right align-items-right">
            <input type="date" readonly id="inscripcion-fecha-creacion" class="mt-2 text-black font-weight-bold" value=<?php  echo date('Y-m-d H:i:s'); ?> style="color:#001D67" >
          </div>          
          <div class="row ">
            <div class="col-md-12 ">
              <div class="detalle mt-2 font-weight-bold" style="color:#001D67">
                Detalles del Curso
              </div>
              <div class="heading text-color my-2">
                Principiante (*)
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="inscripcion-principiante" id="inlineRadio1" value="Si">
                <label class="form-check-label text-color mr-2" for="inlineRadio1">Si</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="inscripcion-principiante" id="inlineRadio2" value="No">
                <label class="form-check-label text-color mr-2" for="inlineRadio2">No</label>
              </div>
              <div class="heading text-color my-2">
                ¿Posee licencia de conducir? (*)
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="inscripcion-licencia-de-conducir" id="inlineRadio3" value="Si">
                <label class="form-check-label text-color mr-2" for="inlineRadio3">Si</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="inscripcion-licencia-de-conducir" id="inlineRadio4" value="No">
                <label class="form-check-label text-color mr-2" for="inlineRadio4">No</label>
              </div>
              <div class="heading text-color my-2">
                Categoría (*)
                <div class="form-group">
                  <input type="text" name="inscripcion-categoria" class="form-control" id="guardar-categoria">
                </div>
              </div>
              <!-- inscripcion Horarios disponibles para clases teoricas -->
              <div class="heading">
                <label class="align-items-center text-color" for="">Turno (*)</label>
                <div class="form-group">
                  <!--Opciones de los tipos de turno -->
                  <div class="row">
                    <div class="col-md-6 mt-2">
                      <select id="select-turno" name="select-turno" class="text-color form-control-plaintext form-control-sm" readonly>
                        <option value="Matutino" <?php echo $data[0]['Tipo'] == 'Matutino' ? 'selected' : ''; ?>>Matutino</option>
                        <option value="Vespertino" <?php echo $data[0]['Tipo'] == 'Vespertino' ? 'selected' : ''; ?>>Vespertino</option>
                      </select>
                    </div>
                    <!--Opciones de los tipos de horario-->
                    <div class="col-md-6 mt-2">
                      <select id="select-modalidades" name="select-modalidades" class="text-color form-control-plaintext form-control-sm" readonly>
                        <?php foreach ($modalities as $item) : ?>
                          <option value="<?php echo $item['CodigoTurno']; ?>" <?php echo $data[0]['Descripcion'] == $item['Descripcion'] ? 'selected' : ''; ?>> <?php echo $item['Descripcion']; ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row ">
            <div class="col-md-12  mt-2">
              <div class="detalle mt-2 font-weight-bold" style="color:#001D67 ">
                Contacto de emergencia (*)
              </div>
              <div class="row ">
                <div class="col-md-6 mt-2">
                  <div class="form-group">
                    <label class="title text-color">Nombre (*)</label>
                    <input type="text" class="form-control  prueba text-color" id="inscripcion-nombreCE" name="inscripcion-nombreCE" required>
                  </div>
                </div>
                <div class="col-md-6 mt-2">
                  <div class="form-group ">
                    <label class="title text-color">Apellido (*)</label>
                    <input type="text" class="form-control text-color" id="inscripcion-apellidoCE" name="inscripcion-apellidoCE" required>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 ">
                  <div class="form-group  ">
                    <label class="title text-color">Télefono (*)</label>
                    <input type="text" class="form-control text-color" name="inscripcion-telefonoCE" maxlength="8" pattern="[0-9]{8}" title="Ingrese por favor, un numero de 8 digitos" id="inscripcion-telefonoCE" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group ">
                    <label class="title text-color">Email (*)</label>
                    <input type="email" class="form-control text-color" name="inscripcion-emailCE" id="inscripcion-emailCE" required>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group  ">
                    <label class="title text-color">Dirección (*)</label>
                    <input type="text" class="form-control text-color" name="inscripcion-direccionCE" id="inscripcion-direccionCE" required>
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
                    <input type="text" class="form-control text-color" id="incripcion-telefonoLT" maxlength="8" pattern="[0-9]{8}" title="Ingrese por favor, un numero de 8 digitos" name="incripcion-telefonoLT">
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
          <div class="row">
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
          <div class="form-group text-center  mt-4">
            <input type="submit" id="submit" class="btn ingresar" name="btn-enviar-inscripcion" id="btn-enviar-inscripcion" value="ENVIAR">
          </div>
        </form>
      </div>
    </div>
  </div>


  <script>
    
  </script>
</body>

</html>