<?php
require_once "db-connection.inc.php";
require_once "event-functions.inc.php";
require_once "error-handling-functions.inc.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add-transaction-submit'])) {
    $transactionCategory = sanitizeInput($_POST['transaction_category']) === 'other' ? $_POST['new_transaction_category'] : sanitizeInput($_POST['transaction_category']);
    $transactionName = sanitizeInput($_POST['transaction_name']);
    $transactionDescription = sanitizeInput($_POST['transaction_description']);
    $transactionDate = sanitizeInput($_POST['transaction_date']);
    $transactionTime = sanitizeInput($_POST['transaction_time']);
    $transactionDateTime = $transactionDate . ' ' . $transactionTime . ':00';
    $transactionAmount = sanitizeInput($_POST['transaction_amount']);
    $transactionPrice = sanitizeInput($_POST['transaction_price']);
    $transactionType = sanitizeInput($_POST['transaction_type']);
    $eventsId = sanitizeInput($_POST['events_id']);
    $usersId = sanitizeInput($_POST['users_id']);

    // Validation
    if (empty($transactionName) || empty($transactionDescription) || empty($transactionDate) || empty($transactionTime) || empty($transactionAmount) || empty($transactionPrice) || empty($transactionCategory) || empty($transactionType) || empty($eventsId) || empty($usersId)) {
        // Handle error here, one or more fields are empty.
        header("Location: ../add-transaction.php?error=emptyfields");
        exit();
    }

    // Check if the transaction's name is too long
    if (strlen($transactionName) > 255) {
        // Handle error here, the transaction's name is too long.
        header("Location: ../add-transaction.php?error=nametoolong");
        exit();
    }

    if (!is_numeric($transactionAmount)) {
        header("Location: ../add-transaction.php?error=invalidamount");
        exit();
    }

    if (!is_numeric($transactionPrice)) {
        header("Location: ../add-transaction.php?error=invalidprice");
        exit();
    }

    if ($transactionType !== 'income' && $transactionType !== 'expense') {
        header("Location: ../add-transaction.php?error=invalidtype");
        exit();
    }

    $sql = "INSERT INTO transaction_history (transaction_name, transaction_description, transaction_date, transaction_amount, transaction_price, transaction_category, transaction_type, events_id, users_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt === false) {
        // Handle error - perhaps by logging and showing an error message
        error_log('mysqli_prepare failed: ' . htmlspecialchars(mysqli_error($conn)));
        exit('An error occurred. Please try again later.');
    }

    $bindResult = mysqli_stmt_bind_param($stmt, "sssidssii", $transactionName, $transactionDescription, $transactionDateTime, $transactionAmount, $transactionPrice, $transactionCategory, $transactionType, $eventsId, $usersId);

    if ($bindResult === false) {
        // Handle error - perhaps by logging and showing an error message
        error_log('mysqli_stmt_bind_param failed: ' . htmlspecialchars(mysqli_error($conn)));
        exit('An error occurred. Please try again later.');
    }

    $executeResult = mysqli_stmt_execute($stmt);

    if ($executeResult === false) {
        // Handle error - perhaps by logging and showing an error message
        error_log('mysqli_stmt_execute failed: ' . htmlspecialchars(mysqli_error($conn)));
        exit('An error occurred. Please try again later.');
    }

    header("Location: ../event-dashboard.php?events_id=" . $_POST['events_id']);
    exit();
} else {
    header("Location: ../event-dashboard.php?events_id=" . $_POST['events_id']);
    exit();
}
?>