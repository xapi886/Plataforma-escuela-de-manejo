<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- FRAMEWORK BOOTSTRAP para el estilo de la pagina-->
    <link rel="stylesheet" href=".../../../plataforma-century-escuela-manejo/Plataforma/css/login.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <!-- Los iconos tipo Solid de Fontawesome-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/solid.css">
    <script src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>
    <title>RECUPERAR CONTRASEÑA</title>
</head>

<body class="h-100">
    <style type="text/css">
        body {
            background-image: url(../Imagenes/login.jpg);
            background-repeat: no repeat;
            background-size: cover;
            background-attachment: fixed;
        }
        .formulario {
            background-color: rgba(255, 255, 255, 0.70);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 30px rgba(0, .0, .0, .0.568);
            color: white;
            margin: auto;
            top: 10rem;
        }
        #fondo:before {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: rgba(33, 53, 105, .70);
        }
        #recuperar-contrasenia {
            color: #F2B123;
            background: #01236b;
            position: absolute;
            border-radius: 10px;
            /*font-size: 10px;*/
            font-weight: bold;
            padding: 5px;
            width: 90%;
            top: -5%;
            margin: 0px auto;
        }
        #nueva-contrasenia {
            background-color: rgba(255, 255, 255, 0);
            border: none;
            border-bottom: 1px solid #8E8E8E;
            outline: none;
            box-shadow: none;
            border-radius: 0%;
        }
        #btn-volver {
            color: #213569;
            font-size: 14px;
            font-weight: bold;
            background: #f0a80e;
        }
    </style>







    <div class="container  h-100 " id="fondo">

        <div class="row justify-content-center  h-100">

            <div class=" col-xl-4 col-lg-6 col-md-6 col-sm-8 col-11 my-5 justify-content-center align-items-center formulario" style="background: #c4cacc;">

                <form method="POST" autocomplete="off">

                    <div class="form-group text-center col-xl-12 col-lg-12 col-md-12 col-sm-12  col-xs-12" id="recuperar-contrasenia">

                        <h5>FIN DE REGISTRO</h5>

                    </div>

                    <label for="" class="text-justify text-dark mx-1 pt-4">Gracias por registrarse, vamos a verificar sus datos en un máximo de 3 días, se le enviará un mensaje a su correo para acceder al contenido (puede aparecer en el apartado de spam)</label>



                    <div class="form-group text-center py-2">

                        <a input type="submit" class="btn registrarme" name="btn-volver" id="btn-volver" href="../../index.php">ACEPTAR</a>

                    </div>

                </form>

            </div>

        </div>

    </div>

</body>

</html>