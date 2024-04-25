<?php
require_once "db-connection.inc.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "INSERT INTO transaction_history (transaction_name, transaction_description, transaction_date, transaction_amount, transaction_price, transaction_category, transaction_type, events_id, users_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssidssii", $_POST['transaction_name'], $_POST['transaction_description'], $_POST['transaction_date'], $_POST['transaction_amount'], $_POST['transaction_price'], $_POST['transaction_category'], $_POST['transaction_type'], $_POST['events_id'], $_POST['users_id']);
    mysqli_stmt_execute($stmt);
    header("Location: ../event-dashboard.php?events_id=" . $_POST['events_id']);
    exit();
}