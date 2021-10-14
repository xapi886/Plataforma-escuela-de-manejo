$(document).ready(function() {


    //Foto Cedula delante
    function previsualizarImg(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#img-template').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    //Foto Cedula detras
    function previsualizarImg1(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#img-template-1').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function previsualizarImg2(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#img-template-3').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#foto-cedula-delante").change(function() {
        previsualizarImg(this);
    });
    $("#foto-cedula-detras").change(function() {
        previsualizarImg1(this);
    });
    $("#foto-pago").change(function() {
        previsualizarImg2(this);
    });
});