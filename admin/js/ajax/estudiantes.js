// Variables de gestion de estudiante
let txtSearch, tblStudent, pagingOffset;

function init() {
    /*
     *    1. Inicializacion de variables.
     */
    txtSearch = $('#txt-search');
    pagingOffset = $('input#offset');

    // Utilizando DataTables-1.10.23 para configurar tabla estudiante
    // Ordenamiento de columna, se debe tener en cuenta lo siguiente>
    // # = Count, 
    // Nombre Completo = NombreCompleto,
    // Cedula = Cedula, 
    // Telefono = Telefono, 
    // Estado = Estado, 
    // Horario prácticas = Practica,
    // Inscripción = Inscripcion,
    // Información = Informacion
    tblStudent = $('#tbl-estudiante').DataTable({
        ordering: true, // permite ordenamiento de columnas
        columns: [ // datos de columnas
            { data: 'Count' }, // nombre alias para datos json
            { data: 'NombreCompleto' },
            { data: 'Cedula' },
            { data: 'Telefono' },
            { data: 'Estado' },
            { data: 'Practica', orderable: false }, // orderable permite activar el ordenamiento de tabla
            { data: 'Inscripcion', orderable: false },
            { data: 'Informacion', orderable: false }
        ],
        columnDefs: [{ // definicion de una columna
                "targets": 4, // numero de columna
                "createdCell": function(td, cellData, rowData, row, col) { // manejar datos de celldas
                    if (cellData == 'Deshabilitado') { // comparacion de datos de las celdas para esa columna
                        $(td).addClass('text-muted'); // configuracion de comportamiento de esas celdas
                    }
                }
            },
            {
                "targets": 5,
                "createdCell": function(td, cellData, rowData, row, col) {
                    if (cellData == 'Asignado') {
                        $(td).addClass('text-muted');
                    }
                }
            },
            {
                "targets": 6,
                "createdCell": function(td, cellData, rowData, row, col) {
                    if (cellData == 'Verificado') {
                        $(td).addClass('text-muted');
                    }
                }
            }
        ],
        rowCallback: function(row, data) { //  con esta funcion podemos verificar y comparar datos entre columnas
            if (data[4] == "Deshabilitado") { // Verificando datos de la columna 4, es decir Estado
                $('td:eq(5)', row).text('-').addClass('text-muted');
            }
            if ($('td:eq(6) a', row).text() == "Verificar") {
                $('td:eq(5)', row).text('-').addClass('text-muted');
            }
        },
        language: {
            "emptyTable": "Sin datos disponibles en la base de datos"
        },
        paging: false, // permite paginacion por defecto de la tabla
        searching: false, // permite sistema de busqueda por defecto
        info: false // permite informacion de tabla por defecto
    });

    /*
     *    2. Comportamiento de componentes.
     */


    /*
     *    3. Eventos de componentes.
     */
    // Por favor utlizar oninput como evento
    // desencadenador de la entrada de texto
    txtSearch.on('input', txtSearchEvent);
}

/**
 * Metodo AJAX de busqueda de registros de estudiantes
 * @param {*} evt 
 */
function txtSearchEvent(evt) {
    // Remuevo filas de tabla
    removeAllRows(tblStudent);
    // Confirmacion si la entrada de texto de gestion estudiante esta vacia
    if (txtSearch.val().length > 0) {
        // Proceso de ajax
        $.ajax({
            type: 'POST',
            url: 'Ajax/StudentAjax.php',
            data: {
                callback: "searchStudentByFulltext",
                text: txtSearch.val()
            },
            dataType: "JSON",
            success: function(data) {
                removeAllRows(tblStudent);
                addRecord(tblStudent, data.students);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + '\r\n' +
                    xhr.statusText + '\r\n' +
                    xhr.responseText + '\r\n' +
                    ajaxOptions);
            }
        });
    } else {
        // Proceso de ajax
        removeAllRows(tblStudent);

        $.ajax({

            type: 'POST',
            url: 'Ajax/StudentAjax.php',
            data: {
                callback: "getNextStudents",
                offset: pagingOffset.val()
            },
            dataType: "JSON",
            success: function(data) {
                removeAllRows(tblStudent);
                addRecord(tblStudent, data.students);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + '\r\n' +
                    xhr.statusText + '\r\n' +
                    xhr.responseText + '\r\n' +
                    ajaxOptions);
            }
        });
    }
}

/**
 * Remueve todos los registros de un elemento tabla en concreto.
 * @param {*} table Elemento tabla
 */
function removeAllRows(table) {
    // Accion de remocion de datos de tabla
    table.rows().remove().draw();
}

/**
 * Agrega registros a un elemento tabla en concreto
 * @param {*} table Elemento tabla
 * @param {*} data Datos JSON
 */
function addRecord(table, data) {
    // Accion de insercion de registros a tabla
    table.rows.add(data).draw();
}

/**
 * Eventos cuando la aplicacion inicia.
 */

/**
 * Arranque del codigo
 */
$(document).ready(init);