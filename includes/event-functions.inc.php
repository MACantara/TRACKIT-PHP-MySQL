<?php
require_once 'event.inc.php';

function handleCreateEvent($conn) {
    require_once "error-handling-functions.inc.php"; // Include the file containing the sanitizeInput function

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['events_name'], $_POST['events_start_date'], $_POST['events_end_date'], $_POST['events_venue'], $_POST['events_budget'], $_POST['events_status'], $_POST['events_description'])) {
            $usersId = $_SESSION['users_id'];
            $eventName = sanitizeInput($_POST['events_name']);
            $eventStartDate = sanitizeInput($_POST['events_start_date']);
            $eventEndDate = sanitizeInput($_POST['events_end_date']);
            $eventVenue = sanitizeInput($_POST['events_venue']);
            $eventBudget = sanitizeInput($_POST['events_budget']);
            $eventStatus = sanitizeInput($_POST['events_status']);
            $eventDescription = sanitizeInput($_POST['events_description']);
            $eventRemarks = sanitizeInput($_POST['events_remarks']);

            createEvent($conn, $usersId, $eventName, $eventStartDate, $eventEndDate, $eventVenue, $eventBudget, $eventStatus, $eventDescription, $eventRemarks);
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

function getUserEvents($conn, $usersId, $sortOrder = 'DESC') {
    $sql = "SELECT events.events_id, events.events_status, events.events_name, events.events_description, events.events_start_date, events.events_end_date, events.events_venue, events.events_budget, events.events_remarks 
            FROM events 
            JOIN department_events ON events.events_id = department_events.events_id 
            JOIN department_users ON department_events.departments_id = department_users.departments_id 
            WHERE department_users.users_id = ? 
            ORDER BY events.events_start_date $sortOrder";
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
    $sql = "SELECT users.users_last_name, users.users_first_name FROM department_users
            INNER JOIN users ON department_users.users_id = users.users_id
            INNER JOIN department_events ON department_users.departments_id = department_events.departments_id
            WHERE department_events.events_id = ?";
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

function updateEvent($conn, $eventsId, $eventsName, $eventsStartDate, $eventsEndDate, $eventsVenue, $eventsBudget, $eventsStatus, $eventsDescription, $eventsRemarks) {
    $sql = "UPDATE events SET events_name = ?, events_start_date = ?, events_end_date = ?, events_venue = ?, events_budget = ?, events_status = ?, events_description = ?, events_remarks = ? WHERE events_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssisssi", $eventsName, $eventsStartDate, $eventsEndDate, $eventsVenue, $eventsBudget, $eventsStatus, $eventsDescription, $eventsRemarks, $eventsId);
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

function limit_words($string, $word_limit) {
    $words = explode(" ",$string);
    $limited_string = implode(" ",array_splice($words,0,$word_limit));
    return (str_word_count($string) > $word_limit) ? $limited_string : $string;
}

function getEventStatus($conn, $eventId) {
    $sql = "SELECT events_status FROM events WHERE events_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $eventId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    return $row['events_status'];
}