<!-- Proceso de gestion de datos de tabla -->
<?php
try {
    // Consulta del numero total de registros de tabla examen_estudiante
    $record_size = $testController->rowCountStudentExams();

    // Numero total de paginas, 15 es el numero constante de filas que se mostraran por pagina
    $total_pages = ceil($record_size / 6);
    // Paginacion de registros
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    // Partida de obtencion de los registros
    $offset = ($page - 1) * 6;
    // Otencion de registros de estudiantes
    //echo "--------------------------------------------------------------" . $record_size . " " . $total_pages . " " . $page;
    //echo "la varible offset es: " . $offset . " ";
    //echo '<br>';
    // Conteo de numero de registros
    $count = $offset + 1;
    
} catch (Throwable $th) {
    echo ($th->getMessage());
}
?>
<!-- 
     Entrada de datos para recuperar los registros de la pagina
     actual cuando se esta buscando a un estudiante por texto  -->
<input id="offset" type="hidden" name="offset" value="<?php echo $offset; ?>">


<link rel="stylesheet" href="css/examenes.css">
<div class="principal-section">
    <!-- Seccion de cabecera -->
    <header class="header-box text-white text-center">Gestión de Exámenes</header>
    <!-- Seccion principal -->
    <main>
        <!-- Seccion de campo de entrada -->

        <div id="search-controls" class="d-none justify-content-between align-items-center mb-2" style="width: 100%;">
            <input class="form-input w-50" type="text" id="txt-search-examenes" placeholder="Buscar Estudiante" style="padding: 5px 30px;">

            <nav id="pagination-container" class="d-flex justify-content-right align-items-center">
                <span id="info-table" class="ml-4 mr-2">
                    <span class="text-primary"><?php echo $page; ?></span>&nbsp;de&nbsp;<span class="text-primary"><?php echo $total_pages ?></span>&nbsp;páginas,&nbsp;<span class="text-primary"><?php echo $record_size ?></span>&nbsp;tarjetas
                </span>
                <ul class="pagination m-0">
                    <li class="page-item">
                        <a class="page-link <?php echo ($page == 1) ? "disabled-link" : ""; ?>" href="<?php echo ($page == 1) ? "javascript:void(0)" : "/admin/?modulo=examenes&page=" . ($page - 1); ?>" aria-label="Previous" data-toggle="tooltip" data-placement="bottom" title="Página anterior">
                            <span aria-hidden="true">&lsaquo;</span>
                            <span class="sr-only">Anterior</span>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link <?php echo ($page == 1) ? "disabled-link" : "" ?>" href="/admin/?modulo=examenes&page=1" data-toggle="tooltip" data-placement="bottom" title="Primera página" id="firts-page">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Primero</span>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link <?php echo ($page == $total_pages) ? "disabled-link" : "" ?>" href="/admin/?modulo=examenes&page=<?php echo $total_pages; ?>" data-toggle="tooltip" data-placement="bottom" title="Última página" id="last-page">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Último</span>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link <?php echo ($page == $total_pages) ? "disabled-link" : "" ?>" href="<?php echo ($page == $total_pages) ? "javascript:void(0)" : "/admin/?modulo=examenes&page=" . ($page + 1); ?>" aria-label="Next" data-toggle="tooltip" data-placement="bottom" title="Página siguiente" id="next-page">
                            <span aria-hidden="true">&rsaquo;</span>
                            <span class="sr-only">Siguiente</span>
                        </a>
                    </li>
                </ul>
            </nav>

        </div>
        <!-- Seccion de pestañas -->
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active" id="nav-results-tab" data-toggle="tab" href="#nav-results" role="tab" aria-controls="nav-results" aria-selected="false">Resultados de Exámenes</a>
                <a class="nav-item nav-link" id="nav-tests-tab" data-toggle="tab" href="#nav-tests" role="tab" aria-controls="nav-tests" aria-selected="true">Exámenes</a>
            </div>
        </nav>
        <!-- Seccion de ítems por pestañas -->
        <div id="tabs-container" class="tab-content bg-white border-bottom border-left border-right p-4 rounded-bottom box-shadow" id="nav-tabContent" style="min-height:35rem;">
            <!-- Seccion pestaña Examenes -->
            <div class="tab-pane fade   d-flex" id="nav-tests" role="tabpanel" aria-labelledby="nav-tests-tab">
                <!-- Seccion de carta -->
                <div class="card bg-light m-2" style="width: 17rem;">
                    <div class="card-header text-center">Examen A</div>
                    <div class="card-body p-3">
                        <div>
                            <dl class="row mb-0" style="font-size: 12px;">
                                <dt class="col-sm-7">Tipo Examen:</dt>
                                <dd class="col-sm-5">Teórico</dd>
                            </dl>
                            <dl class="row mb-0" style="font-size: 12px;">
                                <dt class="col-sm-7">Estado:</dt>
                                <dd class="col-sm-5">Activo</dd>
                            </dl>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent text-right">
                        <a href="/admin/vistas/gestion-examen.php?test=1" class="btn btn-primary btn-sm" target="_blank">Editar</a>
                    </div>
                </div>
                <!-- Seccion de carta -->
                <div class="card bg-light m-2" style="width: 17rem;">
                    <div class="card-header text-center">Examen B</div>
                    <div class="card-body p-3">
                        <div>
                            <dl class="row mb-0" style="font-size: 12px;">
                                <dt class="col-sm-7">Tipo Examen:</dt>
                                <dd class="col-sm-5">Teórico</dd>
                            </dl>
                            <dl class="row mb-0" style="font-size: 12px;">
                                <dt class="col-sm-7">Estado:</dt>
                                <dd class="col-sm-5">Activo</dd>
                            </dl>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent text-right">
                        <a href="/admin/vistas/gestion-examen.php?test=2" class="btn btn-primary btn-sm" target="_blank">Editar</a>
                    </div>
                </div>
                <!-- Seccion de carta -->
                <div class="card bg-light m-2" style="width: 17rem;">
                    <div class="card-header text-center">Examen C</div>
                    <div class="card-body p-3">
                        <div>
                            <dl class="row mb-0" style="font-size: 12px;">
                                <dt class="col-sm-7">Tipo Examen:</dt>
                                <dd class="col-sm-5">Teórico</dd>
                            </dl>
                            <dl class="row mb-0" style="font-size: 12px;">
                                <dt class="col-sm-7">Estado:</dt>
                                <dd class="col-sm-5">Activo</dd>
                            </dl>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent text-right">
                        <a href="/admin/vistas/gestion-examen.php?test=3" class="btn btn-primary btn-sm" target="_blank">Editar</a>
                    </div>
                </div>
                <!-- Seccion de carta -->
                <div class="card bg-light m-2" style="width: 17rem;">
                    <div class="card-header text-center">Examen D</div>
                    <div class="card-body p-3">
                        <div>
                            <dl class="row mb-0" style="font-size: 12px;">
                                <dt class="col-sm-7">Tipo Examen:</dt>
                                <dd class="col-sm-5">Teórico</dd>
                            </dl>
                            <dl class="row mb-0" style="font-size: 12px;">
                                <dt class="col-sm-7">Estado:</dt>
                                <dd class="col-sm-5">Activo</dd>
                            </dl>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent text-right">
                        <a href="/admin/vistas/gestion-examen.php?test=4" class="btn btn-primary btn-sm" target="_blank">Editar</a>
                    </div>
                </div>
                <!-- Seccion de carta -->
                <div class="card bg-light m-2" style="width: 17rem;">
                    <div class="card-header text-center">Examen E</div>
                    <div class="card-body p-3">
                        <div>
                            <dl class="row mb-0" style="font-size: 12px;">
                                <dt class="col-sm-7">Tipo Examen:</dt>
                                <dd class="col-sm-5">Teórico</dd>
                            </dl>
                            <dl class="row mb-0" style="font-size: 12px;">
                                <dt class="col-sm-7">Estado:</dt>
                                <dd class="col-sm-5">Activo</dd>
                            </dl>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent text-right">
                        <a href="/admin/vistas/gestion-examen.php?test=5" class="btn btn-primary btn-sm" target="_blank">Editar</a>
                    </div>
                </div>
            </div>

            <!-- SECCION DE RESULTADOS DE EXAMENES-->
            <!-- Seccion de pestaña Resultados de Examenes -->
            <div class="tab-pane fade d-flex show active" id="nav-results" role="tabpanel" aria-labelledby="nav-results-tab">
                <!-- Seccion de carta -->
                <!-- MUESTRA DE DATOS DEL EXAMEN CON PHP -->
                <div class="container d-flex" id="data-tabla">
                </div>

                <!-- DATOS DE LA CARTA -->
                <?php 
                //$offsetAU = $offset+6;
                $Info = $testModel->getNoRepeatStudenTExam($offset);
                foreach ($Info as $res) {
                    $id = $res['Id'];
                    //echo $id;
                    echo '<input id="id" type="hidden" name="offset" value=' . $res['Id'] . ' >';
                   // echo $id;
                    $data = $testController->getNextStudentExam(0, $id);
                    echo '<div class="result-examenes-students-inicio card bg-light m-2" id="result-examenes" style="width: 18rem;">';
                    echo '<div class="card-header text-center">' . $res['NombreCompleto'] . '</div>';
                    echo '<div class="card-body p-3">';
                    echo '<dt style="font-size: 13px; margin-bottom: 12px;">Fechas Realización:</dt>';
                    foreach ($data as $item) {
                        echo '<table class="table table-striped table-sm" style="font-size: 12px;">';
                        echo '<tbody>';
                        echo '<tr align="center">';
                        echo '<th scope="row">' . $item['TipoExamen'] . '&#8594;</th>';
                        echo '<th></th>';
                        echo '<td>' . $item['Fecha'] . '</td>';
                        echo '</tr>';
                        echo '</tbody>';
                        echo '</table>';
                    }
                    echo '</div>';
                    echo '<div class="card-footer bg-transparent text-right">';
                    echo '<a href="/admin/vistas/resultados-examen.php?result=' . $id . '" class="btn btn-primary btn-sm">Ver detalle</a>';
                    echo '</div>';
                    echo '</div>';
                }
                ?>
                <!-- FIN DE DATOS DE LA CARTA -->
            </div>

        </div>
    </main>
    <!-- Seccion de pie de pagina -->
    <footer></footer>
    <script src="js/examenes.js"></script>
</div>