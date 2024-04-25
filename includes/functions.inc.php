<?php

function emptyInput($firstName, $lastName, $username, $email, $password, $confirmPassword) {
    $result;
    if (empty($firstName) || empty($lastName) || empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function invalidEmail($usersEmail) {
    $result;
    if (!filter_var($usersEmail, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function passwordMatch($password, $confirmPassword) {
    $result;
    if ($password !== $confirmPassword) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function createUser($conn, $firstName, $lastName, $username, $email, $password) {
    $sql = "INSERT INTO users (users_first_name, users_last_name, users_username, users_email, users_password) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../sign-up.php?error=stmtfailed");
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "sssss", $firstName, $lastName, $username, $email, $hashedPassword);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../sign-up.php?error=none");
    exit();
}