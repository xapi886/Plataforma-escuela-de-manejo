<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function verificarInscripcion($codigoInscripcion, $email)
{
    require '../../vendor/autoload.php';
    $mail = new PHPMailer(true);
    try {
        //Server settings
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                     // Enable verbose debug output
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
        $mail->Subject = 'Cuenta verificada';
        $mail->Body    = '
            <h3>SU CUENTA HA SIDO CORRECTAMENTE VERIFICADA ABRA EL SIGUIENTE LINK PARA PODER TERMINAR EL PROCESO DE INSCRIPCIÓN<h3>
            <p>Te redireccionará al formulario para poder completar la inscripcion<p>
            <p><a href="http://' . DOMINIO . '/Plataforma/Vistas/Reglamento.php?result=' . $codigoInscripcion . '">www.escuelademanejocentury.app/Inscripcion</a><p>
            <p>Si no haz solicitado esta accion por favor, reportarla para tomar las medidas necesarias<p>';

        $mail->send();
    } catch (Exception $e) {
    }
}





