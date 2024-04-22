<?php
require_once "../classes/PasswordResetRequestController.class.php";
if (isset($_POST['reset-request-submit'])) {
    $userEmail = $_POST["email"];

    $passwordResetRequestController = new PasswordResetRequestController();
    $passwordResetRequestController->handleRequest($userEmail);

    header("location: ../reset-password.php?reset=success");
} else {
    header("Location: ../index.php");
    exit();
}
?>