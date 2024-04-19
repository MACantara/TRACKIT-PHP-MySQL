<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Grabbing the data
    $firstName = htmlspecialchars($_POST['firstName'], ENT_QUOTES, 'UTF-8');
    $lastName = htmlspecialchars($_POST['lastName'], ENT_QUOTES, 'UTF-8');
    $username = htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
    $password = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');
    $confirmPassword = htmlspecialchars($_POST['confirmPassword'], ENT_QUOTES, 'UTF-8');

    // Instantiate the SignUpController class
    include "../classes/db-connection.class.php";
    include "../classes/sign-up.class.php";
    include "../classes/sign-up-controller.class.php";
    $signUp = new SignUpController($firstName, $lastName, $username, $email, $password, $confirmPassword);


    // Error handling
    $signUp->signUpUser();

    $user_id = $signUp->fetchUserId($username);

    // Instantiate ProfileInfoContr class
    include "../classes/profileinfo.classes.php";
    include "../classes/profile-info-controller.class.php";
    $profileInfo = new ProfileInfoContr($user_id, $username);
    $profileInfo->defaultProfileInfo();

    // Going back to front page
    header("location: ../sign-up.php?error=none");

} else {
    // If there are no errors, redirect back to the signup page
    header("location: ../sign-up.php");
    exit();
}