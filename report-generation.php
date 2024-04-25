<?php
session_start();
require_once 'includes/db-connection.inc.php';

$eventId = $_GET['events_id'];
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
            <h2>Generate Report</h2>

            <form action="generate-report.php" method="post">
                <input type="hidden" name="events_id" value="<?php echo $eventId; ?>">
                <input type="submit" value="Generate Report">
            </form>
        </section>
    </main>
    <?php include 'templates/footer.tpl.php'; ?>
</body>

</html>