$(document).ready(function() {
    var IdExamen = $('#idExamen');
    var IdEstudiante = $('#idEstudiante');

    var btnExamen = $('#btn-enviar-examen');
    //Variables de item Examen
    var preg1 = $('#1'),
        preg2 = $('#2'),
        preg3 = $('#3'),
        preg4 = $('#4'),
        preg5 = $('#5'),
        preg6 = $('#6'),
        preg7 = $('#7'),
        preg8 = $('#8'),
        preg9 = $('#9'),
        preg10 = $('#10'),
        preg11 = $('#11'),
        preg12 = $('#12'),
        preg13 = $('#13'),
        preg14 = $('#14'),
        preg15 = $('#15'),
        preg16 = $('#16'),
        preg17 = $('#17'),
        preg18 = $('#18'),
        preg19 = $('#19'),
        preg20 = $('#20');

    var resp1 = $('input[type=radio][name=Resp1]'),
        resp2 = $('input[type=radio][name=Resp2]'),
        resp3 = $('input[type=radio][name=Resp3]'),
        resp4 = $('input[type=radio][name=Resp4]'),
        resp5 = $('input[type=radio][name=Resp5]'),
        resp6 = $('input[type=radio][name=Resp6]'),
        resp7 = $('input[type=radio][name=Resp7]'),
        resp8 = $('input[type=radio][name=Resp8]'),
        resp9 = $('input[type=radio][name=Resp9]'),
        resp10 = $('input[type=radio][name=Resp10]'),
        resp11 = $('input[type=radio][name=Resp11]'),
        resp12 = $('input[type=radio][name=Resp12]'),
        resp13 = $('input[type=radio][name=Resp13]'),
        resp14 = $('input[type=radio][name=Resp14]'),
        resp15 = $('input[type=radio][name=Resp15]'),
        resp16 = $('input[type=radio][name=Resp16]'),
        resp17 = $('input[type=radio][name=Resp17]'),
        resp18 = $('input[type=radio][name=Resp18]'),
        resp19 = $('input[type=radio][name=Resp19]'),
        resp20 = $('input[type=radio][name=Resp20]');

    let actualizar = false;
    // Variables de tiempo
    var contador = $('#counter');
    var tiempoFormateado = $('#tiempo-formateado')
    contador.hide();
    /**
     * Validar ejecucion de funcion del tiempo en el exmane
     */

    var condicion = contador.text();

    if (Math.floor(condicion) >= 0) {
        setInterval(Tiempo, 1000);

    } else if (Math.floor(condicion) <= 0 && Math.floor(condicion) >= -1) {
        RecargarExamenresultadoExamen();
    }

    btnExamen.on('click', RecargarExamenresultadoExamen);

    function RecargarExamenresultadoExamen() {
        $("div").remove(".contenedor-principal-examen");
        $.ajax({
            type: 'POST',
            url: "Plataforma/Ajax/ajaxExamen.php",
            cache: false,
            data: {
                functionName: "insertar",
                IdExamen: IdExamen.val(),
                preg1: preg1.val(),
                preg2: preg2.val(),
                preg3: preg3.val(),
                preg4: preg4.val(),
                preg5: preg5.val(),
                preg6: preg6.val(),
                preg7: preg7.val(),
                preg8: preg8.val(),
                preg9: preg9.val(),
                preg10: preg10.val(),
                preg11: preg11.val(),
                preg12: preg12.val(),
                preg13: preg13.val(),
                preg14: preg14.val(),
                preg15: preg15.val(),
                preg16: preg16.val(),
                preg17: preg17.val(),
                preg18: preg18.val(),
                preg19: preg19.val(),
                preg20: preg20.val(),
                resp1: resp1.filter(':checked').val(),
                resp2: resp2.filter(':checked').val(),
                resp3: resp3.filter(':checked').val(),
                resp4: resp4.filter(':checked').val(),
                resp5: resp5.filter(':checked').val(),
                resp6: resp6.filter(':checked').val(),
                resp7: resp7.filter(':checked').val(),
                resp8: resp8.filter(':checked').val(),
                resp9: resp9.filter(':checked').val(),
                resp10: resp10.filter(':checked').val(),
                resp11: resp11.filter(':checked').val(),
                resp12: resp12.filter(':checked').val(),
                resp13: resp13.filter(':checked').val(),
                resp14: resp14.filter(':checked').val(),
                resp15: resp15.filter(':checked').val(),
                resp16: resp16.filter(':checked').val(),
                resp17: resp17.filter(':checked').val(),
                resp18: resp18.filter(':checked').val(),
                resp19: resp19.filter(':checked').val(),
                resp20: resp20.filter(':checked').val()
            },
            //dataType: 'json',
            success: function(response) {
                $('#result-examen').html(response);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + '\r\n' +
                    xhr.statusText + '\r\n' +
                    xhr.responseText + '\r\n' +
                    ajaxOptions);
            }
        });
    }


    function Tiempo() {
        var tiempoInicial = contador.text();
        var tiempRestante = 0;
        var tiempo = new Date().getTime(); //Tiempo de hoy con respecto a 1970 OMG;
        tiempRestante += 1;
        var tiempoRestante = tiempoInicial - tiempRestante;
        var Seconds = tiempoInicial; // 1200 segundos equivalente a 20 minutos
        var Minutes = Math.floor(Seconds / 60); // = 20 minutos es el resultado de 1200/60
        Seconds -= Minutes * (60);
        var TimeStr = LeadingZero(Minutes) + ":" + LeadingZero(Seconds);


        console.log(tiempoRestante);
        if (Math.floor(tiempoInicial) >= 0) {
            $.ajax({
                type: 'POST',
                url: "Plataforma/Ajax/ajaxExamen.php",
                cache: false,
                data: {
                    functionName: "actualizar",
                    tiempoRestante: tiempoRestante,
                    TimeStr: TimeStr
                },
                //dataType: 'json',
                success: function(response) {
                    console.log(response);
                    document.getElementById('counter').innerHTML = tiempoRestante;
                    // console.log('Los minutos son: ' + Minutes);
                    //console.log('los segundos son: ' + Seconds);
                    //console.log('TimeStr: ' + TimeStr);
                    console.log(preg1.val(), preg2.val(), preg3.val(), preg4.val(), preg5.val(), preg6.val(), preg7.val(), preg8.val(), preg10.val());
                    console.log(resp1.filter(':checked').val(), resp2.filter(':checked').val(), resp3.filter(':checked').val(), resp4.filter(':checked').val());
                    console.log(Math.floor(tiempoInicial));
                    tiempoFormateado.html(TimeStr);
                    console.log(IdExamen.val());

                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError + '\r\n' +
                        xhr.statusText + '\r\n' +
                        xhr.responseText + '\r\n' +
                        ajaxOptions);
                }
            });
        } else if (Math.floor(tiempoInicial) <= 0 && Math.floor(tiempoInicial) >= -1) {
            RecargarExamenresultadoExamen();
            window.location.reload();
        }
    }

    function LeadingZero(Time) {
        return (Time < 10) ? "0" + Time : +Time;
    }

    //resp1.on("click")
    // resp1.on('click', RecargarExamenresultadoExamen);
    deshabilitar(resp1);
    deshabilitar(resp2);
    deshabilitar(resp3);
    deshabilitar(resp4);
    deshabilitar(resp5);
    deshabilitar(resp6);
    deshabilitar(resp7);
    deshabilitar(resp8);
    deshabilitar(resp9);
    deshabilitar(resp10);
    deshabilitar(resp11);
    deshabilitar(resp12);
    deshabilitar(resp13);
    deshabilitar(resp14);
    deshabilitar(resp15);
    deshabilitar(resp16);
    deshabilitar(resp17);
    deshabilitar(resp18);
    deshabilitar(resp19);
    deshabilitar(resp20);

    function deshabilitar(field) {
        field.on('change', (evt) => {
            field.prop('disabled', true);
        });
    }


});