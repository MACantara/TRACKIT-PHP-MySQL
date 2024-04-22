<?php

require_once 'PasswordResetRequestView.class.php';
require_once 'PasswordResetRequest.class.php';
class PasswordResetRequestController extends PasswordResetRequest {
    public function handleRequest($userEmail) {
        $passwordResetRequest = new PasswordResetRequest();

        $passwordResetRequest->deleteExistingResetRequest($userEmail);

        $selector = bin2hex(random_bytes(8));
        $token = random_bytes(32);
        $url = "localhost/TRACKIT-PHP-MySQL/create-new-password.php?selector=" . $selector . "&validator=" . bin2hex($token);
        $expires = date("U") + 1800;
        $hashedToken = password_hash($token, PASSWORD_DEFAULT);

        $passwordResetRequest->createNewResetRequest($userEmail, $selector, $hashedToken, $expires);

        $passwordResetRequestView = new PasswordResetRequestView();
        $passwordResetRequestView->sendResetEmail($userEmail, $url);
    }
}
