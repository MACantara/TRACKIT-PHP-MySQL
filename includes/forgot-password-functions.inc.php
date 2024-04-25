<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once "../PHPMailer/src/Exception.php";
require_once "../PHPMailer/src/PHPMailer.php";
require_once "../PHPMailer/src/SMTP.php";
require_once "db-connection.inc.php";

function sendResetEmail($userEmail, $url) {
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
    $mail->Body = "
    <html>
    <head>
        <title>Password Reset Request</title>
    </head>
    <body>
        <h1>Hi there, </h1>
        <p>We received a request to reset your password. If you made this request, please click the button below:</p>
        <a href='" . $url . "' style='background-color: #007BFF; color: white; padding: 10px 20px; text-align: center; text-decoration: none; display: inline-block;'>Reset Password</a>
        <p>If you didn't request a password reset, you can safely ignore this email. Your password will not change.</p>
        <p>Thanks,<br>Your Team</p>
    </body>
    </html>";
    $mail->AddAddress($userEmail);

    $mail->Send();
}

function deleteExistingResetRequest($conn, $userEmail) {
    $sql = "DELETE FROM password_reset WHERE password_reset_email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $userEmail);
    mysqli_stmt_execute($stmt);
}

function createNewResetRequest($conn, $userEmail, $selector, $hashedToken, $expires) {
    $sql = "INSERT INTO password_reset (password_reset_email, password_reset_selector, password_reset_token, password_reset_expires) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssss", $userEmail, $selector, $hashedToken, $expires);
    mysqli_stmt_execute($stmt);
}

function handleRequest($conn, $userEmail) {
    deleteExistingResetRequest($conn, $userEmail);
    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);
    $url = BASE_URL . "create-new-password.php?selector=" . $selector . "&validator=" . bin2hex($token);
    $expires = date("U") + 1800;
    $hashedToken = password_hash($token, PASSWORD_DEFAULT);
    createNewResetRequest($conn, $userEmail, $selector, $hashedToken, $expires);
    sendResetEmail($userEmail, $url);
}