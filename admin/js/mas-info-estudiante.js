// Variables de pestañas del panel de examenes
let btnShowPassword, imgShowPassword;

// Botones de edicion para cada campo
let btnEditNombreCE, btnEditApellidoCE, btnEditTelefonoCE,
    btnEditEmailCE, btnEditDireccionCE, btnEditLT,
    btnEditTelefonoLT, btnEditEmailLT, btnEditDireccionLT,
    btnEditObservaciones;

// Elementos campos de texto a editar
let txtNombreCE, txtApellidoCE, txtTelefonoCE,
    txtEmailCE, txtCedulaCE, txtDireccionCE, txtLT,
    txtTelefonoLT, txtEmailLT, txtDireccionLT,
    txtObservacionesLT, txtIdInscripcion,
    txtIdStudent;

// Boton submit y formulario
let btnSubmit, frMasInfoStudent;

// Selectores o Combobox de la vista Informacion estudiantes
let selectTurno, selectModalidades, selectEstado, selectSexo, selectNivel;

// Radio buttons de la vista Informacion estudiantes
let radioSiPrincipiante, radioNoPrincipiante, radioSiLicencia, radioNoLicencia;

// Elementos imagen, file input: foto de perfil y verificacion de cambio de foto
let profilePhoto, inputProfilePhoto, isChangedPhoto = false;

// Variables del Estado y Verificacion del estudiante
let state, verification;

/**
 * Metodo inicializacion de comportamiento
 */
function init() {
    // Inicializacion de variables
    btnShowPassword = $('#btn-show-password');
    imgShowPassword = $('#img-show-password');

    btnEditNombreCE = $('#btn-one');
    btnEditApellidoCE = $('#btn-two');
    btnEditTelefonoCE = $('#btn-three');
    btnEditEmailCE = $('#btn-five');
    btnEditDireccionCE = $('#btn-six');
    btnEditLT = $('#btn-seven');
    btnEditTelefonoLT = $('#btn-eight');
    btnEditEmailLT = $('#btn-nine');
    btnEditDireccionLT = $('#btn-ten');
    btnEditObservaciones = $('#btn-eleven');
    //btnEditFechaExamen = $('#btn-twelve');

    //Seccion de contacto de emergencia 
    txtNombreCE = $('#txt-nombreCE');
    txtApellidoCE = $('#txt-apellidoCE');
    txtTelefonoCE = $('#txt-telefonoCE');
    txtEmailCE = $('#txt-emailCE');
    txtDireccionCE = $('#txt-direccionCE');


    // seccion de lugar de trabajo
    txtLT = $('#txt-LT');
    txtTelefonoLT = $('#txt-telefonoLT');
    txtEmailLT = $('#txt-emailLT');
    txtDireccionLT = $('#txt-direccionLT');
    txtObservacionesLT = $('#txt-observaciones');

    //Id 
    txtIdInscripcion = $('#id-inscripcion');
    txtIdStudent = $('#id-estudiante');

    //Formulario
    btnSubmit = $('#btn-submit');
    frMasInfoStudent = $('#form-mas-info-estudiante');

    // Comportamiento de componentes


    // Eventos de componentes
    btnShowPassword.on('click', btnShowPasswordEvent);

    editButtonsEvent(btnEditNombreCE, txtNombreCE);
    editButtonsEvent(btnEditApellidoCE, txtApellidoCE);
    editButtonsEvent(btnEditTelefonoCE, txtTelefonoCE);
    editButtonsEvent(btnEditEmailCE, txtEmailCE);
    editButtonsEvent(btnEditDireccionCE, txtDireccionCE);
    editButtonsEvent(btnEditLT, txtLT);
    editButtonsEvent(btnEditTelefonoLT, txtTelefonoLT);
    editButtonsEvent(btnEditEmailLT, txtEmailLT);
    editButtonsEvent(btnEditDireccionLT, txtDireccionLT);
    editButtonsEvent(btnEditObservaciones, txtObservacionesLT);

    fieldKeydownEvent(txtNombreCE);
    fieldKeydownEvent(txtApellidoCE);
    fieldKeydownEvent(txtTelefonoCE);
    fieldKeydownEvent(txtEmailCE);
    fieldKeydownEvent(txtDireccionCE);
    fieldKeydownEvent(txtLT);
    fieldKeydownEvent(txtTelefonoLT);
    fieldKeydownEvent(txtEmailLT);
    fieldKeydownEvent(txtDireccionLT);
    fieldKeydownEvent(txtObservacionesLT);

    frMasInfoStudent.on('submit', frmInfoStudentEvent);
}

/**
 * Evento del boton btnShowPassword, muestra y oculta la contrasenia del
 * campo de texto txtPassword.
 * @param {*} evt
 */
function btnShowPasswordEvent(evt) {
    evt.preventDefault();
    txtPassword.attr({
        type: txtPassword.attr('type') == 'password' ? "text" : "password"
    });

    imgShowPassword.attr({
        src: imgShowPassword.attr('src') == '../img/icons/notsee.svg' ?
            "../img/icons/see.svg" : "../img/icons/notsee.svg"
    });
}

