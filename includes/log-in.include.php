<?php

if (isset($_POST['log-in'])) {
    // Grabbing the data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Instantiate the LogInController class
    include "../classes/db-connection.class.php";
    include "../classes/log-in.class.php";
    include "../classes/log-in-controller.class.php";
    $logIn = new LogInController($username, $password);


    // Error handling
    $logIn->logInUser();

    // Going back to front page
    header("location: index.php");

}