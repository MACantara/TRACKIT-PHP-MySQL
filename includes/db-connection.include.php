<?php

$serverName = "mysql-mysql-database.alwaysdata.net";
$dBUserName = "355327_testuser";
$dBPassword = "Crusher15Humble52Finicky80Footnote68Crimson4";
$dBName = "mysql-database_trackit";

$conn = mysqli_connect($serverName, $dBUserName, $dBPassword, $dBName);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}