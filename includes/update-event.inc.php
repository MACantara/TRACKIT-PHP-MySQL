<?php

require_once 'event-functions.inc.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update-event'])) {
    $events_id = $_POST['events_id'];
    $events_name = $_POST['event_name'];
    $events_description = $_POST['event_description'];
    $events_date = $_POST['event_date'];
    $events_time = $_POST['event_time']; // Retrieve event time from form data
    $events_budget = $_POST['event_budget'];

    updateEvent($conn, $events_id, $events_name, $events_description, $events_date, $events_time, $events_budget); // Pass event time to updateEvent function

    header("Location: ../events-overview.php?event-updated=success");
}