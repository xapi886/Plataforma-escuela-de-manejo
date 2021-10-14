// Variables de pestañas del panel de examenes
let btnShowPassword, imgShowPassword;

// Botones de edicion para cada campo
let btnEditNombre, btnEditApellido, btnEditFechaNacimiento,
    btnEditPassword;

// Elementos campos de texto a editar
let txtNombre, txtApellido, txtPassword, txtId;

// Boton submit y formulario
let btnSubmit, frmMiInformacion;

// Elementos imagen, file input: foto de perfil y verificacion de cambio de foto
let profilePhoto, inputProfilePhoto, isChangedPhoto = false;


function init() {
    // Inicializacion de variables
    //variales de password
    btnShowPassword = $('#btn-show-password');
    imgShowPassword = $('#img-show-password');

    //botones de editar
    btnEditNombre = $('#btn-edit-1');
    btnEditApellido = $('#btn-edit-2');
    btnEditPassword = $('#btn-edit-3');

    //inputs
    txtNombre = $('#txt-nombre-user');
    txtApellido = $('#txt-apellido-user');
    txtPassword = $('#txt-password-user');
    txtId = $('#id-user')

    //formulario
    btnSubmit = $('#btn-submit-user');
    frmMiInformacion = $('#frmMiInformacion');

    //foto
    inputProfilePhoto = $('#input-profile-photo');
    profilePhoto = $('#profile-photo');

    // Eventos de componentes
    btnShowPassword.on('click', btnShowPasswordEvent);

    editButtonsEvent(btnEditNombre, txtNombre);
    editButtonsEvent(btnEditApellido, txtApellido);
    editButtonsEvent(btnEditPassword, txtPassword);

    fieldKeydownEvent(txtNombre);
    fieldKeydownEvent(txtApellido);
    fieldKeydownEvent(txtPassword);

    /*inputProfilePhoto.on('click', function() {
        console.log('iput foto selecionado');
    })*/

    frmMiInformacion.on('submit', frmMiInformaciontEvent);
    inputProfilePhoto.on('change', inputProfilePhotoEventChange);


}

/**
 * Actualiza la informacion del Docente
 * @param {*} evt
 */
function frmMiInformaciontEvent(evt) {
    evt.preventDefault();
    updateUser();
}


/*** Function que actualiza los datos del usuario */
function updateUser() {
    $.ajax({
        type: 'POST',
        url: "Ajax/UserAjax.php",
        cache: false,
        data: {
            callback: "updateInfoUser",
            id: parseInt($('#id-user').val()),
            name: txtNombre.val(),
            last: txtApellido.val(),
            password: txtPassword.val(),
        },
        dataType: 'json',
        success: function(data) {
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
        src: imgShowPassword.attr('src') == 'img/icons/notsee.svg' ?
            "img/icons/see.svg" : "img/icons/notsee.svg"
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
 * Metodo actualiza foto de perfil en la vista Informacion de estudiante.
 */
function updateProfilePhoto() {
    let fd = new FormData();
    fd.append('file', inputProfilePhoto[0].files[0]);
    fd.append('idcard', txtId.val());

    $.ajax({
        type: 'POST',
        url: "Ajax/ProfilePhotoUSerAjax.php",
        cache: false,
        data: fd,
        processData: false,
        contentType: false,
        success: function(data) {
            if (data == 0) alert('Ha ocurrido un error al subir imagen de perfil');
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
 * Evento que se desencadena cuando el elemento input file (Foto de perfil)
 * de la vista de Informacion de estudiante cambia de estado.
 * @param {*} evt 
 */
function inputProfilePhotoEventChange(evt) {
    const fileReader = new FileReader();
    const files = inputProfilePhoto[0].files[0];
    console.log('iput foto selecionado');

    fileReader.onload = (evt) => {
        let myPromise = new Promise((resolve, reject) => {
            const image = new Image();

            image.onload = (evt) => {
                resolve({ width: image.width, height: image.height });
            }

            image.onerror = (evt) => {
                reject('Ha ocurrido algún problema con la imagen');
            }

            image.src = fileReader.result;
        });

        myPromise.then((dimensions) => {
            if (dimensions.width >= 170 && dimensions.width <= 200 &&
                dimensions.height >= 170 && dimensions.height <= 200) {

                profilePhoto.attr({ src: evt.target.result });
                isChangedPhoto = true;

                if (btnSubmit.prop('disabled')) {
                    btnSubmit.attr({ disabled: false });
                }
            } else {
                alert(`Dimensiones de la foto deben ser: 170x170, 180x180, 200x200`);
            }
        });
    }
    try { fileReader.readAsDataURL(files); } catch (error) {}
}

/**
 * Arranque del codigo
 */

$(document).ready(init);