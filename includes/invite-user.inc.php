<?php
// Include PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'db-connection.inc.php';
require_once "../PHPMailer/src/Exception.php";
require_once "../PHPMailer/src/PHPMailer.php";
require_once "../PHPMailer/src/SMTP.php";
require_once "../config.php";
require_once "error-handling-functions.inc.php";
$eventId = $_POST['events_id'];

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get email from form
    $email = $_POST['email'];

    // Get user ID connected to the email
    $sql = "SELECT users_id FROM users WHERE users_email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $userId = $user['users_id'];

    // Generate unique token
    $token = bin2hex(random_bytes(32));

    // Get event ID from form
    $eventId = $_POST['events_id'];

    $url = BASE_URL . "accept-invitation.php?token=$token";

    // Check if user ID and event ID already exist as a pair in the event_users table of the database
    $sql = "SELECT * FROM event_users WHERE events_id = ? AND users_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $eventId, $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User ID and event ID already exist as a pair in the event_users table of the database
        // Redirect to the invite-user page with an error message
        header("location: ../invite-user.php?events_id=" . $eventId . "&error=userexistasmanager");
        exit();
    }

    // Check if event ID and email already exist as a pair in the database
    $sql = "SELECT * FROM event_invitations WHERE event_invitations_event_id = ? AND event_invitations_email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $eventId, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Event ID and email already exist as a pair in the database
        // Redirect to the invite-user page with an error message
        header("location: ../invite-user.php?events_id=" . $eventId . "&error=userinviteexists");
        exit();
    }

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

    header("location: ../invite-user.php?events_id=" . $eventId . "&error=none");
}