// Variables de pestañas del panel de examenes

//let selectTurno, selectModalidades, selectEstado, selectSexo;
var selectTurno = $('#select-turno');
var selectModalidades = $('#select-modalidades');
var btnSubmit = $('#btn-submit');
var selectEstado = $('#select-estado');
var selectSexo = $('#select-sexo');

selectTurno.on('change', selectTurnoEventChange);
selectModalidades.on('change', selectModalidadesEventChange);

/**eventos para cambio de turno según lo que hizo donald xD */

/**
 * Evento que se desencadena cuando el estado del select-turno cambia
 * @param {*} evt 
 */
function selectTurnoEventChange(evt) {
    let turno = $(this).find('option').filter(':selected').text();

    removeAllChildren(selectModalidades);

    $.ajax({
        type: 'POST',
        url: "../Ajax/StudentAjax.php",
        cache: false,
        data: {
            callback: "getWeekModalities",
            turno: turno
        },
        dataType: 'json',
        success: function(data) {
            data.modalities.forEach(element => {
                addElement(selectModalidades,
                    $("<option></option>").text(element.Descripcion)
                    .attr({
                        value: element.CodigoTurno
                    }));
            });
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + '\r\n' +
                xhr.statusText + '\r\n' +
                xhr.responseText + '\r\n' +
                ajaxOptions);
        }
    });

    if (btnSubmit.prop('disabled')) {
        btnSubmit.attr({ disabled: false });
    }
}

/**
 * Evento que se desencadena cuando el estado del select-modalidades cambia
 * @param {*} evt 
 */
function selectModalidadesEventChange(evt) {
    if (btnSubmit.prop('disabled')) {
        btnSubmit.attr({ disabled: false });
    }
}

/**
 * Verificacion de disponibilidad de la modalidad a actualizar.
 * @param {*} modalityOld Modalidad actual del estudiante
 * @param {*} modalityNew Modalidad a la que se quiere cambiar al estudiante
 */
/*function isModalityAvailable(modalityOld, modalityNew) {
    let result;
    $.ajax({
        type: 'POST',
        url: "../Ajax/StudentAjax.php",
        async: false, // Para recuperar datos se necesita que sean sincrono y no asincrono
        cache: false,
        data: {
            callback: "isModalityAvailable",
            modality: modalityNew
        },
        dataType: 'json',
        success: function(data) {
            result = data.isAvailable[0].Disponibilidad;
            result = result == 'true' || modalityOld == modalityNew ? true : false;
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + '\r\n' +
                xhr.statusText + '\r\n' +
                xhr.responseText + '\r\n' +
                ajaxOptions);

            return {
                isAvailable: false,
                message: 'Ha ocurrido un error al buscar modalidades'
            };
        }
    });
    return {
        isAvailable: result,
        message: result == false ?
            `Modalidad "${modalityNew}" está ocupada, por favor seleccionar otra` : ''
    };
}*/

function removeAllChildren(element) {
    element.empty();
}
/**
 * Agrega un elemento hijo nodo al padre nodo html
 * @param {*} parent Padre
 * @param {*} child Hijo
 */
function addElement(parent, child) {
    parent.append(child);
}

$(document).ready(init);