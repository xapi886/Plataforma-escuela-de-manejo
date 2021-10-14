<!-- Proceso de gestion de datos de tarjetas -->
<?php
try {
    // Consulta del numero total de horarios practica
    $record_size = $scheduleController->rowCountSchedules();
    // Numero total de paginas, 8 es el numero constante de tarjetas que se mostraran por pagina
    $total_pages = ceil($record_size / 6);
    // Paginacion de tarjetas de horarios
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    // Partida de obtencion de las tarjetas de horarios
    $offset = ($page - 1) * 6;
    // Otencion de datos de cada tarjeta
    // Otencion de registros de estudiantes
    //echo "--------------------------------------------------------------" . $record_size . " " . $total_pages . " " . $page;
    //echo "la varible offset es: " . $offset . " ";
    //echo '<br>';

    $data = isset($_GET['page']) ? $scheduleController->getNextSchedule($offset, 40) : $scheduleController->getNextSchedule(0, 40);
} catch (Throwable $th) {
    echo ($th->getMessage());
}
?>
<input id="offset" type="hidden" name="offset" value="<?php echo $offset; ?>">

<link rel="stylesheet" href="css/horarios.css">

<div class="principal-section">
    <!-- Seccion de cabecera -->
    <header class="header-box text-white text-center">Gestion de Horarios de Clases Prácticas</header>
    <!-- Seccion principal -->
    <main>
        <!-- Seccion de campo de entrada -->
        <div id="data-controllers" class="d-flex justify-content-between mb-3">
            <input class="form-input w-50" type="text" id="txt-search-schedule" placeholder="Buscar Estudiante" style="padding: 5px 30px;">

            <nav id="pagination-container" class="d-flex justify-content-right align-items-center">
                <span id="info-table" class="mr-2">
                    <span class="text-primary"><?php echo $page; ?></span>&nbsp;de&nbsp;<span class="text-primary"><?php echo $total_pages ?></span>&nbsp;páginas,&nbsp;<span class="text-primary"><?php echo $record_size ?></span>&nbsp;tarjetas
                </span>
                <ul class="pagination m-0">
                    <li class="page-item">
                        <a class="page-link <?php echo ($page == 1) ? "disabled-link" : ""; ?>" href="<?php echo ($page == 1) ? "javascript:void(0)" : "/admin/?modulo=horarios&page=" . ($page - 1); ?>" aria-label="Previous" data-toggle="tooltip" data-placement="bottom" title="Página anterior">
                            <span aria-hidden="true">&lsaquo;</span>
                            <span class="sr-only">Anterior</span>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link <?php echo ($page == 1) ? "disabled-link" : "" ?>" href="/admin/?modulo=horarios&page=1" data-toggle="tooltip" data-placement="bottom" title="Primera página">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Primero</span>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link <?php echo ($page == $total_pages) ? "disabled-link" : "" ?>" href="/admin/?modulo=horarios&page=<?php echo $total_pages; ?>" data-toggle="tooltip" data-placement="bottom" title="Última página">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Último</span>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link <?php echo ($page == $total_pages) ? "disabled-link" : "" ?>" href="<?php echo ($page == $total_pages) ? "javascript:void(0)" : "/admin/?modulo=horarios&page=" . ($page + 1); ?>" aria-label="Next" data-toggle="tooltip" data-placement="bottom" title="Página siguiente">
                            <span aria-hidden="true">&rsaquo;</span>
                            <span class="sr-only">Siguiente</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="tests-container" id="container-schedule-all">
            <?php
            $Info = $scheduleController->getNoRepeatSchedule($offset);
            foreach ($Info as $res) {
                $id = $res['Id'];
                //  echo $id;
                //$dia="";
                //$dia=date("D", strtotime("2021-03-16"));    
                //echo $dia;
                // echo $id;
                $data = $scheduleController->getNextSchedule(0, $id);
                echo '<div class="card schedule bg-light m-2" style="width:18rem;max-height: 20rem; height: auto;">';
                echo '<div class="card-header text-center">' . $res['NombreCompleto'] . '</div>';
                echo '<div class="card-body">';
                echo '<div>';
                echo '<dl class="row mb-0" style="font-size: 12px;">';
                echo '<dt class="col-sm-8">Horario:</dt>';
                echo '<dd class="col-sm-4 ">Práctico</dd>';
                echo '</dl>';
                foreach ($data as $item) {
                    $arrH = explode(":", $item['HoraInicio']);
                    $arrHF = explode(":", $item['HoraFin']);
                    $fecha1 = $item['FechaInicio'];
                    $fecha2 = $item['FechaFin'];
                    if ($fecha1  == date("Y-m-d", strtotime($fecha2 . "- 1 days"))) {
                        echo '<dl class="row mb-0 " style="font-size: 12px;">';
                        dia_semana($fecha1 );
                        echo '<dd class="col-sm-4 ">' . $arrH['0'] . ':' . $arrH['1'] . '-' . $arrHF['0'] . ':' . $arrHF['1'] . ' </dd>';
                        echo '</dl>';
                    }else if($fecha1 < date("Y-m-d", strtotime($fecha2 . "- 1 days"))) {
                        echo '<dl class="row mb-0 " style="font-size: 12px;">';
                        //dia_semana($i);
                        $fechaFin = date("Y-m-d", strtotime($fecha2 . "- 1 days"));
                        echo dia_semana_fin($fecha1,$fechaFin);
                        echo '<dd class="col-sm-4 ">' . $arrH['0'] . ':' . $arrH['1'] . '-' . $arrHF['0'] . ':' . $arrHF['1'] . ' </dd>';
                        echo '</dl>';
                    }

                    //echo '<dt class="col-sm-12">'.$item['FechaInicio'].' hasta '.$item['FechaFin'].'</dt>';
                    //echo '<dd class="col-sm-12">'.$arrH ['0'].':'.$arrH['1'].' a '.$arrHF ['0'].':'.$arrHF['1'].' </dd>';
                }
                echo '</div>';
                echo '</div>';
                echo '<div class="card-footer bg-transparent text-right">';
                echo '<a href="/admin/vistas/gestion-horario.php?data=' . $id . '" class="btn btn-primary btn-sm">Editar</a>';
                echo '</div>';
                echo '</div>';
                echo '<input id="id" type="hidden" name="offset" value=' . $res['Id'] . ' >';
            }

            function dia_semana($fecha)
            {
                $dia = date("d", strtotime($fecha));

                $dias = array('', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo');
                $dia_semana = $dias[date('N', strtotime($fecha))];
                //                echo $dia_semana.' '.$dia;

                echo '<dt class="col-sm-8">' . $dia_semana . ' ' . $dia . '</dt>';
            }

            function dia_semana_fin($fecha1,$fecha2)
            {
                $diaIncio = date("d", strtotime($fecha1));
                $diaFin = date("d", strtotime($fecha2));

                $dias = array('', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo');
                $dia_semana_Incio = $dias[date('N', strtotime($fecha1))];
                $dia_semana_Fin = $dias[date('N', strtotime($fecha2))];

                //                echo $dia_semana.' '.$dia;

                echo '<dt class="col-sm-8 text-left ">' . $dia_semana_Incio . ' ' . $diaIncio  .' - '. $dia_semana_Fin . ' ' . $diaFin . '</dt>';

            }
            ?>

            <div class="container d-flex" id="data-tabla">
            </div>
        </div>
    </main>
    <!-- Seccion de pie de pagina -->
    <footer></footer>
    <script src="js/horarios.js"></script>



</div>