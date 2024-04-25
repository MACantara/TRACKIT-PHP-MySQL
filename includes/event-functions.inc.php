<?php
require_once 'event.inc.php';

function handleCreateEvent($conn) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $userId = $_SESSION["users_id"];
        $eventName = $_POST["event_name"];
        $eventDescription = $_POST["event_description"];
        $eventDate = $_POST["event_date"];
        $eventBudget = $_POST["event_budget"];

        createEvent($conn, $userId, $eventName, $eventDescription, $eventDate, $eventBudget);

        header("Location: events-overview.php");
        exit();
    }
}

function getEvent($conn, $eventId) {
    $sql = "SELECT * FROM events WHERE events_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $eventId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

function getTransactions($conn, $eventId) {
    $sql = "SELECT * FROM transaction_history WHERE events_id = ? ORDER BY transaction_date DESC";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $eventId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}