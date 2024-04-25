<?php
require_once "UserModel.php";
require_once "PasswordResetModel.php";

class PasswordResetController {
    private $userModel;
    private $passwordResetModel;

    public function __construct() {
        $this->userModel = new UserModel();
        $this->passwordResetModel = new PasswordResetModel();
    }

    public function resetPassword($selector, $validator, $password, $passwordRepeat) {
        if (empty($password) || empty($passwordRepeat)) {
            return ['status' => 'error', 'message' => 'emptyfields'];
        } else if ($password != $passwordRepeat) {
            return ['status' => 'error', 'message' => 'passwordsdontmatch'];
        }

        $currentDate = date("U");

        $passwordReset = $this->passwordResetModel->getPasswordReset($selector, $currentDate);
        if (!$passwordReset) {
            return ['status' => 'error', 'message' => 'resubmit'];
        } else {
            $tokenBin = hex2bin($validator);
            $tokenCheck = password_verify($tokenBin, $passwordReset["password_reset_token"]);

            if ($tokenCheck === false) {
                return ['status' => 'error', 'message' => 'resubmit'];
            } else if ($tokenCheck === true) {
                $tokenEmail = $passwordReset["password_reset_email"];

                $user = $this->userModel->getUserByEmail($tokenEmail);
                if (!$user) {
                    return ['status' => 'error', 'message' => 'error'];
                } else {
                    $this->userModel->updateUserPassword($password, $tokenEmail);
                    $this->passwordResetModel->deletePasswordReset($tokenEmail);

                    return ['status' => 'success'];
                }
            }
        }
    }
}