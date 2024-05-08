<?php

require_once 'event-functions.inc.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update-event'])) {
    $eventsId = $_POST['events_id'];
    $eventsName = $_POST['event_name'];
    $eventsDescription = $_POST['event_description'];
    $eventsDate = $_POST['event_date'];
    $eventsTime = $_POST['event_time']; // Retrieve event time from form data
    $eventsBudget = $_POST['event_budget'];

    updateEvent($conn, $eventsId, $eventsName, $eventsDescription, $eventsDate, $eventsTime, $eventsBudget); // Pass event time to updateEvent function

    header("Location: ../events-overview.php?event-updated=success");
}