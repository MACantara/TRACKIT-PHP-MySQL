<?php
require_once 'db-connection.inc.php';
require_once '../vendor/autoload.php';
require_once "../config.php";
require_once "error-handling-functions.inc.php";

if (isset($_POST["reset-password-submit"])) {
    $selector = $_POST["selector"];
    $validator = $_POST["validator"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];

    if (passwordResetEmptyInput($password, $confirmPassword) !== false) {
        header("Location: ../create-new-password.php?selector=" . $selector . "&validator=" . $validator . "&error=emptyinput");
        exit();
    }

    if (passwordDoNotMatch($password, $confirmPassword)) {
        header("Location: ../create-new-password.php?selector=" . $selector . "&validator=" . $validator . "&error=passwordsdontmatch");
        exit();
    }

    if (invalidPassword($password) !== false) {
        header("Location: ../create-new-password.php?selector=" . $selector . "&validator=" . $validator . "&error=invalidpassword");
        exit();
    }

    $currentDate = date("U");
    $sql = "DELETE FROM password_reset WHERE password_reset_selector = ? AND password_reset_expires < ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $selector, $currentDate);
    mysqli_stmt_execute($stmt);

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
            $tokenUserId = $row["password_reset_users_id"];
            $sql = "UPDATE users SET users_password = ? WHERE users_id = ?";
            $stmt = mysqli_prepare($conn, $sql);
            $newPwdHash = password_hash($password, PASSWORD_DEFAULT);
            mysqli_stmt_bind_param($stmt, "ss", $newPwdHash, $tokenUserId);
            mysqli_stmt_execute($stmt);
            $sql = "DELETE FROM password_reset WHERE password_reset_users_id = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "s", $tokenUserId);
            mysqli_stmt_execute($stmt);
            header("Location: ../log-in.php?newpwd=success");
        }
    }
} else {
    header("Location: ../index.php");
}