<?php
include_once '../Utilidades/conexion.php';
include_once '../Utilidades/session.php';
include_once '../Utilidades/email.php';
include_once '../Utilidades/confiDev.php';
include_once '../Modelos/EstudianteModel.php';
include_once '../Controladores/EstudianteController.php';

$sessionCliente = new Session();
$resultMessage = $_REQUEST['result'] ?? '';

if (isset($_SESSION['idUser'])){
    session_regenerate_id(true);
    header("Location: ../");
} else {
    if (isset($_POST['correo-recuperacion-contrasenia']) && isset($_POST['Recuperar-Contrasenia'])) {
        $correo = $_POST['correo-recuperacion-contrasenia'];
        $ControladorEstudiante = new EstudianteController();
        $correoExistente = $ControladorEstudiante->UsuarioRegistrado($correo);
        $correExistenteVerificado = $ControladorEstudiante->estadoNOActivoPagoRealizado($correo);
        $correoExitenteHabilitadoVerificado = $ControladorEstudiante->VerificarUsuarioActivoById($correo);
        if ($correoExistente) {
            if (is_numeric($correoExitenteHabilitadoVerificado) && $correoExitenteHabilitadoVerificado > 0) {
                $codigoDeRecuperacion = md5(uniqid(rand(), true));
                $FechaCodigoDeRecuperacion = $ControladorEstudiante->registrarRecuperacion($correo, $codigoDeRecuperacion);
                if ($FechaCodigoDeRecuperacion) {
                    $RecuperarContrasenia = recuperarContrasenia($codigoDeRecuperacion, $correo);
                    header("Location: ../../Plataforma/Vistas/RecuperarContraseniaFin.php");
                } else {
                    header("Location: ../../Plataforma/Vistas/recuperarContrasenia.php?result=FechaNoRegistrada");
                }
            } else {
                echo "<script>alert('Este correo aun no ha sido verifificado o registrado')</script>";
                echo '<!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <!-- FRAMEWORK BOOTSTRAP para el estilo de la pagina-->
                    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
                    <script src="../../js/jquery-3.5.1.min.js"></script>
                    <script src="../../js/popper.min.js"></script>
                    <script src="../../js/bootstrap.min.js"></script>
                    <script src="../../js/aos.js"></script>
                    <script src="../../js/kit-fontawesome.js"></script>
                    <script src="../../Plataforma/js/Registrarse.js"></script>
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
                            max-height: 15rem;
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
                        #correo-recuperacion-contrasenia {
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
                            <div class=" col-xl-4 col-lg-6 col-md-6 col-sm-8 col col-11 my-5 justify-content-center align-items-center formulario" style="background: #c4cacc;">
                                <form method="POST" autocomplete="off">
                                    <div class="form-group text-center col-xl-12 col-lg-12 col-md-12 col-sm-12  col-11" id="recuperar-contrasenia">
                                        <h5>RECUPERAR CONTRASEÑA</h5>
                                    </div>
                                    <div class="form-group mx-3 text-center ">
                                        <label for="" class="text-center text-dark pt-4">Introduzca su correo electronico</label>
                                        <input type="email" class="form-control text-center" id="correo-recuperacion-contrasenia" placeholder="correo" name="correo-recuperacion-contrasenia" required>
                                    </div>
                                    <div class="form-group text-center ">
                                        <button class="text-center btn btn-warning" type="submit" name="Recuperar-Contrasenia"  required>Recuperar contraseña</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <script src="./../../Plataforma/js/viewer.js"> </script>
                    <script src="./../../Plataforma/js/main-viewer.js"> </script>';
            }
        } else {
            echo "<script>alert('Este correo aun no ha sido verifificado o registrado')</script>";
            echo '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <!-- FRAMEWORK BOOTSTRAP para el estilo de la pagina-->
                <!-- jQuery first, then Popper.js, then Bootstrap JS -->
                <script src="../../js/jquery-3.5.1.min.js"></script>
                <script src="../../js/popper.min.js"></script>
                <script src="../../js/bootstrap.min.js"></script>
                <script src="../../js/aos.js"></script>
                <script src="../../js/kit-fontawesome.js"></script>
                <script src="../../Plataforma/js/Registrarse.js"></script>
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
                        max-height: 15rem;
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
                    #correo-recuperacion-contrasenia {
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
                        <div class=" col-xl-4 col-lg-6 col-md-6 col-sm-8 col col-11 my-5 justify-content-center align-items-center formulario" style="background: #c4cacc;">
                            <form method="POST" autocomplete="off">
                                <div class="form-group text-center col-xl-12 col-lg-12 col-md-12 col-sm-12  col-11" id="recuperar-contrasenia">
                                    <h5>RECUPERAR CONTRASEÑA</h5>
                                </div>
                                <div class="form-group mx-3 text-center ">
                                    <label for="" class="text-center text-dark pt-4">Introduzca su correo electronico</label>
                                    <input type="email" class="form-control text-center" id="correo-recuperacion-contrasenia" placeholder="correo" name="correo-recuperacion-contrasenia" required>
                                </div>
                                <div class="form-group text-center ">
                                    <button class="text-center btn btn-warning" type="submit" name="Recuperar-Contrasenia"  required>Recuperar contraseña</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <script src="./../../Plataforma/js/viewer.js"> </script>
                <script src="./../../Plataforma/js/main-viewer.js"> </script>';
            
        }
    } else if (isset($_POST['nueva-contrasenia']) && isset($_POST['Recuperar-Contrasenia']) && isset($_POST['public-code'])) {
        $id = openssl_decrypt($_POST['public-code'], COD, KEY);
        $password = $_POST['nueva-contrasenia'];
        $ControladorEstudiante = new EstudianteController();
        $success = $ControladorEstudiante->actualizarContrasenia($password, $id);
        if ($success) {
            header("Location: ../../../index.php?result=recuperacionCorrecta");
        } else {
            header("Location: .../../../index.php?result=recuperacionIncorrecta");
        }
    } else if ($resultMessage != "") {
        $ControladorEstudiante = new EstudianteController();
        $id = $ControladorEstudiante->getIdByCodigoContrasenia($resultMessage);
        if (!(is_numeric($id) && $id > 0)) {
            echo "  <script>
                        El codigo a expirado, por favor, solicitelo nuevamente
                    </script>";
        } else {
            echo '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <!-- FRAMEWORK BOOTSTRAP para el estilo de la pagina-->
            <link rel="stylesheet" href=".../../Plataforma/css/login.css">

            <script src="../../js/jquery-3.5.1.min.js"></script>
            <script src="../../js/popper.min.js"></script>
            <script src="../../js/bootstrap.min.js"></script>
            <script src="../../js/aos.js"></script>
            <script src="../../js/kit-fontawesome.js"></script>
            <script src="../../Plataforma/js/Registrarse.js"></script>
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
                #nueva-contrasenia-confirmacion{
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
                            <div class="form-group text-center mx-sm-4 mb-3 mt-3 py-2 ">
                            <label for="" class="text-dark">Introduzca su nueva contraseña</label>
                                <input type="text" class="form-control text-center" id="nueva-contrasenia" placeholder="password" name="nueva-contrasenia">
                            </div>
                            <div class="form-group text-center mx-sm-4 mb-3 mt-3 py-2 ">
                            <input type="hidden" value="' . openssl_encrypt($id, COD, KEY) . '"  name="public-code">
                            <div class="form-group text-center ">
                                <button class="text-center btn btn-warning" type="submit"
                                name="Recuperar-Contrasenia" id="Recuperar-Contrasenia">Actualizar contraseña</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>';
        }
    } else {
        echo '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <!-- FRAMEWORK BOOTSTRAP para el estilo de la pagina-->
                <!-- jQuery first, then Popper.js, then Bootstrap JS -->
                <script src="../../js/jquery-3.5.1.min.js"></script>
                <script src="../../js/popper.min.js"></script>
                <script src="../../js/bootstrap.min.js"></script>
                <script src="../../js/aos.js"></script>
                <script src="../../js/kit-fontawesome.js"></script>
                <script src="../../Plataforma/js/Registrarse.js"></script>
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
                    #correo-recuperacion-contrasenia {
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
                        <div class=" col-xl-4 col-lg-6 col-md-6 col-sm-8 col col-11 my-5 justify-content-center align-items-center formulario" style="background: #c4cacc;">
                            <form method="POST" autocomplete="off">
                                <div class="form-group text-center col-xl-12 col-lg-12 col-md-12 col-sm-12  col-11" id="recuperar-contrasenia">
                                    <h5>RECUPERAR CONTRASEÑA</h5>
                                </div>
                                <div class="form-group mx-3 text-center ">
                                    <label for="" class="text-center text-dark pt-4">Introduzca su correo electronico</label>
                                    <input type="email" class="form-control text-center" id="correo-recuperacion-contrasenia" placeholder="correo" name="correo-recuperacion-contrasenia" required>
                                </div>
                                <div class="form-group text-center ">
                                    <button class="text-center btn" Style="background: #f0a80e; color: #213569;" type="submit" name="Recuperar-Contrasenia"  required> Recuperar contraseña</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <script src="./../../Plataforma/js/viewer.js"> </script>
                <script src="./../../Plataforma/js/main-viewer.js"> </script>';
    }
}
?>

