<?php

require '../classes/PasswordReset.class.php';

if (isset($_POST["reset-password-submit"])) {
    $selector = $_POST["selector"];
    $validator = $_POST["validator"];
    $password = $_POST["password"];
    $passwordRepeat = $_POST["password-repeat"];

    $dBUserName = "355327_testuser";
    $dBPassword = "Crusher15Humble52Finicky80Footnote68Crimson4";

    $passwordReset = new PasswordReset($dBUserName, $dBPassword);
    $result = $passwordReset->resetPassword($selector, $validator, $password, $passwordRepeat);

    if ($result['status'] === 'error') {
        header("Location: ../create-new-password.php?selector=" . $selector . "&validator=" . $validator . "&error=" . $result['message']);
        exit();
    } else {
        header("Location: ../log-in.php?newpwd=success");
    }
} else {
    header("Location: ../index.php");
}