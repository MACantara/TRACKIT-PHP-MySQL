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

function limitLoginAttempts($conn, $ip_address) {
    // Check the number of failed login attempts from this IP address
    $sql = "SELECT login_attempt_id, login_attempt_count, login_attempt_last_attempt_time FROM login_attempts WHERE login_attempt_ip_address = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../log-in.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $ip_address);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($resultData)) {
        if ($row['login_attempt_count'] >= 3 && time() - strtotime($row['login_attempt_last_attempt_time']) < 900) {
            // The user has exceeded the maximum number of login attempts and the timeout period has not passed
            header("location: ../log-in.php?error=toomanyattempts");
            exit();
        }
    }

    return $row;
}

function incrementLoginAttempts($conn, $row, $ip_address) {
    if (isset($row['login_attempt_id'])) {
        $sql = "UPDATE login_attempts SET login_attempt_count = login_attempt_count + 1, login_attempt_last_attempt_time = NOW() WHERE login_attempt_id = ?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../log-in.php?error=stmtfailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "i", $row['login_attempt_id']);
    } else {
        $sql = "INSERT INTO login_attempts (login_attempt_ip_address, login_attempt_count, login_attempt_last_attempt_time) VALUES (?, 1, NOW())";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../log-in.php?error=stmtfailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "s", $ip_address);
    }
    mysqli_stmt_execute($stmt);
}

function resetLoginAttempts($conn, $ip_address) {
    $sql = "UPDATE login_attempts SET login_attempt_count = 0 WHERE login_attempt_ip_address = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../log-in.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $ip_address);
    mysqli_stmt_execute($stmt);
}

function loginUser($conn, $username, $password) {
    $ip_address = $_SERVER['REMOTE_ADDR']; // get the user's IP address

    $row = limitLoginAttempts($conn, $ip_address);

    $userExists = userExists($conn, $username, $username);

    if ($userExists === false) {
        header("location: ../log-in.php?error=wronglogin");
        exit();
    }

    $passwordHashed = $userExists["users_password"];
    $checkPassword = password_verify($password, $passwordHashed);

    if ($checkPassword === false) {
        incrementLoginAttempts($conn, $row, $ip_address);
        header("location: ../log-in.php?error=wronglogin");
        exit();
    } else if ($checkPassword === true) {
        resetLoginAttempts($conn, $ip_address);

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

function require_login() {
    // Start the session if it's not already started
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Check if the user is logged in
    if (!isset($_SESSION['users_id'])) {
        // If they're not, redirect them to the login page
        header('Location: log-in.php?error=loginrequired');
        exit();
    }
}

function checkSessionTimeout() {
    // start the session
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // set the timeout duration (in seconds)
    $timeout_duration = 900;  // 15 minutes

    // check if the timeout key exists
    if(isset($_SESSION['timeout'])) {
        // calculate the session lifetime
        $session_lifetime = time() - $_SESSION['timeout'];

        // check if the session has expired
        if($session_lifetime > $timeout_duration) {
            // destroy the session and redirect the user
            session_unset();
            session_destroy();
            header("Location: log-in.php?error=sessiontimeout");
            exit();
        }
    }

    // update the timeout time
    $_SESSION['timeout'] = time();
}