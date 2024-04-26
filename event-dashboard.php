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
                        <td><?php echo $transaction['transaction_amount']; ?></td>
                        <td><?php echo $transaction['transaction_price']; ?></td>
                        <td><?php echo $transaction['transaction_total']; ?></td>
                        <td><?php echo $transaction['transaction_category']; ?></td>
                        <td><?php echo $transaction['transaction_type']; ?></td>
                        <td><?php echo $transaction['transaction_description']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </section>
    </main>
    <?php include 'templates/footer.tpl.php'; ?>
    <script>
        // Pie chart 1
        const pieChart1Ctx = document.getElementById('pieChart1').getContext('2d');
        new Chart(pieChart1Ctx, {
            type: 'pie',
            data: {
                labels: ['Red', 'Blue', 'Yellow'],
                datasets: [{
                    data: [300, 50, 100],
                    backgroundColor: ['rgb(255, 99, 132)', 'rgb(54, 162, 235)', 'rgb(255, 205, 86)']
                }]
            },
            options: {
                responsive: true,
            }
        });
        
        // Pie chart 2
        const pieChart2Ctx = document.getElementById('pieChart2').getContext('2d');
        new Chart(pieChart2Ctx, {
            type: 'pie',
            data: {
                labels: ['Green', 'Purple', 'Orange'],
                datasets: [{
                    data: [200, 150, 50],
                    backgroundColor: ['rgb(75, 192, 192)', 'rgb(153, 102, 255)', 'rgb(255, 159, 64)']
                }]
            },
            options: {
                responsive: true,
            }
        });
        
        // Bar chart
        const barChartCtx = document.getElementById('barChart').getContext('2d');
        new Chart(barChartCtx, {
            type: 'bar',
            data: {
                labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                datasets: [{
                    label: '# of Votes',
                    data: [12, 19, 3, 5, 2, 3],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>

</html>