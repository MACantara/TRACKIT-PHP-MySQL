<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once '../vendor/autoload.php';
require_once "../config.php";
require_once "db-connection.inc.php";
require_once "error-handling-functions.inc.php";
require_once "user-functions.inc.php";
require_once "profile-information-functions.inc.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = sanitizeInput($_POST['firstName']);
    $lastName = sanitizeInput($_POST['lastName']);
    $username = sanitizeInput($_POST['username']);
    $email = sanitizeInput($_POST['email']);
    $password = sanitizeInput($_POST['password']);
    $confirmPassword = sanitizeInput($_POST['confirmPassword']);

    if (signUpEmptyInput($firstName, $lastName, $username, $email, $password, $confirmPassword) !== false) {
        header("location: ../sign-up.php?error=emptyinput");
        exit();
    }

    if (invalidUsername($username) !== false) {
        header("location: ../sign-up.php?error=invalidusername");
        exit();
    }

    if (usernameExists($conn, $username) !== false) {
        header("location: ../sign-up.php?error=usernametaken");
        exit();
    }

    if (invalidEmail($email) !== false) {
        header("location: ../sign-up.php?error=invalidemail");
        exit();
    }

    if (emailExists($conn, $email) !== false) {
        header("location: ../sign-up.php?error=emailtaken");
        exit();
    }

    if (invalidPassword($password) !== false) {
        header("location: ../sign-up.php?error=invalidpassword");
        exit();
    }

    if (passwordDoNotMatch($password, $confirmPassword) !== false) {
        header("location: ../sign-up.php?error=passwordsdontmatch");
        exit();
    }

    createUser($conn, $firstName, $lastName, $username, $email, $password);

} else {
    header("location: ../index.php");
    exit();
}