<?php
include_once 'Plataforma/Utilidades/confiDev.php';
include_once 'Plataforma/Utilidades/conexion.php';
include_once 'Plataforma/Utilidades/email.php';
include_once 'Plataforma/Utilidades/Utilidades.php';
include_once 'Plataforma/Utilidades/main.php';
$utilidades = new Utilidades();

if (isset($_POST['sendMessageButton'])) {
    if ($_POST['name'] != "" && $_POST['email-contact'] != "" && $_POST['message'] != "") {
        $name = $_POST['name'];
        $correo = $_POST['email-contact'];
        $mensaje = $_POST['message'];
        consulta($name, $correo, $mensaje);
    } else {
        echo "<script>alert('No puede dejar campos vacios')</script>;";
    }
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--JQUERY-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/aos.js"></script>
    <script src="js/kit-fontawesome.js"></script>
    <script src="https://cdn.rawgit.com/michalsnik/aos/2.1.1/dist/aos.js"></script>

    <!-- Los iconos tipo Solid de Fontawesome-->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/Bienvenida.css">
    <link href="https://cdn.rawgit.com/michalsnik/aos/2.1.1/dist/aos.css" rel="stylesheet">

    <!-- Nuestro css-->
    <title>Escuela de manejo century</title>
</head>

<body style="background-color: #f0f0f0;">
    <nav class="navbar sticky-top  bg-dark navbar-expand-lg navbar-light" id=navbar-pricipal>
        <div class="container-fluid ">

            <img src="admin/img/logo/logo.png" id="logo" alt="">
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    Menu
                    <i class="fas fa-bars ml-1"></i>
                </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarResponsive">
                <ul class="nav navbar-nav navbar-center">
                    <li class="nav-item">
                        <a class="nav-link active  mx-3 " aria-current="page" href="#">INICIO</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-3" href="#cursos">CURSOS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-3" href="#contacto">CONTACTANOS</a>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="btn bg-dark text-white" style="color: rgba(228, 220, 220, 0.664) !important;font-size: 17px;font-weight: bold;" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">INICIAR SESSION</button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" src="Plataforma/Imagenes/banners/1.jpg" alt="First slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="Plataforma/Imagenes/banners/2.jpg" alt="Second slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="Plataforma/Imagenes/banners/3.jpg" alt="Third slide">
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    <div id="cursos" class="pt-5 pb-5" data-aos="fade-down" data-aos-duration="750">
        <div class="page-section">
            <div class="container pt-3">
                <h1 class="text-center font-weight-bold " id="text-titulos">NUESTROS CURSOS</h1>
                <hr id="line-bottom">
                <div class="row mt-5">
                    <div class="col">
                        <div class="container shadow-lg " style="border: #fff 1px solid; background:#fff;">
                            <h6>
                                Principiante
                            </h6>
                            <ul>
                                <li>15 Horas Practicas</li>
                                <li>Seminario Teórico</li>
                                <li>Asesoramiento y acompañamiento a obtener la licencia</li>
                            </ul>
                        </div>
                        <div class="container bg-success m-0 shadow-lg">
                            <label for="" class="text-light font-weight-bold">Costo C$150</label>
                        </div>
                    </div>

                    <div class="col">
                        <div class="container" style="border: #fff 1px solid; background:#fff;">
                            <h6>
                                Intermedio
                            </h6>
                            <ul>
                                <li>10 Horas Practicas</li>
                                <li>Seminario Teórico</li>
                                <li>Asesoramiento y acompañamiento a obtener la licencia</li>
                            </ul>
                        </div>
                        <div class="container bg-success m-0 shadow-lg">
                            <label for="" class="text-light font-weight-bold">Costo $100</label>
                        </div>
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col">
                        <div class="container shadow-lg" style="border: #fff 1px solid; background:#fff;">
                            <h6>
                                Avanzado
                            </h6>
                            <ul>
                                <li>5 Horas Practicas</li>
                                <li>Seminario Teórico</li>
                                <li>Asesoramiento y acompañamiento a obtener la licencia</li>
                            </ul>
                        </div>
                        <div class="container bg-success m-0 shadow-lg">
                            <label for="" class="text-light font-weight-bold">Costo $50</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="container shadow-lg" style="border: #fff 1px solid; background:#fff;">
                            <h6>
                                Paquete
                            </h6>
                            <ul>
                                <li>Paquete de Horas Practicas </li>
                                <li>Seminario Teórico</li>
                                <li>Asesoramiento y acompañamiento a obtener la licencia</li>
                            </ul>
                        </div>
                        <div class="container bg-success m-0 shadow-lg">
                            <label for="" class="text-light font-weight-bold">Costo $10 por hora</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- Redes sociales-->
    <section class="page-section py-3 " data-aos="fade-down" data-aos-duration="750" id="redes">
        <div class="container">
            <div class="text-center mb-4">
                <h2 class="section-heading text-uppercase"></h2>
                <h3 class="section-subheading text-muted"></h3>
            </div>
            <div class="row text-center">
                <div class="col-md-4">
                    <span class="fa-stack fa-4x">
                        <i class="fas fa-circle fa-stack-2x text-danger"></i>
                        <i class="fas fa-map-marker-alt fa-stack-1x fa-inverse"></i>
                    </span>
                    <h4 class="my-3">Dirección</h4>
                    <p class="text-muted">Colonia Centroamérica del Busto Salvador Mendieta 1c al este, Plaza América</p>
                </div>
                <div class="col-md-4">
                    <a href="https://wa.me/50581697448" target="_BLANK">

                        <span class="fa-stack fa-4x">
                            <i class="fas fa-circle fa-stack-2x text-success"></i>
                            <i class="fab fa-whatsapp fa-stack-1x fa-inverse"></i>
                        </span>
                        <h4 class="my-3 text-dark">WhatsApp</h4>
                        <p class="text-muted">8169 7448</p>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="mailto:info@escuelademanejocentury.com" target="_BLANK">

                        <span class="fa-stack fa-4x">
                            <i class="fas fa-circle fa-stack-2x text-primary"></i>
                            <i class="fas fa-envelope fa-stack-1x fa-inverse"></i>

                        </span>
                        <h4 class="my-3 text-dark">Correos</h4>
                        <p class="text-muted">info@escuelademanejocentury.com</p>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-- Contact-->
    <section class="page-section py-5 " data-aos="fade-down" data-aos-duration="750" id="contacto">
        <div class="container pb-5" style="background-color: #fff;border-radius: 5px !important;">
            <div class="text-center">
                <h2 class="section-heading py-4 pb-5 text-uppercase">CONTACTANOS</h2>
            </div>
            <form id="contactForm" method="POST" name="sentMessage" novalidate="novalidate">
                <div class="row align-items-stretch mb-5 py-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input class="form-control" id="name" name="name" type="text" placeholder="nombre*" required="required" data-validation-required-message="Please enter your name." />
                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="form-group pt-3">
                            <input class="form-control" id="email-contact" name="email-contact" type="email" placeholder="email*" required="required" data-validation-required-message="Please enter your email address." />
                            <p class="help-block text-danger"></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-textarea mb-md-0">
                            <textarea class="form-control" id="message" name="message" placeholder="mensaje*" required="required" data-validation-required-message="Please enter a message."></textarea>
                            <p class="help-block text-danger"></p>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <div id="success"></div>
                    <button class="btn btn-primary btn-xl text-uppercase" name="sendMessageButton" id="sendMessageButton" type="submit">Send Message</button>
                </div>
            </form>
        </div>
    </section>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="exampleModalLabel">INICIAR SESSIÓN</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" autocomplete="off" class="my-auto">
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Usuario</label>
                            <input type="email" class="form-control form-input" id="email" placeholder="Email" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">Contraseña</label>
                            <input type="password" class="form-control form-input" id="password" placeholder="Contraseña" name="password" required>
                        </div>
                        <div class="container-fluid text-center justify-content-center">
                            <input type="submit" class="btn bg-success ingresar mt-4 text-white " name="btn-login" id="btn-login" value="Iniciar sección">
                        </div>
                    </form>
                </div>

                <div class="form-group text-center mb-0">
                    <span class="text-center"> <a href="Plataforma/Vistas/Registrarse.php" id="registrarse">Registrarse</a></span>

                </div>
                <div class="form-group text-center ">
                    <span class="text-center"> <a href="Plataforma/Vistas/recuperarContrasenia.php" id="Recuperar-Contrasenia">Recuperar contraseña</a></span>
                </div>
            </div>
        </div>
    </div>
    <div class="conteiner-fluif">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3900.956987313274!2d-86.25233168518675!3d12.115095591421825!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8f73fe220a36aae1%3A0xa2555f57a5888adb!2sEscuela%20de%20Manejo%20Century!5e0!3m2!1ses-419!2sni!4v1618514300744!5m2!1ses-419!2sni" width="100%" height="600" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
    </div>

    <footer class="py-5" style="background-color: #000000;">
        <p class="text-light text-center">Copyright© 2021 Diseñado y Desarrollado por <a href="https://centurycreativa.com/" target="_blank">Century Creativa</a>.</p>
    </footer>
    <script>
        AOS.init();
    </script>
</body>

</html>