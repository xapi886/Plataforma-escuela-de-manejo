// Variables de pestañas del panel de examenes
let btnShowPassword, imgShowPassword;

// Botones de edicion para cada campo
let btnEditNombre, btnEditApellido, btnEditFechaNacimiento,
    btnEditCedula, btnEditPasaporte, btnEditEmail,
    btnEditTelefono, btnEditDireccion, btnEditPassword,
    btnEditCategoria, btnEditFechaExamen, btnEditPractica, btnEditFechaExamenTransito, btnEditPracticaTransito;

// Elementos campos de texto a editar
let txtNombre, txtApellido, txtFechaNacimiento,
    txtCedula, txtPasaporte, txtEmail,
    txtTelefono, txtDireccion, txtPassword,
    txtCategoria, txtFechaExamen,
    txtIdStudent, txtFechaPractica, txtFechaExamenTransito, txtFechaPracticaTransito, txtlabelcomprobanteET, txtlabelcomprobanteEP;

// Boton submit y formulario
let btnSubmit, frmInfoStudent;

// Selectores o Combobox de la vista Informacion estudiantes
let selectTurno, selectModalidades, selectEstado, selectSexo, selectNivel;

// Radio buttons de la vista Informacion estudiantes
let radioSiPrincipiante, radioNoPrincipiante, radioSiLicencia, radioNoLicencia;

// Elementos imagen, file input: foto de perfil y verificacion de cambio de foto
let profilePhoto, inputProfilePhoto, isChangedPhoto = false,
    isChangedComprobanteET = false;

// Variables del Estado y Verificacion del estudiante
let state, verification;

//variable de confirmacion de seminario 
let checkboxSeminario;

//variable de comprobante de inscripcion
let fileComprobante, fileComprobanteP;

/**
 * Metodo inicializacion de comportamiento
 */
