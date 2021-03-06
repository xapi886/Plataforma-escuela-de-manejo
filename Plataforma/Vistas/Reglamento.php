<?php
try {
    $resultMessage = $_REQUEST['result'] ?? '';
    include_once('../Utilidades/conexion.php');
    include_once('../Utilidades/confiDev.php');
    include_once('../Utilidades/email.php');
    include_once('../Controladores/EstudianteController.php');
    include_once('../Modelos/EstudianteModel.php');
    include_once('../Modelos/InscripcionModel.php');
    include_once('../Controladores/InscripcionController.php');
    include_once('../Utilidades/Utilidades.php');
    include_once('../Utilidades/session.php');
    // Instancia de la clase contralodora StudentController
    $studentController = new EstudianteController();
    $inscripcionController = new InscripcionController();

    // Obtencion de los datos de estudiante
    $Estudiante = $studentController->getIdByCodigo($resultMessage);

    $estado = $Estudiante[0]['Estado'] ?? "";
    $nombre = $Estudiante[0]['Nombre'] ?? "";
    $apellido = $Estudiante[0]['Apellido'] ?? "";
    $email = $Estudiante[0]['email'] ?? "";
    $telefono = $Estudiante[0]['Telefono'] ?? "";
    $cedula = $Estudiante[0]['Cedula'] ?? "";
    $idEstudiante = $Estudiante[0]['IdEstudiante'] ?? "";
    $resultMessage = $_REQUEST['result'] ?? '';

    if($estado == 1){
        header("Location: ../../../index.php?result=inscripcionExitosa");
    }

} catch (Throwable $th) {
    // Mensaje de error
    echo "<script>alert('" . $th->getMessage() . "');</script>";
}
//echo $resultMessage;

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="../../js/jquery-3.5.1.min.js"></script>
    <script src="../../js/popper.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <script src="../../js/aos.js"></script>
    <script src="../../js/kit-fontawesome.js"></script>

    <!-- Los iconos tipo Solid de Fontawesome-->
    <link href="../css/bootstrap.min.css" rel="stylesheet" />


    <title>REGLAMENTO</title>
</head>

