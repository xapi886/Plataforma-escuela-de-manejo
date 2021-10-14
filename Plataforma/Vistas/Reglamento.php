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
                            <label for="" class="text-dark text-justify mx-2 pt-4"> La Escuela de Manejo Century (en adelante llamada “La Escuela”), en atención a los criterios señaladas por la Dirección de Seguridad de Tránsito Nacional y a través del presente reglamento pretende establecer las condiciones que regirán en la prestación del servicio que oferta, así como las pautas de comportamiento esperadas de parte de los alumnos. Normas que persiguen una relación clara y armónica entre los Alumnos y la Escuela de manejo.
                                <br>
                            </label>
                            <label class="text-dark mx-5 text-justify " for="">
                                <ol>
                                    <li value="1">Los alumnos deben de tratar con respeto y consideración al personal administrativo de la Escuela, a los docentes y compañeros de curso.</li>
                                    <li>Los alumnos deben de cuidar de todos los recursos que La Escuela pone a su disposición; haciendo uso adecuado de las instalaciones, el mobiliario y el vehículo. Los que cometan actos de substracción, deterioro, destrucción de bienes, mobiliario, equipo y objetos de La Escuela, de los docentes o de sus compañeros están obligados a la reparación del daño causado. </li>
                                    <li>Los cursos de manejo regulares, contemplan dos etapas: Seminario Teórico y Clases Prácticas. Ambas etapas deben de aprobarse con una nota mínima de Ochenta puntos (80 pts.) sin excepción.</li>
                                    <li>Si el alumno se retira injustificadamente por más de treinta días en cualquiera de las etapas anteriormente mencionadas, los efectos que produzca este alejamiento serán su responsabilidad. En tal caso, tendrá que empezar nuevamente el curso asumiendo los costos respectivos y no podrán exigir ningún tipo de reembolso. </li>
                                    <li>Los cursos de manejo regulares, contemplan dos etapas: Seminario Teórico y Clases Prácticas. Ambas etapas deben de aprobarse con una nota mínima de Ochenta puntos (80 pts.) sin excepción. </li>
                                    <li>Si el alumno se retira injustificadamente por más de treinta días en cualquiera de las etapas anteriormente mencionadas, los efectos que produzca este alejamiento serán su responsabilidad. En tal caso, tendrá que empezar nuevamente el curso asumiendo los costos respectivos y no podrán exigir ningún tipo de reembolso. </li>
                                    <li>Independientemente del nivel contratado, el Alumno debe aprobar en primera instancia la fase Teórica que se imparte al inicio del curso para poder iniciar las clases prácticas. </li>
                                    <li>La asistencia al Seminario Teórico es OBLIGATORIA y debe ser continua e ininterrumpida para asegurar un aprendizaje óptimo. Se imparte en las instalaciones de la Escuela, por tanto, el Alumno debe comparecer puntualmente al inicio de clases. Solo se permitirá el ingreso con 15 minutos de retraso (previa notificación a La Escuela). Ante esta situación, es deber del alumno nivelarse con el contenido impartido. En caso de inasistencia el Alumno deberá esperar la apertura del siguiente seminario, acorde con la programación que realice la Escuela.</li>
                                    <li>A fin de evaluar los conocimientos teóricos, se realizarán exámenes escritos que serán programados en los subsiguientes cinco días después de impartido el Seminario Teórico y en horarios hábiles. El Alumno que no realice el examen dentro de los días establecidos, tendrá que asumir una penalidad de quince dólares (U$15.00) en concepto de reprogramación. Este pago se hará por una única vez.</li>
                                    <li>En caso de no aprobar la fase teórica en el primer examen, el Alumno contará con dos oportunidades más para realizarlo sin cargo adicional. Si no lograra aprobar en las tres oportunidades, deberá asistir nuevamente al Seminario Teórico, que tendrá un costo adicional de sesenta dólares (U$ 60.00) </li>
                                    <li>Las Clases Prácticas deben ser continuas e ininterrumpidas para asegurar un buen rendimiento. En caso de inasistencia a clases el Alumno deberá pagar $15 +IVA, para posteriormente ser reprogramado. La reprogramación de dichas clases prácticas está sujeta a la disponibilidad de horarios de La Escuela.</li>
                                    <li>Al Alumno que aún está bajo la tutela de sus padres NO se les autorizará el retiro de las instalaciones o vehículo de instrucción, en el caso de las horas prácticas, solamente con autorización directa del tutor o encargado con previo aviso a La Escuela. </li>
                                    <li>El Alumno debe estar comprometidos con su proceso de aprendizaje, el cual está bajo su propia responsabilidad. Por tanto, queda estrictamente prohibido durante las clases teóricas y prácticas el uso de celulares y sus accesorios, así como cualquier otro dispositivo que desvíe su atención de la clase en curso. De igual manera están obligados a seguir y cumplir con todas las indicaciones que les brinde el Instructor durante los períodos de clase. </li>
                                    <li>No se permitirán interrupciones al seminario en curso por respeto a sus compañeros y al instructor. En casos de haber llamadas de emergencia se les solicita brinde a sus familiares el número de la Escuela como contacto para que el personal encargado valorando las circunstancias, transmita el mensaje.</li>
                                    <li>Queda estrictamente prohibido fumar o consumir bebidas embriagantes o cualquier otro tipo de enervante durante los períodos de clase, sea teórica o práctica. </li>
                                    <li>Esta estrictamente prohibido presentarse a las clases bajo la influencia de bebidas embriagantes o cualquier enervante, ni bajo los efectos de sustancias tóxicas. Si el Alumno se encuentra bajo algún tipo de medicación, debe comunicarlo al personal de La Escuela, SOBRE TODO ANTES O DURANTE SUS CLASES PRÁCTICAS. </li>
                                    <li>Queda estrictamente prohibido portar armas punzocortantes y de fuego dentro de la institución y durante los períodos de clase, sea teórica o práctica. </li>
                                    <li>El vehículo de instrucción autorizado solo podrá transportar el instructor y el alumno, exceptuando al personal de la policía de tránsito en cumplimiento de sus funciones y al director o representante legal de la Escuela en el proceso de supervisión y control y al instructor que se capacita el cual irá en la parte trasera del vehículo.</li>
                                    <li>Si antes o durante las clases prácticas surgieran condiciones meteorológicas adversas; como lluvia y neblina densa que imposibiliten la visibilidad y reduzca de gran manera la reacción ante un peligro, el Instructor suspenderá la clase asumiendo el control del vehículo. Del mismo modo procederá el Instructor si percibiera que el Alumno se encuentra en un estado alteración de la conducta, que le impida desempeñarse con seguridad y adecuadamente en la vía. En tal caso, las clases serán reprogramadas sin perjuicio del tiempo contratado.</li>
                                    <li>Durante el desarrollo de las clases, el Instructor deberá mantener en todo momento una actitud de respeto y cortesía hacia el alumno, evitando gestos, palabras o frases ofensivas o de doble sentido, con las cuales el alumno pueda sentirse afectado, agredido o intimidado de manera física o psicológica. Las quejas en contra del Instructor deberán ser presentadas por escrito y debidamente fundamentada, quien a su vez tendrá derecho a la réplica con el fin de lograr una solución justa y amigable.</li>
                                    <li>Cuando el Alumno tenga que presentarse a realizar el examen práctico ante el Centro de Educación Vial será asistido por la Escuela de Manejo en prestarle el vehículo de instrucción, sin costo alguno. En caso que el alumno repruebe el examen práctico la Escuela le podrá asistir nuevamente, pero los gastos correrán a cuenta del alumno. </li>
                                    <li>Las tarifas por servicios administrativos o adicionales al curso regular serán fijadas por la Escuela.</li>
                                    <li>Los casos no previstos en el presente reglamento, serán valorados y resueltos por el personal correspondiente de La Escuela.</li>
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