<?php
require_once "error-handling-functions.inc.php";
require_once 'db-connection.inc.php';
require_once 'profile-information-functions.inc.php';

session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $users_id = $_SESSION['users_id'];
    $firstName = htmlspecialchars($_POST['firstName'], ENT_QUOTES, 'UTF-8');
    $lastName = htmlspecialchars($_POST['lastName'], ENT_QUOTES, 'UTF-8');
    $username = htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8');
    $profileAbout = htmlspecialchars($_POST['profileAbout'], ENT_QUOTES, 'UTF-8');
    $profileTitle = htmlspecialchars($_POST['profileTitle'], ENT_QUOTES, 'UTF-8');
    $profileText = htmlspecialchars($_POST['profileText'], ENT_QUOTES, 'UTF-8');
    $currentPassword = $_POST['currentPassword'];

    $userData = getUserIdInformationById($conn, $users_id);
    $passwordHashed = $userData["users_password"];
    $checkPassword = password_verify($currentPassword, $passwordHashed);

    if ($checkPassword === false) {
        header("location: ../profile-information-settings.php?error=wrongpassword");
        exit();
    }

    updateUserInformation($conn, $firstName, $lastName, $username, $users_id);
    updateProfileInformation($conn, $profileAbout, $profileTitle, $profileText, $users_id);

    header("location: ../profile-information-settings.php?error=none");
}