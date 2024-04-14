<?php

class SignUp extends DbConnection {

    protected function setUser($users_first_name, $users_last_name, $users_username, $users_email, $users_password) {
        $sql = "INSERT INTO users (users_first_name, users_last_name, users_username, users_email, users_password) VALUES (?, ?, ?, ?, ?);";
        $stmt = $this->connect()->prepare($sql);

        $hashedPassword = password_hash($users_password, PASSWORD_DEFAULT);

        if (!$stmt->execute(array($users_first_name, $users_last_name, $users_username, $users_email, $hashedPassword))) {
            $stmt = null;
            header("location: ../index.php?error=stmtfailed");
            exit();
        }
    
        $stmt = null;
    } 
    
    protected function checkUsername($users_username) {
        $sql = "SELECT users_username FROM users WHERE users_username = ?;";
        $stmt = $this->connect()->prepare($sql);

        if (!$stmt->execute(array($users_username))) {
            $stmt = null;
            header("location: ../index.php?error=stmtfailed");
            exit();
        }
    
        $resultCheck;
        if ($stmt->rowCount() > 0) {
            $resultCheck = false;
        }
        else {
            $resultCheck = true;
        }

        return $resultCheck;
    }

    protected function checkEmail($users_email) {
        $sql = "SELECT users_email FROM users WHERE users_email = ?;";
        $stmt = $this->connect()->prepare($sql);

        if (!$stmt->execute(array($users_email))) {
            $stmt = null;
            header("location: ../index.php?error=stmtfailed");
            exit();
        }
    
        $resultCheck;
        if ($stmt->rowCount() > 0) {
            $resultCheck = false;
        }
        else {
            $resultCheck = true;
        }

        return $resultCheck;
    }
}