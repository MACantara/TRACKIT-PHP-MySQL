<?php

if (isset($_POST['sign-up'])) {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    require_once 'db-connection.include.php';
    require_once 'functions.include.php';

    if (invalidUsername($username) !== false) {
        header("location: ../templates/signup.php?error=invalidusername");
        exit();
    }

    if (passwordMatch($password, $confirmPassword) !== false) {
        header("location: ../templates/signup.php?error=passwordsdontmatch");
        exit();
    }

    if (usernameExists($conn, $username) !== false) {
        header("location: ../templates/signup.php?error=usernametaken");
        exit();
    }

    createUser($conn, $firstName, $lastName, $email, $username, $password);

} else {
    header("location: ../templates/signup.php");
    exit();
}