/**
 * Agrega propiedades a los botones de edicion
 * @param {*} btn Elemento boton
 * @param {*} field Elemento campo de texto asociado al boton
 */
function editButtonsEvent(btn, field) {
    btn.on('click', (evt) => {
        evt.preventDefault();

        btn.children().attr({
            src: btn.children().attr('src') == '../img/icons/edit.svg' ?
                "../img/icons/close.svg" : "../img/icons/edit.svg",
            style: btn.children().attr('src') == '../img/icons/edit.svg' ?
                "width: 12px" : "width: 20px"
        });

        if (field.prop('readonly')) {
            field
                .removeClass('form-control-plaintext')
                .addClass('form-control')
                .prop('readonly', false);
        } else {
            field
                .removeClass('form-control')
                .addClass('form-control-plaintext')
                .prop('readonly', true);
        }
    });
}

/**
 * Metodo para la adicion del evento keydown a cada campo de texto.
 * @param {*} field
 */
function fieldKeydownEvent(field) {
    field.on('keydown', (evt) => {
        if (btnSubmit.prop('disabled')) {
            btnSubmit.attr({ disabled: false });
        }
    });
}

/**
 * Metodo para la adicion del evento change a cada campo de texto.
 * @param {*} field
 */
function fieldDateChangeEvent(field) {
    field.on('change', (evt) => {
        if (btnSubmit.prop('disabled')) {
            btnSubmit.attr({ disabled: false });
        }
    });
}

/**
 * Actualiza la informacion de estudiante
 * @param {*} evt
 */
function frmInfoStudentEvent(evt) {
    evt.preventDefault();
    updateMoreInfoStudentById();

}

/**
 * Actualiza los datos de un estudiante verificado
 */
function updateMoreInfoStudentById() {
    let validate = isValidatedFields();
    let emailCE = isEmail(txtEmailCE.val());
    let emailLT = isEmail(txtEmailLT.val());

    if (!validate.isValidate) { alert(validate.message); return; }
    //if (!emailCE.isEmail) { alert(email.message); return; }
    //if (!emailLT.isEmail) { alert(email.message); return; }

    if (!confirm('¿Desea cambiar los datos de estudiante?')) { return; }

    $.ajax({
        type: 'POST',
        url: "../Ajax/StudentAjax.php",
        cache: false,
        data: {
            callback: "updateMoreInfoStudentById",
            id: parseInt($('#id-estudiante').val()),
            nameCE: txtNombreCE.val(),
            lastCE: txtApellidoCE.val(),
            direccionCE: txtDireccionCE.val(),
            phoneCE: txtTelefonoCE.val(),
            emailCE: txtEmailCE.val(),
            LT: txtLT.val(),
            direccionLT: txtDireccionLT.val(),
            telefonoLT: txtTelefonoLT.val(),
            emailLT: txtEmailLT.val(),
            observaciones: txtObservacionesLT.val()
        },
        dataType: 'json',
        success: function(data) {
            // alert('recibio la respuesta ajax');
            if (data.updated) {
                alert('Datos de estudiante actualizados exitosamente');
            } else {
                alert('Ha ocurrido un error al actualizar datos');
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + '\r\n' +
                xhr.statusText + '\r\n' +
                xhr.responseText + '\r\n' +
                ajaxOptions);
        }
    });

    if (isChangedPhoto) updateProfilePhoto();
}


/**
 * Remueve todos los hijos del elemento padre, incluso los anidados
 * @param {*} element 
 */
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

/**
 * Validacion de campos de textos
 */
function isValidatedFields() {
    if (!txtNombreCE.val()) {
        return { isValidate: false, message: "Nombre del contacto de emergencia no puede estar vacío" };
    } else if (!txtApellidoCE.val()) {
        return { isValidate: false, message: "Apellido del contacto de emergencia no puede estar vacío" };
    } else if (!txtEmailCE.val()) {
        return { isValidate: false, message: "Correo del contacto de emergencia no puede estar vacío" };
    } else if (!txtTelefonoCE.val()) {
        return { isValidate: false, message: "Teléfono del contacto de emergencia no puede estar vacío" };
    } else if (!txtDireccionCE.val()) {
        return { isValidate: false, message: "Direccion del contacto de emergencia no puede estar vacío" };
    }
    return { isValidate: true, message: "" };
}

/**
 * Verifica si el correo de un estudiante es valido para guardarlo en la base de datos.
 * @param {string} email 
 * @returns {*} Devuelve un objeto con dos resultados 
 * true o false si el correo es valido o no y el otro 
 * una cadena de texto como mensaje si el correo es invalido
 */
function isEmail(email) {
    let pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
    let result = pattern.test(email);
    return {
        isEmail: result,
        message: result == false ?
            `Dirección de correo electrónico incorrecto, por favor introduce uno valido.
            \nPor ejemplo: test@dominio.com` : ''
    };
}



/**
 * Arranque del codigo
 */

$(document).ready(init);