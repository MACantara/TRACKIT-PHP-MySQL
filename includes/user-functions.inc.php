<?php

require_once "db-connection.inc.php";
require_once "error-handling-functions.inc.php";

function createUser($conn, $firstName, $lastName, $username, $email, $password) {
    $sql = "INSERT INTO users (users_first_name, users_last_name, users_username, users_email, users_password) VALUES (?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../sign-up.php?error=stmtfailed");
        exit();
    }
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt, "sssss", $firstName, $lastName, $username, $email, $hashedPassword);
    mysqli_stmt_execute($stmt);
    $users_id = mysqli_insert_id($conn); // Get the ID of the newly created user
    defaultProfileInformation($conn, $username, $users_id); // Create a default profile for the new user
    mysqli_stmt_close($stmt);
    header("location: ../log-in.php?error=none");
    exit();
}


function loginUser($conn, $username, $password) {
    $userExists = userExists($conn, $username, $username);

    if ($userExists === false) {
        header("location: ../log-in.php?error=wronglogin");
        exit();
    }

    $passwordHashed = $userExists["users_password"];
    $checkPassword = password_verify($password, $passwordHashed);

    if ($checkPassword === false) {
        header("location: ../log-in.php?error=wronglogin");
        exit();
    } else if ($checkPassword === true) {
        session_start();
        $keys = ["users_id", "users_first_name", "users_last_name", "users_username", "users_email"];
    
        foreach ($keys as $key) {
            if (isset($userExists[0][$key])) {
                $_SESSION[$key] = $userExists[0][$key];
            }
            if (isset($userExists[$key])) {
                $_SESSION[$key] = $userExists[$key];
            }
        }
        header("location: ../events-overview.php");
        exit();
    }
}