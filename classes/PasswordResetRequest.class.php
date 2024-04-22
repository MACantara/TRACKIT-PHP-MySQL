<?php
require_once "DbConnection.class.php";
class PasswordResetRequest extends DbConnection {
    public function deleteExistingResetRequest($userEmail) {
        $sql = "DELETE FROM passwordReset WHERE passwordResetEmail = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$userEmail]);
    }

    public function createNewResetRequest($userEmail, $selector, $hashedToken, $expires) {
        $sql = "INSERT INTO passwordReset (passwordResetEmail, passwordResetSelector, passwordResetToken, passwordResetExpires) VALUES (?, ?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$userEmail, $selector, $hashedToken, $expires]);
    }
}
