<!-- Proceso de gestion de examen -->
<?php
try {
    // Obtengo el id del examen desde la peticion get
    $id_test = $_REQUEST['test'] ?? '';

    // Inclusion de clases modelos, controladoras y de conexion
    include_once('../Utilidades/conexion.php');
    include_once('../Utilidades/confiDev.php');
    include_once('../Controladores/TestController.php');
    include_once('../Modelos/TestModel.php');

    // Instancia de la clase controladora TestController
    $testController = new TestController();

    // Obtencion de todas las preguntas del examen segun el id del examen
    $questions = $testController->getTestQuestionsById($id_test);

    // Obtencion del tipo de examen
    $type = $testController->getTypeOfTest($id_test);

    // Conteo de preguntas
    $count = 0;
    $countP = 0;

} catch (Throwable $th) {
    // Mensaje de error
    echo "<script>alert('" . $th->getMessage() . "');</script>";
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
    <link href="../css/gestion-examen.css" rel="stylesheet">

    <script src="../../js/jquery-3.5.1.min.js"></script>
    <script src="../../js/popper.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <script src="../../js/aos.js"></script>
    <script src="../../js/fontawesome.js"></script>

    <title>Escuela de Manejo Century</title>
</head>

<body background="../img/backgrounds/info-min.png">
    <!-- Contenedor de ventana modal -->
    <div class="modal show" id="estudiante-modal" tabindex="-1" role="dialog">
        <!-- Ventana Modal -->
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <a href="/admin/?modulo=examenes" id="btn-back" class="btn btn-primary btn-sm">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <h4 class="modal-title m-auto font-weight-bold" style="text-align: center;">Examen <?php echo $type; ?></h4>
                </div>
                <div class="modal-body principal">
                    <!-- Division de informacion -->
                    <div>
                        <div class="d-flex justify-content-between">
                            <h5 class="pr-4 pl-4 font-weight-bold">Preguntas</h5>
                            <a href="/admin/vistas/pregunta-examen.php?test=<?php echo $id_test; ?>" class="mr-4 ml-4 btn btn-primary btn-sm">Agregar pregunta</a>
                        </div>

                        <div id="accordion" style="font-size: 14px;">

                            <?php foreach ($questions as $item) : ?>
                                <input type="hidden" id="count-preguntas" value=<?php (++$countP)?>>
                                <div class="card border-0">
                                    <div class="card-header d-flex justify-content-between" id="headingOne" style="background-color: #ffffff;">
                                        <button class="btn btn-link text-truncate" data-toggle="collapse" data-target="#collapse<?php echo $item['IdPregunta']; ?>" aria-expanded="true" aria-controls="collapse<?php echo $item['IdPregunta']; ?>" style="font-size: 14px; max-width: 500px;" data-toggle="tooltip" data-placement="bottom" title="<?php echo $item['Preguntas']; ?>" data-button-link="wrap">
                                            <?php echo (++$count) . "."; ?>&nbsp;&nbsp;&nbsp;<?php echo $item['Preguntas']; ?>
                                        </button>
                                        <div class="execute-display">
                                            <a href="/admin/vistas/item-pregunta.php?question=<?php echo $item['IdPregunta']; ?>&test=<?php echo $id_test; ?>" class="btn btn-light btn-sm" style="height: 33px; font-size: 12px; padding-top: 6px;" data-type-button="square">
                                                <i class="fas fa-plus"></i><span class="show">&nbsp;&nbsp;Agregar ítem</span>
                                            </a>
                                            <button class="btn btn-light" style="width: 33px; height: 33px; border-radius: 100%;" onclick="showModalQuestionEdit(<?php echo $item['IdPregunta']; ?>)">
                                                <i class="fas fa-pen d-flex justify-content-center align-items-center"></i>
                                            </button>
                                            <button class="btn btn-light" style="width: 33px; height: 33px; border-radius: 100%;" onclick="showModalQuestionImage(<?php echo $item['IdPregunta']; ?>)">
                                                <i class="fas fa-images d-flex justify-content-center align-items-center"></i>
                                            </button>
                                            <button class="btn btn-light" style="width: 33px; height: 33px; border-radius: 100%;" onclick="showModalQuestionDelete(<?php echo $item['IdPregunta']; ?>)">
                                                <i class="fas fa-trash-alt d-flex justify-content-center align-items-center"></i>
                                            </button>
                                        </div>
                                    </div>

                                    

                                    <div id="collapse<?php echo $item['IdPregunta']; ?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                                        <div class="card-body pt-0 pb-0">

                                            <!-- Proceso de gestion de pregunta -->
                                            <?php
                                            try {
                                                // Obtengo el id de pregunta desde el foreach anterior
                                                $id_question = (int) $item['IdPregunta'] ?? '';

                                                // Obtencion de todas las preguntas del examen segun el id
                                                $answers = $testController->getQuestionAnswersById($id_question);
                                            } catch (Throwable $th) {
                                                // Mensaje de error
                                                echo "<script>alert('" . $th->getMessage() . "');</script>";
                                            }
                                            ?>

                                            <?php foreach ($answers as $item) : ?>
                                                <div class="p-2 ml-4 border-bottom d-flex justify-content-between align-items-center execute-display-items">
                                                    <div class="text-truncate" style="max-width: 500px;" data-toggle="tooltip" data-placement="bottom" title="<?php echo $item['Respuesta']; ?>">
                                                        <?php echo $item['Respuesta']; ?>
                                                    </div>
                                                    <div class="execute-display-items-control">
                                                        <button class="btn btn-light d-inline-block" style="width: 33px; height: 33px; border-radius: 100%;" onclick="showModalAnswerEdit(<?php echo $item['IdRespuestas']; ?>)">
                                                            <i class="fas fa-pen d-flex justify-content-center align-items-center"></i>
                                                        </button>
                                                        <button class="btn btn-light d-inline-block" style="width: 33px; height: 33px; border-radius: 100%;" onclick="showModalAnswerDelete(<?php echo $item['IdRespuestas']; ?>)">
                                                            <i class="fas fa-trash-alt d-flex justify-content-center align-items-center"></i>
                                                        </button>
                                                        <div class="custom-control custom-radio d-inline-block flag-question<?php echo $id_question; ?> flag-answer<?php echo $item['IdRespuestas']; ?>" style="vertical-align: middle;" data-toggle="tooltip" title="<?php echo $item['Correcta'] == 1 ? 'Establecida como respuesta correcta' : 'Establecer como respuesta correcta'; ?>">
                                                            <input type="radio" id="radio<?php echo $item['IdRespuestas']; ?>" name="radio-group<?php echo $id_question; ?>" class="custom-control-input" <?php echo $item['Correcta'] == 1 ? 'checked' : ''; ?> onchange="radioButtonsChangeEvent(<?php echo $id_question; ?>, <?php echo $item['IdRespuestas']; ?>)">
                                                            <label class="custom-control-label" for="radio<?php echo $item['IdRespuestas']; ?>"></label>
                                                        </div>
                                                    </div>
                                                </div>

                                            <?php endforeach; ?>

                                        </div>
                                    </div>
                                </div>

                            <?php endforeach; ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ----------------------------------------------------- -->
    <!-- Ventanas Modales de Preguntas -->
    <!-- Ventana de edicion -->
    <div id="modal-editar" class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="background-color: rgba(0, 0, 0, 0.5);">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar pregunta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="txt-editar" class="col-form-label">Edite la pregunta:</label>
                            <input type="text" class="form-control" id="txt-editar">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
                    <button id="btn-modal-editar" type="button" class="btn btn-primary btn-sm">Actualizar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- ----------------------------------------------------- -->
    <!-- Ventana de imagen -->
    <div id="modal-imagen" class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="background-color: rgba(0, 0, 0, 0.5);">
        <div class="modal-dialog" role="document" style="max-width: 500px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Agregar imagen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Subir archivo</span>
                            </div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="input-file" accept=".png, .jpg, .jpeg">
                                <label id="label-input-file" class="custom-file-label text-truncate" for="input-file">
                                    <span id="inside-label-input-file">Archivo...</span>
                                </label>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <img id="test-images" src="../img/tests/00001_TEMPLATE.svg" alt="Imagen de examen de transito">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
                    <button id="btn-modal-imagen" type="button" class="btn btn-primary btn-sm">Actualizar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- ----------------------------------------------------- -->
    <!-- Ventana de eliminacion -->
    <div id="modal-eliminar" class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="background-color: rgba(0, 0, 0, 0.5);">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Eliminar pregunta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger">
                        ¿Estás seguro de eliminar pregunta?
                        <div><small>&#8594;Se perderán todos los datos relacionados a la pregunta</small></div>
                        <small id="deleting"></small>
                    </div>
                    <span class="text-muted pr-3 pl-3 d-inline-block text-truncate" style="max-width: 400px;">
                        &#8594;<small id="pregunta"></small>                        
                    </span>                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
                    <button id="btn-modal-eliminar" type="button" class="btn btn-danger btn-sm">Eliminar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- ----------------------------------------------------- -->

    <!-- ----------------------------------------------------- -->
    <!-- Ventanas Modales de Items de Preguntas -->
    <!-- Ventana de edicion -->
    <div id="modal-editar-item-pregunta" class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="background-color: rgba(0, 0, 0, 0.5);">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar pregunta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="txt-editar-item-pregunta" class="col-form-label">
                                <strong>Edite ítem de pregunta:&nbsp;</strong>
                            </label>
                            <input type="text" class="form-control" id="txt-editar-item-pregunta">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
                    <button id="btn-modal-editar-item-pregunta" type="button" class="btn btn-primary btn-sm">Actualizar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- ----------------------------------------------------- -->
    <!-- Ventana de eliminacion -->
    <div id="modal-eliminar-item-pregunta" class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="background-color: rgba(0, 0, 0, 0.5);">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Eliminar pregunta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger">
                        ¿Estás seguro de eliminar ítem de pregunta?
                        <div><small id="deleting-item"></small></div>
                    </div>
                    <span class="text-muted pr-3 pl-3 d-inline-block text-truncate" style="max-width: 400px;">
                        &#8594;<small id="label-eliminar-item-pregunta"></small>
                    </span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
                    <button id="btn-modal-eliminar-item-pregunta" type="button" class="btn btn-danger btn-sm">Eliminar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- ----------------------------------------------------- -->

    <!-- Scripts -->
    <script type="text/javascript" src="../js/gestion-examen.js"></script>
</body>

</html>