function init() {
    // Inicializacion de variables
    btnShowPassword = $('#btn-show-password');
    imgShowPassword = $('#img-show-password');

    btnEditNombre = $('#btn-one');
    btnEditApellido = $('#btn-two');
    btnEditFechaNacimiento = $('#btn-three');
    btnEditCedula = $('#btn-five');
    btnEditPasaporte = $('#btn-six');
    btnEditEmail = $('#btn-seven');
    btnEditTelefono = $('#btn-eight');
    btnEditDireccion = $('#btn-nine');
    btnEditPassword = $('#btn-ten');
    btnEditCategoria = $('#btn-eleven');
    btnEditFechaExamen = $('#btn-twelve');
    btnEditPractica = $('#btn-thirteen');
    btnEditFechaExamenTransito = $('#btn-fourteen');
    btnEditPracticaTransito = $('#btn-fifteen');


    txtNombre = $('#txt-nombre');
    txtApellido = $('#txt-apellido');
    txtFechaNacimiento = $('#txt-fecha-nacimiento');
    txtCedula = $('#txt-cedula');
    txtPasaporte = $('#txt-pasaporte');
    txtEmail = $('#txt-email');
    txtTelefono = $('#txt-telefono');
    txtDireccion = $('#txt-direccion');
    txtPassword = $('#txt-password');
    txtCategoria = $('#txt-categoria');
    txtFechaExamen = $('#txt-fecha-examen');
    txtIdStudent = $('#id-estudiante');
    txtFechaPractica = $('#txt-fecha-practica');
    txtFechaExamenTransito = $('#txt-fecha-examen-transito');
    txtFechaPracticaTransito = $('#txt-fecha-practica-transito');

    //Comprobante
    txtlabelcomprobanteET = $('#label-comprobanteET'); //label comprobante ET
    txtlabelcomprobanteEP = $('#label-comprobanteEP'); //label comprobante EP



    checkboxSeminario = $('input[type=checkbox][name=seminario]');
    fileComprobante = $('#comprobanteET');
    fileComprobanteP = $('#comprobanteEP');


    btnSubmit = $('#btn-submit');
    frmInfoStudent = $('#form-info-estudiante');

    selectTurno = $('#select-turno');
    selectModalidades = $('#select-modalidades');
    selectEstado = $('#select-estado');
    selectSexo = $('#select-sexo');
    selectNivel = $('#select-levels');

    radioButtonsPrincipiante = $('input[type=radio][name=radio-principiante]');
    radioButtonsLicencia = $('input[type=radio][name=radio-licencia]');

    inputProfilePhoto = $('#input-profile-photo');
    profilePhoto = $('#profile-photo');

    state = $('#hidden-data-estado');
    verification = $('#hidden-data-verificacion');

    // Comportamiento de componentes
    selectTurno.css({ cursor: "pointer" });
    selectModalidades.css({ cursor: "pointer" });
    selectEstado.css({ cursor: "pointer" });
    selectSexo.css({ cursor: "pointer" });
    selectNivel.css({ cursor: "pointer" });

    // Eventos de componentes
    btnShowPassword.on('click', btnShowPasswordEvent);

    editButtonsEvent(btnEditNombre, txtNombre);
    editButtonsEvent(btnEditApellido, txtApellido);
    editButtonsEvent(btnEditFechaNacimiento, txtFechaNacimiento);
    editButtonsEvent(btnEditCedula, txtCedula);
    editButtonsEvent(btnEditPasaporte, txtPasaporte);
    editButtonsEvent(btnEditEmail, txtEmail);
    editButtonsEvent(btnEditTelefono, txtTelefono);
    editButtonsEvent(btnEditDireccion, txtDireccion);
    editButtonsEvent(btnEditPassword, txtPassword);
    editButtonsEvent(btnEditCategoria, txtCategoria);
    editButtonsEvent(btnEditFechaExamen, txtFechaExamen);
    editButtonsEvent(btnEditPractica, txtFechaPractica);
    editButtonsEvent(btnEditFechaExamenTransito, txtFechaExamenTransito);
    editButtonsEvent(btnEditPracticaTransito, txtFechaPracticaTransito);



    fieldKeydownEvent(txtNombre);
    fieldKeydownEvent(txtApellido);
    fieldKeydownEvent(txtFechaNacimiento);
    fieldKeydownEvent(txtCedula);
    fieldKeydownEvent(txtPasaporte);
    fieldKeydownEvent(txtEmail);
    fieldKeydownEvent(txtTelefono);
    fieldKeydownEvent(txtDireccion);
    fieldKeydownEvent(txtPassword);
    fieldKeydownEvent(txtCategoria);
    fieldKeydownEvent(txtFechaExamen);
    fieldKeydownEvent(txtFechaPractica);


    fieldDateChangeEvent(txtFechaNacimiento);
    fieldDateChangeEvent(txtFechaExamen);
    fieldDateChangeEvent(txtFechaPractica);
    fieldDateChangeEvent(txtFechaExamenTransito);
    fieldDateChangeEvent(txtFechaPracticaTransito);



    frmInfoStudent.on('submit', frmInfoStudentEvent);

    selectTurno.on('change', selectTurnoEventChange);
    selectModalidades.on('change', selectModalidadesEventChange);
    selectEstado.on('change', selectEstadoEventChange);
    selectSexo.on('change', selectSexoEventChange);
    selectNivel.on('change', selectNivelEventChange);

    radioButtonsPrincipiante.on('change', radioButtonsPrincipianteEventChange);
    radioButtonsLicencia.on('change', radioButtonsLicenciaEventChange);

    inputProfilePhoto.on('change', inputProfilePhotoEventChange);
    //Comprobante de pago
    //Teorico
    fileComprobante.on('change', inputComprobanteEventChange); // funcion cuando el input de comprobante ET cambia
    txtlabelcomprobanteET.on('change', inputComprobanteEventChange); // funcion cuando el label del comprobante ET cambia.
    //Practico
    fileComprobanteP.on('change', inputComprobanteEventChange);
    txtlabelcomprobanteEP.on('change', inputComprobanteEventChange);


    checkboxSeminario.on('change', checkboxSeminarioEventChange);

}

/**
 * Evento del boton btnShowPassword, muestra y oculta la contrasenia del
 * campo de texto txtPassword.
 * @param {*} evt
 */
function checkboxSeminarioEventChange(evt) {
    //evt.preventDefault();
    //alert('checkbox seleccionado');
    if (!confirm('¿Desea verificar que el seminario ha sido concluido?')) { return; }
    console.log('confirmo');
    $.ajax({
        type: 'POST',
        url: "../Ajax/StudentAjax.php",
        cache: false,
        data: {
            callback: "verificarSeminario",
            id: parseInt($('#id-estudiante').val()),
            turno: selectTurno.val(),
            modalidad: $('#codigo-turno').val()
        },
        //dataType: 'json',
        success: function(data) {
            if (data) {
                alert(data);
                selectModalidades.attr("disabled", true);
                selectTurno.attr("disabled", true);
                checkboxSeminario.attr("disabled", true);
                checkboxSeminario.attr("checked", true);
            }
            //frmInfoStudentEvent(evt);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + '\r\n' +
                xhr.statusText + '\r\n' +
                xhr.responseText + '\r\n' +
                ajaxOptions);
        }
    });
}

getInfoStudentById();

