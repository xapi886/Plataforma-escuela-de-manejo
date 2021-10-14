function insertarDatos() {
    $.ajax({
        type: "POST",
        url: "Utilidades/insertarDatos.php",
        data: $('#frminsert').serialize(),
        success: function(r) {
            console.log(r);
            if (r == 1) {
                $('#frminsert')[0].reset();
                swall("¡Agregado con exito!", ":D", "succes")
            } else {
                swal("¡Error!", ":(", "error");
            }

        }
    });

    return false;
}