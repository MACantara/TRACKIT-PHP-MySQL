<?php

require_once 'event-functions.inc.php';

if (isset($_POST['update-event'])) {
    $events_id = $_POST['events_id'];
    $events_name = $_POST['event_name'];
    $events_description = $_POST['event_description'];
    $events_date = $_POST['event_date'];
    $events_budget = $_POST['event_budget'];

    updateEvent($conn, $events_id, $events_name, $events_description, $events_date, $events_budget);

    header("Location: ../events-overview.php?event-updated=success");
}