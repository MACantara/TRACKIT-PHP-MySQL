<?php
require_once 'db-connection.inc.php';

function createEvent($conn, $userId, $eventName, $eventDescription, $eventDate, $eventBudget) {
    $sql = "INSERT INTO events (events_name, events_description, events_date, events_budget) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssss", $eventName, $eventDescription, $eventDate, $eventBudget);
    mysqli_stmt_execute($stmt);
    $eventId = mysqli_insert_id($conn);

    $sql = "INSERT INTO event_users (users_id, events_id) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $userId, $eventId);
    mysqli_stmt_execute($stmt);
}