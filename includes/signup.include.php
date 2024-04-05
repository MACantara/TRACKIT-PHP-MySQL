<?php

if (isset($_POST['submit'])) {
    $username = $_POST['uid'];
    $pwd = $_POST['pwd'];
    $pwdRepeat = $_POST['pwdrepeat'];

    require_once 'db-connection.include.php';
    require_once 'functions.include.php';

    if (invalidUid($username) !== false) {
        header("location: ../signup.php?error=invaliduid");
        exit();
    }

    if (pwdMatch($pwd, $pwdRepeat) !== false) {
        header("location: ../signup.php?error=passwordsdontmatch");
        exit();
    }

    if (uidExists($conn, $username) !== false) {
        header("location: ../signup.php?error=usernametaken");
        exit();
    }

    createUser($conn, $username, $pwd);

} else {
    header("location: ../signup.php");
    exit();
}