$(document).ready(function() {

    objUtils = new Utils();

    //Llenado de variables del modal de inscripción





    var stlInsertarPrincipiante = $('#slt-insertar-principiante'),
        stlInsertarLicencia = $('#slt-insertar-licencia'),
        insertarCategoria = $('#insertar-categoria'),
        //llenado del contacto de emergencia
        insertarNombreCE = $('#insertar-nombreCE'),
        insertarApellidoCE = $('#insertar-apellidoCE'),
        insertarDireccionCE = $('#insertar-direccionCE'),
        insertarTelefonoCE = $('#insertar-telefonoCE'),
        insertarEmailCE = $('#insertar-EmailCE'),
        //llenado del lugar de trabajo
        insertarLugarTrabajo = $('#insertar-lugarTrabajo'),
        insertarTelefonoLT = $('#insertar-direccionLT'),
        insertarEmailLT = $('#insertar-emailLT'),
        //Observaciones
        insertarObservaciones = $('#insertar-Observaciones'),
        btnInsertarInscripcion = $('#btn-insertar-inscripcion');
    //limitar entradas de las var del lugar del Contacto de emergencia
    objUtils.limitarImput(insertarNombreCE, 40);
    objUtils.limitarImput(insertarApellidoCE, 40);
    objUtils.limitarImput(insertarDireccionCE, 40)
    objUtils.limitarImput(insertarTelefonoCE, 8);
    objUtils.limitarImput(insertarEmailCE, 100);
    //limitar entradas de las var del lugar de trabajo
    objUtils.limitarImput(insertarLugarTrabajo, 40);
    objUtils.limitarImput(insertarTelefonoLT, 8);
    objUtils.limitarImput(insertarEmailLT, 100);
    objUtils.limitarImput(insertarObservaciones, 200);
    //Eventos de insertar en Contacto de Emergencia
    insertarNombreCE.on("keypress", function(e) {
        objUtils.soloLetras(e.keycode, e);
    });
    insertarApellidoCE.on("keypress", function(e) {
        objUtils.soloLetras(e.keycode, e);
    });
    insertarDireccionCE.on("keypress", function(e) {
        objUtils.soloLetrasNumeros(e.keycode, e);
    })
    insertarTelefonoCE.on("keypress", function(e) {
        objUtils.soloNumeros(e.keycode, e);
    });
    insertarEmailCE.on("Keypress", function(e) {
        objUtils.soloLetrasNumeros(e.keycode, e);
    });
    //Eventos de insertar en el lugar de trabajo
    insertarLugarTrabajo.on("keypress", function(e) {
        objUtils.soloLetrasNumeros(e.keycode, e)
    });
    insertarTelefonoLT.on("keypress", function(e) {
        objUtils.soloEnteros(e.keycode, e)
    });
    insertarEmailLT.on("keypress", function(e) {
        objUtils.soloLetrasNumeros(e.keycode, e)
    });
    //insertar Observaciones
    insertarObservaciones.on("keypress", function(e) {
        objUtils.soloLetras(e.keycode, e)
    });
    btnInsertarInscripcion.on("click", insertar);

    function insertar() {
        //variable del contacto de emergencia
        var nombreCE = insertarNombreCE.val(),
            apellidoCE = insertarApellidoCE.val(),
            EmailCE = insertarEmailCE.val(),
            telefonoCE = insertarTelefonoCE.val(),
            direccionCE = insertarDireccionCE.val(),
            //variables del lugar de trabajo
            lugarTrabajo = insertarLugarTrabajo.val(),
            TelefonoLT = insertarTelefonoLT.val(),
            emailLT = insertarEmailLT.val(),
            //variable de observaciones
            Observaciones = insertarObservaciones.val(),
            camposInsertar = [insertarNombreCE, insertarApellidoCE, insertarEmailCE, insertarTelefonoCE, insertarDireccionCE,
                insertarLugarTrabajo, insertarTelefonoLT, insertarEmailLT
            ];
        datosInsertar = [nombreCE, apellidoCE, EmailCE, telefonoCE, direccionCE, lugarTrabajo, TelefonoLT, emailLT];
        if (objUtils.camposVacios(datosInsertar)) {
            if (objUtils.inyeccion(datosInsertar)) {
                var formData = new FormData();
                formData.append("nombreCE", nombreCE);
                formData.append("apellidoCE", apellidoCE);
                formData.append("emailCE", EmailCE);
                formData.append("TelefonoCE", telefonoCE);
                formData.append("DireccionCE", direccionCE);
                formData.append("lugarTrabajo", lugarTrabajo);
                formData.append("TelefonoLT", TelefonoLT);
                formData.append("EmailLT", emailLT);
                formData.append("Obervaciones", Observaciones);
                $.ajax({
                    type: "POST",
                    url: "ajax/AjaxInscripcion.php",
                    data: formData,
                    procesData: false,
                    processType: false,
                    cache: false,
                    success: function(data) {
                        if (data.trim() == "") {
                            finalizacionInsert(camposInsertar);
                            alert("Inscripción realizada correctamente");
                        } else {
                            alert(data.trimLeft().trimRight());
                        }
                    },
                });
            }
        }
    }
});