<?php

if (isset($_POST["submit"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    require_once 'db-connection.inc.php';
    require_once "error-handling-functions.inc.php";
    require_once "user-functions.inc.php";

    if (logInEmptyInput($username, $password) !== false) {
        header("location: ../login.php?error=emptyinput");
        exit();
    }

    $user = loginUser($conn, $username, $password);

    if ($user === false) {
        header("location: ../login.php?error=wronglogin");
        exit();
    }
    
    header("location: ../events-overview.php?error=none");
    exit();
} else {
    header("location: ../login.php");
    exit();
}