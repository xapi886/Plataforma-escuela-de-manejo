// Identificador de preguntas
let idQuestion;

// Variables de las ventanas modales gestion preguntas
let modalEdit, modalImage, modalDelete;

// Inputs de modales gestion preguntas
let txtEdit, inputFileImage;

// Botones de ventanas modales para gestionar las preguntas
let btnModalEdit, btnModalImage, btnModalDelete;

// Elementos especificos del DOM gestion preguntas
let questionToDelete, labelInputFile, imgTestImages, labelDeleting;

// Identificador de item de pregunta
let idAnswer;

// Variables de las ventanas modales gestion de items de preguntas
let modalItemEdit, modalItemDelete;

// Inputs de modales gestion de items de preguntas
let txtItemEdit;

// Botones de ventanas modales para gestionar items de preguntas
let btnModalItemEdit, btnModalItemDelete;

// Elementos especificos del DOM gestion items de preguntas
let labelDeleteItem, labelDeletingItem;

/**
 * Metodo inicializacion de comportamiento
 */
function init() {
    /*
     *    1. Inicializacion de variables.
     */
    modalEdit = $('#modal-editar');
    modalImage = $('#modal-imagen');
    modalDelete = $('#modal-eliminar');
    txtEdit = $('#txt-editar');
    inputFileImage = $('#input-file');
    btnModalEdit = $('#btn-modal-editar');
    btnModalImage = $('#btn-modal-imagen');
    btnModalDelete = $('#btn-modal-eliminar');
    questionToDelete = $('#pregunta');
    labelInputFile = $('#inside-label-input-file');
    imgTestImages = $('#test-images');
    labelDeleting = $('#deleting');

    modalItemEdit = $('#modal-editar-item-pregunta');
    modalItemDelete = $('#modal-eliminar-item-pregunta');
    txtItemEdit = $('#txt-editar-item-pregunta');
    btnModalItemEdit = $('#btn-modal-editar-item-pregunta');
    btnModalItemDelete = $('#btn-modal-eliminar-item-pregunta');
    labelDeleteItem = $('#label-eliminar-item-pregunta');
    labelDeletingItem = $('#deleting-item');

    /*
     *    2. Comportamiento de componentes.
     */
    btnModalEdit.attr({ disabled: true });
    btnModalImage.attr({ disabled: true });

    /*
     *    3. Eventos de componentes.
     */
    inputFileImage.on('change', inputFileImageChangeEvent);
    btnModalEdit.on('click', btnModalEditClickEvent);
    btnModalImage.on('click', btnModalImageClickEvent);
    btnModalDelete.on('click', btnModalDeleteClickEvent);
    modalImage.on('hidden.bs.modal', modalImageHiddenEvent);
    modalEdit.on('hidden.bs.modal', modalEditHiddenEvent);
    txtEdit.on('keydown', txtEditKeydownEvent);

    btnModalItemEdit.on('click', btnModalItemEditClickEvent);
    btnModalItemDelete.on('click', btnModalItemDeleteClickEvent);
}

/**
 * Abre la ventana modal para edicion de pregunta
 * @param {*} idQuestion 
 */
