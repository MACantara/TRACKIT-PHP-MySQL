<?php

if (isset($_POST['reset-request-submit'])) {
    $userEmail = $_POST["email"];

    include "../classes/PasswordResetRequestController.class.php";

    $passwordResetRequestController = new PasswordResetRequestController();
    $passwordResetRequestController->handleRequest($userEmail);

    header("location: ../reset-password.php?reset=success");
} else {
    header("Location: ../index.php");
    exit();
}
?>