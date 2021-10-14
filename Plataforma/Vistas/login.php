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
    <!-- Los iconos tipo Solid de Fontawesome-->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <!-- Nuestro css-->
    <link rel="stylesheet" href="Plataforma/css/login.css">
    <title>Login</title>
</head>

<body class="row m-0 justify-content-center align-items-center vh-100">
    <div class="container  h-100 " id="fondo">
        <div class="row justify-content-center  vh-100">
            <div class="col-xl-3 col-lg-4 col-md-5 col-sm-7 col-11 my-5 justify-content-center my-auto align-items-center formulario">
                <form method="POST" autocomplete="off" class="my-auto">
                    <div class="form-group text-center col-lg-12 col-md-12 col-sm-12 mx-auto" id="login">
                        <h3>Login</h3>
                    </div>
                    <div class="form-group mx-sm-4 mb-3 mt-3 py-2 ">
                        <input type="email" class="form-control form-input" id="email" placeholder="Email" name="username" required>
                    </div>
                    <div class="form-group mx-sm-4 mb-3 mt-3  py-2">
                        <input type="password" class="form-control form-input" id="password" placeholder="Contraseña" name="password" required>
                    </div>
                    <div class="form-group text-center py-2 ">
                        <input type="submit" class="btn ingresar " name="btn-login" id="btn-login" value="INGRESAR ">
                    </div>
                    <div class="form-group text-center mb-0">
                        <span class="text-center"> <a href="Plataforma/Vistas/Registrarse.php" id="registrarse">Registrarse</a></span>

                    </div>
                    <div class="form-group text-center ">
                        <span class="text-center"> <a href="Plataforma/Vistas/recuperarContrasenia.php" id="Recuperar-Contrasenia">Recuperar contraseña</a></span>
                    </div>
                </form>

            </div>
        </div>
            <div class="row">
                <div class="w-100 text-center mt-5" id="creditos">
                    <span class="text-creditos">Sistema desarrollado por <a href="http://centurycreativa.com/" target="_BLANK">Century Creativa</a></span>
                </div>
            </div>
    </div>

</body>
</html>