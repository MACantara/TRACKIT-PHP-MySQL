<?php
require_once "../config.php";
require_once "error-handling-functions.inc.php";

if (isset($_POST['reset-request-submit'])) {
    $userEmail = $_POST["email"];
    require_once '../includes/forgot-password-functions.inc.php';
    handleRequest($conn, $userEmail);
    header("location: ../forgot-password.php?reset=success");
} else {
    header("Location: ../index.php");
    exit();
}