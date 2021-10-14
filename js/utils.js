class Utils {
    
    camposVacios(campos) {
        var state = true;
        for (let i = 0; i < campos.length; i++) {
            if (campos[i] != null) {
                if (campos[i].trim() != "") {
                } else {
                    state = false;
                }
            } else {
                state = false;
            }
        }
        return state;
    }

    camposVaciosNoRequeridosNumericos(campos) {
        for (let i = 0; i < campos.length; i++) {
            if (campos[i] == null) {
                campos[i] = "0";
            } else if (campos[i].trim() == "") {
                campos[i] = "0";
            }
        }
    }

    camposVaciosNoRequeridosString(campos) {
        for (let i = 0; i < campos.length; i++) {
            if (campos[i] == null) {
                campos[i] = "";
            } else if (campos[i].trim() == "") {
                campos[i] = "";
            }
        }
    }

    inyeccion(campos) {
        var state = true;
        for (let i = 0; i < campos.length; i++) {
            if (
                campos[i].includes('"') ||
                campos[i].includes("'") ||
                campos[i].includes(";") ||
                campos[i].includes(":") ||
                campos[i].includes(">") ||
                campos[i].includes("<") ||
                campos[i].includes("https") ||
                campos[i].includes("http") ||
                campos[i].includes("//") ||
                campos[i].includes("/")
            ) {
                state = false;
            }
        }
        return state;
    }

    //Metodo para limpiar las imagenes a su valor por defecto
    limpiarInputFoto(img, input, texto) {
        img.attr("src", "Imagenes/template.png");
        input.val("");
        texto.html("Click para subir una foto");
    }

    limpiarCamposCard(components) {
        for (let i = 0; i < components.length; i++) {
            components[i].html("");
        }
    }

    limpiarCamposSelect(components) {
        for (let i = 0; i < components.length; i++) {
            components[i].val(components[i].find("option:first").val());
        }
    }

    limpiarCamposText(components) {
        for (let i = 0; i < components.length; i++) {
            components[i].val("");
        }
    }

    validarSoloLetras(components) {
        for (let i = 0; i < components.length; i++) {
            components[i].addEventListener("keypress", function (e) {
                const soloLetras = new RegExp("^[A-Z,Á,É,Í,Ó,Ú,Ý]+$", "i");
                if (!soloLetras.test(String.fromCharCode(e.keyCode))) {
                    e.preventDefault();
                }
            });
        }
        /*^ indica que el patrón debe iniciar con los caracteres dentro de los corchetes
             [] indica que los caracteres admitidos son letras del alfabeto
             + indica que los caracteres dentro de los corchetes se pueden repetir
             $ indica que el patrón finaliza con los caracteres que están dentro de los corchetes.
             i indica que validaremos letras mayúsculas y minúsculas (case-insensitive)*/
    }

    soloNumeros(caracter, e, numeroVal) {
        var numero = numeroVal;
        if (String.fromCharCode(caracter) === "." && numero.length === 0) {
            e.preventDefault();
        } else if (numero.includes(".") && String.fromCharCode(caracter) === ".") {
            e.preventDefault();
        } else {
            const soloNumeros = new RegExp("^[0-9]+$");
            if (
                !soloNumeros.test(String.fromCharCode(caracter)) &&
                !(String.fromCharCode(caracter) === ".")
            ) {
                e.preventDefault();
            }
        }
    }

    soloEnteros(caracter, e) {
        const soloNumeros = new RegExp("^[0-9]+$");
        if (!soloNumeros.test(String.fromCharCode(caracter))) {
            e.preventDefault();
        }
    }

    soloLetras(caracter, e) {
        if (e.charCode != 32) {
            const soloLetras = new RegExp("^[A-Z,Á-Ú,a-z,á-ú]+$");
            if (!soloLetras.test(String.fromCharCode(caracter))) {
                e.preventDefault();
                return true;
            }
            return false;
        }
    }

    soloLetrasNumeros(caracter, e) {
        if (e.charCode != 32) {
            const soloLetras = new RegExp("^[A-Z,Á-Ú,a-z,á-ú,0-9]+$");
            if (!soloLetras.test(String.fromCharCode(caracter))) {
                e.preventDefault();
                return true;
            }
            return false;
        }
    }

    bloquearCopiado(components) {
        for (let i = 0; i < components.length; i++) {
            components[i].on("paste", function (e) {
                e.preventDefault();
            });
        }
    }

    bloquearPegado(components) {
        for (let i = 0; i < components.length; i++) {
            components[i].on("copy", function (e) {
                e.preventDefault();
            });
        }
    }

    lostFocusDescuento(components) {
        for (let i = 0; i < components.length; i++) {
            components[i].on("blur", function () {
                var valor = components[i].val();

                if (valor.trim().length === 0) {
                    components[i].val("0.00");
                } else {
                    if (components[i].val() > 100) {
                        components[i].val("100");
                    }

                    if (
                        valor.substring(valor.length - 1, valor.length) === "." &&
                        components[i].val() < 100
                    ) {
                        components[i].val(components[i].val() + "00");
                    }

                    if (!valor.includes(".")) {
                        components[i].val(components[i].val() + ".00");
                    }
                }
            });
        }
    }

    lostFocus(components) {
        for (let i = 0; i < components.length; i++) {
            components[i].on("blur", function () {
                var valor = components[i].val();

                if (valor.trim().length === 0) {
                    components[i].val("0.00");
                } else {
                    if (
                        valor.substring(valor.length - 1, valor.length) === "." &&
                        components[i].val() < 100
                    ) {
                        components[i].val(components[i].val() + "00");
                    }

                    if (!valor.includes(".")) {
                        components[i].val(components[i].val() + ".00");
                    }
                }
            });
        }
    }

    deshabilitarCampos(campos) {
        for (var i = 0; i < campos.length; i++) {
            campos[i].prop("disabled", true);
        }
    }

    habilitarCampos(campos) {
        for (var i = 0; i < campos.length; i++) {
            campos[i].prop("disabled", false);
        }
    }

    isNumber(numero) {
        if (isNaN(numero)) {
            return true;
        } else {
            return false;
        }
    }

    limitarImput(imput, tam) {
        imput.on("keypress", function () {
            if (imput.val().length >= tam) {
                return false;
            }
        });
    }

    cursorWait(componente) {
        componente.css("cursor", "wait");
    }

    cursorNormal(componente) {
        componente.css("cursor", "auto");
    }

    abrirModal(modal) {
        modal.modal("show");
    }

    ocultarModal(modal) {
        modal.modal("hide");
    }

    cerrarModal(modal) {
        var result = confirm(
            "Todos los datos no guardados se perderan, ¿estas seguro de continuar?"
        );
        if (result == true) {
            modal.modal("hide");
        }
    }
}
