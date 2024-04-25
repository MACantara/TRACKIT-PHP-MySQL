<?php

$serverName = "localhost";
$dBUserName = "root";
$dBPassword = "Rockslide43Silent95Poncho11Sabotage82Catalog5";
$dBName = "trackit";

$conn = mysqli_connect($serverName, $dBUserName, $dBPassword, $dBName);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}