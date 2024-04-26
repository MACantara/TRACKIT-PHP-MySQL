<?php
// Include PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'db-connection.inc.php';
require_once "../PHPMailer/src/Exception.php";
require_once "../PHPMailer/src/PHPMailer.php";
require_once "../PHPMailer/src/SMTP.php";
require_once "../config.php";

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get email from form
    $email = $_POST['email'];

    // Generate unique token
    $token = bin2hex(random_bytes(32));

    // Get event ID from form
    $eventId = $_POST['events_id'];

    $url = BASE_URL . "accept-invitation.php?token=$token";

    // Save token, event ID, and email in database
    $sql = "INSERT INTO event_invitations (event_invitations_event_id, event_invitations_email, event_invitations_token) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $eventId, $email, $token);
    $stmt->execute();

    // Create PHPMailer instance and configure SMTP settings
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = "ssl";
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 465;
    $mail->isHTML();
    $mail->Username = "welptest12@gmail.com";
    $mail->Password = "faix wvbv fauy qodg";
    $mail->SetFrom("no-reply@trackit.com");
    $mail->Subject = "Event Management Invitation";
    $mail->Body = "
    <html>
    <head>
        <title>Event Management Invitation</title>
    </head>
    <body>
        <h1>Hi there, </h1>
        <p>You have been invited to manage an event. Click the link to accept the invitation: " . $url . "</p>
    </body>
    </html>";
    $mail->AddAddress($email);

    $mail->Send();

    header("location: ../invite-user.php?events_id=" . $eventId . "?error=none");
}