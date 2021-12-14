<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require_once '../vendor/autoload.php';
class Mailer
{
    public function sendMail($contact)
    {
        $mail = new PHPMailer(true); // Passing `true` enables exceptions
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
        try {
            $mail->isSMTP();
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 587;
            $mail->SMTPSecure = 'tls';
            $mail->SMTPAuth = true;
            $mail->Username = 'camilo.santander1313@gmail.com';
            $mail->Password = 'Capitan1313:$';
            $mail->setFrom("camilo.santander1313@gmail.com", "Camilo Santander");
            $mail->addAddress("demon_camilo@hotmail.com", "Camilo Santander");
            $mail->Subject = "Mensaje de Contacto: <b>" . $contact->name . "</b>.";
            $mail->isHTML(true);
            $mail->Body = "Mensaje de Contacto generado por: <b>" . $contact->name . "</b>.<br>
            Email: " . $contact->email . "<br>
            Teléfono: " . $contact->phone . "<br>
            Mensaje: " . $contact->message . ".<br>";
            $mail->send();
            echo 'Mensaje Enviado al Parecer.';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
