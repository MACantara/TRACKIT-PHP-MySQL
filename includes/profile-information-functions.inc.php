<?php

require_once "db-connection.inc.php";

function getUserInformation($conn, $users_id) {
    $sql = "SELECT users_first_name, users_last_name, users_username, users_email, users_email_verified FROM users WHERE users_id = ?;";
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

function getUserIdInformationById($conn, $users_id) {
    $sql = "SELECT * FROM users WHERE users_id = ? LIMIT 1";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../log-in.php?error=stmtfailed");
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

function getUserInformationByEmail($conn, $email) {
    $sql = "SELECT * FROM users WHERE users_email = ? LIMIT 1";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../log-in.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $email);
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

function getProfileInformation($conn, $users_id) {
    $sql = "SELECT * FROM profiles WHERE users_id = ?;";
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

function updateUserInformation($conn, $firstName, $lastName, $username, $users_id) {
    $sql = "UPDATE users SET users_first_name = ?, users_last_name = ?, users_username = ? WHERE users_id = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../profile-information.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sssi", $firstName, $lastName, $username, $users_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function updateUserEmail($conn, $email, $users_id) {
    $sql = "UPDATE users SET users_email = ? WHERE users_id = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../profile-information.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "si", $email, $users_id);
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