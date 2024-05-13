<?php
require_once "../config.php";
require_once "error-handling-functions.inc.php";
require_once '../includes/forgot-password-functions.inc.php';

if (isset($_POST['reset-request-submit'])) {
    $userEmail = sanitizeInput($_POST["email"]);

    // Check if password reset request for the user already exists
    $sql = "SELECT * FROM password_reset 
            JOIN users ON password_reset.password_reset_users_id = users.users_id 
            WHERE users.users_email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $userEmail);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Password reset request for the user already exists
        header("Location: ../forgot-password.php?error=passwordresetrequestalreadyexists");
        exit();
    }

    if (passwordRequestEmptyInput($userEmail) || invalidEmail($userEmail)) {
        header("Location: ../forgot-password.php?error=emptyinput");
        exit();
    }

    handleRequest($conn, $userEmail);
    header("location: ../forgot-password.php?reset=success");
} else {
    header("Location: ../index.php");
    exit();
}