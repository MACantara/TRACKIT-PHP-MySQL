<?php
session_start();
require_once 'includes/db-connection.inc.php';
require_once 'includes/event-functions.inc.php';

require_once 'includes/user-functions.inc.php';
require_login();
checkSessionTimeout();

$eventsId = $_GET['events_id'];
$usersId = $_SESSION["users_id"];

$row = getEvent($conn, $eventsId);

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$recordsPerPage = 25; // Change this to 50, 75, or 100 as needed
$startFrom = ($page - 1) * $recordsPerPage;

$_SESSION['sort'] = $_GET['sort'] ?? $_SESSION['sort'] ?? 'DESC';
$_SESSION['filter'] = $_GET['filter'] ?? $_SESSION['filter'] ?? null;
$_SESSION['transaction_type'] = $_GET['transaction_type'] ?? $_SESSION['transaction_type'] ?? null;
$sort = $_SESSION['sort'];
$filterDays = $_SESSION['filter'];
$transactionType = $_SESSION['transaction_type'];
$transactions = getTransactions($conn, $eventsId, $sort, $filterDays === 0 ? null : $filterDays, $transactionType, $startFrom, $recordsPerPage);
$expenses = getEventExpenses($conn, $eventsId);
$incomes = getEventIncomes($conn, $eventsId);
$totalExpenses = getTotalEventExpenses($conn, $eventsId);
$totalIncome = getTotalEventIncome($conn, $eventsId);
$remainingBudget = empty($transactions) ? $row['events_budget'] : getEventRemainingBudget($conn, $eventsId);

list($expensesWithinBudget, $expensesOverBudget, $remainingBudget) = calculateBudget($totalExpenses, $remainingBudget, $transactions, $row, $eventsId, $conn);

// Add pagination links at the end of the transaction history table
$totalRecords = count(getTransactions($conn, $eventsId, $sort, $filterDays === 0 ? null : $filterDays, $transactionType));
$totalPages = ceil($totalRecords / $recordsPerPage);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "templates/meta-tags.tpl.php"; ?>
    <title>Event Dashboard - <?php echo $row['events_name']; ?></title>
    <?php include "templates/external-links.tpl.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <?php include "templates/header.tpl.php"; ?>

    <main>
        <div class="event-dashboard-buttons-container">
            <a class="secondary-outline-button" href="events-overview.php"><i class="bi bi-arrow-left"></i> Back to
                Events Overview</a>
            <a class="button" href="add-transaction.php?events_id=<?php echo $eventsId; ?>"><i
                    class="bi bi-plus-circle"></i> Add Transaction</a>
            <a class="button" href="invite-user.php?events_id=<?php echo $eventsId; ?>"><i
                    class="bi bi-person-plus"></i> Invite User</a>
            <form action="includes/report-generation.inc.php?events_id=<?php echo $eventsId; ?>" method="post">
                <input type="hidden" name="event_id" value="<?php echo $eventsId; ?>">
                <button class="button" type="submit" name="generate-report"><i class="bi bi-file-earmark-text"></i>
                    Generate Report</button>
            </form>
        </div>
        <h1 class="margin-top-16"><?php echo $row['events_name']; ?></h1>
        <section class="chart-container">
            <section class="one-column-grid-container">
                <h2>Top 5 Expenses</h2>
                <canvas id="pieChart1"></canvas>
                <p>Total Expenses: &#8369; <?php echo number_format(getTotalEventExpenses($conn, $eventsId), 2); ?></p>
            </section>
            <section class="one-column-grid-container">
                <h2>Top 5 Income</h2>
                <canvas id="pieChart2"></canvas>
                <p>Total Income: &#8369; <?php echo number_format(getTotalEventIncome($conn, $eventsId), 2); ?></p>
            </section>
            <section class="one-column-grid-container">
                <h2>Remaining Budget</h2>
                <canvas id="barChart"></canvas>
                <p>Remaining Budget: &#8369; <?php echo number_format($remainingBudget, 2); ?></p>
            </section>
        </section>
        <section class="one-column-grid-container">
            <h2>Transaction History</h2>
            <?php if (empty($transactions)): ?>
                <?php include 'includes/transaction-filter-controls.php'; ?>
                <p>There are No Transaction History Yet</p>
            <?php else: ?>
                <?php
                include 'includes/transaction-filter-controls.php';
                include 'includes/transaction-pagination-controls.php';
                ?>
                <table>
                    <tr>
                        <th>Date</th>
                        <th>Name</th>
                        <th>Amount</th>
                        <th>Price</th>
                        <th>Total</th>
                        <th>Category</th>
                        <th>Type</th>
                        <th style="max-width: 300px;">Description</th>
                    </tr>
                    <?php foreach ($transactions as $transaction): ?>
                        <tr>
                            <td>
                                <?php
                                $date = new DateTime($transaction['transaction_date']);
                                echo $date->format('Y-m-d g:i A');
                                ?>
                            </td>
                            <td><?php echo $transaction['transaction_name']; ?></td>
                            <td><?php echo number_format($transaction['transaction_amount']); ?></td>
                            <td><?php echo '&#8369; ' . number_format($transaction['transaction_price'], 2); ?></td>
                            <td><?php echo '&#8369; ' . number_format($transaction['transaction_total'], 2); ?></td>
                            <td><?php echo $transaction['transaction_category']; ?></td>
                            <td><?php echo $transaction['transaction_type']; ?></td>
                            <td style="max-width: 300px;"><?php echo $transaction['transaction_description']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>
        </section>
    </main>
    <?php include 'templates/footer.tpl.php'; ?>
    <?php include 'includes/event-dashboard-charts.php'; ?>
</body>

</html>