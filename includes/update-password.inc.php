<?php
require_once 'db-connection.inc.php';
require_once "error-handling-functions.inc.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["updatePassword"])) {
    $usersEmail = $_POST["usersEmail"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];

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
    header("Location: ../profile-information.php?newpassword=success");
} else {
    header("Location: ../index.php");
}