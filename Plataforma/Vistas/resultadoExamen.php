<?php
include_once 'Plataforma/Utilidades/Utilidades.php';
include_once 'Plataforma/Utilidades/main.php';

$utilidades = new Utilidades();
$session = new Session();
$idExamen = $session->getIdExamen();
echo $session->getCurrentId();

?>

<div class="principal-section">
  <div class="container-fluid estudiante">
    <div class="row">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <form method="POST">
          <!-- inicio de formulario -->
          <div class="row ">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
              <div class="form-group mt-5 mb-4 shadow" id="examen">
                <h5>Resultado del Examen Teórico</h5>
              </div>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-xl-9 col-lg-9 col-md-9 col-sm-5 col-xs-5 ">
              <?php
              //$id = 1;
              $Examen =   $modeloExamen->ResultadoExamen($idExamen);
              echo $Examen;
              ?>
            </div>
            <input type="hidden" id="id-examen" name="id" value="1">
            <!-- cuenta Atras -->
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-xs-5">
              <div class="container text-justify formulario-estudiante shadow">
                <label class="strong" for="">Las preguntas marcadas en verde fueron correctas
                  <span class="mx-1 py-0 correcta"></span>
                </label>
                <label class="strong" for="">Las preguntas marcadas en rojo fueron incorrectas
                  <span class="mx-1 py-0 incorrecta"></span>
                </label>
                <label class="strong">La nota obtenida fue: <?php $controladorExamen = new ExamenController();
                                                            $idEstudiante = $session->getCurrentId();
                                                            $ExamenEstudiante = $controladorExamen->getExamenEstudianteById($idEstudiante, $idExamen);
                                                            $Nota = $ExamenEstudiante->getNota();
                                                            echo $Nota . " " . $idExamen ?></label>
              </div>
            </div>
          </div>
          <!-- aqui iba el boton -->
        </form>
      </div>
    </div>
  </div>
</div>