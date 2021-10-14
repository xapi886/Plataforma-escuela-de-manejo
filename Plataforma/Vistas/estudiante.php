<?php
include_once 'Plataforma/Utilidades/Utilidades.php';
include_once 'Plataforma/Utilidades/main.php';
$utilidades = new Utilidades();
$resultMessage = '';
$session = new Session();
$idEstudiante = $session->getCurrentId();
echo $idEstudiante ;

$controladorEstudiante = new EstudianteController();
$ExamenModel = new ExamenModel();
$Estudiante = $controladorEstudiante->getEstudianteById($session->getCurrentId());
$fechaAhora = date('Y-m-d');
$FechaNacimiento = $Estudiante->getFechaNacimiento();
$cumpleanos = new DateTime("$FechaNacimiento");
$hoy = new DateTime();
$annos = $hoy->diff($cumpleanos);
$edad =  $annos->y;

if (isset($_POST['btn-guardar-editar-estudiante'])) {
  $pasaporte = $_POST['editar-pasaporte'] ?? '';
  $direccion = $_POST['editar-direccion'] ?? '';
  $telefono = $_POST['editar-telefono'] ?? '';
  $password = $_POST['editar-contrasenia'] ?? '';
  $Foto = $_FILES['editar-foto'];
  $tag = "actualizar";
  $id = "";
  echo 'enviando datos';
  $componentes = [$pasaporte, $direccion, $telefono, $password];
  //if (!$utilidades->camposVacios($componentes)) {
  // if (!$utilidades->campoInyecciones($componentes)) {
  if (is_numeric($telefono)) {
    $id = $session->getCurrentId();
    $result = $controladorEstudiante->actualizar($id, $pasaporte, $telefono, $password, $direccion);
    $tag = $controladorEstudiante->getFototEstudianteById($id);
    echo $tag;
    if ($result) {
      $controladorEstudiante->actualizarUrlFoto($id, $Foto, $tag);
      //FOTO
      $resultMessage = "actualizado";
      if ($Foto['name'] != null) {
        $ruta_carpeta = "Plataforma/Imagenes/Estudiante/Perfil/" . "PROFILE_PHOTO_";
        $ruta_guardar_archivo = $ruta_carpeta . $id . ".png";
        $nombre_archivo_temp = $_FILES["editar-foto"]["tmp_name"];
        move_uploaded_file($nombre_archivo_temp, $ruta_guardar_archivo);
        $resultMessage = "fotoActualizada";
      } else {
        // echo 'Hubo un error al intentar cambiar la foto de perfil, por favor intentelo de nuevo';
      }
    } else {
      // echo 'Error no tan fatal';
    }
  }
  //  }else{
  //   echo 'No se aceptan caracteres especiales';
  //  }
  // }else{
  //    echo 'No se aceptan campos vacios';
  //   }
}
?>

