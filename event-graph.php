<?php
session_start();
require_once 'includes/db-connection.inc.php';

$eventId = $_GET['events_id'];
$sql = "SELECT * FROM transactions WHERE events_id = ? AND transaction_date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $eventId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$transactions = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <?php include "templates/external-links.tpl.php"; ?>
</head>

<body>
    <?php include 'templates/header.tpl.php'; ?>
    <main>
        <section>
<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<canvas id="eventGraph"></canvas>

<script>
var ctx = document.getElementById('eventGraph').getContext('2d');
var chart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['7 days ago', '6 days ago', '5 days ago', '4 days ago', '3 days ago', '2 days ago', 'Yesterday', 'Today'],
        datasets: [{
            label: 'Expenses',
            data: <?php echo json_encode(array_column($transactions, 'expenses')); ?>,
            borderColor: 'rgb(255, 99, 132)',
            fill: false
        }, {
            label: 'Income',
            data: <?php echo json_encode(array_column($transactions, 'income')); ?>,
            borderColor: 'rgb(75, 192, 192)',
            fill: false
        }, {
            label: 'Budget',
            data: <?php echo json_encode(array_column($transactions, 'budget')); ?>,
            borderColor: 'rgb(153, 102, 255)',
            fill: false
        }]
    }
});
</script>
        </section>
    </main>
    <?php include 'templates/footer.tpl.php'; ?>
</body>

</html>