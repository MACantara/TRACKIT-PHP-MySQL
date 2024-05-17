<?php
require_once 'db-connection.inc.php';
require_once 'error-handling-functions.inc.php';
require_once "user-functions.inc.php";


function createEvent($conn, $usersId, $eventName, $eventStatus, $eventDescription, $eventDate, $eventTime,  $eventBudget)
{
    if (eventEmptyInput($eventName, $eventStatus, $eventDescription, $eventDate, $eventTime,  $eventBudget) !== false) {
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
    $sql = "INSERT INTO events (events_name, events_status, events_description, events_date, events_budget) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssss", $eventName, $eventStatus, $eventDescription, $eventDateTime, $eventBudget);
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
}