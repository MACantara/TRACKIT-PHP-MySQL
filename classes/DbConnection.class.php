<?php

class DbConnection {
    /**
     * Connects to the database using the provided credentials.
     *
     * @throws PDOException if there is an error connecting to the database
     * @return PDO the database connection object
     */
    protected function connect() {
        try {
            $dBUserName = "root";
            $dBPassword = "Rockslide43Silent95Poncho11Sabotage82Catalog5";

            $conn = new PDO("mysql:host=localhost;dbname=trackit", $dBUserName, $dBPassword);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }
}