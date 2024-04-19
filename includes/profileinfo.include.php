<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Grabbing the data

    $users_id = $_SESSION['users_id'];
    $users_username = $_SESSION['users_username'];
    $profileAbout = htmlspecialchars($_POST['profileAbout'], ENT_QUOTES, 'UTF-8');
    $profileTitle = htmlspecialchars($_POST['profileTitle'], ENT_QUOTES, 'UTF-8');
    $profileText = htmlspecialchars($_POST['profileText'], ENT_QUOTES, 'UTF-8');

    include "../classes/DbConnection.class.php";
    include "../classes/profileinfo.classes.php";
    include "../classes/ProfileInformationController.class.php";
    $profileInfo = new ProfileInformationController($users_id, $users_username);

    $profileInfo->updateProfileInfo($profileAbout, $profileTitle, $profileText);

    header("location: ../profile.php?error=none");
}