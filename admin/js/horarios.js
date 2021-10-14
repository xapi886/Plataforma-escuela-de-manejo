// Variables de pestañas del panel de examenes
let searchControl, txtsearchSchedule, pagingOffset;
let id;
let page;


function init() {
    // Inicializacion de variables
    txtsearchSchedule = $('#txt-search-schedule');
    pagingOffset = $('input#offset');
    id = $('input#id');
    page = $('page');

    // Eventos de componentes
    //txtsearchExamStudent.on('input', txtSearchEvent);
    txtsearchSchedule.on('keypress', function(e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if (code == 13) {
            buscar();
        }
    });
}

function buscar() {

    var textoBusqueda = txtsearchSchedule.val();
    if (txtsearchSchedule.val().length > 0 && txtsearchSchedule.val() != "") {
        $("div").remove(".schedule");
        $('#data-tabla').html('<div class="row h-100 w-100 justify-content-center align-items-center m-0"> <div class="loading align-items-center"> <img src="img/logo/logo.png" class ="w-100 mt-5"/>  <br> <p class="text-center mt-3">Cargando informacion del Horario...</p> </div></div>');

        $.ajax({
            type: "POST",
            url: "Ajax/ScheduleAjax.php",
            data: {
                texto: textoBusqueda,
                callback: 'buscar'
            },
            success: function(data) {
                $('#container-schedule-all').html(data);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + '\r\n' +
                    xhr.statusText + '\r\n' +
                    xhr.responseText + '\r\n' +
                    ajaxOptions);
            }


        });
    } else if (txtsearchSchedule.val().length == 0 && txtsearchSchedule.val() == "") {
        $("div").remove(".schedule");
        $.ajax({
            type: 'POST',
            url: 'Ajax/ScheduleAjax.php',
            data: {
                callback: "ReCargarEstudianteHorario",
                offset: pagingOffset.val(),
                id: id.val()
            },
            success: function(data) {
                $('#container-schedule-all').html(data);
                console.log('ReCargarEstudianteHorario');
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