<?php

if (isset($_POST['submit'])) {
    $username = $_POST['uid'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    require_once 'db-connection.include.php';
    require_once 'functions.include.php';

    if (invalidUid($username) !== false) {
        header("location: ../signup.php?error=invaliduid");
        exit();
    }

    if (passwordMatch($password, $confirmPassword) !== false) {
        header("location: ../signup.php?error=passwordsdontmatch");
        exit();
    }

    if (uidExists($conn, $username) !== false) {
        header("location: ../signup.php?error=usernametaken");
        exit();
    }

    createUser($conn, $username, $password);

} else {
    header("location: ../signup.php");
    exit();
}