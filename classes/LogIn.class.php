<?php

class LogIn extends DbConnection {

    /**
     * Retrieves user information from the database based on the provided username and password.
     *
     * @param string $username The username or email of the user for authentication
     * @param string $password The password for user authentication
     * @throws None
     * @return void
     */
    protected function getUser($username, $password) {
        $sql = "SELECT * FROM users WHERE users_username = ? OR users_email = ?;";
        
        $stmt = $this->connect()->prepare($sql);

        if (!$stmt->execute(array($username, $username))) {
            $stmt = null;
            header("location: ../log-in.php?error=stmtfailed");
            exit();
        }

        if ($stmt->rowCount() == 0) {
            $stmt = null;
            header("location: ../log-in.php?error=wronglogin");
            exit();
        }

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $checkPassword = password_verify($password, $user["users_password"]);

        if ($checkPassword == false) {
            $stmt = null;
            header("location: ../log-in.php?error=wronglogin");
            exit();
        } elseif ($checkPassword == true) {
            session_start();
            $keys = ["users_id", "users_first_name", "users_last_name", "users_username", "users_email"];

            foreach ($keys as $key) {
                if (isset($user[0][$key])) {
                    $_SESSION[$key] = $user[0][$key];
                }
                if (isset($user[$key])) {
                    $_SESSION[$key] = $user[$key];
                }
            }
            header("location: ../index.php?error=none");

            $stmt = null;
        }
    
        $stmt = null;
    } 
}