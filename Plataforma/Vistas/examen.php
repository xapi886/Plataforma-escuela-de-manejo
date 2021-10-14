<?php

include_once 'Plataforma/Utilidades/Utilidades.php';
include_once 'Plataforma/Utilidades/main.php';
$IdExamen = $_REQUEST['modulo'] ?? '';

$utilidades = new Utilidades();
$EstudianteModel = new EstudianteModel();
$controladorEstudiante = new EstudianteController();
$ExamenModel = new ExamenModel();
$controladorExamen = new ExamenController();
$session = new Session();
$ressultMessage = "";
$idExam = $session->setIdExamen($IdExamen);
$idEstudiante = $session->getCurrentId();
?>
<div class="principal-section">
    <div class="container-fluid estudiante">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <form method="POST">
                    <!-- inicio de formulario -->
                    <div class="row ">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                            <div class="header-box-examen text-white text-center">
                                <h5>Examen Teorico</h5>
                            </div>
                        </div>
                    </div>
                    <!-- Mostrar datos del resultado del examen-->
                    <div id="result-examen">
                    </div>
                    <!-- Datos del examen-->
                    <div class="contenedor-principal-examen">
                        <div class="row mt-2">
                            <div class="col-xl-9 col-lg-9 col-md-9 col-sm-5 col-xs-5 ">
                                <?php
                                $Examen =   $modeloExamen->Examen_2($IdExamen);
                                echo $Examen;
                                ?>
                            </div>
                            <!-- cuenta Atras -->
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-xs-5">
                                <div class="container formulario-estudiante shadow">
                                    <label class="strong" for="">Tiempo a cumplir:<b> 20 min </b></label>
                                    <!-- <label class="strong" for=""> Tiempo restante : <span id="tiempo"> </span>: </label> -->
                                    <label class="strong" for=""> Oportunidades: <b>1</b> </label>
                                    <!-- <span id="temporizador"></span> -->
                                    <label for="" class="Strong">Tiempo Restante: <span id="tiempo-formateado"> </span>
                                    </label>
                                    <span class="text-white" id="counter" name="counter"><?php $controladorExamen = new ExamenController();
                                                                                            $idEstudiante = $session->getCurrentId();
                                                                                            $ExamenEstudiante = $controladorExamen->getExamenEstudianteById($idEstudiante, ($session->getIdExamen())); //Select de los datos de la tabla ExamenEstudiante
                                                                                            $Tiempo = $ExamenEstudiante->getTiempo();
                                                                                            echo $Tiempo;
                                                                                            ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="form-group mt-4">
                                <button type="submit" class="btn bg-success pl-5 pr-5" id="btn-enviar-examen" >Enviar
                                </button>
                            </div>
                        </div>
                        <div id="info-guardada"> 
                            aqui se muestra
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="Plataforma/js/examen.js"></script>
<?php
if ($ressultMessage == 'Realizado') {
    echo '<div class="modal fade" id="idresultMessage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" href="#" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Alerta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                  Lo sentimos, usted ya ha realizado este examen asi que por favor intente con otro diferente
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Aceptar</button>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){
$("#idresultMessage").modal("show");
});
</script>';
}
?>