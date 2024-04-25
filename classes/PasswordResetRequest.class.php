<?php
include "../classes/DbConnection.class.php";
class PasswordResetRequest extends DbConnection {
    public function deleteExistingResetRequest($userEmail) {
        $sql = "DELETE FROM password_reset WHERE password_reset_email = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$userEmail]);
    }

    public function createNewResetRequest($userEmail, $selector, $hashedToken, $expires) {
        $sql = "INSERT INTO password_reset (password_reset_email, password_reset_selector, password_reset_token, password_reset_expires) VALUES (?, ?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$userEmail, $selector, $hashedToken, $expires]);
    }
}
