<?php

if (isset($_POST['sign-up'])) {
    // Grabbing the data
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Instantiate the SignUpController class
    include "../classes/db-connection.class.php";
    include "../classes/sign-up.class.php";
    include "../classes/sign-up-controller.class.php";
    $signUp = new SignUpController($firstName, $lastName, $username, $email, $password, $confirmPassword);


    // Error handling
    $signUp->signUpUser();

    // Going back to front page
    header("location: ../templates/sign-up.template.php?error=none");

} else {
    // If there are no errors, redirect back to the signup page
    header("location: ../templates/sign-up.template.php");
    exit();
}