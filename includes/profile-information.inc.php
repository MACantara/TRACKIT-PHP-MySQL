<?php
require_once "error-handling-functions.inc.php";
require_once 'db-connection.inc.php';
require_once 'profile-information-functions.inc.php';

session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $users_id = $_SESSION['users_id'];
    $firstName = sanitizeInput($_POST['firstName']);
    $lastName = sanitizeInput($_POST['lastName']);
    $username = sanitizeInput($_POST['username']);
    $profileAbout = sanitizeInput($_POST['profileAbout']);
    $profileTitle = sanitizeInput($_POST['profileTitle']);
    $profileText = sanitizeInput($_POST['profileText']);
    $currentPassword = sanitizeInput($_POST['currentPassword']);

    $userData = getUserIdInformationById($conn, $users_id);
    $passwordHashed = $userData["users_password"];
    $checkPassword = password_verify($currentPassword, $passwordHashed);

    if ($checkPassword === false) {
        header("location: ../profile-information-settings.php?error=wrongcurrentpasswordprofile");
        exit();
    }

    updateUserInformation($conn, $firstName, $lastName, $username, $users_id);
    updateProfileInformation($conn, $profileAbout, $profileTitle, $profileText, $users_id);

    header("location: ../profile-information-settings.php?error=none");
}