<?php
// Include PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once "error-handling-functions.inc.php";
require_once 'db-connection.inc.php';
require_once 'profile-information-functions.inc.php';
require_once '../vendor/autoload.php';
require_once "../config.php";

session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $users_id = $_SESSION['users_id'];
    $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
    $currentPassword = $_POST['currentPassword'];

    $userData = getUserIdInformationById($conn, $users_id);
    $passwordHashed = $userData["users_password"];
    $checkPassword = password_verify($currentPassword, $passwordHashed);
    $usersUsername = $userData["users_username"];

    // Check if current password is correct
    if ($checkPassword === false) {
        // Incorrect current password
        // Redirect to the profile-information-settings page with an error message
        header("location: ../profile-information-settings.php?error=wrongcurrentpasswordemail");
        exit();
    }

    // Generate a unique token for email verification
    $token = bin2hex(random_bytes(32));

    // Save the token and new email in the database
    $sql = "INSERT INTO email_verification (email_verification_users_id, email_verification_token, email_verification_new_email) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $users_id, $token, $email);
    $stmt->execute();

    // Send verification email
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->Username = "welptest12@gmail.com";
        $mail->Password = "faix wvbv fauy qodg";
        $mail->SMTPSecure = "ssl";
        $mail->Port = 465;

        $mail->setFrom('welptest12@gmail.com', 'TRACKIT Team');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $url = BASE_URL . '/verify-email.php?token=' . $token;
        $mail->Subject = 'Email Change Verification';
        $mail->Body = "
            <html>
            <body>
                <h1>Hi there, " . $usersUsername . "</h1>
                <p>You have requested to change your email address. Please click the button below to verify your new email:</p>
                <a href='" . $url . "' style='background-color: #007BFF; color: white; padding: 10px 20px; text-align: center; text-decoration: none; display: inline-block;'>Verify Email</a>
                <p style='font-size: 0.8em; color: gray;'>Or copy and paste this link into your browser: <br>" . $url . "</p>
                <p>If you didn't request this change, you can safely ignore this email.</p>
                <p>Sincerely,<br>Your Website Team</p>
            </body>
            </html>";

        $mail->send();
    } catch (Exception $e) {
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    }

    // Redirect to the profile-information-settings page with a success message
    header("location: ../profile-information-settings.php?emailupdaterequest=success");
}