$(document).ready(function() {



    //var btnExamen = $("#Examen");

    var Estado = document.getElementById('estado');
    var btnExamen = document.getElementById('Examen-1');
    //alert(Estado.value);
    window.addEventListener("load", function() {
        if (Estado.value == "Activo") {
            document.getElementById('Examen-1').disabled = false;
            document.getElementById('Examen-2').disabled = false;
            document.getElementById('Examen-3').disabled = false;
            document.getElementById('Examen-4').disabled = false;
            document.getElementById('Examen-5').disabled = false;
        } else {
            document.getElementById('Examen-1').disabled = true;
            document.getElementById('Examen-2').disabled = true;
            document.getElementById('Examen-3').disabled = true;
            document.getElementById('Examen-4').disabled = true;
            document.getElementById('Examen-5').disabled = true;
        }
    });

    $("#Examen-1").on("click", function() {
        var respuesta = confirm("¿Esta seguro de realizar el examen? solo tendrá 20 min y una unica oportunidad");
        if (respuesta == true) {
            return true;
        } else {
            return false;
        }
    });
    $("#Examen-2").on("click", function() {
        var respuesta = confirm("¿Esta seguro de realizar el examen? solo tendrá 20 min y una unica oportunidad");
        if (respuesta == true) {
            return true;
        } else {
            return false;
        }
    });
    $("#Examen-3").on("click", function() {
        var respuesta = confirm("¿Esta seguro de realizar el examen? solo tendrá 20 min y una unica oportunidad");
        if (respuesta == true) {
            return true;
        } else {
            return false;
        }
    });
    $("#Examen-4").on("click", function() {
        var respuesta = confirm("¿Esta seguro de realizar el examen? solo tendrá 20 min y una unica oportunidad");
        if (respuesta == true) {
            return true;
        } else {
            return false;
        }
    });
    $("#Examen-5").on("click", function() {
        var respuesta = confirm("¿Esta seguro de realizar el examen? solo tendrá 20 min y una unica oportunidad");
        if (respuesta == true) {
            return true;
        } else {
            return false;
        }
    });
})