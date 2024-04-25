<?php
session_start();
require_once 'includes/db-connection.inc.php';

$eventId = $_GET['events_id'];

// Fetch transactions
$sql = "SELECT * FROM transaction_history WHERE events_id = ? ORDER BY transaction_date DESC";
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
    <?php include "templates/event-sidebar-navigation.tpl.php"; ?>
    <main>
        <section>
            <form action="includes/report-generation.inc.php?events_id=<?php echo $eventId; ?>" method="post">
                <input type="hidden" name="event_id" value="<?php echo $eventId; ?>">
                <button type="submit" name="generate-report">Generate Report</button>
            </form>
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
</body>

</html>