<?php
include_once '../../Plataforma/Utilidades/confiDev.php';
include_once '../../Plataforma/Utilidades/conexion.php';
include_once '../../Plataforma/Utilidades/Utilidades.php';
include_once '../../Plataforma/Utilidades/session.php';
include_once '../../Plataforma/Utilidades/email.php';
include_once '../../Plataforma/Controladores/EstudianteController.php';
include_once '../../Plataforma/Modelos/EstudianteModel.php';

$session = new Session();
//$conexion = new DB();
$EstudianteModel = new EstudianteModel();
$controladorEstudiante = new EstudianteController();
$utilidades = new Utilidades();
$resultMessage = $_REQUEST['result'] ?? '';

if (isset($_SESSION['idUser'])) {
  session_regenerate_id(true);
  header("Location: ../");
} else if ((isset($_POST['btn-guardar-estudiante']))) {
  if (
    $_POST['guardar-nombre-estudiante'] != ""
    and $_POST['guardar-apellido-estudiante'] != ""
  ) {
    /***inputs -Datos personales */
    $nombre = $_POST['guardar-nombre-estudiante'];
    $apellido = $_POST['guardar-apellido-estudiante'];
    $fechaNacimiento = $_POST['guardar-fechaNacimiento-estudiante'];
    $telefono = $_POST['guardar-telefono-estudiante'];
    $cedula = $_POST['guardar-cedula-estudiante'];
    $direccion = $_POST['guardar-direccion-estudiante'];
    $pasaporte = $_POST['guardar-pasaporte-estudiante'];
    $password = $_POST['guardar-password-estudiante'];
    $email = $_POST['guardar-email-estudiante'];
    $sexo = $_POST['guardar-sexo-estudiante'];
    $metodoPago = $_POST['guardar-metodo-pago'];

    /*** Fotos necesarias */

    $fotoCedulaDelante = $_FILES["foto-cedula-delante"];
    $fotoCedulaDetras = $_FILES["foto-cedula-detras"];
    $fotoPago = $_FILES["foto-pago"];
    $foto = [];

    /*** */
    $VerificarUsuarioActivoById = "";
    $VerificarUsuarioNoActivoById = "";
    $DatosEstudiante = [$nombre, $apellido, $email, $password, $cedula, $fechaNacimiento, $sexo, $telefono, $direccion];
    if (!$utilidades->camposVacios($DatosEstudiante)) {
      if (!$utilidades->campoInyecciones($DatosEstudiante)) {
        $VerificarEstudianteRegistradoActivoById =  $controladorEstudiante->VerificarUsuarioActivoById($email); //Usuario activo control de pago y estado en 1
        $VerificarEstudianteRegistradoNoActivoById =  $controladorEstudiante->VerificarUsuarioNoActivoById($email); //usuario estado 0 control pago 0
        $estadoActivoPagoNOrealizado =  $controladorEstudiante->estadoActivoPagoNOrealizado($email); //usuario estado 1 control pago 0
        $estadoNOActivoPagoRealizado =  $controladorEstudiante->estadoNOActivoPagoRealizado($email); //usuario estado 0 control pago 1
        $cedulaRepetida = $controladorEstudiante->CedulaRepetida($cedula);
        if (!(is_numeric($VerificarEstudianteRegistradoActivoById) && $VerificarEstudianteRegistradoActivoById > 0)) {
          if (!(is_numeric($VerificarEstudianteRegistradoNoActivoById) && $VerificarEstudianteRegistradoNoActivoById > 0)) {
            if (!(is_numeric($estadoActivoPagoNOrealizado) && $estadoActivoPagoNOrealizado > 0)) {
              if (!(is_numeric($estadoNOActivoPagoRealizado) && $estadoNOActivoPagoRealizado > 0)) {
                if (!(is_numeric($cedulaRepetida) && $cedulaRepetida > 0)) {
                  $succes = $controladorEstudiante->Insertar($nombre, $apellido, $email, $password, $cedula, $pasaporte, $fechaNacimiento, $sexo, $telefono, $direccion,$metodoPago);
                  if ($succes) {
                    echo "<script> se guardaron los datos generales </script>";
                    $id = $controladorEstudiante->getIdByEmail($email);
                    $controladorEstudiante->actualizarUrlFoto($id, $foto, "Nuevo");
                    $fotocedulaDelanteEnviada = $controladorEstudiante->actualizarUrlFotoCedulaDelante($id, $fotoCedulaDelante);
                    //FotoCedulaDelante
                    if ($fotoCedulaDelante['name'] != null) {
                      $ruta_carpeta = "../../Plataforma/Imagenes/Estudiante/" . "Cedula-delante";
                      $ruta_guardar_archivo = $ruta_carpeta . $id . ".png";
                      $nombre_archivo_temp = $_FILES["foto-cedula-delante"]["tmp_name"];
                      move_uploaded_file($nombre_archivo_temp, $ruta_guardar_archivo);
                      //FotoCedulaDetras
                      if ($fotocedulaDelanteEnviada) {
                        if ($fotoCedulaDetras['name'] != null) {
                          $controladorEstudiante->actualizarUrlFotoCedulaDetras($id, $fotoCedulaDetras);
                          $ruta_carpeta = "../../Plataforma/Imagenes/Estudiante/" . "Cedula-detras";
                          $ruta_guardar_archivo = $ruta_carpeta . $id . ".png";
                          $nombre_archivo_temp = $_FILES["foto-cedula-detras"]["tmp_name"];
                          move_uploaded_file($nombre_archivo_temp, $ruta_guardar_archivo);
                          //FotoBaucher
                          if ($fotoPago['name'] != null) {
                            $controladorEstudiante->actualizarUrlFotoBaucher($id, $fotoPago);
                            $ruta_carpeta = "../../Plataforma/Imagenes/Estudiante/" . "Pago";
                            $ruta_guardar_archivo = $ruta_carpeta . $id . ".png";
                            $nombre_archivo_temp = $_FILES["foto-pago"]["tmp_name"];
                            move_uploaded_file($nombre_archivo_temp, $ruta_guardar_archivo);
                            $mensaje = "Exito";
                            if ($mensaje == "Exito") {
                              CorreoVerificarEstudiante($nombre, $apellido, $cedula, $email, $telefono);
                              header("Location: ../../Plataforma/Vistas/Registrarse.php?result=Exito");
                              header('location: ../../Plataforma/Vistas/FinRegistro.php');
                            }
                          } else {
                            header("Location: ../../Plataforma/Vistas/Registrarse.php?result=ingreseTodasLasFotos");
                          }
                        } else {
                          header("Location: ../../Plataforma/Vistas/Registrarse.php?result=ingreseTodasLasFotos");
                        }
                      }
                    } else {
                      header("Location: ../../Plataforma/Vistas/Plataforma/Vistas/Registrarse.php?result=ingreseTodasLasFotos");
                    }
                  } else {
                    header("Location: ../../Plataforma/Vistas/Registrarse.php?result=lleneCamposSolicitados");
                  }
                } else {
                  header("Location: ../../Plataforma/Vistas/Registrarse.php?result=cedulaRepetida");
                }
              } else {
                header("Location: ../../Plataforma/Vistas/Registrarse.php?result=correoexistentenoconfirmado");
              }
            } else {
              header("Location: ../../Plataforma/Vistas/Registrarse.php?result=correoexistentenoconfirmado");
            }
          } else {
            header("Location: ../../Plataforma/Vistas/Registrarse.php?result=correoexistentenoconfirmado");
          }
        } else {
          header("Location: ../../Plataforma/Vistas/Registrarse.php?result=correoexistente");
        }
      } else {
        header("Location: ../../Plataforma/Vistas/Registrarse.php?result=loginFaileCaracteres");
      }
    } else {
      header("Location: ../../Plataforma/Vistas/Registrarse.php?result=loginFaileVacios");
    }
  }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0 shrink-to-fit=no">

  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="../../js/jquery-3.5.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.min.js" integrity="sha512-d4KkQohk+HswGs6A1d6Gak6Bb9rMWtxjOa0IiY49Q3TeFd5xAzjWXDCBW9RS7m86FQ4RzM2BdHmdJnnKRYknxw==" crossorigin="anonymous"></script>
  <script src="../../js/popper.min.js"></script>
  <script src="../../js/bootstrap.min.js"></script>
  <script src="../../js/aos.js"></script>
  <script src="../../js/kit-fontawesome.js"></script>
  <script src="../../Plataforma/js/Registrarse.js"></script>
  <!-- Nuestro css-->
  <link href="../css/viewer.css" rel="stylesheet" />
  <link rel="stylesheet" href="../../Plataforma/css/Registrarse.css">
  <link href="../css/bootstrap.min.css" rel="stylesheet" />
  <link href="../css/bootstrap-datepicker3.min.css" rel="stylesheet" />
  <link href="../css/bootstrap-datepicker3.standalone.min.css" rel="stylesheet" />
  <title>Registro</title>
</head>

<body id="fondo">
  <div class="container h-100 Estudiante">
    <div class="container Registro">
      <form method="POST" autocomplete="off" enctype="multipart/form-data">
        <div class="row justify-content-center h-100">
          <div class="col-xl-10 col-lg-10 col-md-10 col-sm-12 mt-5 justify-content-center align-items-center formulario">

            <!-- INICIO DEL DIV DE REGISTRO-->
            <!-- Datos Generales -->
            <div class="container Datos-Generales">
              <div class="form-group col-10 text-center" id="guardar-perfil">
                <h3>Datos de Registro</h3>
              </div>
              <div class="row mt-4">
                <div class="col-md-6 ">
                  <label class="title text-color"> Nombre<span>*</span></label>
                  <input type="text" class="form-control text-color" id="guardar-nombre-estudiante" name="guardar-nombre-estudiante" maxlength="50" required>
                </div>
                <div class="col-md-6 ">
                  <label class="title text-color">Apellido<span>*</span></label>
                  <input type="text" class="form-control text-color" id="guardar-apellido-estudiante" name="guardar-apellido-estudiante" maxlength="50" required>
                </div>
                <div class="col-md-6">
                  <label class="title text-color"> Fecha de Nacimiento<span>*</span></label>
                  <input type="date" class="form-control text-color" id="guardar-fechaNacimiento-estudiante" name="guardar-fechaNacimiento-estudiante" maxlength="50" required>
                </div>
                <div class="col-md-6">
                  <label class="title text-color"> Telefono <span>*</span></label>
                  <input type="text" class="form-control text-color" id="guardar-telefono-estudiante" name="guardar-telefono-estudiante" maxlength="8" pattern="[0-9]{8}" title="Ingrese por favor, un numero de 8 digitos" required>
                </div>
                <div class="col-md-6">
                  <label class="title text-color"> Cedula de identidad<span>*</span></label>
                  <input type="text" class="form-control text-color" id="guardar-cedula-estudiante" name="guardar-cedula-estudiante" maxlength="16" required>
                </div>
                <div class="col-md-6">
                  <label class="title text-color"> Direccion <span>*</span></label>
                  <input type="text" class="form-control text-color" id="guardar-direccion-estudiante" name="guardar-direccion-estudiante" maxlength="80" required>
                </div>
                <div class="col-md-6">
                  <label class="title text-color"> Pasaporte</label>
                  <input type="text" class="form-control text-color" id="guardar-pasaporte-estudiante" name="guardar-pasaporte-estudiante">
                </div>
                <div class="col-md-6">
                  <label class="title text-color"> Email <span>*</span></label>
                  <input type="email" class="form-control text-color" id="guardar-email-estudiante" name="guardar-email-estudiante" maxlength="200" required>
                </div>
                <div class="col-md-6">
                  <label class="title text-color"> Sexo <span>*</span> </label>
                  <div class="sexo mt-2 pt-1">
                    <select class="control text-color w-100" id="guardar-sexo-estudiante" name="guardar-sexo-estudiante" required>
                      <option value="Femenino">Femenino</option>
                      <option value="Masculino">Masculino</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <label class="title text-color"> Contraseña<span>*</span></label>
                  <input type="password" class="form-control text-color" id="guardar-password-estudiante" name="guardar-password-estudiante" required>
                  <input id="id-registro" name="id-registro" type="hidden">
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Fin Datos Generales -->
        <div class="row justify-content-center h-100 ">
          <div class="col-xl-10 col-lg-10 col-md-10 col-sm-12 mt-5 justify-content-center align-items-center formulario">
            <div class="form-group text-center" id="fotos-necesarias">
              <h3>Fotos requeridas</h3>
            </div>
            <table class="table mt-5" id="table-text">
              <thead>
                <tr>
                  <th>Documento</th>
                  <!-- <th>Nombre</th> --->
                  <th class="text-center">Foto</th>
                  <th class="text-center">Subir</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <!-- padre  -->
                  <td>Cédula lado frontal</td> <!-- hijo  -->
                  <!-- <td><span id="spam-titulo-insertar-usuario"></span></td>  -->
                  <td class="text-center">
                    <img src="../Imagenes/template.png" id="img-template">
                  </td>
                  <td class="text-center ">
                    <!-- hijo  -->
                    <label for="foto-cedula-delante" class="label-foto-cedula-delante">Subir</label> <!-- next  -->
                    <input type="file" id="foto-cedula-delante" class="btn btn-success" name="foto-cedula-delante" accept="image/*" required><!-- next  -->
                  </td>
                </tr>
                <tr>
                  <td>Cédula lado posterior</td>
                  <!-- <td><span id="spam-titulo-insertar-usuario"></span></td>  -->
                  <td class="text-center">
                    <img src="../Imagenes/template.png" id="img-template-1">
                  </td>
                  <td class="text-center">
                    <label for="foto-cedula-detras" class="label-foto-cedula-detras">Subir</label>
                    <input type="file" id="foto-cedula-detras" class="btn bg-success text-light" name="foto-cedula-detras" accept="image/*" required>
                  </td>
                </tr>
                <tr>
                  <!-- <td>Voucher Pago</td>
                  <td class="text-center">
                    <img src="../Imagenes/template.png" id="img-template-2">
                  </td>
                  <td class="text-center">
                    <label for="foto-voucher" class="label-foto-voucher">Subir</label>
                    <input type="file" id="foto-voucher" class="btn bg-success text-light" name="foto-voucher" accept="image/*" required>
                  </td>
                </tr>-->
              </tbody>
            </table>
          </div>
        </div>

        <!-- Tipo de pago -->
        <div class="row justify-content-center h-100">
          <div class="col-xl-10 col-lg-10 col-md-10 col-sm-12 mt-5 justify-content-center align-items-center formulario">
            <div class="form-group text-center" id="fotos-necesarias">
              <h3>Metodo de pago</h3>
            </div>
            <!--div del tipo de pago -->
            <div class="row mt-5">
              <div class="col-md-6">
                <div class="mt-2 pt-1">
                  <label class="title text-color pb-2">Seleccione metodo de pago<span>*</span></label>
                  <select class="control text-color w-100" id="guardar-metodo-pago" name="guardar-metodo-pago" required title="seleccione una opcion..">
                    <!--<option value="Elija un metodo de pago...">Elija un metodo de pago...</option> -->
                    <option value="Efectivo Cordobas (C$)">Efectivo Cordobas (C$)</option>
                    <option value="Transferencia Bancaria">Transferencia Bancaria</option>
                    <option value="Tarjeta">Tarjeta</option>
                  </select>
                </div>
                <!--<label class="text-color mt-2"id="foto-factura" for="">Adjunte la foto de la Factura</label>
                <label class="text-color mt-2"id="foto-baucher"for="">Adjunte la foto del voucher de pago en banpro</label>
                <label class="text-color mt-2"id=""for="">Adjunte la foto del recibo</label>-->
              </div>

              <div class="col" id="contenedorMetodoPago">
                <div class="row">
                  <div class="col">
                    <div class="">
                      <div class="container text-center p-0" style="background-color: #28a745;">
                        <label for="foto-pago" class="label-foto-pago text-center">Click para subir la foto</label>
                      </div>
                      <input id="foto-pago" type="file" class="btn bg-success text-light" name="foto-pago" accept="image/*" required>
                      <br>
                      <div style="border: 3px dashed #656565;" class="text-center ">
                        <img src="../Imagenes/template1.png" class="my-2" id="img-template-3">
                      </div>
                    </div>
                  </div>
                </div>
                <!-- fin adjuntar div -->

              </div>
            </div>

            <!-- fin de div tipo de pago -->
          </div>
        </div>
        <!-- Botones -->
        <div class="row justify-content-center ">
          <div class="col-lg-12 justify-content-center align-items-center">
            <div class="container">
              <div class="form-group text-center mt-5">
                <input name="btn-guardar-estudiante" id="btn-guardar-estudiante" type="submit" class="btn bg-success px-4 mx-1 text-light"></input>
                <a href="../../index.php" class="btn bg-danger mx-1 text-light" id="btn-cancelar">
                  Cancelar
                </a>
              </div>
            </div>
          </div>
        </div>
        <input type="hidden" name="idEstudiante" value=<?php $id ?>>
      </form>
    </div>
  </div>

  <script src="./../../Plataforma/js/viewer.js"> </script>
  <script src="./../../Plataforma/js/main-viewer.js"> </script>
  <script>
    $(document).ready(function($) {
      $('#guardar-cedula-estudiante').mask("999-999999-9999a", {
        placeholder: "XXX-XXXXXX-XXXXX"
      })
    });
  </script>
  <?php
  if ($resultMessage == "correoexistente") {
    echo '
            <div class="modal fade" id="idModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Alerta</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Ya hay un usuario registrado con este correo, por favor registrese con uno diferente.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $("#idModal").modal("show");
        </script>

        ';
  } else if ($resultMessage == "loginFaileVacios") {
    echo '
            <div class="modal fade" id="idModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" href="#">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Alerta</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Por favor, llene todos los campos para poder continuar, (los datos marcados con * son de caracter obligatorio).
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $("#idModal").modal("show");
        </script>
        ';
  } else if ($resultMessage == "loginFaileCaracteres") {
    echo '
            <div class="modal fade" id="idModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" href="#">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Alerta</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        No se admiten caracteres especiales, por favor, intentelo nuevamente.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $("#idModal").modal("show");
        </script>
        ';
  } else if ($resultMessage == "correoexistentenoconfirmado") {
    echo '
            <div class="modal fade" id="idModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" href="#">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Alerta</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    Usted ya tiene una cuenta registrada sin confirmar con este correo, por favor, espero a que el administrador verifique los datos enviados y valide su cuenta para poder continuar en un plazo maximo de 3 dias, si no
                    contactese con nosotros para poder ayudarle
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $("#idModal").modal("show");
        </script>
        ';
  } else if ($resultMessage == "correoexistenteSinControldePago") {
    echo '
            <div class="modal fade" id="idModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" href="#">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Alerta</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    Usted ya tiene una cuenta registrada sin confirmar con este correo, por favor, espero a que el administrador verifique los datos enviados y valide su cuenta para poder continuar, si no
            contactese con nosotros para poder ayudarle *Control Pago no verificado
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $("#idModal").modal("show");
        </script>
        ';
  } else if ($resultMessage == "ingreseTodasLasFotos") {
    echo '
            <div class="modal fade" id="idModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" href="#">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Alerta</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                       Por favor ingrese todas las Fotos necesarias
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $("#idModal").modal("show");
        </script>
        ';
  } else if ($resultMessage == "lleneCamposSolicitados") {
    echo '
            <div class="modal fade" id="idModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" href="#">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Alerta</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                       Por favor ingrese todas las Fotos necesarias
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $("#idModal").modal("show");
        </script>
        ';
  } else if ($resultMessage == "Exito") {
    echo '
            <div class="modal fade" id="idModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" href="#">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Alerta</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                      Registro realizado exitosamente
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $("#idModal").modal("show");
        </script>
        ';
  } else if ($resultMessage == "cedulaRepetida") {
    echo '
            <div class="modal fade" id="idModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" href="#">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Alerta</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                      ya existe un usuario registrado con esta numero de identidad, verifique sus datos nuevamente e intentelo de nuevo;
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $("#idModal").modal("show");
        </script>
        ';
  }
  ?>
</body>

</html>