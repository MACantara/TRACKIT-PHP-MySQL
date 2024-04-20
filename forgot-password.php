<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$mail = new PHPMailer();
$mail->isSMTP();
$mail->SMTPAuth = true;
$mail->SMTPSecure = "ssl";
$mail->Host = "smtp.gmail.com";
$mail->Port = 465;
$mail->isHTML();
$mail->Username = "welptest12@gmail.com";
$mail->Password = "faix wvbv fauy qodg";
$mail->SetFrom("no-reply@trackit.com");
$mail->Subject = "Reset your password";
$mail->Body = "Click here to reset your password: <a href='http://localhost/TRACKIT-PHP-MySQL/reset-password.php'>Reset</a>";
$mail->AddAddress("mangelo0902@gmail.com");

$mail->Send();