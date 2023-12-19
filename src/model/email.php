<?php
require_once '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;

function sendMail($to, $subject, $message)
{
    require_once 'data.php';
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = $host;
    $mail->SMTPAuth = true;
    $mail->Username = $user;
    $mail->Password = $pw;
    $mail->Port = 465;
    $mail->SMTPSecure = "ssl";
    $mail->setFrom($user, 'Chen');

    // El mensaje del correo
    $mail->addAddress($to);
    $mail->Subject = 'Registro de usuarios';
    $mail->isHTML(true);
    $mail->Body = "<h1>Bienvenido $subject!</h1> <p>Pincha en el enlace para confirmar tu correo.</p> $message";
    if (!$mail->send()) {
        exit('No se ha podido enviar el mensaje');
    }
    // Cerrar la conexión
    $mail->smtpClose();
}
