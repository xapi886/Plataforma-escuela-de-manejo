$(document).ready(function() {


    /**Variables de información del estudiante */

    var fechaNacimiento = ('#editar-fecha-nacimiento');
    var edad = $('#edad');
    /** variables de fecha de examenes*/
    var fechaET = $('#fecha-examen-teorico'),
        fechaEP = $('#fecha-examen-practico'),
        fechaETT = $('#fecha-examen-teorico-transito'),
        fechaEPT = $('#fecha-examen-practico-transito');

    /**Requiisitos de los examenes */
    var licenciarME = $('#licencia-me');
    var licenciaOrdinaria = $('#licencia-ordinaria');

    console.log(edad.val());
    console.log(fechaETT.text());
    licenciarME.hide();
    licenciaOrdinaria.hide();

    var containerEPme = $('#container-EP-me'); // contenedor EP menor de edad
    var containerETme = $('#container-ET-me'); // contenedor ET menor de edad
    var containerEPlo = $('#container-ET-lo'); // contenedor ET licencia ordinaria
    var containerETlo = $('#container-EP-lo'); // contenedor EP licencia ordinaria


    if (fechaETT.text() != "0000-00-00" && fechaEPT.text() == "0000-00-00") { // cuando la fecha ET ha sido asignada
        if (parseFloat(edad.val()) <= 16) {
            console.log("es un menor de edad");
            console.log("toy aqui 1 me cuando solo la fecha ET ha sido asignada");

            licenciarME.show();
            containerEPme.hide();
        } else if (parseFloat(edad.val()) >= 17) {
            console.log("Es un mayor de edad");
            licenciaOrdinaria.show();
            containerEPlo.hide();
            console.log("toy aqui 2 lo cuando solo la fecha ET ha sido asignada");

        }
    } else if (fechaEPT.text() != "0000-00-00" && fechaETT.text() == "0000-00-00") { // cuando la fecha EP ha sido asignada
        if (parseFloat(edad.val()) <= 16) {
            console.log("es un menor de edad");
            console.log("toy aqui 1 me cuando solo la fecha EP ha sido asignada");

            licenciarME.show();
            containerETme.hide();
        } else if (parseFloat(edad.val()) >= 17) {
            console.log("Es un mayor de edad");
            console.log("toy aqui 2 lo cuando solo la fecha EP ha sido asignada");

            licenciaOrdinaria.show();
            containerETlo.hide();
        }
    } else if (fechaETT.text() != "0000-00-00" && fechaEPT.text() != "0000-00-00") {
        /**cuando ambas fechas han sido asignadas*/
        if (parseFloat(edad.val()) <= 16) {
            console.log("es un menor de edad");
            console.log("ambas fechas han sido asignadas");
            licenciarME.show();
            console.log("toy aqui 1 me cuando ambas fechas EP ha sido asignada");


        } else if (parseFloat(edad.val()) >= 17) {
            console.log("Es un mayor de edad");
            console.log("ambas fechas han sido asignadas");
            licenciaOrdinaria.show();
            console.log("toy aqui 1 lo cuando ambas fechas EP ha sido asignada");

        }
    }


});