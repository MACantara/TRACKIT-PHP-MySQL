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

function getEventName($conn, $eventId) {
    $sql = "SELECT events_name FROM events WHERE events_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $eventId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    return $row['events_name'];
}

function getTransactions($conn, $eventId) {
    $sql = "SELECT * FROM transaction_history WHERE events_id = ? ORDER BY transaction_date DESC";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $eventId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function getUserEvents($conn, $userId) {
    $sql = "SELECT events.events_id, events.events_name, events.events_description, events.events_date, events.events_budget FROM events JOIN event_users ON events.events_id = event_users.events_id WHERE event_users.users_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function getCategories($conn, $eventId) {
    $sql = "SELECT transaction_category FROM transaction_history WHERE events_id = ? GROUP BY transaction_category;"; // adjust the table and column names as needed
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../index.php?error=sqlerror");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "i", $eventId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
}

function getEventExpenses($conn, $eventId) {
    $sql = "SELECT SUM(transaction_total) AS total_expenses FROM transaction_history WHERE events_id = ? AND transaction_type = 'expense'";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $eventId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    return $row['total_expenses'];
}

function getEventIncome($conn, $eventId) {
    $sql = "SELECT SUM(transaction_total) AS total_income FROM transaction_history WHERE events_id = ? AND transaction_type = 'income'";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $eventId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    return $row['total_income'];
}

function getEventRemainingBudget($conn, $eventId) {
    $expenses = getEventExpenses($conn, $eventId);
    $income = getEventIncome($conn, $eventId);
    $remainingBudget = $income - $expenses;
    return $remainingBudget;
}