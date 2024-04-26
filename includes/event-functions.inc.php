<?php
require_once 'event.inc.php';

function handleCreateEvent($conn) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['event_name'], $_POST['event_description'], $_POST['event_date'], $_POST['event_time'], $_POST['event_budget'])) {
            $userId = $_SESSION['users_id'];
            $eventName = $_POST['event_name'];
            $eventDescription = $_POST['event_description'];
            $eventDate = $_POST['event_date'];
            $eventTime = $_POST['event_time'];
            $eventBudget = $_POST['event_budget'];

            createEvent($conn, $userId, $eventName, $eventDescription, $eventDate, $eventTime, $eventBudget);
            header("Location: events-overview.php?create=success");
        } else {
            header("Location: events-overview.php?create=error");
        }
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

function getTotalEventExpenses($conn, $eventId) {
    $sql = "SELECT SUM(transaction_total) AS total_expenses FROM transaction_history WHERE events_id = ? AND transaction_type = 'expense'";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $eventId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    return $row['total_expenses'];
}

function getTotalEventIncome($conn, $eventId) {
    $sql = "SELECT SUM(transaction_total) AS total_income FROM transaction_history WHERE events_id = ? AND transaction_type = 'income'";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $eventId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    return $row['total_income'];
}
    
function getEventRemainingBudget($conn, $eventId) {
    $event = getEvent($conn, $eventId);
    $expenses = getTotalEventExpenses($conn, $eventId);
    $income = getTotalEventIncome($conn, $eventId);
    $remainingBudget = ($event['events_budget'] + $income) - $expenses;
    return $remainingBudget;
}

function getEventManagers($conn, $eventId) {
    $sql = "SELECT users.users_last_name, users.users_first_name FROM event_users
            INNER JOIN users ON event_users.users_id = users.users_id
            WHERE event_users.events_id = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return false;
    }
    mysqli_stmt_bind_param($stmt, "i", $eventId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $managers = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $managers[] = $row['users_first_name'] . ' ' . $row['users_last_name'];
    }
    return $managers;
}

function getEventExpenses($conn, $eventId)
{
    $sql = "SELECT transaction_category, SUM(transaction_total) as transaction_total
            FROM transaction_history
            WHERE events_id = ? AND transaction_type = 'Expense'
            GROUP BY transaction_category";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../events-overview.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "i", $eventId);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    $expenses = mysqli_fetch_all($resultData, MYSQLI_ASSOC);

    mysqli_stmt_close($stmt);

    return $expenses;
}

function getEventIncomes($conn, $eventId) {
    $sql = "SELECT transaction_category, SUM(transaction_total) as transaction_total
            FROM transaction_history
            WHERE events_id = ? AND transaction_type = 'Income'
            GROUP BY transaction_category";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../events-overview.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "i", $eventId);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    $income = mysqli_fetch_all($resultData, MYSQLI_ASSOC);

    mysqli_stmt_close($stmt);

    return $income;
}

function deleteEvent($conn, $eventId) {
    $sql = "DELETE FROM events WHERE events_id = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return false;
    }
    mysqli_stmt_bind_param($stmt, "i", $eventId);
    mysqli_stmt_execute($stmt);
    return true;
}

function updateEvent($conn, $eventId, $eventName, $eventDescription, $eventDate, $eventTime, $eventBudget) {
    $eventDateTime = $eventDate . ' ' . $eventTime . ':00';
    $sql = "UPDATE events SET events_name = ?, events_description = ?, events_date = ?, events_budget = ? WHERE events_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssi", $eventName, $eventDescription, $eventDateTime, $eventBudget, $eventId);
    mysqli_stmt_execute($stmt);
}

// Group transactions by category and calculate total amount    
function groupTransactionsByCategory($transactions)
{
    $groupedTransactions = [];
    if (is_array($transactions)) {
        foreach ($transactions as $transaction) {
            if (!isset($groupedTransactions[$transaction['transaction_category']])) {
                $groupedTransactions[$transaction['transaction_category']] = 0;
            }
            $groupedTransactions[$transaction['transaction_category']] += $transaction['transaction_total'];
        }
    }
    return $groupedTransactions;
}

function groupOtherCategories($groupedTransactions, $limit) {
    $topCategories = array_slice($groupedTransactions, 0, $limit, true);
    if (count($groupedTransactions) > $limit) {
        $topCategories['Other'] = array_sum(array_slice($groupedTransactions, $limit));
    }
    return $topCategories;
}

function sanitizeInput($input) {
    return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
}