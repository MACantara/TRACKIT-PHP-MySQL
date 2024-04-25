<?php
require 'db-connection.inc.php';
require_once "../PHPMailer/src/Exception.php";
require_once "../PHPMailer/src/PHPMailer.php";
require_once "../PHPMailer/src/SMTP.php";
require_once "../config.php";
require_once "error-handling-functions.inc.php";

if (isset($_POST["reset-password-submit"])) {
    $selector = $_POST["selector"];
    $validator = $_POST["validator"];
    $password = $_POST["password"];
    $passwordRepeat = $_POST["password-repeat"];
    if (empty($password) || empty($passwordRepeat)) {
        header("Location: ../create-new-password.php?selector=" . $selector . "&validator=" . $validator . "&error=emptyfields");
        exit();
    } else if ($password != $passwordRepeat) {
        header("Location: ../create-new-password.php?selector=" . $selector . "&validator=" . $validator . "&error=passwordsdontmatch");
        exit();
    }
    $currentDate = date("U");
    $sql = "SELECT * FROM password_reset WHERE password_reset_selector = ? AND password_reset_expires >= ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $selector, $currentDate);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (!$row = mysqli_fetch_assoc($result)) {
        header("Location: ../create-new-password.php?selector=" . $selector . "&validator=" . $validator . "&error=resubmit");
        exit();
    } else {
        $tokenBin = hex2bin($validator);
        $tokenCheck = password_verify($tokenBin, $row["password_reset_token"]);
        if ($tokenCheck === false) {
            header("Location: ../create-new-password.php?selector=" . $selector . "&validator=" . $validator . "&error=resubmit");
            exit();
        } else if ($tokenCheck === true) {
            $tokenEmail = $row["password_reset_email"];
            $sql = "UPDATE users SET users_password = ? WHERE users_email = ?";
            $stmt = mysqli_prepare($conn, $sql);
            $newPwdHash = password_hash($password, PASSWORD_DEFAULT);
            mysqli_stmt_bind_param($stmt, "ss", $newPwdHash, $tokenEmail);
            mysqli_stmt_execute($stmt);
            $sql = "DELETE FROM password_reset WHERE password_reset_email = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
            mysqli_stmt_execute($stmt);
            header("Location: ../log-in.php?newpwd=success");
        }
    }
} else {
    header("Location: ../index.php");
}