function showModalQuestionEdit(idQuestion) {
    let fd = new FormData();
    fd.append('id', idQuestion);
    fd.append('callback', 'getQuestionById');

    $.ajax({
        type: 'POST',
        url: "../Ajax/TestAjax.php",
        cache: false,
        data: fd,
        processData: false,
        contentType: false,
        dataType: "JSON",
        success: function(data) {
            setIdQuestion(idQuestion);
            txtEdit.val(data.question);
            modalEdit.modal('show');
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
 * Abre la ventana modal para edicion de imagen
 * @param {*} idQuestion 
 */
function showModalQuestionImage(idQuestion) {
    let fd = new FormData();
    fd.append('id', idQuestion);
    fd.append('callback', 'getImageURL');

    $.ajax({
        type: 'POST',
        url: "../Ajax/TestAjax.php",
        cache: false,
        data: fd,
        processData: false,
        contentType: false,
        dataType: "JSON",
        success: function(data) {
            setIdQuestion(idQuestion);
            if (data.url != null) {
                imgTestImages.attr({ src: data.url });
            } else {
                labelInputFile.html('Archivo...');
                imgTestImages.attr({ src: '/admin/img/tests/00001_TEMPLATE.svg' });
            }
            modalImage.modal('show');
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
 * Abre la ventana modal para eliminacion de pregunta
 * @param {*} idQuestion 
 */
function showModalQuestionDelete(idQuestion) {
    let fd = new FormData();
    fd.append('id', idQuestion);
    fd.append('callback', 'getQuestionById');

    $.ajax({
        type: 'POST',
        url: "../Ajax/TestAjax.php",
        cache: false,
        data: fd,
        processData: false,
        contentType: false,
        dataType: "JSON",
        success: function(data) {
            setIdQuestion(idQuestion);
            questionToDelete.html(data.question);
            modalDelete.modal('show');
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
 * Evento change, se desencadena cuando el estado del
 * input file cambia, aquí demuestra el cambio de imagen 
 * en la etiqueta img
 * @param {*} evt 
 */
function inputFileImageChangeEvent(evt) {
    const fileReader = new FileReader();
    const fileName = evt.target.files[0].name; // Obteniendo nombre del archivo seleccionado
    const file = evt.target.files[0];

    fileReader.onload = (evt) => {
        const image = new Image();
        image.src = fileReader.result;
        labelInputFile.html(fileName);
        imgTestImages.attr({ src: evt.target.result });
        btnModalImage.attr({ disabled: false });
    }
    try { fileReader.readAsDataURL(file); } catch (error) {}
}

/**
 * Evento click del boton Actualizar imagen de pregunta
 * @param {*} evt 
 */
function btnModalImageClickEvent(evt) {
    let fd = new FormData();
    fd.append('file', inputFileImage[0].files[0]);
    fd.append('id_question', getIdQuestion());

    $.ajax({
        type: 'POST',
        url: "../Ajax/ImagesTestAjax.php",
        cache: false,
        data: fd,
        processData: false,
        contentType: false,
        dataType: "JSON",
        success: function(data) {
            if (data == 0) alert('Ha ocurrido un error al subir imagen de perfil');
            if (data == 1) {
                alert('Imagen actualizada exitosamente');
                modalImage.modal('hide');
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
 * Evento click del boton Actualizar pregunta
 * @param {*} evt 
 */
function btnModalEditClickEvent(evt) {
    let fd = new FormData();
    fd.append('new_question', txtEdit.val());
    fd.append('id_question', getIdQuestion());
    fd.append('callback', 'updateQuestion');

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
                alert('Pregunta actualizada exitosamente');
                modalEdit.modal('hide');
                location.reload();
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
 * Evento click del boton Eliminar pregunta
 * @param {*} evt 
 */
function btnModalDeleteClickEvent(evt) {
    let fd = new FormData();
    fd.append('id_question', getIdQuestion());
    fd.append('callback', 'deleteQuestion');

    $.ajax({
        type: 'POST',
        url: "../Ajax/TestAjax.php",
        cache: false,
        data: fd,
        processData: false,
        contentType: false,
        dataType: "JSON",
        beforeSend: function() {
            labelDeleting.html('Deleting...');
        },
        success: function(data) {
            if (data.status) {
                alert('Pregunta eliminada exitosamente');
                modalDelete.modal('hide');
                location.reload();
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
 * Evento que se desencadena cuando 
 * la ventana modal de edicion de imagenes es cerrada
 * @param {*} evt 
 */
function modalImageHiddenEvent(evt) {
    inputFileImage.val('');
    labelInputFile.html('Archivo...');
    btnModalImage.attr({ disabled: true });
}

/**
 * Evento que se desencadena cuando 
 * la ventana modal de edicion de pregunta es cerrada
 * @param {*} evt 
 */
function modalEditHiddenEvent(evt) {
    btnModalEdit.attr({ disabled: true });
}

/**
 * Evento del campo de texto de la ventana modal de edicion de
 * pregunta.
 * @param {*} evt 
 */
function txtEditKeydownEvent(evt) {
    btnModalEdit.attr({ disabled: false });
}

/**
 * Setter de idQuestion
 * @param int id 
 */
function setIdQuestion(id) {
    idQuestion = id;
}

/**
 * Getter de idQuestion
 * @returns idQuestion identificador de pregunta
 */
function getIdQuestion() {
    return idQuestion;
}

/**
 * Setter de idQuestion
 * @param int id 
 */
function setIdAnswer(id) {
    idAnswer = id;
}

/**
 * Getter de idQuestion
 * @returns idQuestion identificador de pregunta
 */
function getIdAnswer() {
    return idAnswer;
}

/**
 * Abre la ventana modal para edicion de item de pregunta
 * @param {*} idAnswer 
 */
function showModalAnswerEdit(idAnswer) {
    let fd = new FormData();
    fd.append('id_answer', idAnswer);
    fd.append('callback', 'getAnswerById');

    $.ajax({
        type: 'POST',
        url: "../Ajax/TestAjax.php",
        cache: false,
        data: fd,
        processData: false,
        contentType: false,
        dataType: "JSON",
        success: function(data) {
            setIdAnswer(idAnswer);
            txtItemEdit.val(data.answer);
            modalItemEdit.modal('show');
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
 * Abre la ventana modal para eliminacion de item de pregunta
 * @param {*} idAnswer 
 */
function showModalAnswerDelete(idAnswer) {
    let fd = new FormData();
    fd.append('id_answer', idAnswer);
    fd.append('callback', 'getAnswerById');

    $.ajax({
        type: 'POST',
        url: "../Ajax/TestAjax.php",
        cache: false,
        data: fd,
        processData: false,
        contentType: false,
        dataType: "JSON",
        success: function(data) {
            setIdAnswer(idAnswer);
            labelDeleteItem.html(data.answer);
            modalItemDelete.modal('show');
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
 * Evento click del boton Editar item de pregunta
 * @param {*} evt 
 */
function btnModalItemEditClickEvent(evt) {
    let fd = new FormData();
    fd.append('new_answer', txtItemEdit.val());
    fd.append('id_answer', getIdAnswer());
    fd.append('callback', 'updateAnswer');

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
                alert('Ítem actualizado exitosamente');
                modalItemEdit.modal('hide');
                location.reload();
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
 * Evento click del boton Eliminar item de pregunta
 * @param {*} evt 
 */
function btnModalItemDeleteClickEvent(evt) {
    let fd = new FormData();
    fd.append('id_answer', getIdAnswer());
    fd.append('callback', 'deleteAnswer');

    $.ajax({
        type: 'POST',
        url: "../Ajax/TestAjax.php",
        cache: false,
        data: fd,
        processData: false,
        contentType: false,
        dataType: "JSON",
        beforeSend: function() {
            labelDeletingItem.html('Deleting...');
        },
        success: function(data) {
            if (data.status) {
                alert('Ítem eliminado exitosamente');
                modalItemDelete.modal('hide');
                location.reload();
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
 * Evento que se desencadena cuando el estado de un radio button
 * de un item de pregunta cambia, actualizando automaticamente
 * la respuesta correcta de la pregunta
 * @param {*} idQuestion Identificador de pregunta
 * @param {*} idAnswer Identificador de item de pregunta
 */
function radioButtonsChangeEvent(idQuestion, idAnswer) {
    let fd = new FormData();
    fd.append('id_question', idQuestion);
    fd.append('id_answer', idAnswer);
    fd.append('callback', 'setCorrectAnswer');

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
                alert('Respuesta establecida como correcta');
                $(`.flag-question${idQuestion}`).attr({
                    title: 'Establecer como respuesta correcta'
                });
                $(`.flag-answer${idAnswer}`).attr({
                    title: 'Establecida como respuesta correcta'
                });
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
 * Arranque del codigo
 */
$(document).ready(init);