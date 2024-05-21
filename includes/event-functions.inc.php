<?php
require_once 'event.inc.php';

function handleCreateEvent($conn)
{
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

            // Create the event first to get the event ID
            $eventsId = createEvent($conn, $usersId, $eventName, $eventStartDate, $eventEndDate, $eventVenue, $eventBudget, $eventStatus, $eventDescription, $eventRemarks);

            // Loop through each array of inputs and create separate records
            foreach ($_POST['events_objectives'] as $objective) {
                $eventObjective = sanitizeInput($objective);
                createObjective($conn, $eventsId, $eventObjective);
            }

            foreach ($_POST['events_problems_encountered'] as $problem) {
                $eventProblem = sanitizeInput($problem);
                createProblem($conn, $eventsId, $eventProblem);
            }

            foreach ($_POST['events_actions_taken'] as $action) {
                $eventAction = sanitizeInput($action);
                createAction($conn, $eventsId, $eventAction);
            }

            foreach ($_POST['events_recommendations'] as $recommendation) {
                $eventRecommendation = sanitizeInput($recommendation);
                createRecommendation($conn, $eventsId, $eventRecommendation);
            }

            // Process the uploaded files
            if (isset($_FILES['events_documentation_pictures'])) {
                require_once 'event.inc.php';

                $pictures = $_FILES['events_documentation_pictures'];

                // Prepare an array of pictures
                $picturesArray = [];

                // Check if multiple files are uploaded
                if (is_array($pictures['name'])) {
                    // Get the count of uploaded files
                    $fileCount = count($pictures['name']);
                } else {
                    // Only one file is uploaded
                    $fileCount = 1;
                    $pictures['name'] = array($pictures['name']);
                    $pictures['type'] = array($pictures['type']);
                    $pictures['tmp_name'] = array($pictures['tmp_name']);
                    $pictures['error'] = array($pictures['error']);
                    $pictures['size'] = array($pictures['size']);
                }

                $fileKeys = array_keys($pictures);

                for ($i = 0; $i < $fileCount; $i++) {
                    foreach ($fileKeys as $key) {
                        $picturesArray[$i][$key] = $pictures[$key][$i];
                    }
                }

                storeEventDocumentationPicture($conn, $eventsId, $picturesArray);
            }

            header("Location: events-overview.php?create-event=success");
        } else {
            header("Location: events-overview.php?create-event=error");
        }
    }
}

