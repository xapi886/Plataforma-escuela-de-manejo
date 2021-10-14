<!-- Proceso de gestion de examen -->
<?php
try {
    // Obtengo el id del examen desde la peticion get
    $id_question = $_REQUEST['question'] ?? '';
    $id_test = $_REQUEST['test'] ?? '';

    // Inclusion de clases modelos, controladoras y de conexion
    include_once('../Utilidades/conexion.php');
    include_once('../Utilidades/confiDev.php');
    include_once('../Controladores/TestController.php');
    include_once('../Modelos/TestModel.php');

    // Instancia de la clase controladora TestController
    $testController = new TestController();

    // Obtencion de todas las preguntas del examen segun el id
    $question = $testController->getQuestionById($id_question);

    // Obtencion del tipo de examen
    $type = $testController->getTypeOfTest($id_test);
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
    <link href="../css/style-pregunta-item.css" rel="stylesheet">

    <script src="../../js/jquery-3.5.1.min.js"></script>
    <script src="../../js/popper.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <script src="../../js/aos.js"></script>
    <script src="../../js/fontawesome.js"></script>

    <title>Escuela de Manejo Century</title>
</head>

<body background="../img/backgrounds/info-min.png">
    <!-- Contenedor de la ventana Modal -->
    <div class="modal show" id="estudiante-modal" tabindex="-1" role="dialog">
        <!-- Ventana Modal -->
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <a href="/admin/vistas/gestion-examen.php?test=<?php echo $id_test ?>" id="btn-back" class="btn btn-primary btn-sm">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <h4 class="modal-title m-auto font-weight-bold" style="text-align: center;">Examen <?php echo $type; ?></h4>
                </div>
                <div class="modal-body principal">
                    <form style="padding: 0 50px;">
                        <div>
                            <label for="">&#8594;<?php echo $question; ?></label>
                        </div>
                        <div class="form-group principal">
                            <label for="">Agregue el nuevo ítem</label>
                            <input type="hidden" id="id-test" name="id-test" value="<?php echo $id_test; ?>">
                            <input type="hidden" id="id-question" name="id-question" value="<?php echo $id_question; ?>">
                            <input type="text" class="form-input d-block w-100" id="txt-add-item">
                            <small class="form-text text-muted">Cuando tenga listo el ítem, de click en Agregar</small>
                        </div>
                        <div class="modal-footer border-0 d-flex justify-content-center">
                            <a href="/admin/vistas/gestion-examen.php?test=<?php echo $id_test; ?>" type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancelar</a>
                            <button id="btn-add-item" class="btn btn-primary btn-sm">Agregar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script type="text/javascript" src="../js/item-pregunta.js"></script>
</body>

</html>