<body class="h-100">

    <style type="text/css">
        body {
            background-image: url(../Imagenes/login.png);
            background-repeat: no repeat;
            background-size: cover;
            background-attachment: fixed;
        }

        /*#fondo:before {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: rgba(33, 53, 105, .70);
        }*/

        .scrollType {
            max-height: 35rem;
            overflow-y: scroll;
        }

        .contenedor {
            border-radius: 5px;
        }
    </style>

    <div class="container h-100" id="fondo">


        <div class="row justify-content-center mb-5">
            <div class=" col-xl-8 col-lg-8 col-md-10 col-10 col xs-10 mt-5 justify-content-center align-items-center contenedor" style="background: #ffffff;">
                <form method="POST" action="" autocomplete="off">
                    <!-- onSubmit="return valid()" -->
                    <input type="hidden" id="cod" value=<?php echo $resultMessage ?>>
                    <div class="container ">
                        <h3 class="text-center text-dark mt-2">REGLAMENTO ESCUELA CENTURY</h3>
                        <div class="form-group mx-sm-4 py-2 scrollType ">
                            <label for="" class="text-dark text-justify mx-2 pt-4"> La Escuela de Manejo Century (en adelante llamada ???La Escuela???), en atenci??n a los criterios se??aladas por la Direcci??n de Seguridad de Tr??nsito Nacional y a trav??s del presente reglamento pretende establecer las condiciones que regir??n en la prestaci??n del servicio que oferta, as?? como las pautas de comportamiento esperadas de parte de los alumnos. Normas que persiguen una relaci??n clara y arm??nica entre los Alumnos y la Escuela de manejo.
                                <br>
                            </label>
                            <label class="text-dark mx-5 text-justify " for="">
                                <ol>
                                    <li value="1">Los alumnos deben de tratar con respeto y consideraci??n al personal administrativo de la Escuela, a los docentes y compa??eros de curso.</li>
                                    <li>Los alumnos deben de cuidar de todos los recursos que La Escuela pone a su disposici??n; haciendo uso adecuado de las instalaciones, el mobiliario y el veh??culo. Los que cometan actos de substracci??n, deterioro, destrucci??n de bienes, mobiliario, equipo y objetos de La Escuela, de los docentes o de sus compa??eros est??n obligados a la reparaci??n del da??o causado. </li>
                                    <li>Los cursos de manejo regulares, contemplan dos etapas: Seminario Te??rico y Clases Pr??cticas. Ambas etapas deben de aprobarse con una nota m??nima de Ochenta puntos (80 pts.) sin excepci??n.</li>
                                    <li>Si el alumno se retira injustificadamente por m??s de treinta d??as en cualquiera de las etapas anteriormente mencionadas, los efectos que produzca este alejamiento ser??n su responsabilidad. En tal caso, tendr?? que empezar nuevamente el curso asumiendo los costos respectivos y no podr??n exigir ning??n tipo de reembolso. </li>
                                    <li>Los cursos de manejo regulares, contemplan dos etapas: Seminario Te??rico y Clases Pr??cticas. Ambas etapas deben de aprobarse con una nota m??nima de Ochenta puntos (80 pts.) sin excepci??n. </li>
                                    <li>Si el alumno se retira injustificadamente por m??s de treinta d??as en cualquiera de las etapas anteriormente mencionadas, los efectos que produzca este alejamiento ser??n su responsabilidad. En tal caso, tendr?? que empezar nuevamente el curso asumiendo los costos respectivos y no podr??n exigir ning??n tipo de reembolso. </li>
                                    <li>Independientemente del nivel contratado, el Alumno debe aprobar en primera instancia la fase Te??rica que se imparte al inicio del curso para poder iniciar las clases pr??cticas. </li>
                                    <li>La asistencia al Seminario Te??rico es OBLIGATORIA y debe ser continua e ininterrumpida para asegurar un aprendizaje ??ptimo. Se imparte en las instalaciones de la Escuela, por tanto, el Alumno debe comparecer puntualmente al inicio de clases. Solo se permitir?? el ingreso con 15 minutos de retraso (previa notificaci??n a La Escuela). Ante esta situaci??n, es deber del alumno nivelarse con el contenido impartido. En caso de inasistencia el Alumno deber?? esperar la apertura del siguiente seminario, acorde con la programaci??n que realice la Escuela.</li>
                                    <li>A fin de evaluar los conocimientos te??ricos, se realizar??n ex??menes escritos que ser??n programados en los subsiguientes cinco d??as despu??s de impartido el Seminario Te??rico y en horarios h??biles. El Alumno que no realice el examen dentro de los d??as establecidos, tendr?? que asumir una penalidad de quince d??lares (U$15.00) en concepto de reprogramaci??n. Este pago se har?? por una ??nica vez.</li>
                                    <li>En caso de no aprobar la fase te??rica en el primer examen, el Alumno contar?? con dos oportunidades m??s para realizarlo sin cargo adicional. Si no lograra aprobar en las tres oportunidades, deber?? asistir nuevamente al Seminario Te??rico, que tendr?? un costo adicional de sesenta d??lares (U$ 60.00) </li>
                                    <li>Las Clases Pr??cticas deben ser continuas e ininterrumpidas para asegurar un buen rendimiento. En caso de inasistencia a clases el Alumno deber?? pagar $15 +IVA, para posteriormente ser reprogramado. La reprogramaci??n de dichas clases pr??cticas est?? sujeta a la disponibilidad de horarios de La Escuela.</li>
                                    <li>Al Alumno que a??n est?? bajo la tutela de sus padres NO se les autorizar?? el retiro de las instalaciones o veh??culo de instrucci??n, en el caso de las horas pr??cticas, solamente con autorizaci??n directa del tutor o encargado con previo aviso a La Escuela. </li>
                                    <li>El Alumno debe estar comprometidos con su proceso de aprendizaje, el cual est?? bajo su propia responsabilidad. Por tanto, queda estrictamente prohibido durante las clases te??ricas y pr??cticas el uso de celulares y sus accesorios, as?? como cualquier otro dispositivo que desv??e su atenci??n de la clase en curso. De igual manera est??n obligados a seguir y cumplir con todas las indicaciones que les brinde el Instructor durante los per??odos de clase. </li>
                                    <li>No se permitir??n interrupciones al seminario en curso por respeto a sus compa??eros y al instructor. En casos de haber llamadas de emergencia se les solicita brinde a sus familiares el n??mero de la Escuela como contacto para que el personal encargado valorando las circunstancias, transmita el mensaje.</li>
                                    <li>Queda estrictamente prohibido fumar o consumir bebidas embriagantes o cualquier otro tipo de enervante durante los per??odos de clase, sea te??rica o pr??ctica. </li>
                                    <li>Esta estrictamente prohibido presentarse a las clases bajo la influencia de bebidas embriagantes o cualquier enervante, ni bajo los efectos de sustancias t??xicas. Si el Alumno se encuentra bajo alg??n tipo de medicaci??n, debe comunicarlo al personal de La Escuela, SOBRE TODO ANTES O DURANTE SUS CLASES PR??CTICAS. </li>
                                    <li>Queda estrictamente prohibido portar armas punzocortantes y de fuego dentro de la instituci??n y durante los per??odos de clase, sea te??rica o pr??ctica. </li>
                                    <li>El veh??culo de instrucci??n autorizado solo podr?? transportar el instructor y el alumno, exceptuando al personal de la polic??a de tr??nsito en cumplimiento de sus funciones y al director o representante legal de la Escuela en el proceso de supervisi??n y control y al instructor que se capacita el cual ir?? en la parte trasera del veh??culo.</li>
                                    <li>Si antes o durante las clases pr??cticas surgieran condiciones meteorol??gicas adversas; como lluvia y neblina densa que imposibiliten la visibilidad y reduzca de gran manera la reacci??n ante un peligro, el Instructor suspender?? la clase asumiendo el control del veh??culo. Del mismo modo proceder?? el Instructor si percibiera que el Alumno se encuentra en un estado alteraci??n de la conducta, que le impida desempe??arse con seguridad y adecuadamente en la v??a. En tal caso, las clases ser??n reprogramadas sin perjuicio del tiempo contratado.</li>
                                    <li>Durante el desarrollo de las clases, el Instructor deber?? mantener en todo momento una actitud de respeto y cortes??a hacia el alumno, evitando gestos, palabras o frases ofensivas o de doble sentido, con las cuales el alumno pueda sentirse afectado, agredido o intimidado de manera f??sica o psicol??gica. Las quejas en contra del Instructor deber??n ser presentadas por escrito y debidamente fundamentada, quien a su vez tendr?? derecho a la r??plica con el fin de lograr una soluci??n justa y amigable.</li>
                                    <li>Cuando el Alumno tenga que presentarse a realizar el examen pr??ctico ante el Centro de Educaci??n Vial ser?? asistido por la Escuela de Manejo en prestarle el veh??culo de instrucci??n, sin costo alguno. En caso que el alumno repruebe el examen pr??ctico la Escuela le podr?? asistir nuevamente, pero los gastos correr??n a cuenta del alumno. </li>
                                    <li>Las tarifas por servicios administrativos o adicionales al curso regular ser??n fijadas por la Escuela.</li>
                                    <li>Los casos no previstos en el presente reglamento, ser??n valorados y resueltos por el personal correspondiente de La Escuela.</li>
                                </ol>
                            </label>
                        </div>
                    </div>
                    <div class="container my-2">
                        <label>
                            <input type="radio" name="acepto-condiciones" id="acepto-condiciones">
                            He leido y acepto terminos y condiciones
                        </label>
                    </div>
                    <div class="container mb-3 text-center">
                        <a class="btn btn-primary text-light" id="btn-enviar" name="btn-enviar">ENVIAR</a>
                        <a class="btn btn-danger" href="../../index.php">CANCELAR</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {

            var btnEnviar = $("#btn-enviar");
            var CheckCondiciones = $("#acepto-condiciones");
            btnEnviar.on('click', validarCheck);

            var cod = $('#cod');

            function validarCheck() {
                if (CheckCondiciones.is(':checked')) {
                    //alert('checkbox seleccionado');
                    $(location).attr('href', '../../Plataforma/Vistas/inscripcion.php?result=' + cod.val());

                } else {
                    alert('Acepte los terminos y condiciones antes de continuar');
                }
            }

        });
    </script>


</body>

</html>