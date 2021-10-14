<?php

include_once 'Plataforma/Utilidades/Utilidades.php';
include_once 'Plataforma/Utilidades/main.php';
include_once 'Plataforma/Utilidades/Session.php';

if (!isset($_SESSION['idUser'])) {
    session_regenerate_id(true);
    header("Location: ../");
} else {
    $session = new Session();
    $id  = $session->getCurrentId();
    $events = $controladorHorario->getHorarioByStudent($id);
}
?>
<link href="Plataforma/css/horario.css" rel="stylesheet">
<link href="../../css/fullcalendar.css" rel="stylesheet">
<link href="../../css/fullcalendar.min.css" rel="stylesheet">
<div class="principal-section p-0">
    <div class="container-fluid">
        <div class="row p-0 ">
            <div class="col-lg-12 col-l6-12 col-md-12 col-sm-12 col-12 p-0  mb-5">
               <div class="header-box-horario text-white text-center mt-5 mb-4">
                    <h5>Horario de clases practicas</h5>
                </div>
                <!-- Sección del Calendario -->
                <div class="horario-container px-5 pb-5  pt-3">
                    <div id="calendar">
                    </div>
                </div>
                <!-- Sección de abajo imprimir -->
                <!-- <div class="container">
                    <div class="form-group text-center mt-2 mb-2">
                        <button type="submit" class="btn btn-success text-center">
                            Imprimir
                            <i class="fas fa-print"></i>
                        </button>
                    </div>
                </div>-->
            </div>
        </div>
    </div>
</div>
<script src="../../js/jquery.js"></script>
<script src="../../js/moment.min.js"></script>
<script src="../../js/fullcalendar/fullcalendar.min.js"></script>
<script src="../../js/fullcalendar/fullcalendar.js"></script>
<script src="../../js/fullcalendar/locale/es.js"></script>
<script>
    $(document).ready(function() {
       function get_calendar_height() {
            return $(window).height();
        }
        $(window).resize(function() {
            $('#calendar').fullCalendar('option', 'height', get_calendar_height());
        });
        //variables del calendario
        var date = new Date();
        var yyyy = date.getFullYear().toString();
        var mm = (date.getMonth() - 1).toString().length == 1 ? "0" + (date.getMonth() + 1).toString() : (date.getMonth() + 1).toString();
        var dd = (date.getDate()).toString().length == 1 ? "0" + (date.getDate()).toString() : (date.getDate()).toString();
        $('#calendar').fullCalendar({
            header: {
                language: 'es',
                left: "prev,next,today",
                center: 'title',
                right: 'month,basicWeek,basicDay',
            },
            defaultDate: yyyy + "-" + mm + "-" + dd,
            editable: true,
            eventLimit: true,
            selectable: true,
            selectHelper: true,
            height: get_calendar_height,
            select: function(start, end) {
                $('#ModalAdd #start').val(moment(start).format('YYYY-MM-DD'));
                $('#ModalAdd #end').val(moment(end).format('YYYY-MM-DD'));
                // $('#ModalAdd #diaI').val(moment(start).format('dddd'));
                // $('#ModalAdd #diaF').val(moment(end).format('dddd'));
                var endFormateado = $('#ModalAdd #endForm').val(moment(end).subtract(1, "days").format('YYYY-MM-DD'));
                //var startdate = moment();
                //startdate = startdate.subtract(1, "days");
                //startdate = startdate.format("DD-MM-YYYY");
                $('#ModalAdd').modal('show');
            },
            events: [
                <?php
                foreach ($events as $event) :
                ?> {
                        id: '<?php echo $event['IdHorario']; ?>',
                        apellido: '<?php echo $event['Apellido']; ?>',
                        nombre: '<?php echo $event['Nombre']; ?>',
                        color: '<?php echo $event['Color']; ?>',
                        creacion: '<?php echo $event['FechaCreacion']; ?>',
                        title: '<?php
                                    $HoraIncioFormateada = explode(":", $event['HoraInicio']);
                                    $HoraFinFormateada = explode(":", $event['HoraFin']);
                                    echo $HoraIncioFormateada[0] . ":" . $HoraIncioFormateada[1] . "-"
                                        . $HoraFinFormateada[0] . ":" . $HoraFinFormateada[1] ?>',
                        start: '<?php echo $event['FechaInicio']; ?>',
                        end: '<?php echo $event['FechaFin']; ?>',
                        horaInicio: '<?php echo $event['HoraInicio']; ?>',
                        horaFin: '<?php echo $event['HoraFin']; ?>',
                        idEstudiante: '<?php echo $event['IdEstudiante']; ?>',
                        idUsuario: '<?php echo $event['IdUsuario']; ?>',
                    },
                <?php endforeach; ?>
            ]
        });
    });
</script>
<script>
</script>