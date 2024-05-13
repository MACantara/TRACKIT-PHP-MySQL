<?php

require_once 'event-functions.inc.php';
require_once 'error-handling-functions.inc.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update-event'])) {
    $eventsId = sanitizeInput($_POST['events_id']);
    $eventsName = sanitizeInput($_POST['event_name']);
    $eventsDescription = sanitizeInput($_POST['event_description']);
    $eventsDate = sanitizeInput($_POST['event_date']);
    $eventsTime = sanitizeInput($_POST['event_time']); // Retrieve event time from form data
    $eventsBudget = sanitizeInput($_POST['event_budget']);

    updateEvent($conn, $eventsId, $eventsName, $eventsDescription, $eventsDate, $eventsTime, $eventsBudget); // Pass event time to updateEvent function

    header("Location: ../events-overview.php?event-updated=success");
}