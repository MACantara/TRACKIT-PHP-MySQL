<?php
require_once 'db-connection.inc.php'; // Include your database connection file

// Check if token and action are provided
if (isset($_GET['token']) && isset($_GET['action'])) {
    // Get token and action from URL
    $token = $_GET['token'];
    $action = $_GET['action'];  

    // Get event ID and email from database using the token
    $sql = "SELECT event_invitations_events_id, event_invitations_email, events_name FROM event_invitations INNER JOIN events ON event_invitations.event_invitations_events_id = events.events_id WHERE event_invitations_token = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $eventId = $row['event_invitations_events_id'];
        $email = $row['event_invitations_email'];

        // Check if email matches a user in the database
        $sql = "SELECT * FROM users JOIN department_users ON users.users_id = department_users.users_id WHERE users_email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // If action is 'accept', link user to event in the department_events table
            if ($action === 'accept') {
                $sql = "INSERT INTO department_events (events_id, departments_id) VALUES (?, (SELECT departments_id FROM department_users WHERE users_id = ?))";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ii", $eventId, $user['users_id']);
                $stmt->execute();
            }
        }

        // Delete token from database
        $sql = "DELETE FROM event_invitations WHERE event_invitations_token = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $token);
        $stmt->execute();
    }
}