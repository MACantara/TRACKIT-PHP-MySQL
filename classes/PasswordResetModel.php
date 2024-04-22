<?php
require_once "DbConnection.class.php";

class PasswordResetModel extends DbConnection {
    public function getPasswordReset($selector, $currentDate) {
        $sql = "SELECT * FROM passwordReset WHERE passwordResetSelector = ? AND passwordResetExpires >= ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$selector, $currentDate]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function deletePasswordReset($email) {
        $sql = "DELETE FROM passwordReset WHERE passwordResetEmail = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$email]);
    }
}