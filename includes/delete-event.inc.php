<?php
require_once "db-connection.inc.php";
require_once "event-functions.inc.php";

if (isset($_POST['events_id'])) {
    $eventId = $_POST['events_id'];
    if (deleteEvent($conn, $eventId)) {
        header("Location: ../events-overview.php?delete=success");
        exit();
    } else {
        header("Location: ../events-overview.php?delete=error");
        exit();
    }
} else {
    header("Location: ../events-overview.php?delete=error");
    exit();
}