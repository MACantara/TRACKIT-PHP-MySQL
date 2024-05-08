<?php

$serverName = "localhost";
$dBUserName = "mikmikk03_trackit";
$dBPassword = "Hate64Obstacle51Outreach52Obscure31Spoof7";
$dBName = "mikmikk03_trackit";

$conn = mysqli_connect($serverName, $dBUserName, $dBPassword, $dBName);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}