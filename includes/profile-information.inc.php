<?php
require_once "error-handling-functions.inc.php";
require_once 'db-connection.inc.php';
require_once 'profile-information-functions.inc.php';

session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $users_id = $_SESSION['users_id'];
    $profileAbout = htmlspecialchars($_POST['profileAbout'], ENT_QUOTES, 'UTF-8');
    $profileTitle = htmlspecialchars($_POST['profileTitle'], ENT_QUOTES, 'UTF-8');
    $profileText = htmlspecialchars($_POST['profileText'], ENT_QUOTES, 'UTF-8');
    updateProfileInformation($conn, $profileAbout, $profileTitle, $profileText, $users_id);
    header("location: ../profile-information.php?error=none");
}