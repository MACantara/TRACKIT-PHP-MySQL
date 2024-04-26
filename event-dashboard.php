<?php
session_start();
require_once 'includes/db-connection.inc.php';
require_once 'includes/event-functions.inc.php';

$eventId = $_GET['events_id'];
$userId = $_SESSION["users_id"];

$row = getEvent($conn, $eventId);
$transactions = getTransactions($conn, $eventId);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Information</title>
    <?php include "templates/external-links.tpl.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <?php include "templates/header.tpl.php"; ?>

    <main>
        <div class="event-dashboard-buttons-container">
            <a class="secondary-outline-button" href="events-overview.php">Back to Events Overview</a>
            <a class="button" href="add-transaction.php?events_id=<?php echo $eventId; ?>">Add Transaction</a>
            <form action="includes/report-generation.inc.php?events_id=<?php echo $eventId; ?>" method="post">
                <input type="hidden" name="event_id" value="<?php echo $eventId; ?>">
                <button class="button" type="submit" name="generate-report">Generate Report</button>
            </form>
        </div>
        <section>
            <h2><?php echo $row['events_name']; ?></h2>
            <p>Budget: <?php echo $row['events_budget']; ?></p>
        </section>
        <section class="chart-container">
            <section>
                <canvas id="pieChart1"></canvas>
            </section>
            <section>
                <canvas id="pieChart2"></canvas>
            </section>
            <section>
                <canvas id="barChart"></canvas>
            </section>
        </section>
        <section class="one-column-grid-container">
            <h2>Transaction History</h2>
            <table>
                <tr>
                    <th>Date</th>
                    <th>Name</th>
                    <th>Amount</th>
                    <th>Price</th>
                    <th>Total</th>
                    <th>Category</th>
                    <th>Type</th>
                    <th>Description</th>
                </tr>
                <?php foreach ($transactions as $transaction): ?>
                    <tr>
                        <td><?php echo $transaction['transaction_date']; ?></td>
                        <td><?php echo $transaction['transaction_name']; ?></td>
                        <td><?php echo number_format($transaction['transaction_amount']); ?></td>
                        <td><?php echo 'PHP ' . number_format($transaction['transaction_price'], 2); ?></td>
                        <td><?php echo 'PHP ' . number_format($transaction['transaction_total'], 2); ?></td>
                        <td><?php echo $transaction['transaction_category']; ?></td>
                        <td><?php echo $transaction['transaction_type']; ?></td>
                        <td><?php echo $transaction['transaction_description']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </section>
    </main>
    <?php include 'templates/footer.tpl.php'; ?>
    <script src="static/js/event-dashboard-charts.js"></script>
</body>

</html>