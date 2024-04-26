<?php
require_once 'db-connection.inc.php';
require_once 'error-handling-functions.inc.php';


function createEvent($conn, $userId, $eventName, $eventDescription, $eventDate, $eventTime, $eventBudget) {
    if (eventEmptyInput($eventName, $eventDescription, $eventDate, $eventTime, $eventBudget) !== false) {
        header("location: create-event.php?error=emptyinput");
        exit();
    }

    if (eventNameExists($conn, $eventName) !== false) {
        header("location: create-event.php?error=eventnametaken");
        exit();
    }

    if (tooLongEventName($eventName) !== false) {
        header("location: create-event.php?error=toolongeventname");
        exit();
    }

    if (invalidEventDate($eventDate) !== false) {
        header("location: create-event.php?error=invalideventdate");
        exit();
    }

    if (invalidEventTime($eventTime) !== false) {
        header("location: create-event.php?error=invalideventtime");
        exit();
    }

    if (invalidEventBudget($eventBudget) !== false) {
        header("location: create-event.php?error=invalideventbudget");
        exit();
    }

    $eventDateTime = $eventDate . 'T' . $eventTime . ':00';
    $sql = "INSERT INTO events (events_name, events_description, events_date, events_budget) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssss", $eventName, $eventDescription, $eventDateTime, $eventBudget);
    mysqli_stmt_execute($stmt);
    $eventId = mysqli_insert_id($conn);

    $sql = "INSERT INTO event_users (users_id, events_id) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $userId, $eventId);
    mysqli_stmt_execute($stmt);
}