<?php

if (isset($_POST['sign-up'])) {
    // Grabbing the data
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Linking the database connection and functions
    require_once 'db-connection.include.php';
    require_once 'functions.include.php';

    // Error handling
    if (invalidUsername($username) !== false) {
        header("location: ../templates/sign-up.php?error=invalidusername");
        exit();
    }

    if (passwordMatch($password, $confirmPassword) !== false) {
        header("location: ../templates/sign-up.php?error=passwordsdontmatch");
        exit();
    }

    if (usernameExists($conn, $username) !== false) {
        header("location: ../templates/sign-up.php?error=usernametaken");
        exit();
    }

    // If there are no errors, create the user
    createUser($conn, $firstName, $lastName, $email, $username, $password);

} else {
    // If there are no errors, redirect back to the signup page
    header("location: ../templates/sign-up.php");
    exit();
}