<?php
require_once "../config.php";
require_once "error-handling-functions.inc.php";
require_once '../includes/forgot-password-functions.inc.php';

if (isset($_POST['reset-request-submit'])) {
    $userEmail = $_POST["email"];

    if (passwordRequestEmptyInput($userEmail) || invalidEmail($userEmail)) {
        header("Location: ../forgot-password.php?error=emptyinput");
        exit();
    }

    if (!emailNotFound($userEmail, $conn)) {
        header("Location: ../forgot-password.php?error=emailnotfound");
        exit();
    }

    handleRequest($conn, $userEmail);
    header("location: ../forgot-password.php?reset=success");
} else {
    header("Location: ../index.php");
    exit();
}