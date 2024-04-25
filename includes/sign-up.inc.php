<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = htmlspecialchars($_POST['firstName'], ENT_QUOTES, 'UTF-8');
    $lastName = htmlspecialchars($_POST['lastName'], ENT_QUOTES, 'UTF-8');
    $username = htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
    $password = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');
    $confirmPassword = htmlspecialchars($_POST['confirmPassword'], ENT_QUOTES, 'UTF-8');

    require_once 'db-connection.inc.php';
    require_once 'functions.inc.php';

    if (signUpEmptyInput($firstName, $lastName, $username, $email, $password, $confirmPassword) !== false) {
        header("location: ../sign-up.php?error=emptyinput");
        exit();
    }

    if (passwordMatch($password, $confirmPassword) !== false) {
        header("location: ../sign-up.php?error=passwordsdontmatch");
        exit();
    }

    createUser($conn, $firstName, $lastName, $username, $email, $password);

} else {
    header("location: ../index.php");
    exit();
}