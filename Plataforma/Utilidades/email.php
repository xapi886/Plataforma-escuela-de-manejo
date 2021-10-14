<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function CorreoVerificarEstudiante($nombreEstudiante, $apellidoEstudiante,$cedulaEstudiante,$correoEstudiante, $telefonoEstudiante)
{
        require '../../vendor/autoload.php';

    $mail = new PHPMailer(true);
    try {
        //Server settings
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host = HOST;                                         // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username = USEREMAIL;                                // SMTP username
        $mail->Password = PASSWORDEMAIL;                            // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = PUERTO;                                 // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
        $mail->CharSet = 'UTF-8';
        //Recipients
        $mail->setFrom(USEREMAIL, 'Escuela de Manejo century');
        $mail->addAddress('info@escuelademanejocentury.com', 'Desde el sitio web');
        // Content
        //$mail->isHTML(true);
        $mail->Subject = 'Nuevo estudiante registrado';
        $mail->Body    = '
         Un nuevo estudiante se ha Registrado, por favor confirme los datos enviados desde la plataforma

             Nombre  :  ' . $nombreEstudiante .'
             Apellido: ' . $apellidoEstudiante .'
             Correo: ' . $cedulaEstudiante .'
             Numero: ' . $correoEstudiante .'
             Cedula: ' . $telefonoEstudiante .'
        ';
        $mail->send();
    } catch (Exception $e) {
    }
}

function recuperarContrasenia($codigorecuperacion, $email)
{
    require '../../vendor/autoload.php';
    $mail = new PHPMailer(true);
    try {
        //Server settings
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host = HOST;                                         // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username = USEREMAIL;                                // SMTP username
        $mail->Password = PASSWORDEMAIL;                            // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = PUERTO;                                 // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
        $mail->CharSet = 'UTF-8';

        //Recipients
        $mail->setFrom(USEREMAIL, 'Escuela de Manejo Century');
        $mail->addAddress($email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'RECUPERACIÓN DE CUENTA';
        $mail->Body    = '
            <h3>ABRE EL LINK PARA RECUPERAR TU CONTRASEÑA<h3>
            <p>Te redireccionará a un formulario para generar una nueva<p>
            <p><a href="http://' . DOMINIO . '/Plataforma/Vistas/recuperarContrasenia.php?result=' . $codigorecuperacion . '">www.escuelademanejocentury.app/recuperarContrasenia</a><p>
            <p>Si no haz solicitado esta accion por favor, reportarla para tomar las medidas necesarias<p>
        ';

        $mail->send();
    } catch (Exception $e) {
    }
}

function estudianteInscrito($nombreEstudiante, $apellidoEstudiante,$correoEstudiante,$telefonoEstudiante,$cedulaEstudiante)
{
    require '../../vendor/autoload.php';
    $mail = new PHPMailer(true);
    try {
        //Server settings
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host = HOST;                                         // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username = USEREMAIL;                                // SMTP username
        $mail->Password = PASSWORDEMAIL;                            // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = PUERTO;                                 // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
        $mail->CharSet = 'UTF-8';
        //Recipients
        $mail->setFrom(USEREMAIL, 'Escuela de Manejo century');
        $mail->addAddress('info@escuelademanejocentury.com', 'Desde el sitio web');
        // Content
        //$mail->isHTML(true);
        $mail->Subject = 'Estudiante Inscrito';
        $mail->Body    = '
         Un nuevo estudiante se ha Inscrito exitosamente, puede revisar y corfirmar los datos enviados desde la plataforma

             Nombre  : ' . $nombreEstudiante . ' 
             Apellido: ' . $apellidoEstudiante . '
             Correo  : ' . $correoEstudiante . ' 
             Numero  : ' . $telefonoEstudiante . '
             Cedula  : ' . $cedulaEstudiante . '
        ';
        $mail->send();
    } catch (Exception $e) {

    }
}


function consulta($nombre, $email, $mensaje)
{
    require 'vendor/autoload.php';
    $mail = new PHPMailer(true);
    try {
        //Server settings
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host = HOST;                                         // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username = USEREMAIL;                                // SMTP username
        $mail->Password = PASSWORDEMAIL;                            // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = PUERTO;                                 // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
        $mail->CharSet = 'UTF-8';

        //Recipients
        $mail->setFrom(USEREMAIL, 'Escuela de Manejo Century');
        $mail->addAddress(USEREMAIL);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'CONSULTA';
        $mail->Body    = '
            <h3>SE OBTUVO LA SIGUIENTE CONSULTA DESDE LA WEB<h3>
            <p> ' . $nombre . '  <p>
            <p> ' . $email . '  <p>
            <p> ' . $mensaje . '  <p>

        
        ';

        $mail->send();
    } catch (Exception $e) {
    }
}







