<?php

if (isset($_POST['submit'])) {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    require_once 'db-connection.include.php';
    require_once 'functions.include.php';

    if (invalidUsername($username) !== false) {
        header("location: ../signup.php?error=invalidusername");
        exit();
    }

    if (passwordMatch($password, $confirmPassword) !== false) {
        header("location: ../signup.php?error=passwordsdontmatch");
        exit();
    }

    if (usernameExists($conn, $username) !== false) {
        header("location: ../signup.php?error=usernametaken");
        exit();
    }

    createUser($conn, $firstName, $lastName, $email, $username, $password);

} else {
    header("location: ../signup.php");
    exit();
}