<?php
if ($resultMessage  == "RecuperarContrasenia") {
    echo '   <div class="modal fade" id="idresultMessage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" href="#" >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Alerta</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Se ha enviado un link a su bandeja de entrada, en caso de no aparacer, por favor revise en la bandeja de spam
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $("#idresultMessage").modal("show");
        </script>';
} else if ($resultMessage  == "ActivacionIncompleta") {
    echo '<div class="modal fade" id="idresultMessage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" href="#" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Info</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                 Registro completado exitosamente, se enviará un correo de verificación a su bandeja principal o  en la carpeta de spam este proceso puede dilatar hasta un maximo de 3 días,
                 de haber pasado el tiempo maximo, por favor ponerse en contacto con nosotros.    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $("#idresultMessage").modal("show");
    </script>';
} else if ($resultMessage  == "NoRegistrado") {
    echo '<div class="modal fade" id="idresultMessage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" href="#" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Alerta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                     Lo sentimos,No hay ninguna cuenta registrada y activa con este correo. 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $("#idresultMessage").modal("show");
    </script>';
} else if ($resultMessage  == "CamposVacios") {
    echo '<div class="modal fade" id="idresultMessage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" href="#" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Alerta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    <div class="modal-body">
                        Usuario y Contraseñas Correctos;
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $("#idresultMessage").modal("show");
    </script>';
} else if ($resultMessage  == "FechaNoRegistrada") {
    echo '<div class="modal fade" id="idresultMessage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" href="#" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Alerta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    <div class="modal-body">
                        Usuario y Contraseñas Correctos, pero la fecha no se registro :"c;
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $("#idresultMessage").modal("show");
    </script>';
}
if ($resultMessage  == "RecuperacionCorrecta") {
    echo '   <div class="modal fade" id="idresultMessage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" href="#" >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Alerta</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                     Tu contraseña se ha actualizado correctamente.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $("#idresultMessage").modal("show");
        </script>';
} else if ($resultMessage  == "RecuperacionIncorrecta") {
    echo '<div class="modal fade" id="idresultMessage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" href="#" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Info</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Lo sentimos, a ocurrido un error al actualizar tu contraseña, por favor ponte en contacto con nosotros para ayudarte a solucionarlo.   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $("#idresultMessage").modal("show");
    </script>';
}
?>
</body>
</html>