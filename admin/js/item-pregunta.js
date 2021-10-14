// Campos de texto
let txtAddAnswer, txtHiddenIdTest, txtHiddenIdQuestion;

// Boton de agregacion
let btnAddAnswer;

/**
 * Metodo inicializacion de comportamiento
 */
function init() {
    /*
     *    1. Inicializacion de variables.
     */
    txtAddAnswer = $('#txt-add-item');
    btnAddAnswer = $('#btn-add-item');
    txtHiddenIdTest = $('#id-test');
    txtHiddenIdQuestion = $('#id-question');

    /*
     *    2. Comportamiento de componentes.
     */
    btnAddAnswer.attr({ disabled: true });

    /*
     *    3. Eventos de componentes.
     */

    btnAddAnswer.on('click', btnAddAnswerClickEvent);
    txtAddAnswer.on('keyup', txtAddAnswerKeyupEvent);
}

/**
 * Evento click para el boton de creacion de item de pregunta
 * @param {*} evt 
 */
function btnAddAnswerClickEvent(evt) {
    evt.preventDefault();
    let fd = new FormData();
    fd.append('id_question', parseInt(txtHiddenIdQuestion.val()));
    fd.append('answer', txtAddAnswer.val());
    fd.append('callback', 'addAnswer');

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
                alert('Ítem de pregunta agregada exitosamente');
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
 * texto txtAddAnswer, teniendo en cuenta cuando el usuario llega a dejar 
 * vacio el campo de texto.
 * @param {*} evt 
 */
function txtAddAnswerKeyupEvent(evt) {
    if ($(this).val().length > 0) {
        btnAddAnswer.attr({ disabled: false });
        return;
    }

    if ($(this).val() == '') {
        btnAddAnswer.attr({ disabled: true });
        return;
    }
}

/**
 * Arranque del codigo
 */
$(document).ready(init);