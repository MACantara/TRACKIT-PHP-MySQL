<?php
require_once 'event.inc.php';

function handleCreateEvent($conn) {
    require_once "error-handling-functions.inc.php"; // Include the file containing the sanitizeInput function

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['event_name'], $_POST['event_description'], $_POST['event_date'], $_POST['event_time'], $_POST['event_budget'])) {
            $usersId = $_SESSION['users_id'];
            $eventName = sanitizeInput($_POST['event_name']);
            $eventDescription = sanitizeInput($_POST['event_description']);
            $eventDate = sanitizeInput($_POST['event_date']);
            $eventTime = sanitizeInput($_POST['event_time']);
            $eventBudget = sanitizeInput($_POST['event_budget']);

            createEvent($conn, $usersId, $eventName, $eventDescription, $eventDate, $eventTime, $eventBudget);
            header("Location: events-overview.php?create-event=success");
        } else {
            header("Location: events-overview.php?create-event=error");
        }
    }
}

function getEvent($conn, $eventsId) {
    $sql = "SELECT * FROM events WHERE events_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $eventsId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

function getEventName($conn, $eventsId) {
    $sql = "SELECT events_name FROM events WHERE events_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $eventsId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    return $row['events_name'];
}

function getTransactions($conn, $eventsId, $sort = 'DESC', $filterDays = null, $transactionType = null, $startFrom = 0, $recordsPerPage = 0) {
    $sql = "SELECT * FROM transaction_history WHERE events_id = ?";
    $params = [$eventsId];
    $types = "i";

    if ($filterDays) {
        $sql .= " AND transaction_date >= DATE_SUB(CURDATE(), INTERVAL ? DAY)";
        $params[] = $filterDays;
        $types .= "i";
    }
    if ($transactionType) {
        $sql .= " AND transaction_type = ?";
        $params[] = $transactionType;
        $types .= "s";
    }
    $sql .= " ORDER BY transaction_date " . $sort;
    if ($recordsPerPage > 0) {
        $sql .= " LIMIT ?, ?";
        $params[] = $startFrom;
        $params[] = $recordsPerPage;
        $types .= "ii";
    }
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, $types, ...$params);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function getUserEvents($conn, $usersId) {
    $sql = "SELECT events.events_id, events.events_name, events.events_description, events.events_date, events.events_budget FROM events JOIN event_users ON events.events_id = event_users.events_id WHERE event_users.users_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $usersId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function getCategories($conn, $eventsId) {
    $sql = "SELECT transaction_category FROM transaction_history WHERE events_id = ? GROUP BY transaction_category;"; // adjust the table and column names as needed
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../index.php?error=sqlerror");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "i", $eventsId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
}

function getTotalEventExpenses($conn, $eventsId) {
    $sql = "SELECT SUM(transaction_total) AS total_expenses FROM transaction_history WHERE events_id = ? AND transaction_type = 'expense'";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $eventsId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    return $row['total_expenses'];
}

function getTotalEventIncome($conn, $eventsId) {
    $sql = "SELECT SUM(transaction_total) AS total_income FROM transaction_history WHERE events_id = ? AND transaction_type = 'income'";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $eventsId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    return $row['total_income'];
}
    
function getEventRemainingBudget($conn, $eventsId) {
    $event = getEvent($conn, $eventsId);
    $expenses = getTotalEventExpenses($conn, $eventsId);
    $income = getTotalEventIncome($conn, $eventsId);
    $remainingBudget = ($event['events_budget'] + $income) - $expenses;
    return $remainingBudget;
}

function getEventManagers($conn, $eventsId) {
    $sql = "SELECT users.users_last_name, users.users_first_name FROM event_users
            INNER JOIN users ON event_users.users_id = users.users_id
            WHERE event_users.events_id = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return false;
    }
    mysqli_stmt_bind_param($stmt, "i", $eventsId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $managers = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $managers[] = $row['users_first_name'] . ' ' . $row['users_last_name'];
    }
    return $managers;
}

function getEventExpenses($conn, $eventsId)
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

    mysqli_stmt_bind_param($stmt, "i", $eventsId);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    $expenses = mysqli_fetch_all($resultData, MYSQLI_ASSOC);

    mysqli_stmt_close($stmt);

    return $expenses;
}

function getEventIncomes($conn, $eventsId) {
    $sql = "SELECT transaction_category, SUM(transaction_total) as transaction_total
            FROM transaction_history
            WHERE events_id = ? AND transaction_type = 'Income'
            GROUP BY transaction_category";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../events-overview.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "i", $eventsId);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    $income = mysqli_fetch_all($resultData, MYSQLI_ASSOC);

    mysqli_stmt_close($stmt);

    return $income;
}

function deleteEvent($conn, $eventsId) {
    $sql = "DELETE FROM events WHERE events_id = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return false;
    }
    mysqli_stmt_bind_param($stmt, "i", $eventsId);
    mysqli_stmt_execute($stmt);
    return true;
}

function updateEvent($conn, $eventsId, $eventName, $eventDescription, $eventDate, $eventTime, $eventBudget) {
    $eventDateTime = $eventDate . ' ' . $eventTime . ':00';
    $sql = "UPDATE events SET events_name = ?, events_description = ?, events_date = ?, events_budget = ? WHERE events_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssi", $eventName, $eventDescription, $eventDateTime, $eventBudget, $eventsId);
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

function getEventInitialBudget($conn, $eventsId) {
    $sql = "SELECT events_budget FROM events WHERE events_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $eventsId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    return $row['events_budget'];
}

function calculateBudget($totalExpenses, $remainingBudget, $transactions, $row, $eventsId, $conn) {
    // If remaining budget is less than 0, set it to 0
    if ($remainingBudget < 0) {
        $remainingBudget = 0;
    }

    // Calculate expenses within and over budget
    if ($totalExpenses > $remainingBudget && $remainingBudget == 0) {
        $remainingBudget = empty($transactions) ? $row['events_budget'] : getEventRemainingBudget($conn, $eventsId);
        $expensesWithinBudget = $totalExpenses - abs($remainingBudget);
        $remainingBudget = 0;
    } else {
        $expensesWithinBudget = $totalExpenses;
    }

    // Calculate expenses over budget
    if ($totalExpenses > $remainingBudget) {
        $expensesOverBudget = $totalExpenses - $expensesWithinBudget;
    } else {
        $expensesOverBudget = 0;
    }

    return array($expensesWithinBudget, $expensesOverBudget, $remainingBudget);
}