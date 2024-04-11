<?php

if (isset($_POST['submit'])) {
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

    createUser($conn, $username, $password);

} else {
    header("location: ../signup.php");
    exit();
}