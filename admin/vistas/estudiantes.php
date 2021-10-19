<!-- Proceso de gestion de datos de tabla -->

<?php
try {
    // Consulta del numero total de registros de tabla estudiante
    $record_size = $studentController->rowCountStudents();
    // Numero total de paginas, 15 es el numero constante de filas que se mostraran por pagina
    $total_pages = ceil($record_size / 15);
    // Paginacion de registros
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    //echo  "..................................." ."la variable page es: ". $page . " ";
    //echo "la variable recor_size es: ". $record_size . " ";
    //echo "la varible total_pages es: " .$total_pages . " ";
    // Partida de obtencion de los registros
    $offset = ($page - 1) * 15;
    //echo "la varible offset es: " .$offset . " ";
    // Otencion de registros de estudiantes
    $data = isset($_GET['page']) ? $studentController->getNextStudents($offset) : $studentController->getNextStudents(0);
    //echo "la varible offset es: " .$offset . " ";
    //echo "la varible data es: " .$data . " ";
    // Conteo de numero de registros
    $count = $offset + 1;
} catch (Throwable $th) {
    echo ($th->getMessage());
}
?>

<!-- Entrada de datos para recuperar los registros de la pagina
     actual cuando se esta buscando a un estudiante por texto 
-->
<input id="offset" type="hidden" name="offset" value="<?php echo $offset; ?>">
<link rel="stylesheet" href="css/estudiantes.css">
<div class="principal-section">
    <!-- Seccion de cabecera -->
    <header class="header-box text-white text-center">Gestión de Estudiantes</header>
    <!-- Seccion principal -->
    <main>
        <!-- Seccion de campo de entrada -->
        <div id="data-controllers" class="d-flex justify-content-between mb-3">
            <input class="form-input w-50" type="text" id="txt-search" placeholder="Buscar Estudiante" style="padding: 5px 30px;">
            <nav id="pagination-container" class="d-flex justify-content-right align-items-center">
                <span id="info-table" class="mr-2">
                    <span class="text-primary"><?php echo $page; ?></span>&nbsp;de&nbsp;<span class="text-primary"><?php echo $total_pages; ?></span>&nbsp;páginas,&nbsp;<span class="text-primary"><?php echo $record_size; ?></span>&nbsp;registros
                </span>
                <ul class="pagination m-0">
                    <li class="page-item">
                        <a class="page-link <?php echo ($page == 1) ? "disabled-link" : ""; ?>" href="<?php echo ($page == 1) ? "javascript:void(0)" : "/admin/?modulo=estudiantes&page=" . ($page - 1); ?>" aria-label="Previous" data-toggle="tooltip" data-placement="bottom" title="Página anterior">
                            <span aria-hidden="true">&lsaquo;</span>
                            <span class="sr-only">Anterior</span>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link <?php echo ($page == 1) ? "disabled-link" : "" ?>" href="/admin/?modulo=estudiantes&page=1" data-toggle="tooltip" data-placement="bottom" title="Primera página">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Primero</span>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link <?php echo ($page == $total_pages) ? "disabled-link" : "" ?>" href="/admin/?modulo=estudiantes&page=<?php echo $total_pages; ?>" data-toggle="tooltip" data-placement="bottom" title="Última página">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Último</span>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link <?php echo ($page == $total_pages) ? "disabled-link" : "" ?>" href="<?php echo ($page == $total_pages) ? "javascript:void(0)" : "/admin/?modulo=estudiantes&page=" . ($page + 1); ?>" aria-label="Next" data-toggle="tooltip" data-placement="bottom" title="Página siguiente">
                            <span aria-hidden="true">&rsaquo;</span>
                            <span class="sr-only">Siguiente</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        <!-- Seccion de datos de tabla -->

        <div class="table-responsive">
            <table id="tbl-estudiante" class="table table-hover">
                <thead class="">
                    <tr>
                        <th>#</th>
                        <th>Nombre completo</th>
                        <th>Cédula</th>
                        <th>Teléfono</th>
                        <th>Estado</th>
                        <th>Horario prácticas</th>
                        <th>Inscripción</th>
                        <th>Información</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Datos de la tabla -->
                    <?php foreach ($data as $item) : ?>
                        <tr>
                            <td><?php echo $count++; ?></td>
                            <td><?php echo $item['NombreCompleto']; ?></td>
                            <td><?php echo $item['Cedula']; ?></td>
                            <td><?php echo $item['Telefono']; ?></td>
                            <td class="<?php echo $item['EstadoBoolean'] == '0' ? '' : 'text-muted'; ?>">
                                <?php echo $item['Estado'] == 'Habilitado' ? 'Habilitado' : 'Deshabilitado'; ?>
                            </td>
                            <td class="<?php echo $item['Practica'] == 'Asignado' || $item['EstadoBoolean'] == 0 ? 'text-muted' : ''; ?>">
                                <?php echo $item['EstadoBoolean'] == '0' ? '-' : $item['Practica']; ?>
                            </td>
                            <td class="<?php echo $item['Inscripcion'] == 'Verificado' ? 'text-muted' : ''; ?>">
                                <?php echo $item['Inscripcion']; ?>
                            </td>
                            <td><?php echo $item['Informacion']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
    <!-- Seccion de pie de pagina -->
    <footer></footer>
    <!-- Scripts -->
    <script type="text/javascript" src="js/ajax/estudiantes.js"></script>
</div>