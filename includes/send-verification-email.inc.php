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

$users_id = $_SESSION['users_id'];
$userData = getUserInformation($conn, $users_id);

// Check if email is already verified
if ($userData['users_email_verified'] == 1) {
    header("location: ../profile-information-settings.php?error=emailalreadyverified");
    exit();
}

// Generate a unique token for email verification
$token = bin2hex(random_bytes(32));

// Save the token in the database
$sql = "INSERT INTO email_verification (email_verification_users_id, email_verification_token, email_verification_new_email, email_verification_created_at) VALUES (?, ?, ?, NOW())";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iss", $users_id, $token, $userData['users_email']);
$stmt->execute();

require_once 'email-functions.inc.php';

$url = BASE_URL . '/verify-email.php?token=' . $token;
$subject = 'Email Verification';
$body = "
    <html>
    <body>
        <h1>Welcome to our website!</h1>
        <p>Please click the link below to verify your email:</p>
        <a href='" . $url . "' style='background-color: #007BFF; color: white; padding: 10px 20px; text-align: center; text-decoration: none; display: inline-block;'>Verify Email</a>
        <p>If you didn't create this account, you can safely ignore this email.</p>
        <p>Sincerely,<br>Our Website Team</p>
    </body>
    </html>";

sendEmail($userData['users_email'], $subject, $body, $url);

header("location: ../profile-information-settings.php?emailverificationsent");