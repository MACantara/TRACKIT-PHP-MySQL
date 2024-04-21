<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

if (isset($_POST['reset-request-submit'])) {

    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);

    $url = "localhost/TRACKIT-PHP-MySQL/create-new-password.php?selector=" . $selector . "&validator=" . bin2hex($token);

    $expires = date("U") + 1800;

    $dBUserName = "355327_testuser";
    $dBPassword = "Crusher15Humble52Finicky80Footnote68Crimson4";

    $conn = new PDO("mysql:host=mysql-mysql-database.alwaysdata.net;dbname=mysql-database_trackit", $dBUserName, $dBPassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $userEmail = $_POST["email"];
    $sql = "DELETE FROM passwordReset WHERE passwordResetEmail = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$userEmail]);

    $sql = "INSERT INTO passwordReset (passwordResetEmail, passwordResetSelector, passwordResetToken, passwordResetExpires) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $hashedToken = password_hash($token, PASSWORD_DEFAULT);
    $stmt->execute([$userEmail, $selector, $hashedToken, $expires]);

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
    $mail->Body = "Click here to reset your password: <a href='" . $url . "'>Reset</a>";
    $mail->AddAddress($userEmail);

    $mail->Send();

    header("location: ../reset-password.php?reset=success");
} else {
    header("Location: ../index.php");
    exit();
}