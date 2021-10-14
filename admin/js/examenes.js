// Variables de pestañas del panel de examenes
let tabTests, tabResults, panelTests, panelResults;
let searchControl, txtsearchExamStudent, divExamenes, pagingOffset;
let id;
let page;


function init() {
    // Inicializacion de variables
    tabTests = $('#nav-tests-tab'); //Examenes
    tabResults = $('#nav-results-tab'); //Resultados de Examenes
    panelTests = $('#nav-tests'); //div que muestra los 5 tipos de examen
    panelResults = $('#nav-results'); //div que muestra los resultados de los examenes
    searchControl = $("#search-controls"); //div para buscar estudiantes
    txtsearchExamStudent = $('#txt-search-examenes');
    divExamenes = $('#result-examenes');
    pagingOffset = $('input#offset');
    id = $('input#id');
    page = $('page');



    // Comportamiento de componentes
    // panelResults.addClass("d-none");
    // panelResults.toggleClass("d-flex", false);
    panelTests.addClass("d-none");
    panelTests.toggleClass("d-flex", false);

    panelResults.addClass("d-flex");
    panelResults.toggleClass("d-none", false);

    searchControl.addClass("d-flex");
    searchControl.toggleClass("d-none", false);

    searchControl.fadeTo("slow", 1);

    // Eventos de componentes
    tabTests.on("click", tabTestsEventClick);
    tabResults.on("click", tabResultsEventClick);
    //txtsearchExamStudent.on('input', txtSearchEvent);
    txtsearchExamStudent.on('keypress', function(e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if (code == 13) {
            buscar();
        }
    });


}

/**
 * Evento click de la pestaña Examenes
 * @param {*} e 
 */
function tabTestsEventClick(e) {

    panelTests.addClass("d-flex");
    panelTests.toggleClass("d-none", false);

    panelResults.addClass("d-none");
    panelResults.toggleClass("d-flex", false);

    searchControl.addClass("d-none");
    searchControl.toggleClass("d-flex", false);

    searchControl.fadeTo("slow", 0);
}

/**
 * Evento click de la pestaña Resultados de examenes
 * @param {*} e 
 */
function tabResultsEventClick(e) {
    panelTests.addClass("d-none");
    panelTests.toggleClass("d-flex", false);

    panelResults.addClass("d-flex");
    panelResults.toggleClass("d-none", false);

    searchControl.addClass("d-flex");
    searchControl.toggleClass("d-none", false);

    searchControl.fadeTo("slow", 1);
}

/**
 * Metodo AJAX de busqueda de registros de estudiantes
 * @param {*} evt 
 */

function buscar() {

    var textoBusqueda = txtsearchExamStudent.val();
    if (txtsearchExamStudent.val().length > 0 && txtsearchExamStudent.val() != "") {
        $("div").remove(".result-examenes-students");
        $('#data-tabla').html('<div class="row h-100 w-100 justify-content-center align-items-center m-0"> <div class="loading align-items-center"> <img src="img/logo/logo.png" class ="w-100 mt-5"/>  <br> <p class="text-center mt-3">Cargando informacion de la categoria...</p> </div></div>');
        $.ajax({
            type: "POST",
            url: "Ajax/TestAjax.php",
            data: {
                textoBusqueda: textoBusqueda,
                callback: 'buscar'
            },
            success: function(data) {
                $('#nav-results').html(data);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + '\r\n' +
                    xhr.statusText + '\r\n' +
                    xhr.responseText + '\r\n' +
                    ajaxOptions);
            }


        });
    } else if (txtsearchExamStudent.val().length == 0 && txtsearchExamStudent.val() == "") {
        $("div").remove(".result-examenes-students");
        $.ajax({
            type: 'POST',
            url: 'Ajax/TestAjax.php',
            data: {
                callback: "ReCargarEstudianteExamen",
                offset: pagingOffset.val(),
                id: id.val()
            },
            success: function(data) {
                console.log('ReCargarEstudianteExamen');
                $('#nav-results').html(data);
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
 * Arranque del codigo
 */
$(document).ready(init);