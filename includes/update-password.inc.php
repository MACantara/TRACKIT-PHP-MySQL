<?php
require_once 'db-connection.inc.php';
require_once "error-handling-functions.inc.php";
require_once 'profile-information-functions.inc.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["updatePassword"])) {
    $usersEmail = sanitizeInput($_POST["usersEmail"]);
    $password = sanitizeInput($_POST["password"]);
    $confirmPassword = sanitizeInput($_POST["confirmPassword"]);
    $currentPassword = sanitizeInput($_POST["currentPassword"]);

    $userData = getUserInformationByEmail($conn, $usersEmail);
    $passwordHashed = $userData["users_password"];
    $checkPassword = password_verify($currentPassword, $passwordHashed);

    if ($checkPassword === false) {
        header("location: ../profile-information-settings.php?error=wrongcurrentpasswordupdatepassword");
        exit();
    }

    if (passwordResetEmptyInput($password, $confirmPassword) !== false) {
        header("Location: ../profile-information.php?error=emptyinput");
        exit();
    }

    if (passwordDoNotMatch($password, $confirmPassword)) {
        header("Location: ../profile-information.php?error=passwordsdontmatch");
        exit();
    }

    if (invalidPassword($password) !== false) {
        header("Location: ../profile-information.php?error=invalidpassword");
        exit();
    }

    $sql = "UPDATE users SET users_password = ? WHERE users_email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    $newPasswordHash = password_hash($password, PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt, "ss", $newPasswordHash, $usersEmail);
    mysqli_stmt_execute($stmt);
    header("Location: ../profile-information-settings.php?newpassword=success");
} else {
    header("Location: ../index.php");
}