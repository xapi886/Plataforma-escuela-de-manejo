$(document).ready(function() {
    AOS.init();
    $('#input-icono-actualizar-Estudiante').change(function(e) {
        var file = e.target.files[0],
            imageType = /image.*/;
        if (!file.type.match(imageType)) {
            return;
        } else {
            var reader = new FileReader();
            reader.onload = fileOnload;
            reader.readAsDataURL(file);
        }
        var filename = $('#input-icono-actualizar-Estudiante').val().split("\\").pop();
        var idname = $('#input-icono-actualizar-Estudiante').attr("id");
        $("span." + idname).next().find("span").html(filename);
    });

    function fileOnload(e) {
        var result = e.target.result;
        $('#input-icono-actualizar-Estudiante').attr("src", result);
    }
})