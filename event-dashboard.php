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

$colors = [
    '#B71C1C', // Red
    '#880E4F', // Pink
    '#4A148C', // Purple
    '#311B92', // Deep Purple
    '#1A237E', // Indigo
    '#0D47A1', // Blue
    '#01579B', // Light Blue
    '#006064', // Cyan
    '#004D40', // Teal
    '#1B5E20', // Green
    '#33691E', // Light Green
    '#827717', // Lime
    '#F57F17', // Yellow
    '#FF6F00', // Amber
    '#E65100', // Orange
    '#BF360C'  // Deep Orange
];

$groupedExpenseTransactions = groupTransactionsByCategory($expenses);
$groupedIncomeTransactions = groupTransactionsByCategory($incomes);

// Sort by total amount in descending order and take top 5
arsort($groupedExpenseTransactions);
arsort($groupedIncomeTransactions);

$topExpenseCategories = array_slice($groupedExpenseTransactions, 0, 5, true);
$topIncomeCategories = array_slice($groupedIncomeTransactions, 0, 5, true);

// Add "Other" category
$topExpenseCategories = groupOtherCategories($groupedExpenseTransactions, 5);
$topIncomeCategories = groupOtherCategories($groupedIncomeTransactions, 5);

// Add pagination links at the end of the transaction history table
$totalRecords = count(getTransactions($conn, $eventsId, $sort, $filterDays === 0 ? null : $filterDays, $transactionType));
$totalPages = ceil($totalRecords / $recordsPerPage);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Dashboard - <?php echo $row['events_name']; ?></title>
    <?php include "templates/external-links.tpl.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <?php include "templates/header.tpl.php"; ?>

    <main>
        <div class="event-dashboard-buttons-container">
            <a class="secondary-outline-button" href="events-overview.php"><i class="bi bi-arrow-left"></i> Back to Events Overview</a>
            <a class="button" href="add-transaction.php?events_id=<?php echo $eventsId; ?>"><i class="bi bi-plus-circle"></i> Add Transaction</a>
            <a class="button" href="invite-user.php?events_id=<?php echo $eventsId; ?>"><i class="bi bi-person-plus"></i> Invite User</a>
            <form action="includes/report-generation.inc.php?events_id=<?php echo $eventsId; ?>" method="post">
                <input type="hidden" name="event_id" value="<?php echo $eventsId; ?>">
                <button class="button" type="submit" name="generate-report"><i class="bi bi-file-earmark-text"></i> Generate Report</button>
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
                <div class="controls">
                    <form action="event-dashboard.php" method="get" class="filter-form">
                        <input type="hidden" name="events_id" value="<?php echo $eventsId; ?>">
                        <label for="sort" class="filter-label">Sort by date:</label>
                        <select name="sort" id="sort" class="filter-select">
                            <option value="ASC" <?php echo $sort == 'ASC' ? 'selected' : ''; ?>>Old to Recent</option>
                            <option value="DESC" <?php echo $sort == 'DESC' ? 'selected' : ''; ?>>Recent to Old</option>
                        </select>
                        <label for="filter" class="filter-label">Filter by date:</label>
                        <select name="filter" id="filter" class="filter-select">
                            <option value="" <?php echo $filterDays === null ? 'selected' : ''; ?>>All</option>
                            <option value="1" <?php echo $filterDays == '1' ? 'selected' : ''; ?>>Today</option>
                            <option value="2" <?php echo $filterDays == '2' ? 'selected' : ''; ?>>Yesterday</option>
                            <option value="7" <?php echo $filterDays == '7' ? 'selected' : ''; ?>>Last 7 days</option>
                            <option value="14" <?php echo $filterDays == '14' ? 'selected' : ''; ?>>Last 14 days</option>
                            <option value="30" <?php echo $filterDays == '30' ? 'selected' : ''; ?>>Last 30 days</option>
                            <option value="60" <?php echo $filterDays == '60' ? 'selected' : ''; ?>>Last 60 days</option>
                            <option value="90" <?php echo $filterDays == '90' ? 'selected' : ''; ?>>Last 90 days</option>
                        </select>
                        <label for="transaction_type" class="filter-label">Filter by transaction type:</label>
                        <select name="transaction_type" id="transaction_type" class="filter-select">
                            <option value="">All</option>
                            <option value="income" <?php echo $_SESSION['transaction_type'] == 'income' ? 'selected' : ''; ?>>
                                Income</option>
                            <option value="expense" <?php echo $_SESSION['transaction_type'] == 'expense' ? 'selected' : ''; ?>>
                                Expense</option>
                        </select>
                        <button type="submit" class="filter-button">Apply</button>
                        <a href="event-dashboard.php?events_id=<?php echo $eventsId; ?>&sort=DESC&filter=&transaction_type="
                            class="filter-button">Reset</a>
                    </form>
                </div>
                <p>There are No Transaction History Yet</p>
            <?php else: ?>
                <div class="controls">
                    <form action="event-dashboard.php" method="get" class="filter-form">
                        <input type="hidden" name="events_id" value="<?php echo $eventsId; ?>">
                        <label for="sort" class="filter-label">Sort by date:</label>
                        <select name="sort" id="sort" class="filter-select">
                            <option value="ASC" <?php echo $sort == 'ASC' ? 'selected' : ''; ?>>Old to Recent</option>
                            <option value="DESC" <?php echo $sort == 'DESC' ? 'selected' : ''; ?>>Recent to Old</option>
                        </select>
                        <label for="filter" class="filter-label">Filter by date:</label>
                        <select name="filter" id="filter" class="filter-select">
                            <option value="" <?php echo $filterDays === null ? 'selected' : ''; ?>>All</option>
                            <option value="1" <?php echo $filterDays == '1' ? 'selected' : ''; ?>>Today</option>
                            <option value="2" <?php echo $filterDays == '2' ? 'selected' : ''; ?>>Yesterday</option>
                            <option value="7" <?php echo $filterDays == '7' ? 'selected' : ''; ?>>Last 7 days</option>
                            <option value="14" <?php echo $filterDays == '14' ? 'selected' : ''; ?>>Last 14 days</option>
                            <option value="30" <?php echo $filterDays == '30' ? 'selected' : ''; ?>>Last 30 days</option>
                            <option value="60" <?php echo $filterDays == '60' ? 'selected' : ''; ?>>Last 60 days</option>
                            <option value="90" <?php echo $filterDays == '90' ? 'selected' : ''; ?>>Last 90 days</option>
                        </select>
                        <label for="transaction_type" class="filter-label">Filter by transaction type:</label>
                        <select name="transaction_type" id="transaction_type" class="filter-select">
                            <option value="">All</option>
                            <option value="income" <?php echo $_SESSION['transaction_type'] == 'income' ? 'selected' : ''; ?>>
                                Income</option>
                            <option value="expense" <?php echo $_SESSION['transaction_type'] == 'expense' ? 'selected' : ''; ?>>
                                Expense</option>
                        </select>
                        <button type="submit" class="filter-button">Apply</button>
                        <a href="event-dashboard.php?events_id=<?php echo $eventsId; ?>&sort=DESC&filter=&transaction_type="
                            class="filter-button">Reset</a>
                    </form>
                    <div class="pagination">
                        <?php
                        echo "<div class='pagination'>";
                        if ($page > 1) {
                            echo "<a href='event-dashboard.php?events_id=" . $eventsId . "&page=" . ($page - 1) . "&sort=" . $sort . "&filter=" . $filterDays . "'><i class='bi bi-arrow-left'></i></a> ";
                        }
                        echo "Page " . $page . " of " . $totalPages;
                        if ($page < $totalPages) {
                            echo " <a href='event-dashboard.php?events_id=" . $eventsId . "&page=" . ($page + 1) . "&sort=" . $sort . "&filter=" . $filterDays . "'><i class='bi bi-arrow-right'></i></a>";
                        }
                        echo "</div>";
                        ?>
                    </div>
                </div>
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
    <script>
        // Pie chart - Expenses
        const pieChartCtx1 = document.getElementById("pieChart1").getContext("2d");
        new Chart(pieChartCtx1, {
            type: "doughnut",
            data: {
                labels: <?php echo json_encode(array_keys($topExpenseCategories)); ?>,
                datasets: [
                    {
                        data: <?php echo json_encode(array_values($topExpenseCategories)); ?>,
                        backgroundColor: <?php echo json_encode($colors); ?>,
                    },
                ],
            },
            options: {
                responsive: true,
            },
        });
        // Pie chart - Incomes
        const pieChartCtx2 = document.getElementById("pieChart2").getContext("2d");
        new Chart(pieChartCtx2, {
            type: "doughnut",
            data: {
                labels: <?php echo json_encode(array_keys($topIncomeCategories)); ?>,
                datasets: [
                    {
                        data: <?php echo json_encode(array_values($topIncomeCategories)); ?>,
                        backgroundColor: <?php echo json_encode($colors); ?>,
                    },
                ],
            },
            options: {
                responsive: true,
            },
        });
        // Bar chart - Remaining Budget
        const barChartCtx = document.getElementById("barChart").getContext("2d");
        new Chart(barChartCtx, {
            type: "doughnut",
            data: {
                labels: ["Remaining Budget", "Expenses Within Budget", "Expenses Over Budget"],
                datasets: [
                    {
                        label: "Budget (In PHP)",
                        data: [
                            <?php echo $remainingBudget; ?>, 
                            <?php echo $expensesWithinBudget; ?>, 
                            <?php echo $expensesOverBudget; ?>
                        ],
                        backgroundColor: [
                            "green",
                            "red",
                            "darkred"
                        ]
                    },
                ],
            },
        });
    </script>
</body>

</html>