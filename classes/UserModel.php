<?php
require_once "DbConnection.class.php";

class UserModel extends DbConnection {
    public function getUserByEmail($email) {
        $sql = "SELECT * FROM users WHERE users_email = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateUserPassword($password, $email) {
        $sql = "UPDATE users SET users_password = ? WHERE users_email = ?";
        $stmt = $this->connect()->prepare($sql);
        $newPwdHash = password_hash($password, PASSWORD_DEFAULT);
        $stmt->execute([$newPwdHash, $email]);
    }
}