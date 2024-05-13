<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendEmail($email, $subject, $body, $url) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = "smtp-trackit.alwaysdata.net";
        $mail->SMTPAuth = true;
        $mail->Username = "trackit@alwaysdata.net";
        $mail->Password = "Gloomily23Map15Landmass33Exonerate51Coagulant4";
        $mail->SMTPSecure = "ssl";
        $mail->Port = 465;

        $mail->setFrom('trackit@alwaysdata.net', 'TRACKIT Team');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;

        $mail->send();
    } catch (Exception $e) {
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    }
}