<?php

if (isset($_POST["submit"])) {
    $username = $_POST["uid"];
    $password = $_POST["pwd"];

    require_once 'db-connection.include.php';
    require_once 'functions.include.php';

    loginUser($conn, $username, $password);
} else {
    header("location: ../login.php");
    exit();
}