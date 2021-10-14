<?php
$data = $_REQUEST['all'] ?? '';
$idInstructor = $_REQUEST['Instructor'] ?? '';

echo $idInstructor;

//echo $data;
include_once('../Utilidades/conexion.php');
include_once('../Utilidades/confiDev.php');
include_once('../Controladores/StudentController.php');
include_once('../Modelos/StudentModel.php');
include_once('../Modelos/ScheduleModel.php');
include_once('../Controladores/ScheduleController.php');
include_once('../Modelos/UserModel.php');

$studentController = new StudentController();
$scheduleController = new ScheduleController();
$dataStudent = $studentController->getInfoStudentById($data) ?? '';
$events = $scheduleController->getAllHorario($idInstructor);

$userModel = new UserModel();
$query = $userModel->getallUser();
foreach ($query

    as $user) {
    $nombre = $user['Nombre'];
    $apellido = $user['Apellido'];
    $password = $user['Password'];
    $idUser = $user['IdUsuario'];
    $foto = $user['Foto'];
}
// echo "<script> alert('Id de la info: $info') </script>";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="gb18030">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="Plataforma en linea, escuela de manejo century" content="">
    <meta name="century creativa" content="">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">

    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <link href="../../css/font-awesome.min.css" rel="stylesheet">
    <link href="../../css/aos.css" rel="stylesheet">
    <link href="../css/modal.css" rel="stylesheet">
    <link href="../../css/fullcalendar.css" rel="stylesheet">
    <link href="../../css/fullcalendar.min.css" rel="stylesheet">

    <script src="../../js/popper.min.js"></script>
    <script src="../../js/aos.js"></script>
    <script src="../../js/fontawesome.js"></script>
    <script src="../../js/jquery-3.5.1.min.js"></script>

    <script src="../../js/jquery.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <script src="../../js/moment.min.js"></script>
    <script src="../../js/fullcalendar/fullcalendar.min.js"></script>
    <script src="../../js/fullcalendar/fullcalendar.js"></script>
    <script src="../../js/fullcalendar/locale/es.js"></script>


    <title>Escuela de Manejo Century</title>
</head>

