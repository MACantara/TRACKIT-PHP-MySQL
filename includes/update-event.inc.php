<?php

require_once 'event-functions.inc.php';
require_once 'error-handling-functions.inc.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update-event'])) {
    $eventsId = sanitizeInput($_POST['events_id']);
    $eventsName = sanitizeInput($_POST['events_name']);
    $eventsSemester = sanitizeInput($_POST['events_semester']);
    $eventsAcademicYear = sanitizeInput($_POST['events_academic_year'] == 'other' ? $_POST['other_academic_year'] : $_POST['events_academic_year']);
    $eventsStartDate = sanitizeInput($_POST['events_start_date']);
    $eventsEndDate = sanitizeInput($_POST['events_end_date']);
    $eventsVenue = sanitizeInput($_POST['events_venue']);
    $eventsBudget = sanitizeInput($_POST['events_budget']);
    $eventsStatus = sanitizeInput($_POST['events_status']);
    $eventsDescription = sanitizeInput($_POST['events_description']);
    $eventsRemarks = sanitizeInput($_POST['events_remarks']);

    // Loop through each array of inputs and sanitize them
    $eventsObjectives = array_map('sanitizeInput', $_POST['events_objectives'] ?? []);
    $eventsProblemsEncountered = array_map('sanitizeInput', $_POST['events_problems_encountered'] ?? []);
    $eventsActionsTaken = array_map('sanitizeInput', $_POST['events_actions_taken'] ?? []);
    $eventsRecommendations = array_map('sanitizeInput', $_POST['events_recommendations'] ?? []);

    $updates = [
        'objectives' => $eventsObjectives,
        'problems_encountered' => $eventsProblemsEncountered,
        'actions_taken' => $eventsActionsTaken,
        'recommendations' => $eventsRecommendations
    ];

    foreach ($updates as $table => $records) {
        foreach ($records as $id => $value) {
            // If the value is empty, set it to NULL
            if (empty($value)) {
                $value = NULL;
            }
            updateOrInsertRecord($conn, $table, $id, $value, $eventsId);
        }
    }

    // Process the uploaded files
    if (isset($_FILES['events_documentation_pictures'])) {
        require_once 'event.inc.php';

        $pictures = $_FILES['events_documentation_pictures'];

        // Restructure the $_FILES array
        $fileCount = count($pictures['name']);
        $fileKeys = array_keys($pictures);

        $picturesArray = [];

        for ($i = 0; $i < $fileCount; $i++) {
            foreach ($fileKeys as $key) {
                $picturesArray[$i][$key] = $pictures[$key][$i];
            }
        }

        // Define the upload directory
        $uploadDir = 'C:/xampp/htdocs/TRACKIT-PHP-MySQL/static/img/';

        // Check if the upload directory exists, if not, create it
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        foreach ($picturesArray as $picture) {
            // Check for upload errors
            if ($picture['error'] !== UPLOAD_ERR_OK) {
                // Handle error
                continue;
            }

            // Generate a unique name for the file
            $pictureName = uniqid() . '-' . basename($picture['name']);
            $picturePath = $uploadDir . $pictureName;

            // Move the file to the upload directory
            if (!move_uploaded_file($picture['tmp_name'], $picturePath)) {
                // Handle error
                continue;
            }

            // Update the database with the file path
            updateEventDocumentationPictures($conn, $eventsId, $picturePath);
        }
    }

    updateEvent($conn, $eventsId, $eventsSemester, $eventsAcademicYear, $eventsName, $eventsStartDate, $eventsEndDate, $eventsVenue, $eventsBudget, $eventsStatus, $eventsDescription, $eventsRemarks);

    header("Location: ../events-overview.php?event-updated=success");
}