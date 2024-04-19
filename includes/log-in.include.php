<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Grabbing the data
    $username = htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8');
    $password = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');

    // Instantiate the LogInController class
    include "../classes/db-connection.class.php";
    include "../classes/log-in.class.php";
    include "../classes/log-in-controller.class.php";
    $logIn = new LogInController($username, $password);

    // Error handling
    $logIn->logInUser();

    // Going back to front page
    header("location: ../index.php");

}