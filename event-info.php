<?php
session_start();
require_once 'includes/db-connection.inc.php';

$eventId = $_GET['events_id'];
$sql = "SELECT * FROM events WHERE events_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $eventId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
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
    <?php include 'templates/header.tpl.php'; ?>
    <main>
        <section>
            <h2><?php echo $row['events_name']; ?></h2>
            <p>Expenses: <?php echo $row['expenses']; ?></p>
            <p>Income: <?php echo $row['income']; ?></p>
            <p>Budget: <?php echo $row['events_budget']; ?></p>
        </section>
    </main>
    <?php include 'templates/footer.tpl.php'; ?>
</body>

</html>