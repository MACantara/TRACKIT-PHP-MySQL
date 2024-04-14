<?php


if (isset($_POST["submit"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    require_once 'db-connection.include.php';
    require_once 'functions.include.php';

    loginUser($conn, $username, $password);
} else {
    header("location: ../templates/login.php");
    exit();
}