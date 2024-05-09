<?php
require_once "error-handling-functions.inc.php";
require_once 'db-connection.inc.php';
require_once 'profile-information-functions.inc.php';

session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $users_id = $_SESSION['users_id'];
    $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
    $currentPassword = $_POST['currentPassword'];

    $userData = getUserIdInformationById($conn, $users_id);
    $passwordHashed = $userData["users_password"];
    $checkPassword = password_verify($currentPassword, $passwordHashed);

    if ($checkPassword === false) {
        header("location: ../profile-information-settings.php?error=wrongcurrentpasswordemail");
        exit();
    }

    updateUserEmail($conn, $email, $users_id);

    header("location: ../profile-information-settings.php?email=success");
}