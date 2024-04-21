<?php
require_once "DbConnection.class.php";
class PasswordReset extends DbConnection {
    public function resetPassword($selector, $validator, $password, $passwordRepeat) {
        if (empty($password) || empty($passwordRepeat)) {
            return ['status' => 'error', 'message' => 'emptyfields'];
        } else if ($password != $passwordRepeat) {
            return ['status' => 'error', 'message' => 'passwordsdontmatch'];
        }

        $currentDate = date("U");

        $sql = "SELECT * FROM passwordReset WHERE passwordResetSelector = ? AND passwordResetExpires >= ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$selector, $currentDate]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$result) {
            return ['status' => 'error', 'message' => 'resubmit'];
        } else {
            $tokenBin = hex2bin($validator);
            $tokenCheck = password_verify($tokenBin, $result["passwordResetToken"]);

            if ($tokenCheck === false) {
                return ['status' => 'error', 'message' => 'resubmit'];
            } else if ($tokenCheck === true) {
                $tokenEmail = $result["passwordResetEmail"];

                $sql = "SELECT * FROM users WHERE users_email = ?";
                $stmt = $this->connect()->prepare($sql);
                $stmt->execute([$tokenEmail]);

                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                if (!$result) {
                    return ['status' => 'error', 'message' => 'error'];
                } else {
                    $sql = "UPDATE users SET users_password = ? WHERE users_email = ?";
                    $stmt = $this->connect()->prepare($sql);
                    $newPwdHash = password_hash($password, PASSWORD_DEFAULT);
                    $stmt->execute([$newPwdHash, $tokenEmail]);

                    $sql = "DELETE FROM passwordReset WHERE passwordResetEmail = ?";
                    $stmt = $this->connect()->prepare($sql);
                    $stmt->execute([$tokenEmail]);

                    return ['status' => 'success'];
                }
            }
        }
    }
}