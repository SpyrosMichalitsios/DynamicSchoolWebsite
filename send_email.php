<?php
//THIS IS A FUNCTION FOR SENDING EMAILS
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

function sendEmail($sender,$recipient, $subject, $body) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'spiretos48625@gmail.com';
        $mail->Password   = 'vjjfphyqmqkxdwte';
        $mail->SMTPSecure = 'ssl';
        $mail->Port       = 465;

        // Recipients
        $mail->setFrom("spiretos48625@gmail.com");
        $mail->addAddress($recipient);

        // Content
        $mail->Subject = $subject;
        $fullBody = "From: $sender\n\n$body";
        $mail->Body = $fullBody;


        $mail->send();
    } catch (Exception $e) {
        echo "Error: {$mail->ErrorInfo}";
    }
}
?>