<div class="principal-section mt-2">
  <div class="container-fluid container-examen mt-5">
    <input type="hidden" id="edad" value="<?php echo $edad ?>">
    <div class="text-white text-center col-xl-12 col-lg-12 col-md-12 col-sm-11 col-10" id="fecha-examen">
      <h5>Fechas de examenes</h5>
    </div>
    <!-- Informacion de examenes en escuela de manejo-->
    <div class="form-group mt-4" style="border-bottom: 1px solid #C9C9C9;">
      <div class="container-fluid text-center">
        <h6 style="color:#4d7ae2;"> Examenes en escuela de manejo</h6>
      </div>
      <div class="row">
        <div class="col-md-6 col-sm-6 col-6 text-left">
          <label class="text-left">Fecha Examen teórico </label>
        </div>
        <div class="col-md-6 col-sm-6 col-6 text-right">
          <label class="text-right" id="fecha-examen-teorico" value="<?php ?>"></label>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 col-sm-6 col-6 text-left ">
          <label class="text-left">Fecha Examen práctico </label>
        </div>
        <div class="col-md-6 col-sm-6 col-6 text-right">
          <label class="text-right" id="fecha-examen-practico" value="<?php ?>"></label>
        </div>
      </div>
    </div>
    <!-- Informacion de examenes en transito-->
    <div class="form-group mt-2" style="border-bottom: 1px solid #C9C9C9">
      <div class="container-fluid text-center font-weight-bold">
        <h6 style="color:#4d7ae2;"> Examenes en transito</h6>
      </div>
      <div class="row">
        <div class="col-md-6 col-sm-6 col-6 text-left">
          <label class="text-left">Fecha Examen teórico: </label>
        </div>
        <div class="col-md-6 col-sm-6 col-6 text-right">
          <label class="text-right" id="fecha-examen-teorico-transito" value="<?php ?>"></label>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 col-sm-6 col-6 text-left ">
          <label class="text-left">Fecha Examen práctico: </label>
        </div>
        <div class="col-md-6 col-sm-6 col-6 text-right">
          <label class="text-right" id="fecha-examen-practico-transito" value="<?php ?>"></label>
        </div>
      </div>
    </div>
  </div>

  <div class="container-fluid container-examen mt-5" id="licencia-me">
    <div class="text-white text-center col-xl-12 col-lg-12 col-md-12 col-sm-11 col-10" id="examen-requisitos">
      <h6>Requisistos para realizar examen en transito</h6>
    </div>
    <div class="form-group mt-4" style="border-bottom: 1px solid #C9C9C9">
      <div class="row">
        <div class="col-md-6 col-sm-6 col-6 text-left" id="container-ET-me">
          <div class="container-fluid text-center font-weight-bold">
            <h6 style="color:#4d7ae2;"> Examen Teórico</h6>
          </div>
          <ol class="text-left">
            <li>Cedula de identidad</li>
            <li>Certificado brindado por parte de la escuela</li>
            <li>Presentar la foto de la inscripcion:
              <a href="<?php ?>" id="ComprobanteETme" download="ComprobanteET.pdf">Descargar Hoja de inscripcion</a>
            </li>
            <p>**Presentar esta hoja en transito para poder realizar el examen**</p>
          </ol>
        </div>
        <div class="col-md-6 col-sm-6 col-6 text-left"  id="container-EP-me"  style="border-left: 1px solid #C9C9C9">
          <div class="container-fluid text-center font-weight-bold" id="container-EP-me" >
            <h6 style="color:#4d7ae2;"> Examen Práctico</h6>
          </div>
          <ol class="text-left">
            <li>Fotocopia de cedula</li>
            <li>Cedula de identidad</li>
            <li>Tres examenes de cruz roja</li>
            <li>Baucher de licencia</li>
            <li>Fianza original</li>
            <li>Fotocopia de la cedula de identidad de los fiadores</li>
            <li>Presentar la foto de la inscripcion:
              <embed class="ml-1" id="ComprobanteETPme" id="view-2" src="<?php ?>" type="application/pdf" 
              
               />
              <a href="<?php ?>" id="ComprobanteETPme">Descargar </a>
            </li>
            <p>**Presentar esta hoja en transito para poder realizar el examen**</p>
          </ol>
        </div>
      </div>
    </div>
    <div class="form-group mt-4" style="border-bottom: 1px solid #C9C9C9">
      <div class="row">
        <div class="col-md-12 col-sm-12 col-12 text-left">
          <div class="container-fluid text-center font-weight-bold">
            <h6 style="color:#4d7ae2;">Documentos Necesarios</h6>
          </div>
          <ol class="text-left">
            <li>Examen de la vista C$ 145</li>
            <li>Examen Psicologico C$ 220</li>
            <li>Examen de Sangre C$ 145</li>
            <li>Examen practico C$ 150</li>
            <li>Certificado de egresado por parte de escuela C$ 125</li>
            <li>Licencia de conducir C$ 200</li>
            <p class="m-0 p-0">**Los examenes son pagados en banpro**</p>
            <p class="m-0 p-0">**Los examenes de cruz roja se realizan en cruz roja 7 sur o cruz roja Don bosco**</p>
            <p class="text-danger m-0 p-0">**Recordar estar 10 minutos antes en tránsito Nacional**</p>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <div class="container-fluid container-examen mt-5" id="licencia-ordinaria">
    <div class="text-white text-center col-xl-12 col-lg-12 col-md-12 col-sm-11 col-10" id="examen-requisitos">
      <h5>Requisistos para realizar examen en transito</h5>
    </div>
    <div class="form-group mt-5" style="border-bottom: 1px solid #C9C9C9">
      <div class="row">
        <div class="col-md-6 col-sm-6 col-6 text-left" id="container-ET-lo">
          <div class="container-fluid text-center font-weight-bold">
            <h6 style="color:#4d7ae2;"> Examen Teórico</h6>
          </div>
          <ol class="text-left">
            <li>Cedula de identidad</li>
            <li>Certificado brindado por parte de la escuela</li>
            <li>Presentar la foto de la inscripcion:
            <br>
              <embed class="ml-1" id="ComprobanteETV" src="<?php ?>" type="application/pdf" width="100px" height="100px"/>
              <a href="<?php ?>" id="ComprobanteET" target="_blank">Descargar</a>
            </li>
            <p class="font-weight-bold text-danger">*Presentar esta hoja en transito para poder realizar el examen*</p>
          </ol>
        </div>
        <div class="col-md-6 col-sm-6 col-6 text-left"  style="border-left: 1px solid #C9C9C9">
          <div class="container-fluid text-center font-weight-bold" id="container-EP-lo">
            <h6 style="color:#4d7ae2;"> Examen Práctico</h6>
          </div>
          <ol class="text-left">
            <li>Fotocopia de cedula</li>
            <li>Cedula de identidad</li>
            <li>Tres examenes de cruz roja</li>
            <li>Baucher de licencia</li>
            <li>Fianza original</li>
            <li>Fotocopia de la cedula de identidad de los fiadores</li>
            <li>Presentar la foto de la inscripcion:
            <br>
            <embed class="ml-1" id="ComprobanteEPV" src="<?php ?>" type="application/pdf" width="100px" height="100px"/>
              <a href="<?php ?>" id="ComprobanteEP" target="_blank">Descargar</a>
            </li>
            <p class="font-weight-bold text-danger">*Presentar esta hoja en transito para poder realizar el examen*</p>
          </ol>
        </div>
      </div>
    </div>
    <div class="form-group mt-4" style="border-bottom: 1px solid #C9C9C9">
      <div class="row">
        <div class="col-md-12 col-sm-12 col-12 text-left" style="border-right: 1px solid #C9C9C9">
          <div class="container-fluid text-center font-weight-bold">
            <h6 style="color:#4d7ae2;">Documentos Necesarios</h6>
          </div>
          <ol class="text-left">
            <li>Examen de la vista C$ 145</li>
            <li>Examen Psicologico C$ 220</li>
            <li>Examen de Sangre C$ 145</li>
            <li>Examen practico C$ 150</li>
            <li>Certificado de egresado por parte de escuela C$ 125</li>
            <li>Licencia de conducir C$ 200</li>
            <p class=" font-weight-bold m-0 p-0">*Los examenes son pagados en banpro*</p>
            <p class=" font-weight-bold m-0 p-0">*Los examenes de cruz roja se realizan en cruz roja 7 sur o cruz roja don bosco*</p>
            <p class=" font-weight-bold text-danger m-0 p-0">*Recordar estar 10 minutos antes en tránsito Nacional*</p>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <div class="container-fluid container-examen mt-5">
    <div class="text-white text-center col-xl-12 col-lg-12 col-md-12 col-sm-11 col-10" id="fecha-examen">
      <h5>Información del curso</h5>
    </div>
    <div class="form-group mt-4" style="border-bottom: 1px solid #C9C9C9">
      <div class="row">
        <div class="col-md-6 col-sm-6 col-6 text-left">
          <label class="text-left">Seminario: </label>
        </div>
        <div class="col-md-6 col-sm-6 col-6 text-right">
          <label class="text-right" value="<?php  ?>" id="turno" style="border: 0px solid #fff"></label>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 col-sm-6 col-6 text-left ">
          <label class="text-left">Nivel/Horas Practicas: </label>
        </div>
        <div class="col-md-6 col-sm-6 col-6 text-right">
          <label class="text-right" id="nivel" value="<?php ?>" style="border: 0px solid #fff"></label>
        </div>
      </div>
    </div>
  </div>

  <form method="POST" autocomplete="off" enctype="multipart/form-data">
    <div class="container-fluid estudiante mt-5">
      <div class="row justify-content-center align-items-center ">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 formulario-estudiante shadow">
          <div class="header-box text-white text-center col-xl-12 col-lg-12 col-md-12 col-sm-11 col-10">
            <h5>Editar perfil</h5>
          </div>
          <div class="row">
            <div class="col-md-6 mt-5">
              <div class="form-group">
                <label class="title">Nombre</label>
                <label type="text" class="form-control text-color" id="editar-nombre" name="editar-nombre" value="<?php  ?>"> </label>
              </div>
            </div>
            <div class="col-md-6 mt-5">
              <div class="form-group ">
                <label>Apellido</label>
                <label type="text" class="form-control text-color" id="editar-apellido" name="editar-apellido" value="<?php  ?>"> </label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 ">
              <div class="form-group  ">
                <label>Cédula de identidad</label>
                <label type="text" class="form-control text-color" id="editar-cedula" name="editar-cedula" value="<?php  ?>"> </label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group ">
                <label>Pasaporte</label>
                <input type="text" class="form-control" id="editar-pasaporte" name="editar-pasaporte" value="<?php  ?>">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group  ">
                <label>Sexo</label>
                <label type="text" class="form-control text-color" id="editar-sexo" name="editar-sexo" value="<?php  ?>"></label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group  ">
                <label>Fecha de nacimiento</label>
                <label type="text" class="form-control text-color" id="editar-fecha-nacimiento" name="editar-fecha-nacimiento" value="<?php  ?>"></label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group ">
                <label>Email</label>
                <label type="text" class="form-control text-color" id="editar-email" name="editar-email" value="<?php  ?>"></label>
              </div>
            </div>
            <div class="col md-6">
              <div class="form-group  ">
                <label>Contraseña</label>
                <input type="text" class="form-control" id="editar-contrasenia" name="editar-contrasenia" value="<?php  ?>">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group  ">
                <label>Dirección</label>
                <input type="text" class="form-control" id="editar-direccion" name="editar-direccion" value="<?php  ?>">
              </div>
            </div>
            <div class="col-md-6">
              <label>Telefono</label>
              <input type="text" class="form-control" id="editar-telefono" maxlength="8" pattern="[0-9]{8}" title="Ingrese por favor, un numero de 8 digitos" name="editar-telefono" value="<?php  ?>">
            </div>
          </div>
          <div class="col-md-6">
            <label class="text-center">Foto</label>
            <div class="form-group editar-foto ">
              <span class="editar-foto">
                <input type="file" name="editar-foto" id="editar-foto" class="w-100" accept="image/*">
              </span>
              <label for="editar-foto" class="w-100" id="label-input-foto">
                <span> Click para agregar una foto</span>
                <img value="<?php  ?>" id="template">
              </label>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid estudiante ">
      <div class="row justify-content-center align-items-center mt-5 pb-5">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 formulario-estudiante  shadow">
          <div class="header-box-fotos text-white text-center col-xl-12 col-lg-12 col-md-12 col-sm-11 col-10">
            <h5>Fotos de Registro</h5>
          </div>
          <table class="table table-borderless table-text mt-4">
            <thead class="text-color">
              <tr>
                <th>Documento</th>
                <th></th>
                <th></th>
                <th>Foto</th>
              </tr>
            </thead>
            <tbody class="text-color">
              <tr>
                <td>Foto Cédula por delante</td>
                <td></td>
                <td>
                </td>
                <td>
                  <div class="foto-cedula-delante">
                    <div class="form-group editar-foto-cedula-delante">
                      <label for="editar-foto-cedula-delante" class="w-100" id="label-input-foto-cedula-delante">
                        <span> </span>
                        <div class="docs-pictures">
                          <img class="image" id="foto-cedula-delante" value="<?php  ?>">
                        </div>
                      </label>
                    </div>
                </td>
              </tr>
              <tr>
                <td>Foto Cédula por detras</td>
                <td></td>
                <td>
                </td>
                <td>
                  <div class=" foto-cedula-detras">
                    <div class="form-group editar-foto-cedula-detras">
                      <div class="">
                        <label for="editar-foto-cedula-detras" class="w-100" id="label-input-foto-cedula-detras">
                          <span> </span>
                          <section class="docs-pictures">
                            <img class="image" id="foto-cedula-detras" value="<?php  ?>">
                          </section>
                        </label>
                      </div>
                    </div>
                  </div>
                </td>
              </tr>
              <tr>
                <td>Documento de Pago</td>
                <td></td>
                <td>
                </td>
                <td>
                  <div class="foto-cedula-Boucher">
                    <div class="form-group editar-foto-Boucher">
                      <div class="add-photo" id="add-foto-boucher">
                        <label for="editar-foto-Boucher" class="w-100" id="label-input-foto-baucher">
                          <span> </span>
                          <img class="image" alt="" id="foto-Boucher" value="<?php  ?>">
                        </label>
                      </div>
                    </div>
                </td>
              </tr>
              <tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="form-group text-center mt-3 mb-0">
        <button type="submit" class="btn bg-success text-light pl-4 pr-4 " name="btn-guardar-editar-estudiante" id="btn-guardar-editar-estudiante"> Guardar</button>
        <button class="btn bg-danger pl-4 pr-4" id="btn-cancelar"> Cancelar</button>
      </div>
    </div>
  </form>
</div>
</div>


<?php
echo $controladorEstudiante->editarDatosEstudiante($session->getCurrentId());

if ($resultMessage === "actualizado") {
  echo '<div class="modal fade" id="idresultMessage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" href="#" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Datos Actualidos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    <div class="modal-body">
                        Datos actualizados correctamente
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $("#idresultMessage").modal("show");
    </script>';
} else if ($resultMessage === "fotoActualizada") {
  echo '<div class="modal fade" id="idresultMessage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" href="#" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Datos Actualidos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    <div class="modal-body">
                        Foto actualizada correctamente
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $("#idresultMessage").modal("show");
    </script>';
}
?>