<body background="../img/backgrounds/info-min.png">
    <!-- Contenedor de ventana Modal -->
    <div class="modal show" id="estudiante-modal" tabindex="-1" role="dialog">
        <!-- Ventana Modal -->
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <a href="/admin/?modulo=estudiantes" id="btn-back" class="btn btn-primary btn-sm">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <h4 class="modal-title m-auto font-weight-bold" style="text-align: center;">Horario de prácticas</h4>
                </div>
                <div class="modal-body principal">
                    <form class="" action="" method="post" enctype="multipart/form-data">

                        <!-- Division de informacion -->
                        <!-- Calendario FullCalendar-->
                        <div class="container">
                            <h5 class="pr-4 pl-4 font-weight-bold">Información de horario</h5>
                            <div id="calendar" class="col-md-12">
                            </div>

                            <!-- Modal EDITAR HORARIO-->

                            <div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <form class="form-horizontal" method="POST">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">Informacion del horario</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <input type="hidden" name="idEstudiante" id="idEstudiante" value=<?php echo $data ?>>
                                            <input type="hidden" name="idUser" id="idUser" value=<?php echo $idUser ?>>
                                            <input type="hidden" name="id" class="form-control" id="id">

                                            <div class="modal-body">
                                                <!-- Division de entrada de datos -->
                                                <!-- Division de entrada de datos -->
                                                <div class="form-group principal row pr-4 pl-4 mr-0 ml-0">
                                                    <label for="title" class="col-sm-3 control-label">Estudiante y horario escogido:</label>
                                                    <div class="col" style="font-size: 13px;">
                                                        <input type="text" name="title" class="form-control" id="title" placeholder="Titulo" readonly>
                                                    </div>
                                                </div>

                                                <!-- Division de entrada de datos -->
                                                <div class="form-group principal row pr-4 pl-4 mr-0 ml-0">
                                                    <label for="start" class="col-sm-3 control-label">Fecha Inicial: </label>
                                                    <div class="col" style="font-size: 13px;">
                                                        <input type="text" name="start" class="form-control" id="start" readonly>
                                                    </div>
                                                </div>

                                                <!-- Division de entrada de datos -->
                                                <div class="form-group principal row pr-4 pl-4 mr-0 ml-0">
                                                    <label for="start" class="col-sm-3 control-label">Fecha Final: </label>
                                                    <div class="col" style="font-size: 13px;">
                                                        <input type="text" name="end" class="form-control" id="end" readonly>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botones del formulario -->
                        <!-- <div class="modal-footer border-0 d-flex justify-content-center">
                            <a href="/admin/?modulo=horarios" type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancelar</a>
                            <button type="submit" class="btn btn-primary btn-sm">Actualizar</button>
                        </div>-->
                    </form>
                </div>
                <div class="modal-footer">
                    <!-- Generar Hoja de inscripcion -->
                    <div class="pr-2 text-right">
                        <form id="frm-reportes" action="/admin/Utilidades/HojaHorario.php?id=<?php echo $idInstructor; ?>" target="_blank" method="POST" autocomplete="off" enctype="multipart/form-data">
                            <input type="hidden" name="nombreReporte" value="reporte1">
                            <input type="hidden" name="id-er" value="<?php echo $idInstructor; ?>">
                            <button type="submit" class="btn-success btn-generar-report">
                                <i class="fas fa-print"></i> &nbsp;Generar
                            </button>
                        </form>
                    </div>
                    <!-- Fin generador de Hoja de inscripcion -->
                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            //variables del calendario
            var date = new Date();
            var yyyy = date.getFullYear().toString();
            var mm = (date.getMonth() - 1).toString().length == 1 ? "0" + (date.getMonth() + 1).toString() : (date.getMonth() + 1).toString();
            var dd = (date.getDate()).toString().length == 1 ? "0" + (date.getDate()).toString() : (date.getDate()).toString();

            //variables del horario

            //*** variables de inserci贸n */
            var
                HoraInicio = $("#HoraInicio"),
                HoraFin = $("#HoraFin"),
                title = $("#title"),
                FechaInicio = $("#start"),
                FechaFin = $("#end"),
                color = $('#color'),
                idEstudiante = $('#idEstudiante'),
                idUser = $('#idUser');


            var AddModal = $("#btn-guardar");
            AddModal.on("click", insertar);

            //*** variables de actualizaci贸n */

            var
                editHoraInicio = $('#edit-HoraInicio'),
                editHoraFin = $('#edit-HoraFin'),
                editColor = $('#edit-color'),
                idHorario = $('#id');

            var editHorario = $('#btn-actualizar');
            editHorario.on("click", eliminarModificarHorario);

            //eliminar horario

            var deleteHorario = $('input:checkbox[name=delete]');
            // deleteHorario.on("click", eliminarModificarHorario);

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

                /* select: function(start, end) {
                     $('#ModalAdd #start').val(moment(start).format('YYYY-MM-DD'));
                     $('#ModalAdd #end').val(moment(end).format('YYYY-MM-DD'));
                     $('#ModalAdd').modal('show');
                 },*/

                eventRender: function(event, element) {

                    element.bind('dblclick', function() {
                        $('#ModalEdit #id').val(event.id);
                        $('#ModalEdit #title').val(event.title);
                        $('#ModalEdit #start').val(moment(event.start).format('YYYY-MM-DD'));
                        $('#ModalEdit #end').val(moment(event.end).format('YYYY-MM-DD'));
                        $('#ModalEdit #color').val(event.color);
                        $('#ModalEdit').modal('show');

                    });
                },

                eventDrop: function(event, delta, revertFunc) { // si changement de position

                    edit(event);

                },
                eventResize: function(event, dayDelta, minuteDelta, revertFunc) { // si changement de longueur

                    edit(event);

                },


                events: [
                    <?php
                    foreach ($events as $event) :

                    ?> {
                            id: '<?php echo $event['IdHorario']; ?>',
                            apellido: '<?php echo $event['Apellido']; ?>',
                            nombre: '<?php echo $event['Nombre']; ?>',

                            creacion: '<?php echo $event['FechaCreacion']; ?>',
                            title: '<?php
                                    $HoraIncioFormateada = explode(":", $event['HoraInicio']);
                                    $HoraFinFormateada = explode(":", $event['HoraFin']);
                                    echo $HoraIncioFormateada[0] . ":" . $HoraIncioFormateada[1] . "-"
                                        . $HoraFinFormateada[0] . ":" . $HoraFinFormateada[1] . " " . $event['Nombre'] . ' ' . $event['Apellido'];; ?>',
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

            function edit(event) {
                start = event.start.format('YYYY-MM-DD HH:mm:ss');
                if (event.end) {
                    end = event.end.format('YYYY-MM-DD HH:mm:ss');
                } else {
                    end = start;
                }

                id = event.id;

                Event = [];
                Event[0] = id;
                Event[1] = start;
                Event[2] = end;

                $.ajax({
                    url: '../Ajax/ScheduleAjax.php',
                    type: "POST",
                    data: {
                        callback: 'editEventDate',
                        Event: Event
                    },
                    succces: function(response) {
                        if (response) {
                            alert('se modifico la fecha');
                        } else {
                            alert('ocurrio un error');

                        }
                    }
                });
            }

            function insertar() {
                // Pasando hora inicio a minutos
                var partsIncio = HoraInicio.val().split(':');
                var totalInicio = parseInt(partsIncio[0]) * 60 + parseInt(partsIncio[1]);

                // Pasando hora Fin a minutos
                var partsFin = HoraFin.val().split(':');
                var totalFin = parseInt(partsFin[0]) * 60 + parseInt(partsFin[1]);

                var TotalNecesario = totalInicio + 60;
                var Limite = totalInicio + 180;

                if (HoraInicio.val() < HoraFin.val()) {
                    if (totalFin >= TotalNecesario) {
                        if (totalFin <= Limite) {
                            $.ajax({
                                type: "POST",
                                url: "../Ajax/ScheduleAjax.php",
                                data: {
                                    callback: 'addSchedule',
                                    start: FechaInicio.val(),
                                    end: FechaFin.val(),
                                    color: color.val(),
                                    horaInicio: HoraInicio.val(),
                                    horaFin: HoraFin.val(),
                                    idEstudiante: idEstudiante.val(),
                                    idUser: idUser.val()
                                },
                                success: function(response) {
                                    alert('Horario agregado exitosamente');
                                },
                                error: function(xhr, ajaxOptions, thrownError) {
                                    alert(thrownError + '\r\n' +
                                        xhr.statusText + '\r\n' +
                                        xhr.responseText + '\r\n' +
                                        ajaxOptions);
                                }
                            });
                        } else {
                            alert('las horas practicas no puden ser mayor a 3 horas que equivale a ' + Limite + 'segundos');
                        }
                    } else {
                        alert('las horas practicas deben de tener por lo menos una hora de duracion');
                    }

                } else {
                    alert('La hora de inicio:  ' + HoraInicio.val() + '   no puede ser mayor a la hora final: ' +
                        HoraFin.val() + '   Hora Inicial separada= ' + totalInicio + '   Hora Final separada= ' + totalFin +
                        ' la horafinal tiene que ser por lo menos de = ' + TotalNecesario);
                }
            }

            function eliminarModificarHorario() {
                // Pasando hora inicio a minutos
                var partsIncio = editHoraInicio.val().split(':');
                var totalInicio = parseInt(partsIncio[0]) * 60 + parseInt(partsIncio[1]);

                // Pasando hora Fin a minutos
                var partsFin = editHoraFin.val().split(':');
                var totalFin = parseInt(partsFin[0]) * 60 + parseInt(partsFin[1]);

                var TotalNecesario = totalInicio + 60; // Tiempo mayor a una hora
                var Limite = totalInicio + 180; //Tiempo no mayor a tres horas
                if (editHoraInicio.val() != "" && editHoraFin.val() != "") {
                    if (editHoraInicio.val() < editHoraFin.val()) {
                        if (totalFin >= TotalNecesario) {
                            if (totalFin <= Limite) {
                                $.ajax({
                                    type: "POST",
                                    url: "../Ajax/ScheduleAjax.php",
                                    data: {
                                        callback: 'deleteModifySchedule',
                                        color: editColor.val(),
                                        horaInicio: editHoraInicio.val(),
                                        horaFin: editHoraFin.val(),
                                        id: idHorario.val(),
                                    },
                                    success: function(response) {
                                        if (response) {
                                            alert('consulta efectuada actualizar');
                                        } else {
                                            alert('hubo un error efectuando la consulta');
                                        }
                                    }
                                });
                            }
                        }
                    }

                } else if (deleteHorario.filter(':checked').val() != "") {
                    $.ajax({
                        type: "POST",
                        url: "../Ajax/ScheduleAjax.php",
                        data: {
                            callback: 'deleteModifySchedule',
                            id: idHorario.val(),
                            delete: deleteHorario.filter(':checked').val()
                        },
                        success: function(response) {
                            if (response) {
                                alert('consulta efectuada eliminar');
                            } else {
                                alert('hubo un error efectuando la consulta');
                            }
                        }
                    });
                }
            }
        });
    </script>
</body>

</html>