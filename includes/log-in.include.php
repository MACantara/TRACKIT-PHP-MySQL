<?php


if (isset($_POST["log-in"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    require_once 'db-connection.include.php';
    require_once 'functions.include.php';

    loginUser($conn, $username, $password);
} else {
    header("location: ../templates/log-in.php");
    exit();
}