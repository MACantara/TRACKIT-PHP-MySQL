<?php
session_start();
require_once 'includes/db-connection.inc.php';
require_once "includes/event-functions.inc.php";

$eventId = isset($_GET['events_id']) ? $_GET['events_id'] : null;
$userId = $_SESSION['users_id'];

$categories = getCategories($conn, $eventId);
date_default_timezone_set('Asia/Manila');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Transaction</title>
    <?php include "templates/external-links.tpl.php"; ?>
</head>

<body>
    <?php include 'templates/header.tpl.php'; ?>
    <main>
        <section class="section-container">
            <h1>Add Transaction</h1>
            <form action="includes/add-transaction.inc.php" method="post">
                <label for="transaction_name">Transaction Name:</label>
                <input type="text" id="transaction_name" name="transaction_name">
                <label for="transaction_description">Description:</label>
                <input type="text" id="transaction_description" name="transaction_description">
                <label for="transaction_date">Date:</label>
                <input type="date" id="transaction_date" name="transaction_date" value="<?php echo date('Y-m-d'); ?>">
                <label for="transaction_time">Time:</label>
                <input type="time" id="transaction_time" name="transaction_time" value="<?php echo date('H:i'); ?>">
                <label for="transaction_amount">Amount:</label>
                <input type="number" id="transaction_amount" name="transaction_amount" min="0">
                <label for="transaction_price">Price:</label>
                <input type="number" id="transaction_price" name="transaction_price" min="0">
                <label for="transaction_category">Category:</label>
                <select id="transaction_category" name="transaction_category">
                    <option value="" selected disabled>Select a category</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category['transaction_category']; ?>">
                            <?php echo $category['transaction_category']; ?></option>
                    <?php endforeach; ?>
                    <option value="other">Other...</option>
                </select>
                <input class="margin-top-16" type="text" id="new_transaction_category" name="new_transaction_category"
                    placeholder="Enter new category" style="display: none;">
                <label for="transaction_type">Type:</label>
                <select id="transaction_type" name="transaction_type">
                    <option value="expense">Expense</option>
                    <option value="income">Income</option>
                </select>
                <input type="hidden" id="events_id" name="events_id" value="<?php echo $eventId; ?>">
                <input type="hidden" id="users_id" name="users_id" value="<?php echo $userId; ?>">
                <div class="two-grid-column-container">
                    <a class="button margin-top-16" href="event-dashboard.php?events_id=<?php echo $eventId; ?>"><i class="bi bi-arrow-left"></i> Back</a>
                    <button class="button margin-top-16" type="submit" name="add-transaction-submit"><i class="bi bi-plus-circle"></i> Add Transaction</button>
                </div>
            </form>
            <?php
            if (isset($_GET['error'])) {
                if ($_GET['error'] == 'emptyfields') {
                    echo '<p class="error">Please fill in all fields.</p>';
                } elseif ($_GET['error'] == 'nametoolong') {
                    echo '<p class="error">The transaction name is too long.</p>';
                } elseif ($_GET['error'] == 'invalidamount') {
                    echo '<p class="error">The amount should be a number.</p>';
                } elseif ($_GET['error'] == 'invalidprice') {
                    echo '<p class="error">The price should be a number.</p>';
                } elseif ($_GET['error'] == 'invalidtype') {
                    echo '<p class="error">The transaction type is invalid.</p>';
                }
            }
            ?>
        </section>
    </main>
    <?php include 'templates/footer.tpl.php'; ?>
    <script src="static/js/add-transaction.js"></script>
</body>

</html>