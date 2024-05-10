<?php
session_start();
require_once 'includes/db-connection.inc.php';

$message = '';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Get the record from the database that matches this token
    $sql = "SELECT * FROM email_verification WHERE email_verification_token = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    $record = $result->fetch_assoc();

    if ($record) {
        // Update the user's email and set the email verification status to true
        $sql = "UPDATE users SET users_email = ?, users_email_verified = 1 WHERE users_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $record['email_verification_new_email'], $record['email_verification_users_id']);
        $stmt->execute();

        // Delete the record from the email_verification table
        $sql = "DELETE FROM email_verification WHERE email_verification_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $record['email_verification_id']);
        $stmt->execute();

        $message = "Your email has been verified successfully!";
    } else {
        $message = "Invalid verification token!";
    }
} else {
    $message = "No verification token provided!";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "templates/meta-tags.tpl.php"; ?>
    <title>Home</title>
    <?php include "templates/external-links.tpl.php"; ?>
</head>

<body>
    <?php include 'templates/header.tpl.php'; ?>
    <main>
        <section class="section-container">
            <p><?php echo $message; ?></p>
        </section>
    </main>
    <?php include 'templates/footer.tpl.php'; ?>
</body>

</html>