<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- FRAMEWORK BOOTSTRAP para el estilo de la pagina-->
    <link rel="stylesheet" href="../../Plataforma/css/login.css">

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
            background-image: url(../Imagenes/login.png);
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

        #btn-continuar {
            color: #213569;
            font-size: 14px;
            font-weight: bold;
            background: #f0a80e;
        }
    </style>

    <div class="container  h-100 " id="fondo">
        <div class="row justify-content-center  h-100">
            <div class=" col-xl-4 col-lg-6 col-md-6 col-sm-8 col xs-8 my-5 justify-content-center align-items-center formulario" style="background: #c4cacc;">
                <form method="POST" autocomplete="off">
                    <div class="form-group text-center col-xl-12 col-lg-12 col-md-12 col-sm-12  col-xs-12" id="recuperar-contrasenia">
                        <h5>RECUPERAR CONTRASEÑA</h5>
                    </div>
                    <label for="" class="text-center text-dark mx-5 pt-4">Enviamos un enlace de recuperación a tu correo, por favor revisa y dale click al link</label>
                    <div class="form-group text-center ">
                         <a class="text-center btn px-4"  Style="background: #f0a80e; color: #213569;"  href="../../" id="Recuperar-Contrasenia">Aceptar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>