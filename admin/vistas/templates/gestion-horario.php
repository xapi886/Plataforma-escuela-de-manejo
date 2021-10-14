<?php
$data = $_REQUEST['data'] ?? '';
$tutor = $_REQUEST['tutor'] ?? '';

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
$events = $scheduleController->getHorarioByStudent($data);

$userModel = new UserModel();
$query = $userModel->getallUser();
foreach ($query as $user) {
    $nombre = $user['Nombre'];
    $apellido = $user['Apellido'];
    $password = $user['Password'];
    $idUser = $user['IdUsuario'];
    $foto = $user['Foto'];
}

$tutor = $studentController->showTutor($data);

$nameTutor = $tutor[0]['Nombre'];
$id = $tutor[0]['IdInstructor'];


echo $id;
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
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
                    <a href="/admin/?modulo=horarios" id="btn-back" class="btn btn-primary btn-sm">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <h4 class="modal-title m-auto font-weight-bold" style="text-align: center;">Horario de prácticas</h4>
                </div>
                <div class="modal-body principal">
                    <form class="" action="" method="post" enctype="multipart/form-data">
                        <!-- Division de informacion -->
                        <div style="margin-bottom: 50px;">
                            <h5 class="pr-4 pl-4 font-weight-bold">Información básica</h5>
                            <!-- Division de entrada de datos -->
                            <div class="form-group principal row pr-4 pl-4 mr-0 ml-0 border-bottom">
                                <label for="" class="col-form-label text-uppercase font-weight-bold text-muted d-flex align-items-center" style="font-size: 10px; padding: 0;">Foto</label>
                                <div class="p-0 text-right" style="width: 93%;">
                                    <img id="profile-photo" src=<?php echo "../../" . $dataStudent[0]['Foto'] ?> alt="Foto de perfil">
                                </div>
                            </div>
                            <!-- Division de entrada de datos -->
                            <div class="form-group principal row pr-4 pl-4 mr-0 ml-0 border-bottom">
                                <label for="" class="col-sm-3 col-form-label text-uppercase font-weight-bold text-muted d-flex align-items-center" style="font-size: 10px; padding: 0;">Nombre</label>
                                <div class="col-sm-8">
                                    <input type="text" readonly value=<?php echo $dataStudent[0]['Nombre'] ?> class="form-control-plaintext form-control-sm" id="" placeholder="Nombres">
                                </div>
                            </div>
                            <!-- Division de entrada de datos -->
                            <div class="form-group principal row pr-4 pl-4 mr-0 ml-0 border-bottom">
                                <label for="" class="col-sm-3 col-form-label text-uppercase font-weight-bold text-muted d-flex align-items-center" style="font-size: 10px; padding: 0;">Apellido</label>
                                <div class="col-sm-8">
                                    <input type="text" value=<?php echo $dataStudent[0]['Apellido'] ?> readonly class="form-control-plaintext form-control-sm" id="" placeholder="Apellidos">
                                </div>
                            </div>

                            <div class="form-group principal row pr-4 pl-4 mr-0 ml-0 border-bottom">
                                <label for="" class="col-sm-3 col-form-label text-uppercase font-weight-bold text-muted d-flex align-items-center" style="font-size: 10px; padding: 0;">Tutor</label>
                                <div class="col-sm-8">
                                    <input type="text" value=<?php  echo $nameTutor ?>  class="form-control-plaintext form-control-sm" id="" placeholder="Tutor" readonly>
                                </div>
                            </div>
                        </div>
                        <!-- Division de informacion -->
                        <!-- Calendario FullCalendar-->
                        <div class="container">
                            <h5 class="pr-4 pl-4 font-weight-bold">Información de horario</h5>
                            <div id="calendar" class="col-md-12">
                            </div>

                            <!-- Modal AGREGAR HORARIO-->
                            <div class="modal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <form class="form-horizontal" method="POST">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">Agregar horario</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <input type="hidden" name="idEstudiante" id="idEstudiante" value=<?php echo $data ?>>
                                            <input type="hidden" name="idUser" id="idUser" value=<?php echo $idUser ?>>

                                            <div class="modal-body">
                                                <!-- Division de entrada de datos -->
                                                <div class="form-group principal row pr-4 pl-4 mr-0 ml-0">
                                                    <label for="title" class="col-sm-3 control-label">Estudiante:</label>
                                                    <div class="col" style="font-size: 13px;">
                                                        <input type="text" name="title" class="form-control" value=<?php echo $dataStudent[0]['Nombre'] ?> id="title" placeholder="Titulo" readonly>
                                                    </div>
                                                </div>

                                                <!-- Division de entrada de datos -->
                                                <div class="form-group principal row pr-4 pl-4 mr-0 ml-0">
                                                    <label for="start" class="col-sm-3 control-label">Fecha Inicial: </label>
                                                    <div class="col" style="font-size: 13px;">
                                                        <input type="text" name="start" class="form-control" id="start" readonly>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="end" class="form-control" id="end" readonly>
                                                

                                                <!-- Division de entrada de datos -->
                                                <div class="form-group principal row pr-4 pl-4 mr-0 ml-0">
                                                    <label for="start" class="col-sm-3 control-label">Fecha Final: </label>
                                                    <div class="col" style="font-size: 13px;">
                                                        <input type="text" name="endForm" class="form-control" id="endForm" readonly>
                                                    </div>
                                                </div>

                                                <!-- Division de entrada de datos -->
                                                <div class="form-group principal row pr-4 pl-4 mr-0 ml-0">
                                                    <label for="end" class="col-sm-3 control-label">Hora de Inicio: </label>
                                                    <div class="col" style="font-size: 13px;">
                                                        <input type="time" min="06:00" max="18:00" class="form-control" name="HoraInicio" id="HoraInicio">
                                                    </div>
                                                </div>

                                                <!-- Division de entrada de datos -->
                                                <div class="form-group principal row pr-4 pl-4 mr-0 ml-0">
                                                    <label for="end" class="col-sm-3 control-label">Hora de Fin:</label>
                                                    <div class="col" style="font-size: 13px;">
                                                        <input type="time" min="06:00" max="18:00" class="form-control" name="HoraFin" id="HoraFin">
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
                                                <button type="submit" id="btn-guardar" class="btn btn-primary">Guardar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal EDITAR HORARIO-->
                            <div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <form class="form-horizontal" method="POST">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel2">Modificar horario</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <input type="hidden" name="idEstudiante" id="idEstudiante" value=<?php echo $data ?>>
                                            <input type="hidden" name="idUser" id="idUser" value=<?php echo $idUser ?>>
                                            <input type="hidden" name="id" class="form-control" id="id">

                                            <div class="modal-body">
                                                <!-- Division de entrada de datos -->
                                                <div class="form-group principal row pr-4 pl-4 mr-0 ml-0">
                                                    <label for="title" class="col-sm-3 control-label">Estudiante:</label>
                                                    <div class="col" style="font-size: 13px;">
                                                        <input type="text" class="form-control" value=<?php echo $dataStudent[0]['Nombre'] ?> placeholder="Titulo" readonly>
                                                    </div>
                                                </div>

                                                <!-- Division de entrada de datos -->
                                                <div class="form-group principal row pr-4 pl-4 mr-0 ml-0">
                                                    <label for="title" class="col-sm-3 control-label">Horario escogido:</label>
                                                    <div class="col" style="font-size: 13px;">
                                                        <input type="text" name="title" class="form-control" id="title" placeholder="Titulo" readonly>
                                                    </div>
                                                </div>

                                                <!-- Division de entrada de datos -->
                                                <div class="form-group principal row pr-4 pl-4 mr-0 ml-0">
                                                    <label for="start" class="col-sm-3 control-label">Fecha Inicial: </label>
                                                    <div class="col" style="font-size: 13px;">
                                                        <input type="text" name="edit-start" class="form-control" id="edit-start" readonly>
                                                    </div>
                                                </div>

                                                <!-- Division de entrada de datos -->

                                                <input type="hidden" name="end" class="form-control" id="edit-end" readonly>

                                                <div class="form-group principal row pr-4 pl-4 mr-0 ml-0">
                                                    <label for="start" class="col-sm-3 control-label">Fecha Final: </label>
                                                    <div class="col" style="font-size: 13px;">
                                                        <input type="text" name="edit-end-form" class="form-control" id="edit-end-form" readonly>
                                                    </div>
                                                </div>

                                                <!-- Division de entrada de datos -->
                                                <div class="form-group principal row pr-4 pl-4 mr-0 ml-0">
                                                    <label for="end" class="col-sm-3 control-label">Hora de Inicio: </label>
                                                    <div class="col" style="font-size: 13px;">
                                                        <input type="time" min="06:00" max="18:00" class="form-control" name="edit-HoraInicio" id="edit-HoraInicio">
                                                    </div>
                                                </div>

                                                <!-- Division de entrada de datos -->
                                                <div class="form-group principal row pr-4 pl-4 mr-0 ml-0">
                                                    <label for="end" class="col-sm-3 control-label">Hora de Fin:</label>
                                                    <div class="col" style="font-size: 13px;">
                                                        <input type="time" min="06:00" max="18:00" class="form-control" name="edit-HoraFin" id="edit-HoraFin">
                                                    </div>
                                                </div>

                                                <!-- Eliminar Evento -->
                                                <div class="form-group principal">
                                                    <div class="col-sm-offset-2 col-sm-10">
                                                        <div class="checkbox">
                                                            <label class="text-danger"><input type="checkbox" id="delete" name="delete"> Eliminar Evento</label>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
                                                <button type="submit" id="btn-actualizar" name="btn-actualizar" class="btn btn-primary">Actualizar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                        <!-- Seccion de link para mas ver todos los horarios -->
                        <div class="mt-4 pr-4 mb-4 text-right">
                            <a target="_blank" href="/admin/vistas/gestion-all-horario.php?all=<?php echo $data.'&Instructor='.$id; ?>" class="btn btn-outline-light btn-sm text-primary">&#8594;&nbsp;Ver todos los horarios</a>
                        </div>
                    </form>
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

            //*** variables de inserción */
            var
                HoraInicio = $("#HoraInicio"),
                HoraFin = $("#HoraFin"),
                title = $("#title"),
                FechaInicio = $("#start"),
                FechaFin = $("#end"),
                idEstudiante = $('#idEstudiante'),
                idUser = $('#idUser');

               // $('#calendar').render();
            var AddModal = $("#btn-guardar");
            AddModal.on("click", insertar);

            //*** variables de actualización */

            var
                editHoraInicio = $('#edit-HoraInicio'),
                editHoraFin = $('#edit-HoraFin'),
                // editColor = $('#edit-color'),
                editStart = $('#edit-start'),
                editEnd = $('#edit-end'),
                idHorario = $('#id');

            var editHorario = $('#btn-actualizar');
            editHorario.on("click", actualizar);


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
               // eventDrop: false,
                //eventResize: false,
                
                select: function(start, end) {
                                       // leemos las fechas de inicio de evento y hoy
                    var check = moment(start).format('YYYY-MM-DD');
                    var today = moment(new Date()).format('YYYY-MM-DD');

                    if (check >= today) {
                        $('#ModalAdd #start').val(moment(start).format('YYYY-MM-DD'));
                        $('#ModalAdd #end').val(moment(end).format('YYYY-MM-DD'));
                        var endFormateado = $('#ModalAdd #endForm').val(moment(end).subtract(1, "days").format('YYYY-MM-DD'));
                        $('#ModalAdd').modal('show');
                    }else{
                        alert('No se pueden agregar horarios en fechas pasadas');
                    }
                },

                eventRender: function(event, element) {

                    element.bind('dblclick', function() {
                        $('#ModalEdit #id').val(event.id);
                        $('#ModalEdit #title').val(event.title);
                        $('#ModalEdit #edit-start').val(moment(event.start).format('YYYY-MM-DD'));
                        $('#ModalEdit #edit-end').val(moment(event.end).format('YYYY-MM-DD'));

                        var endEditFormateado = $('#ModalEdit #edit-end-form').val(moment(event.end).subtract(1, "days").format('YYYY-MM-DD'));

                        //$('#ModalEdit #color').val(event.color);
                        $('#ModalEdit').modal('show');

                    });
                },

                /*eventDrop: function(event, delta, revertFunc) { // si changement de position

                    edit(event);

                },
                eventResize: function(event, dayDelta, minuteDelta, revertFunc) { // si changement de longueur

                    edit(event);

                },*/


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


           /* function edit(event) {
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
            }*/

            function insertar() {
                // Pasando hora inicio a minutos
                //let validate = isValidatedFields();
                // if (!validate.isValidate) { alert(validate.message); return; }

                var partsIncio = HoraInicio.val().split(':');
                var totalInicio = parseInt(partsIncio[0]) * 60 + parseInt(partsIncio[1]);

                // Pasando hora Fin a minutos
                var partsFin = HoraFin.val().split(':');
                var totalFin = parseInt(partsFin[0]) * 60 + parseInt(partsFin[1]);
                var TotalNecesario = totalInicio + 60;
                var Limite = totalInicio + 180;
                if (HoraInicio.val() != "" && HoraFin.val() != "") {
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
                                        horaInicio: HoraInicio.val(),
                                        horaFin: HoraFin.val(),
                                        idEstudiante: idEstudiante.val(),
                                        idUser: idUser.val()
                                    },
                                    success: function(data) {
                                        if (data) {
                                            alert(data);

                                        }
                                        $("#calendar").fullCalendar('render');

                                        //  window.location.reload();
                                    },
                                    error: function(xhr, ajaxOptions, thrownError) {
                                        alert(thrownError + '\r\n' +
                                            xhr.statusText + '\r\n' +
                                            xhr.responseText + '\r\n' +
                                            ajaxOptions);
                                    }
                                });
                                // window.location.reload();

                            } else {
                                alert('Las horas practicas no puden ser mayor a 3 horas que equivale');
                            }
                        } else {
                            alert('Las horas practicas deben de tener por lo menos una hora de duracion');
                        }

                    } else {
                        alert('La hora de inicio no puede ser mayor a la hora final');
                    }
                } else {
                    alert("La hora de inicio y hora de fin no pueden quedar vacios");
                }
                //  window.location.reload();

            }


            /**
             * Evento del boton btnShowPassword, muestra y oculta la contrasenia del
             * campo de texto txtPassword.
             * @param {*} evt
             */
            function actualizar() {

                //evt.preventDefault();
                // Pasando hora inicio a minutos
                console.log();
                var partsIncio = editHoraInicio.val().split(':');
                var totalInicio = parseInt(partsIncio[0]) * 60 + parseInt(partsIncio[1]);

                // Pasando hora Fin a minutos
                var partsFin = editHoraFin.val().split(':');
                var totalFin = parseInt(partsFin[0]) * 60 + parseInt(partsFin[1]);

                var TotalNecesario = totalInicio + 60; // Tiempo mayor a una hora
                var Limite = totalInicio + 180; //Tiempo no mayor a tres horas

                /* let validate = isValidatedFieldsEdit();
                  if (!validate.isValidate) {
                      alert(validate.message);
                      return;
                  }*/
                if (editHoraInicio.val() != "" && editHoraFin.val() != "") {
                    if (editHoraInicio.val() < editHoraFin.val()) {
                        if (totalFin >= TotalNecesario) {
                            if (totalFin <= Limite) {
                                $.ajax({
                                    type: "POST",
                                    url: "../Ajax/ScheduleAjax.php",
                                    data: {
                                        callback:'actualizar',
                                        horaInicio: editHoraInicio.val(),
                                        horaFin: editHoraFin.val(),
                                        start: editStart.val(),
                                        end: editEnd.val(),
                                        id: idHorario.val(),
                                    },
                                    success: function(response) {
                                        console.log(response);
                                        if (response) {
                                            alert(response);
                                            //window.location.reload();
                                           // $('#ModalEdit').modal().hide();
                                           $("#calendar").fullCalendar('render');

                                        }
                                    }
                                });
                            } else {
                                alert('No puede exceder un rango de 3 horas');
                            }
                        } else {
                            alert('El horario debe tener un rango minimo de una hora');
                        }
                    } else {
                        alert('La hora de incio no puede ser menor a la hora de finalizacion');
                    }
                } else {
                    alert('Las horas no pueden estar vacias');

                }
            }

            deleteHorario.on('click', deleteSchedule);

            function deleteSchedule() {
                var respuesta = confirm("¿Esta seguro de eliminar el horario");
                if (respuesta == true) {
                    $.ajax({
                        type: "POST",
                        url: "../Ajax/ScheduleAjax.php",
                        data: {
                            callback: 'delete',
                            id: idHorario.val(),
                            delete: deleteHorario.filter(':checked').val()
                        },
                        success: function(response) {
                            if (response) {
                                alert('Horario eliminado');
                                $('#ModalEdit').modal().hide();
                                window.location.reload();
                            } else {
                                alert('hubo un error efectuando la consulta');
                            }
                        }
                    });
                    return true;
                } else {
                    alert('Horario no eliminado');
                    deleteHorario.attr("checked", false);
                    return false;
                }
            }


        });
    </script>




</body>

</html>