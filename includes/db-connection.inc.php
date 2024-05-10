<?php

$serverName = "mysql-trackit.alwaysdata.net";
$dBUserName = "trackit";
$dBPassword = "Gloomily23Map15Landmass33Exonerate51Coagulant4";
$dBName = "trackit_trackit-database";

$conn = mysqli_connect($serverName, $dBUserName, $dBPassword, $dBName);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}