<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once "../PHPMailer/src/Exception.php";
require_once "../PHPMailer/src/PHPMailer.php";
require_once "../PHPMailer/src/SMTP.php";
require_once "../config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = htmlspecialchars($_POST['firstName'], ENT_QUOTES, 'UTF-8');
    $lastName = htmlspecialchars($_POST['lastName'], ENT_QUOTES, 'UTF-8');
    $username = htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
    $password = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');
    $confirmPassword = htmlspecialchars($_POST['confirmPassword'], ENT_QUOTES, 'UTF-8');

    require_once "db-connection.inc.php";
    require_once "error-handling-functions.inc.php";
    require_once "user-functions.inc.php";
    require_once "profile-information-functions.inc.php";

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