function getEvent($conn, $eventsId)
{
    $sql = "SELECT * FROM events WHERE events_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $eventsId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

function getEventName($conn, $eventsId)
{
    $sql = "SELECT events_name FROM events WHERE events_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $eventsId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    return $row['events_name'];
}

function getTransactions($conn, $eventsId, $sort = 'DESC', $filterDays = null, $transactionType = null, $startFrom = 0, $recordsPerPage = 0)
{
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

function getUserEvents($conn, $usersId, $sortOrder = 'DESC')
{
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

function getCategories($conn, $eventsId)
{
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

function getTotalEventExpenses($conn, $eventsId)
{
    $sql = "SELECT SUM(transaction_total) AS total_expenses FROM transaction_history WHERE events_id = ? AND transaction_type = 'expense'";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $eventsId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    return $row['total_expenses'];
}

function getTotalEventIncome($conn, $eventsId)
{
    $sql = "SELECT SUM(transaction_total) AS total_income FROM transaction_history WHERE events_id = ? AND transaction_type = 'income'";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $eventsId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    return $row['total_income'];
}

function getEventRemainingBudget($conn, $eventsId)
{
    $event = getEvent($conn, $eventsId);
    $expenses = getTotalEventExpenses($conn, $eventsId);
    $income = getTotalEventIncome($conn, $eventsId);
    $remainingBudget = ($event['events_budget'] + $income) - $expenses;
    return $remainingBudget;
}

function getEventManagers($conn, $eventsId)
{
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

function getEventIncomes($conn, $eventsId)
{
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

function deleteEvent($conn, $eventsId)
{
    $sql = "DELETE FROM events WHERE events_id = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return false;
    }
    mysqli_stmt_bind_param($stmt, "i", $eventsId);
    mysqli_stmt_execute($stmt);
    return true;
}

function updateEvent($conn, $eventsId, $eventsName, $eventsStartDate, $eventsEndDate, $eventsVenue, $eventsBudget, $eventsStatus, $eventsDescription, $eventsRemarks)
{
    $sql = "UPDATE events SET events_name = ?, events_start_date = ?, events_end_date = ?, events_venue = ?, events_budget = ?, events_status = ?, events_description = ?, events_remarks = ? WHERE events_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssisssi", $eventsName, $eventsStartDate, $eventsEndDate, $eventsVenue, $eventsBudget, $eventsStatus, $eventsDescription, $eventsRemarks, $eventsId);
    mysqli_stmt_execute($stmt);
}

function updateOrInsertRecord($conn, $table, $id, $value, $eventsId)
{
    // If the value is empty, set it to NULL
    if (empty($value)) {
        $value = NULL;
    }

    // Check if the record exists
    $sql = "SELECT * FROM $table WHERE {$table}_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        // The record exists, update it
        $sql = "UPDATE $table SET {$table}_name = ? WHERE {$table}_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "si", $value, $id);
        mysqli_stmt_execute($stmt);
    } else if ($value !== NULL) {
        // The record doesn't exist and the value is not NULL, insert it
        $sql = "INSERT INTO $table ({$table}_name) VALUES (?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $value);
        mysqli_stmt_execute($stmt);

        // Get the ID of the inserted record
        $insertedId = mysqli_insert_id($conn);

        // Insert a record into the junction table
        $junctionTable = "event_$table";
        $sql = "INSERT INTO $junctionTable (events_id, {$table}_id) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $eventsId, $insertedId);
        mysqli_stmt_execute($stmt);
    }
}


function updateEventDocumentationPictures($conn, $eventsId, $pictures) {
    foreach ($pictures as $picture) {
        // Check for upload errors
        if ($picture['error'] !== UPLOAD_ERR_OK) {
            // Handle error
            continue;
        }

        // Read the file content
        $pictureContent = file_get_contents($picture['tmp_name']);

        // Check if the picture already exists
        $sql = "SELECT * FROM documentation_pictures WHERE documentation_pictures_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $eventsId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            // The picture exists, update it
            $sql = "UPDATE documentation_pictures SET documentation_pictures_item = ? WHERE documentation_pictures_id = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "si", $pictureContent, $eventsId);
            mysqli_stmt_execute($stmt);
        } else {
            // The picture doesn't exist, insert it
            $sql = "INSERT INTO documentation_pictures (documentation_pictures_item) VALUES (?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "s", $pictureContent);
            mysqli_stmt_execute($stmt);

            // Get the ID of the inserted picture
            $pictureId = mysqli_insert_id($conn);

            // Insert a record into the event_documentation_pictures table
            $sql = "INSERT INTO event_documentation_pictures (events_id, documentation_pictures_id) VALUES (?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ii", $eventsId, $pictureId);
            mysqli_stmt_execute($stmt);
        }
    }
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

function groupOtherCategories($groupedTransactions, $limit)
{
    $topCategories = array_slice($groupedTransactions, 0, $limit, true);
    if (count($groupedTransactions) > $limit) {
        $topCategories['Other'] = array_sum(array_slice($groupedTransactions, $limit));
    }
    return $topCategories;
}

function getEventInitialBudget($conn, $eventsId)
{
    $sql = "SELECT events_budget FROM events WHERE events_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $eventsId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    return $row['events_budget'];
}

function calculateBudget($totalExpenses, $remainingBudget, $transactions, $row, $eventsId, $conn)
{
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

function limit_words($string, $word_limit)
{
    $words = explode(" ", $string);
    $limited_string = implode(" ", array_splice($words, 0, $word_limit));
    return (str_word_count($string) > $word_limit) ? $limited_string : $string;
}

function getEventStatus($conn, $eventsId)
{
    $sql = "SELECT events_status FROM events WHERE events_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $eventsId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    return $row['events_status'];
}