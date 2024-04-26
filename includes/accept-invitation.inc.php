<?php
require_once 'db-connection.inc.php'; // Include your database connection file

// Check if token is provided
if (isset($_GET['token'])) {
    // Get token from URL
    $token = $_GET['token'];

    // Get event ID and email from database using the token
    $sql = "SELECT event_invitations_event_id, event_invitations_email, events_name FROM event_invitations INNER JOIN events ON event_invitations.event_invitations_event_id = events.events_id WHERE event_invitations_token = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $eventId = $row['event_invitations_event_id'];
        $email = $row['event_invitations_email'];

        // Check if email matches a user in the database
        $sql = "SELECT * FROM users WHERE users_email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Link user to event in the event_users table
            $sql = "INSERT INTO event_users (events_id, users_id) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $eventId, $user['users_id']);
            $stmt->execute();
        }

        // Delete token from database
        $sql = "DELETE FROM event_invitations WHERE event_invitations_token = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $token);
        $stmt->execute();
    }
}