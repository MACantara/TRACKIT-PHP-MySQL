<?php
require_once 'db-connection.inc.php';
require_once "error-handling-functions.inc.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $eventsId = sanitizeInput($_POST['events_id']);
    $eventsStatus = sanitizeInput($_POST['events_status']);

    $sql = "UPDATE events SET events_status = ? WHERE events_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "si", $eventsStatus, $eventsId);
    mysqli_stmt_execute($stmt);

    echo "Event status updated successfully";
}