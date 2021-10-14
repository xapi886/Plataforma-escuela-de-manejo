<?php
include_once 'Plataforma/Utilidades/Utilidades.php';
include_once 'Plataforma/Utilidades/main.php';
include_once 'Plataforma/Utilidades/Session.php';

if (!isset($_SESSION['idUser'])) {
    session_regenerate_id(true);
    header("Location: ../");
} else {
    $controladorEstudiante = new EstudianteController();
    $ExamenModel = new ExamenModel();
    $Estudiante = $controladorEstudiante->getEstudianteById($session->getCurrentId());
    $fechaAhora = date('Y-m-d');

    $FechaExamen = $Estudiante->getExamenTeorico();
    $Estado = "";

    if (($fechaAhora >=  $FechaExamen) && ($FechaExamen != "0000-00-00")) {
        $Estado = 'Activo';
    } else {
        $Estado = 'Inactivo';
    }

    
    $resultMessage = '';
    $EstudianteModel = new EstudianteModel();
    $controladorEstudiante = new EstudianteController();
    $ExamenModel = new ExamenModel();
    $controladorExamen = new ExamenController();
    $session = new Session();

    $ExamenEstudiante1 = $controladorExamen->getExamenEstudianteById($session->getCurrentId(),1);
    $ExamenEstudiante2 = $controladorExamen->getExamenEstudianteById($session->getCurrentId(),2);
    $ExamenEstudiante3 = $controladorExamen->getExamenEstudianteById($session->getCurrentId(),3);
    $ExamenEstudiante4 = $controladorExamen->getExamenEstudianteById($session->getCurrentId(),4);
    $ExamenEstudiante5 = $controladorExamen->getExamenEstudianteById($session->getCurrentId(),5);

    $nota1 = $ExamenEstudiante1->getNota();
    $nota2 = $ExamenEstudiante2->getNota();
    $nota3 = $ExamenEstudiante3->getNota();
    $nota4 = $ExamenEstudiante4->getNota();
    $nota5 = $ExamenEstudiante5->getNota();

    $notas =[$nota1,$nota2, $nota3,$nota4,$nota5];
    $notaE1 = 0; $notaE2 = 0;$notaE3= 0;$notaE4= 0;$notaE5=0;
    if($nota1 !='' && $nota1>=0){
        $notaE1 = $nota1;
    }else{
        $notaE1 = 'No se ha realizado';
    }
    if($nota2 !='' && $nota2>=0){
        $notaE2 = $nota2;
    }else{
        $notaE2 = 'No se ha realizado';
    }

    if($nota3 !='' && $nota3>=0){
        $notaE3 = $nota3;
    }else{
        $notaE3 = 'No se ha realizado';
    }

    if($nota4 !='' && $nota4>=0){
        $notaE4 = $nota4;
    }else{
        $notaE4 = 'No se ha realizado';
    }

    if($nota5 !='' && $nota5>=0){
        $notaE5 = $nota5;
    }else{
        $notaE5 = 'No se ha realizado';
    }
 



    if (isset($_POST['Examen'])) {
        $Examen = $_POST['Examen'];
        $Estado = $_POST['estado'];
        $fecha = Date("Y-m-d H:i:s");
        //set de IdExamen en variable de Session
        $IdExamen = $Examen;
        $id = $session->setIdExamen($IdExamen); // Obtiene el id del examen enviado por medio del POST

        $idEstudiante = $session->getCurrentId();
        $IntentosExamen = $controladorExamen->CantidadIntentoExamen($idEstudiante);
        $IntentoPorExamen = $controladorExamen->limitarIntentoPorExamen($idEstudiante, $Examen);
        $ExamenEstudiante = $controladorExamen->ValidarRealizarExamen($idEstudiante, $IntentosExamen);
        $FechaProximoIntento =  $ExamenEstudiante->getFechaFutura();
        $FechaHora = $controladorExamen->HoraFecha($idEstudiante, $IntentosExamen);
        $Horafutura = $FechaHora->getHoraFutura();
        $SoloFecha = $FechaHora->getSolofecha();
        $fechaFutura = date("Y-m-d  H:i:s", strtotime(" +1 day"));
        $Tiempo = 1200;
        if ($Estado == "Activo") {
            if ($Examen == 1) {
                if ($IntentosExamen >= 0 && $IntentosExamen < 3) { // se limita el numero de intentos a no mayor de 3
                    if (is_numeric($IntentoPorExamen) && $IntentoPorExamen == 0) { //Se limita el intento a solo 1 vez por examen
                        if ($IntentosExamen == 0) { // Si el intento es el primero a realizar no se comparan las fechas
                            $result = $controladorExamen->InsertaExamenEstudiante($fecha, $fechaFutura, $IntentosExamen + 1, "",  $Examen, $idEstudiante, $Tiempo,$IntentoPorExamen);
                            if ($result) {
                                header("Location: index.php?modulo=$Examen");
                            } else
                                echo "<script>alert('Lo sentimos, algo salio mal recargue la pagina e intentelo de nuevo');</script>";
                            // header("Location: ../../index.php?modulo=Examen_1");
                        } else {
                            if ($fecha >= $FechaProximoIntento) { // comparar fecha actual con fechafutara(la fecha en que se realizo el examen mas 1 dia) si se ha realizad ya un examen
                                $result = $controladorExamen->InsertaExamenEstudiante($fecha, $fechaFutura, $IntentosExamen + 1, "",  $Examen, $idEstudiante, $Tiempo,$IntentoPorExamen);
                                if ($result) {
                                    header("Location: index.php?modulo=$Examen");
                                } else
                                    echo "<script>alert('Lo sentimos, algo salio mal recargue la pagina e intentelo de nuevo');</script>";
                            } else {
                                $resultMessage = 'proximoIntento';
                            }
                        }
                    } else {
                        $resultMessage = 'Realizado';
                    }
                } else {
                    $resultMessage = 'noMasIntentos';
                }
            } else if ($Examen == 2) {
                if ($IntentosExamen >= 0 && $IntentosExamen < 3) { // se limita el numero de intentos a no mayor de 3
                    if (is_numeric($IntentoPorExamen) && $IntentoPorExamen == 0) { //Se limita el intento a solo 1 vez por examen
                        if ($IntentosExamen == 0) { // Si el intento es el primero a realizar no se comparan las fechas
                            $result = $controladorExamen->InsertaExamenEstudiante($fecha, $fechaFutura, $IntentosExamen + 1, "",  $Examen, $idEstudiante, $Tiempo,$IntentoPorExamen);
                            if ($result) {
                                header("Location: index.php?modulo=$Examen");
                            } else
                                echo "<script>alert('Lo sentimos, algo salio mal recargue la pagina e intentelo de nuevo');</script>";
                        } else {
                            if ($fecha >= $FechaProximoIntento) { // comparar fecha actual con fechafutara(la fecha en que se realizo el examen mas 1 dia) si se ha realizad ya un examen
                                $result = $controladorExamen->InsertaExamenEstudiante($fecha, $fechaFutura, $IntentosExamen + 1, "",  $Examen, $idEstudiante, $Tiempo,$IntentoPorExamen);
                                if ($result) {
                                    header("Location: index.php?modulo=$Examen");
                                } else
                                    echo "<script>alert('Lo sentimos, algo salio mal recargue la pagina e intentelo de nuevo');</script>";
                            } else {
                                $resultMessage = 'proximoIntento';
                            }
                        }
                    } else {
                        $resultMessage = 'Realizado';
                    }
                } else {
                    $resultMessage = 'noMasIntentos';
                }
            } else if ($Examen == 3) {
                if ($IntentosExamen >= 0 && $IntentosExamen < 3) { // se limita el numero de intentos a no mayor de 3
                    if (is_numeric($IntentoPorExamen) && $IntentoPorExamen == 0) { //Se limita el intento a solo 1 vez por examen
                        if ($IntentosExamen == 0) { // Si el intento es el primero a realizar no se comparan las fechas
                            $result = $controladorExamen->InsertaExamenEstudiante($fecha, $fechaFutura, $IntentosExamen + 1, "",  $Examen, $idEstudiante, $Tiempo,$IntentoPorExamen);
                            if ($result) {
                                header("Location: index.php?modulo=$Examen");
                            } else
                                echo "<script>alert('Lo sentimos, algo salio mal recargue la pagina e intentelo de nuevo');</script>";
                        } else {
                            if ($fecha >= $FechaProximoIntento) { // comparar fecha actual con fechafutara(la fecha en que se realizo el examen mas 1 dia) si se ha realizad ya un examen
                                $result = $controladorExamen->InsertaExamenEstudiante($fecha, $fechaFutura, $IntentosExamen + 1, "",  $Examen, $idEstudiante, $Tiempo,$IntentoPorExamen);
                                if ($result) {
                                    header("Location: index.php?modulo=$Examen");
                                } else
                                    echo "<script>alert('Lo sentimos, algo salio mal recargue la pagina e intentelo de nuevo');</script>";
                            } else {
                                $resultMessage = 'proximoIntento';
                            }
                        }
                    } else {
                        $resultMessage = 'Realizado';
                    }
                } else {
                    $resultMessage = 'noMasIntentos';
                }
            } else if ($Examen == 4) {
                if ($IntentosExamen >= 0 && $IntentosExamen < 3) { // se limita el numero de intentos a no mayor de 3
                    if (is_numeric($IntentoPorExamen) && $IntentoPorExamen == 0) { //Se limita el intento a solo 1 vez por examen
                        if ($IntentosExamen == 0) { // Si el intento es el primero a realizar no se comparan las fechas
                            $result = $controladorExamen->InsertaExamenEstudiante($fecha, $fechaFutura, $IntentosExamen + 1, "",  $Examen, $idEstudiante, $Tiempo,$IntentoPorExamen);
                            if ($result) {
                                header("Location: index.php?modulo=$Examen");
                            } else
                                echo "<script>alert('Lo sentimos, algo salio mal recargue la pagina e intentelo de nuevo');</script>";
                        } else {
                            if ($fecha >= $FechaProximoIntento) { // comparar fecha actual con fechafutara(la fecha en que se realizo el examen mas 1 dia) si se ha realizad ya un examen
                                $result = $controladorExamen->InsertaExamenEstudiante($fecha, $fechaFutura, $IntentosExamen + 1, "",  $Examen, $idEstudiante, $Tiempo,$IntentoPorExamen);
                                if ($result) {
                                    header("Location: index.php?modulo=$Examen");
                                } else
                                    echo "<script>alert('Lo sentimos, algo salio mal recargue la pagina e intentelo de nuevo');</script>";
                            } else {
                                $resultMessage = 'proximoIntento';
                            }
                        }
                    } else {
                        $resultMessage = 'Realizado';
                    }
                } else {
                    $resultMessage = 'noMasIntentos';
                }
            } else if ($Examen == 5) {
                if ($IntentosExamen >= 0 && $IntentosExamen < 3) { // se limita el numero de intentos a no mayor de 3
                    if (is_numeric($IntentoPorExamen) && $IntentoPorExamen == 0) { //Se limita el intento a solo 1 vez por examen
                        if ($IntentosExamen == 0) { // Si el intento es el primero a realizar no se comparan las fechas
                            $result = $controladorExamen->InsertaExamenEstudiante($fecha, $fechaFutura, $IntentosExamen + 1, "",  $Examen, $idEstudiante, $Tiempo,$IntentoPorExamen);
                            if ($result) {
                                header("Location: index.php?modulo=$Examen");
                            } else
                                echo "<script>alert('Lo sentimos, algo salio mal recargue la pagina e intentelo de nuevo');</script>";
                        } else {
                            if ($fecha >= $FechaProximoIntento) { // comparar fecha actual con fechafutara(la fecha en que se realizo el examen mas 1 dia) si se ha realizad ya un examen
                                $result = $controladorExamen->InsertaExamenEstudiante($fecha, $fechaFutura, $IntentosExamen + 1, "",  $Examen, $idEstudiante, $Tiempo,$IntentoPorExamen);
                                if ($result) {
                                    header("Location: index.php?modulo=$Examen");
                                } else
                                    echo "<script>alert('Lo sentimos, algo salio mal recargue la pagina e intentelo de nuevo');</script>";
                            } else {
                                $resultMessage = 'proximoIntento';
                            }
                        }
                    } else {
                        $resultMessage = 'Realizado';
                    }
                } else {
                    $resultMessage = 'noMasIntentos';
                }
            }
        } else {
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
                                 Aun no ha llegado la fecha para su examen
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
    }
}
?>

<div class="principal-section">
    <div class="container-fluid estudiante">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <form method="POST" autocomplete="off">
                    <!-- inicio de formulario -->
                    <div class="header-box-examen text-white mb-4 text-center">
                        <h5>Examen Teórico</h5>
                    </div>
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        </div>
                    </div>
                    <div class="container-fluid verExamen" style="background-color: #fff;">
                        <div class="row">
                            <div class="col-xl-3 my-4">
                                <div class="contenedor-examen shadow-sm">
                                    <div class="container titulo-examen text-center ">
                                        <label class="text-color text-center " for="">Examen #1</label>
                                    </div>
                                    <div class="container-fluid examenes">
                                        <label class="text-color " for=""> <span class="font-weight-bold"> Tipo Examen: </span><?php $controladorExamen = new ExamenController();
                                                                                                                                $Examen = $controladorExamen->getExamenById(1);
                                                                                                                                echo $Examen->getTipoExamen(); ?></label><br>
                                        <!-- <label class="text-color" for=""> <span class="font-weight-bold">Fecha: </span><?php echo $FechaExamen ?></label><br> -->
                                        <label class="text-color" for=""><span class="font-weight-bold">Estado:</span> <?php echo $Estado ?></label><br>
                                        <label class="text-color" for=""> <span class="font-weight-bold">Nota: </span><?php echo $notaE1 ?></label><br>


                                        <!-- <span><?php echo $FechaExamen . " = " . $fechaAhora . "<br>" ?> </span>
                                    <span><?php echo date("Y-m-d H:i:s", strtotime(" +1 day"));   ?> </span>-->

                                    </div>
                                    <div class="botton text-center">
                                        <button type="submit" name="Examen" value="1" id="Examen-1" class="btn examen btn-primary mt-2 mb-2"> Realizar Examen</button>
                                        <input type="hidden" name="tipo-examen" value="A">
                                        <input type="hidden" name="id-examen" value="1">
                                        <input type="hidden" name="estado" id="estado" value=<?php echo $Estado ?>>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 my-4">
                                <div class="contenedor-examen shadow-sm">
                                    <div class="container titulo-examen text-center ">
                                        <label class=" text-color text-center" for="">Examen #2</label>
                                    </div>
                                    <div class="container examenes ">
                                        <label class="text-color " for=""> <span class="font-weight-bold"> Tipo Examen: </span><?php $controladorExamen = new ExamenController();
                                                                                                                                $Examen = $controladorExamen->getExamenById(2);
                                                                                                                                echo $Examen->getTipoExamen(); ?></label><br>
                                        <label class="text-color" for=""> <span class="font-weight-bold">Estado: </span><?php echo $Estado ?></label><br>
                                        <label class="text-color" for=""> <span class="font-weight-bold">Nota: </span><?php echo $notaE2 ?></label><br>

                                    </div>
                                    <div class="botton text-center">
                                        <button type="submit" name="Examen" id="Examen-2" value="2" class="btn btn-primary mt-2 mb-2"> Realizar Examen</button>
                                        <input type="hidden" name="tipo-examen" value="B">
                                        <input type="hidden" name="id-examen" value="2">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 my-4">
                                <div class="contenedor-examen shadow-sm">
                                    <div class="container titulo-examen  text-center ">
                                        <label class="text-color text-color text-center" for="">Examen #3</label>
                                    </div>
                                    <div class="container examenes">
                                        <label class="text-color " for=""> <span class="font-weight-bold"> Tipo Examen: </span> <?php $controladorExamen = new ExamenController();
                                                                                                                                $Examen = $controladorExamen->getExamenById(3);
                                                                                                                                echo $Examen->getTipoExamen(); ?></label><br>
                                        <label class="text-color" for=""> <span class="font-weight-bold">Estado: </span><?php echo $Estado ?></label><br>
                                        <label class="text-color" for=""> <span class="font-weight-bold">Nota: </span><?php echo $notaE3 ?></label><br>

                                    </div>
                                    <div class="botton text-center">
                                        <button type="submit" name="Examen" id="Examen-3" value="3" class="btn btn-primary mt-2 mb-2"> Realizar Examen</button>
                                        <input type="hidden" name="tipo-examen" value="C">
                                        <input type="hidden" name="id-examen" value="3">
                                    </div>
                                </div>

                            </div>
                            <div class="col-xl-3 my-4">
                                <div class="contenedor-examen shadow-sm">
                                    <div class="text-color container titulo-examen text-center ">
                                        <label class="text-center" for="">Examen #4</label>
                                    </div>
                                    <div class="container examenes">
                                        <label class="text-color " for=""> <span class="font-weight-bold"> Tipo Examen: </span><?php $controladorExamen = new ExamenController();
                                                                                                                                $Examen = $controladorExamen->getExamenById(4);
                                                                                                                                echo $Examen->getTipoExamen(); ?></label><br>
                                        <label class="text-color" for=""> <span class="font-weight-bold">Estado: </span><?php echo $Estado ?></label><br>
                                        <label class="text-color" for=""> <span class="font-weight-bold">Nota: </span><?php echo $notaE4 ?></label><br>

                                    </div>
                                    <div class="botton text-center">
                                        <button type="submit" name="Examen" id="Examen-4" value="4" class="btn btn-primary mt-2 mb-2"> Realizar Examen</button>
                                        <input type="hidden" name="tipo-examen" value="D">
                                        <input type="hidden" name="id-examen" value="4">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 mb-4">
                                <div class="contenedor-examen shadow-sm">
                                    <div class="text-color container titulo-examen text-center ">
                                        <label class="text-center" for="">Examen #5</label>
                                    </div>
                                    <div class="container examenes ">
                                        <label class="text-color " for=""> <span class="font-weight-bold"> Tipo Examen: </span><?php $controladorExamen = new ExamenController();
                                                                                                                                $Examen = $controladorExamen->getExamenById(5);
                                                                                                                                echo $Examen->getTipoExamen(); ?></label><br>
                                        <label class="text-color" for=""> <span class="font-weight-bold">Estado: </span><?php echo $Estado ?></label><br>
                                        <label class="text-color" for=""> <span class="font-weight-bold">Nota: </span><?php echo $notaE5 ?></label><br>

                                    </div>
                                    <div class="botton text-center">
                                        <button type="submit" name="Examen" id="Examen-5" value="5" class="btn btn-primary mt-2 mb-2"> Realizar Examen</button>
                                        <input type="hidden" name="tipo-examen" value="E">
                                        <input type="hidden" name="id-examen" value="5">
                                        <input type="hidden" name="actualizar" value="5">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="Plataforma/js/verExamen.js"></script>


<?php
if ($resultMessage == "Realizado") {
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
                            Usted ya realizo este Examen intente con uno diferente
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
} else if ($resultMessage == "proximoIntento") {
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
                    Usted ya realizo un examen el día de hoy, podrá volver a intentarlo el dia ' . $SoloFecha . '  a las ' . $Horafutura . '
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
} else if ($resultMessage == "noMasIntentos") {
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
                        ya no tiene mas intentos para realizar el examen
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