function getInfoStudentById() {

    //console.log('entro al metodo jquery');
    $.ajax({
        type: 'POST',
        url: "../Ajax/StudentAjax.php",
        cache: false,
        data: {
            callback: "getInfoStudentById",
            id: parseInt($('#id-estudiante').val()),
        },
        dataType: 'json',
        success: function(data) {
            console.log(data.info);
            let dataInfo = data.info;
            let res = '';
            dataInfo.forEach(dataInfo => res = `${dataInfo.CodigoTurno},${dataInfo.ComprobanteEP}`);
            //console.log(res);

            //var pizza = "porción1 porción2 porción3 porción4 porción5 porción6";
            var arreglo = res.split(',');
            // document.write(arreglo[1]); //porción3
            //console.log(arreglo[0]);
            //console.log(arreglo[1]);


            $('#Codigo').val(arreglo[0]);
            //$('#view-comprobante').src(arreglo[1]);



            /*dataInfo.forEach(dataInfo => resCT = `${dataInfo.ComprobanteEP}`);
            console.log(resCT);
            $('#test-01').val(resCT); */
            //$('#task-result').show();
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + '\r\n' +
                xhr.statusText + '\r\n'

                +
                xhr.responseText + '\r\n' +
                ajaxOptions);
        }
    });

}
//setInterval(getInfoStudentById, 10000);


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

    if (state.val() == 'Habilitado' && verification.val() == 'Habilitado') {
        updateStudentVerified();
    } else {
        updateStudentRegisteredOnly();
    }
}

/**
 * Actualiza los datos de un estudiante verificado
 */
