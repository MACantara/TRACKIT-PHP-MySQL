<?php
require_once "DbConnection.class.php";

class PasswordResetModel extends DbConnection {
    public function getPasswordReset($selector, $currentDate) {
        $sql = "SELECT * FROM password_reset WHERE password_reset_selector = ? AND password_reset_expires >= ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$selector, $currentDate]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function deletePasswordReset($email) {
        $sql = "DELETE FROM password_reset WHERE password_reset_email = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$email]);
    }
}