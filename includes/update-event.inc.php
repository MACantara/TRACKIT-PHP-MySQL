<?php

require_once 'event-functions.inc.php';
require_once 'error-handling-functions.inc.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update-event'])) {
    $eventsId = sanitizeInput($_POST['events_id']);
    $eventsName = sanitizeInput($_POST['events_name']);
    $eventsStartDate = sanitizeInput($_POST['events_start_date']);
    $eventsEndDate = sanitizeInput($_POST['events_end_date']);
    $eventsVenue = sanitizeInput($_POST['events_venue']);
    $eventsBudget = sanitizeInput($_POST['events_budget']);
    $eventsStatus = sanitizeInput($_POST['events_status']);
    $eventsDescription = sanitizeInput($_POST['events_description']);
    $eventsRemarks = sanitizeInput($_POST['events_remarks']);
    // For file uploads, you need to handle it separately
    // $eventsDocumentationPictures = $_FILES['events_documentation_pictures'];

    updateEvent($conn, $eventsId, $eventsName, $eventsStartDate, $eventsEndDate, $eventsVenue, $eventsBudget, $eventsStatus, $eventsDescription, $eventsRemarks);

    header("Location: ../events-overview.php?event-updated=success");
}