function updateStudentVerified() {
    let validate = isValidatedFields();
    let email = isEmail(txtEmail.val());
    let modality = isModalityAvailable(
        $('#Codigo').val(),
        selectModalidades.val()
    );

    if (!validate.isValidate) { alert(validate.message); return; }
    if (!email.isEmail) { alert(email.message); return; }
    if (!modality.isAvailable) { alert(modality.message); return; }
    if (!confirm('¿Desea cambiar los datos de estudiante?')) { return; }

    $.ajax({
        type: 'POST',
        url: "../Ajax/StudentAjax.php",
        cache: false,
        data: {
            callback: "updateInfoStudent",
            id: parseInt($('#id-estudiante').val()),
            name: txtNombre.val(),
            last: txtApellido.val(),
            birthdate: txtFechaNacimiento.val(),
            gender: selectSexo.val(),
            idcard: txtCedula.val(),
            passport: txtPasaporte.val(),
            email: txtEmail.val(),
            password: txtPassword.val(),
            phone: txtTelefono.val(),
            address: txtDireccion.val(),
            state: parseInt(selectEstado.val()),
            beginner: radioButtonsPrincipiante.filter(':checked').val(),
            license: radioButtonsLicencia.filter(':checked').val(),
            category: txtCategoria.val(),
            old_modality: $('#Codigo').val(),
            new_modality: selectModalidades.val(),
            testdate: txtFechaExamen.val(),
            practicedate: txtFechaPractica.val(),
            level: selectNivel.val(),
            transito_test_date: txtFechaExamenTransito.val(),
            transito_practice_date: txtFechaPracticaTransito.val()
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
    if (isChangedComprobanteET) updatedComprobanteET();
    if (isChangedComprobanteET) updatedComprobanteEP();


}

/**
 * Actualiza datos de un estudiante solamente registrado
 */
function updateStudentRegisteredOnly() {
    let validate = isValidatedFields();
    let email = isEmail(txtEmail.val());

    if (!validate.isValidate) { alert(validate.message); return; }
    if (!email.isEmail) { alert(email.message); return; }
    if (!confirm('¿Desea cambiar los datos de estudiante?')) { return; }

    $.ajax({
        type: 'POST',
        url: "../Ajax/StudentAjax.php",
        cache: false,
        data: {
            callback: "updateInfoStudentRegisteredOnly",
            id: parseInt($('#id-estudiante').val()),
            name: txtNombre.val(),
            last: txtApellido.val(),
            birthdate: txtFechaNacimiento.val(),
            gender: selectSexo.val(),
            idcard: txtCedula.val(),
            passport: txtPasaporte.val(),
            email: txtEmail.val(),
            password: txtPassword.val(),
            phone: txtTelefono.val(),
            address: txtDireccion.val(),
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
 * Metodo actualiza foto de perfil en la vista Informacion de estudiante.
 */
function updateProfilePhoto() {
    let fd = new FormData();
    fd.append('file', inputProfilePhoto[0].files[0]);
    fd.append('idcard', $('#id-estudiante').val());

    $.ajax({
        type: 'POST',
        url: "../Ajax/ProfilePhotoAjax.php",
        cache: false,
        data: fd,
        processData: false,
        contentType: false,
        success: function(data) {
            if (data === 0) alert('Ha ocurrido un error al subir imagen de perfil');
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
 * Evento que se desencadena cuando el estado del select-estado cambia
 * @param {*} evt 
 */
function selectEstadoEventChange(evt) {
    if (btnSubmit.prop('disabled')) {
        btnSubmit.attr({ disabled: false });
    }
}

/**
 * Evento que se desencadena cuando el estado del select-sexo cambia
 * @param {*} evt 
 */
function selectSexoEventChange(evt) {
    if (btnSubmit.prop('disabled')) {
        btnSubmit.attr({ disabled: false });
    }
}

/**
 * Evento que se desencadena cuando el estado del select-sexo cambia
 * @param {*} evt 
 */
function selectNivelEventChange(evt) {
    if (btnSubmit.prop('disabled')) {
        btnSubmit.attr({ disabled: false });
    }
}

/**
 * Evento que se desencadena cuando los radio buttons
 * de principiante cambian de estado
 * @param {*} evt 
 */
function radioButtonsPrincipianteEventChange(evt) {
    if (btnSubmit.prop('disabled')) {
        btnSubmit.attr({ disabled: false });
    }
}

/**
 * Evento que se desencadena cuando los radio buttons
 * de licencia cambian de estado
 * @param {*} evt 
 */
function radioButtonsLicenciaEventChange(evt) {
    if (btnSubmit.prop('disabled')) {
        btnSubmit.attr({ disabled: false });
    }
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
    if (!txtNombre.val()) {
        return { isValidate: false, message: "Nombre no puede estar vacío" };
    } else if (!txtCedula.val()) {
        return { isValidate: false, message: "Cédula no puede estar vacío" };
    } else if (!txtEmail.val()) {
        return { isValidate: false, message: "Correo no puede estar vacío" };
    } else if (!txtTelefono.val()) {
        return { isValidate: false, message: "Teléfono no puede estar vacío" };
    } else if (!txtPassword.val()) {
        return { isValidate: false, message: "Contraseña no puede estar vacío" };
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
 * Verificacion de disponibilidad de la modalidad a actualizar.
 * @param {*} modalityOld Modalidad actual del estudiante
 * @param {*} modalityNew Modalidad a la que se quiere cambiar al estudiante
 */
function isModalityAvailable(modalityOld, modalityNew) {
    let result;
    let optionText = $("#select-modalidades option:selected").text();
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
            `Modalidad "${optionText}" está ocupada, por favor seleccionar otra` : ''
    };
}

/**
 * Evento que se desencadena cuando el elemento input file (Foto de perfil)
 * de la vista de Informacion de estudiante cambia de estado.
 * @param {*} evt 
 */
function inputProfilePhotoEventChange(evt) {
    const fileReader = new FileReader();
    const files = inputProfilePhoto[0].files[0];

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
 * Evento que se desencadena cuando el elemento input file (Foto de perfil)
 * de la vista de Informacion de estudiante cambia de estado.
 * @param {*} evt 
 */
function inputComprobanteEventChange(evt) {
    const fileReader = new FileReader();
    const files = fileComprobante[0].files[0];
    console.log('Funcion cuando cambia el input comprobante');
    isChangedComprobanteET = true;

    if (btnSubmit.prop('disabled')) {
        btnSubmit.attr({ disabled: false });
    }
}


function updatedComprobanteET() {
    let fd = new FormData();
    fd.append('file', fileComprobante[0].files[0]);
    fd.append('idcard', $('#id-estudiante').val());

    $.ajax({
        type: 'POST',
        url: "../Ajax/UploadComprobante.php",
        cache: false,
        data: fd,
        processData: false,
        contentType: false,
        success: function(data) {
            if (data === 0) {
                alert('Ha ocurrido un error al subir el archivo');
            }

            // window.location.reload();
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + '\r\n' +
                xhr.statusText + '\r\n' +
                xhr.responseText + '\r\n' +
                ajaxOptions);
        }
    });

    //window.location.reload();
}

function updatedComprobanteEP() {
    let fd = new FormData();
    fd.append('file', fileComprobanteP[0].files[0]);
    fd.append('idcard', $('#id-estudiante').val());

    $.ajax({
        type: 'POST',
        url: "../Ajax/UploadComprobanteP.php",
        cache: false,
        data: fd,
        processData: false,
        contentType: false,
        success: function(data) {
            if (data === 0) alert('Ha ocurrido un error al subir imagen de perfil');
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + '\r\n' +
                xhr.statusText + '\r\n' +
                xhr.responseText + '\r\n' +
                ajaxOptions);
        }
    });



}


function previsualizarImg(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#template-comprobante').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

$("#comprobanteET").change(function() {
    previsualizarImg(this);
});



function previsualizarImg2(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#template-comprobante-2').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

$("#comprobanteEP").change(function() {
    previsualizarImg2(this);
});


function previsualizarImg3(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#view-1').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

$("#comprobanteET").change(function() {
    previsualizarImg3(this);
});

function previsualizarImg4(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#view-2').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

$("#comprobanteEP").change(function() {
    previsualizarImg4(this);
});









/**
 * Arranque del codigo
 */

$(document).ready(init);