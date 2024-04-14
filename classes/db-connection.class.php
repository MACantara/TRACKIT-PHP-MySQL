<?php

class DbConnection {
    protected function connect() {
        try {
            $dBUserName = "355327_testuser";
            $dBPassword = "Crusher15Humble52Finicky80Footnote68Crimson4";

            $conn = new PDO("mysql:host=mysql-mysql-database.alwaysdata.net;dbname=mysql-database_trackit", $dBUserName, $dBPassword);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }
}