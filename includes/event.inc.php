<?php
require_once 'db-connection.inc.php';
require_once 'error-handling-functions.inc.php';
require_once "user-functions.inc.php";


function createEvent($conn, $usersId, $eventName, $eventStartDate, $eventEndDate, $eventVenue, $eventBudget, $eventStatus, $eventDescription, $eventRemarks)
{
    // if (eventEmptyInput($eventName, $eventStartDate, $eventEndDate, $eventVenue, $eventBudget, $eventStatus, $eventDescription, $eventRemarks) !== false) {
    //     header("location: create-event.php?error=emptyinput");
    //     exit();
    // }

    if (eventNameExists($conn, $eventName) !== false) {
        header("location: create-event.php?error=eventnametaken");
        exit();
    }

    if (tooLongEventName($eventName) !== false) {
        header("location: create-event.php?error=toolongeventname");
        exit();
    }

    // if (invalidEventDate($eventStartDate, $eventEndDate) !== false) {
    //     header("location: create-event.php?error=invalideventdate");
    //     exit();
    // }

    if (invalidEventBudget($eventBudget) !== false) {
        header("location: create-event.php?error=invalideventbudget");
        exit();
    }

    $sql = "INSERT INTO events (events_name, events_start_date, events_end_date, events_venue, events_budget, events_status, events_description, events_remarks) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssssss", $eventName, $eventStartDate, $eventEndDate, $eventVenue, $eventBudget, $eventStatus, $eventDescription, $eventRemarks);
    mysqli_stmt_execute($stmt);
    $eventsId = mysqli_insert_id($conn);

    // Fetch the departments_id associated with the usersId
    $departmentsId = getDepartmentsIdByUsersId($conn, $usersId);

    // Check if the departments_id exists in the departments table
    $sql = "SELECT * FROM departments WHERE departments_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $departmentsId);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($resultData) === 0) {
        header("location: create-event.php?error=invaliddepartmentsid");
        exit();
    }

    $sql = "INSERT INTO department_events (departments_id, events_id) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $departmentsId, $eventsId);
    mysqli_stmt_execute($stmt);

    return $eventsId;
}

function createObjective($conn, $eventId, $objective)
{
    $sql = "INSERT INTO objectives (objectives_name) VALUES (?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $objective);
    mysqli_stmt_execute($stmt);
    $objectivesId = mysqli_insert_id($conn);

    $sql = "INSERT INTO event_objectives (events_id, objectives_id) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $eventId, $objectivesId);
    mysqli_stmt_execute($stmt);
}

function createProblem($conn, $eventId, $problem)
{
    $sql = "INSERT INTO problems_encountered (problems_encountered_name) VALUES (?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $problem);
    mysqli_stmt_execute($stmt);
    $problemsEncounteredId = mysqli_insert_id($conn);

    $sql = "INSERT INTO event_problems_encountered (events_id, problems_encountered_id) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $eventId, $problemsEncounteredId);
    mysqli_stmt_execute($stmt);
}

function createAction($conn, $eventId, $action)
{
    $sql = "INSERT INTO actions_taken (actions_taken_name) VALUES (?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $action);
    mysqli_stmt_execute($stmt);
    $actionsTakenId = mysqli_insert_id($conn);

    $sql = "INSERT INTO event_actions_taken (events_id, actions_taken_id) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $eventId, $actionsTakenId);
    mysqli_stmt_execute($stmt);
}

function createRecommendation($conn, $eventId, $recommendation)
{
    $sql = "INSERT INTO recommendations (recommendations_name) VALUES (?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $recommendation);
    mysqli_stmt_execute($stmt);
    $recommendationsId = mysqli_insert_id($conn);

    $sql = "INSERT INTO event_recommendations (events_id, recommendations_id) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $eventId, $recommendationsId);
    mysqli_stmt_execute($stmt);
}

function storeEventDocumentationPicture($conn, $eventId, $pictures) {
    // Define the upload directory
    $uploadDir = 'C:/xampp/htdocs/TRACKIT-PHP-MySQL/static/img/';

    foreach ($pictures as $picture) {
        // Check for upload errors
        if ($picture['error'] !== UPLOAD_ERR_OK) {
            // Handle error
            return;
        }

        // Generate a unique name for the file
        $pictureName = uniqid() . '-' . basename($picture['name']);
        $picturePath = $uploadDir . $pictureName;

        // Move the file to the upload directory
        if (!move_uploaded_file($picture['tmp_name'], $picturePath)) {
            // Handle error
            return;
        }

        // Insert into the documentation_pictures table
        $sql = "INSERT INTO documentation_pictures (documentation_pictures_item) VALUES (?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 's', $picturePath);
        mysqli_stmt_execute($stmt);

        // Get the ID of the inserted picture
        $pictureId = mysqli_insert_id($conn);

        // Insert into the event_documentation_pictures table
        $sql = "INSERT INTO event_documentation_pictures (events_id, documentation_pictures_id) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'ii', $eventId, $pictureId);
        mysqli_stmt_execute($stmt);
    }
}