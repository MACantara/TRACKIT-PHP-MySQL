<?php


if (isset($_POST["submit"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    require_once 'db-connection.inc.php';
    require_once 'functions.inc.php';

    if (logInEmptyInput($username, $password) !== false) {
        header("location: ../login.php?error=emptyinput");
    }

    loginUser($conn, $username, $password);
} else {
    header("location: ../login.php");
    exit();
}