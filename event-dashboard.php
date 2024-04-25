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
</head>

<body>
    <?php include "templates/header.tpl.php"; ?>

    <main>
        <a href="events-overview.php">Back to Events Overview</a>
        <a href="add-transaction.php?events_id=<?php echo $eventId; ?>">Add Transaction</a>
        <form action="includes/report-generation.inc.php?events_id=<?php echo $eventId; ?>" method="post">
                <input type="hidden" name="event_id" value="<?php echo $eventId; ?>">
                <button type="submit" name="generate-report">Generate Report</button>
            </form>
        <section>
            <h2><?php echo $row['events_name']; ?></h2>
            <p>Budget: <?php echo $row['events_budget']; ?></p>
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
</body>

</html>