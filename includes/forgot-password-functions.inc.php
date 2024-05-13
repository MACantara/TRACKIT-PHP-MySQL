<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once '../vendor/autoload.php';
require_once "db-connection.inc.php";

function sendResetEmail($usersEmail, $usersUsername, $url) {
    require_once 'email-functions.inc.php';

    $subject = "Reset your password";
    $body = "
        <html>
        <head>
            <title>Password Reset Request</title>
        </head>
        <body>
            <h1>Hi there, " . $usersUsername . "</h1>
            <p>We received a request to reset your password. If you made this request, please click the button below:</p>
            <a href='" . $url . "' style='background-color: #007BFF; color: white; padding: 10px 20px; text-align: center; text-decoration: none; display: inline-block;'>Reset Password</a>
            <p style='font-size: 0.8em; color: gray;'>Or copy and paste this link into your browser: <br>" . $url . "</p>
            <p>If you didn't request a password reset, you can safely ignore this email. Your password will not change.</p>
            <p>Sincerely,<br>TRACKIT Team</p>
        </body>
        </html>";

    sendEmail($usersEmail, $subject, $body, $url);
}

function deleteExistingResetRequest($conn, $usersId) {
    $sql = "DELETE FROM password_reset WHERE password_reset_users_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $usersId);
    mysqli_stmt_execute($stmt);
}

function createNewResetRequest($conn, $usersId, $selector, $hashedToken, $expires) {
    $sql = "INSERT INTO password_reset (password_reset_users_id, password_reset_selector, password_reset_token, password_reset_expires) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "isss", $usersId, $selector, $hashedToken, $expires);
    mysqli_stmt_execute($stmt);
}

function handleRequest($conn, $usersEmail) {
    if (passwordRequestEmptyInput($usersEmail) !== false) {
        header("location: ../forgot-password.php?error=emptyinput");
        exit();
    }

    // Get the user's id and username
    $sql = "SELECT users_id, users_username FROM users WHERE users_email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $usersEmail);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($result)) {
        $usersId = $row['users_id'];
        $usersUsername = $row['users_username'];
    } else {
        header("location: ../forgot-password.php?error=nouser");
        exit();
    }

    deleteExistingResetRequest($conn, $usersId);
    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);
    $url = BASE_URL . "create-new-password.php?selector=" . $selector . "&validator=" . bin2hex($token);
    $expires = date("U") + 1800;
    $hashedToken = password_hash($token, PASSWORD_DEFAULT);
    createNewResetRequest($conn, $usersId, $selector, $hashedToken, $expires);
    sendResetEmail($usersEmail, $usersUsername, $url);
}