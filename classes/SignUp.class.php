<?php

class SignUp extends DbConnection
{

    /**
     * Sets a new user in the database with the given information.
     *
     * @param string $users_first_name The first name of the user.
     * @param string $users_last_name The last name of the user.
     * @param string $users_username The username of the user.
     * @param string $users_email The email of the user.
     * @param string $users_password The password of the user.
     * @throws Exception If the database query fails.
     * @return void
     */
    protected function setUser($users_first_name, $users_last_name, $users_username, $users_email, $users_password)
    {
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

    /**
     * Checks if the provided username exists in the database.
     *
     * @param string $users_username The username to be checked.
     * @throws None
     * @return bool Returns true if the username does not exist, false otherwise.
     */
    protected function checkUsername($users_username)
    {
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
        } else {
            $resultCheck = true;
        }

        return $resultCheck;
    }

    /**
     * Checks if the given email is already registered in the database.
     *
     * @param string $users_email The email to be checked.
     * @throws None
     * @return bool Returns true if the email is not registered, false otherwise.
     */
    protected function checkEmail($users_email)
    {
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
        } else {
            $resultCheck = true;
        }

        return $resultCheck;
    }

    protected function getUserId($users_username) {
        $sql = "SELECT users_id FROM users WHERE users_username = ?;";
        $stmt = $this->connect()->prepare($sql);
        if (!$stmt->execute(array($users_username))) {
            $stmt = null;
            header("location: ../profile-information.php?error=stmtfailed");
            exit();
        }
        if ($stmt->rowCount() == 0) {
            $stmt = null;
            header("location: ../profile-information.php?error=profilenotfound");
            exit();
        }
        $profileData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $profileData;
    }
}