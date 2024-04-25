<?php
session_start();
require_once 'includes/db-connection.inc.php';
require_once "includes/event-functions.inc.php";

$eventId = isset($_GET['events_id']) ? $_GET['events_id'] : null;
$userId = $_SESSION['users_id'];

$categories = getCategories($conn, $eventId);
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
            <h2>Add Transaction</h2>
            <form action="includes/add-transaction.inc.php" method="post">
                <label for="transaction_name">Transaction Name:</label><br>
                <input type="text" id="transaction_name" name="transaction_name"><br>
                <label for="transaction_description">Description:</label><br>
                <input type="text" id="transaction_description" name="transaction_description"><br>
                <label for="transaction_date">Date:</label><br>
                <input type="date" id="transaction_date" name="transaction_date"><br>
                <label for="transaction_amount">Amount:</label><br>
                <input type="number" id="transaction_amount" name="transaction_amount" min="0"><br>
                <label for="transaction_price">Price:</label><br>
                <input type="number" id="transaction_price" name="transaction_price" min="0"><br>
                <label for="transaction_category">Category:</label><br>
                <select id="transaction_category" name="transaction_category">
                    <option value="" selected disabled>Select a category</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category['transaction_category']; ?>">
                            <?php echo $category['transaction_category']; ?></option>
                    <?php endforeach; ?>
                    <option value="other">Other...</option>
                </select><br>
                <input type="text" id="new_transaction_category" name="new_transaction_category"
                    placeholder="Enter new category" style="display: none;"><br>
                <label for="transaction_type">Type:</label><br>
                <select id="transaction_type" name="transaction_type">
                    <option value="expense">Expense</option>
                    <option value="income">Income</option>
                </select><br>
                <input type="hidden" id="events_id" name="events_id" value="<?php echo $eventId; ?>">
                <input type="hidden" id="users_id" name="users_id" value="<?php echo $userId; ?>">
                <button type="submit" class="button">Add Transaction</button>
            </form>
        </section>
    </main>
    <?php include 'templates/footer.tpl.php'; ?>
    <script src="static/js/add-transaction.js"></script>
</body>

</html>