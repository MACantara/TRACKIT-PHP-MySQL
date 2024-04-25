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
    <?php include "templates/event-sidebar-navigation.tpl.php"; ?>
    <main>
        <section>
        </section>
    </main>
    <?php include 'templates/footer.tpl.php'; ?>
</body>

</html>