<?php

require_once "db-connection.inc.php";

function signUpEmptyInput($firstName, $lastName, $username, $email, $password, $confirmPassword) {
    $result;
    if (empty($firstName) || empty($lastName) || empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function logInEmptyInput($username, $password) {
    $result;
    if (empty($username) || empty($password)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function invalidUsername($username) {
    $result;
    if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
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
function usernameExists($conn, $username, $email) {
    $sql = "SELECT * FROM users WHERE users_username = ? or users_email = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

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
    header("location: ../sign-up.php?error=none");
    exit();
}


function loginUser($conn, $username, $password) {
    $usernameExists = usernameExists($conn, $username, $username);

    if ($usernameExists === false) {
        header("location: ../log-in.php?error=wronglogin");
        exit();
    }

    $passwordHashed = $usernameExists["users_password"];
    $checkPassword = password_verify($password, $passwordHashed);

    if ($checkPassword === false) {
        header("location: ../log-in.php?error=wronglogin");
        exit();
    } else if ($checkPassword === true) {
        session_start();
        $keys = ["users_id", "users_first_name", "users_last_name", "users_username", "users_email"];
    
        foreach ($keys as $key) {
            if (isset($usernameExists[0][$key])) {
                $_SESSION[$key] = $usernameExists[0][$key];
            }
            if (isset($usernameExists[$key])) {
                $_SESSION[$key] = $usernameExists[$key];
            }
        }
        header("location: ../index.php");
        exit();
    }
}

function getProfileInformation($conn, $users_id) {
    $sql = "SELECT * FROM profiles WHERE users_id = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../profile-information.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "i", $users_id);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        $result = false;
        return $result;
    }
    mysqli_stmt_close($stmt);
}

function updateProfileInformation($conn, $profileAbout, $profileTitle, $profileText, $users_id) {
    $sql = "UPDATE profiles SET profiles_about = ?, profiles_introduction_title = ?, profiles_introduction_text = ? WHERE users_id = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../profile-information.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "sssi", $profileAbout, $profileTitle, $profileText, $users_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function setProfileInformation($conn, $profileAbout, $profileTitle, $profileText, $users_id) {
    $sql = "INSERT INTO profiles (profiles_about, profiles_introduction_title, profiles_introduction_text, users_id) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../profile-information.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "sssi", $profileAbout, $profileTitle, $profileText, $users_id);
    if (!mysqli_stmt_execute($stmt)) {
        header("location: ../profile-information.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_close($stmt);
}

function defaultProfileInformation($conn, $users_username, $users_id) {
    $profileAbout = "Hello! I'm a new user on this platform and excited to explore and connect with others.";
    $profileTitle = "Welcome to " . $users_username . "'s profile!";
    $profileText = "I'm still setting up my profile, but please feel free to reach out and connect with me in the meantime.";
    setProfileInformation($conn, $profileAbout, $profileTitle, $profileText, $users_id);
}