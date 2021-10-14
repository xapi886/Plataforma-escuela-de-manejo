// Campos de texto
let txtAddQuestion, txtHiddenIdTest;

// Boton de agregacion
let btnAddQuestion;

/**
 * Metodo inicializacion de comportamiento
 */
function init() {
    /*
     *    1. Inicializacion de variables.
     */
    txtAddQuestion = $('#txt-add-question');
    btnAddQuestion = $('#btn-add-question');
    txtHiddenIdTest = $('#id-test');

    /*
     *    2. Comportamiento de componentes.
     */
    btnAddQuestion.attr({ disabled: true });

    /*
     *    3. Eventos de componentes.
     */

    btnAddQuestion.on('click', btnAddQuestionClickEvent);
    txtAddQuestion.on('keyup', txtAddQuestionKeyupEvent);
}

/**
 * Evento click para el boton de creacion de pregunta
 * @param {*} evt 
 */
function btnAddQuestionClickEvent(evt) {
    evt.preventDefault();
    let fd = new FormData();
    fd.append('id_test', parseInt(txtHiddenIdTest.val()));
    fd.append('question', txtAddQuestion.val());
    fd.append('callback', 'addQuestion');

    $.ajax({
        type: 'POST',
        url: "../Ajax/TestAjax.php",
        cache: false,
        data: fd,
        processData: false,
        contentType: false,
        dataType: "JSON",
        success: function(data) {
            if (data.status) {
                alert('Pregunta agregada exitosamente');
                $(location).attr(
                    'href',
                    `/admin/vistas/gestion-examen.php?test=${parseInt(txtHiddenIdTest.val())}`
                );
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + '\r\n' +
                xhr.statusText + '\r\n' +
                xhr.responseText + '\r\n' +
                ajaxOptions);
        }
    });
}

/**
 * Evento que se desencadena cuando el usuario introduce
 * cadenas de caracteres en el campo de
 * texto txtAddQuestion, teniendo en cuenta cuando el usuario llega a dejar 
 * vacio el campo de texto.
 * @param {*} evt 
 */
function txtAddQuestionKeyupEvent(evt) {
    if ($(this).val().length > 0) {
        btnAddQuestion.attr({ disabled: false });
        return;
    }

    if ($(this).val() == '') {
        btnAddQuestion.attr({ disabled: true });
        return;
    }
}

/**
 * Arranque del codigo
 */
$(document).ready(init);