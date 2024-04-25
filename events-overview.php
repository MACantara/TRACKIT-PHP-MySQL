<?php
session_start();
require_once 'includes/db-connection.inc.php';
require_once 'includes/event-functions.inc.php';

$userId = $_SESSION["users_id"];
$events = getUserEvents($conn, $userId);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events Overview</title>
    <?php include "templates/external-links.tpl.php"; ?>
</head>

<body>
    <?php include 'templates/header.tpl.php'; ?>
    <main>
        <section>
            <h1>Events Overview</h1>
            <a href="create-event.php">Create Event</a>
            <?php foreach ($events as $event): ?>
                <div>
                    <h2><a
                            href="event-dashboard.php?events_id=<?php echo $event['events_id']; ?>"><?php echo $event['events_name']; ?></a>
                    </h2>
                    <p><?php echo $event['events_description']; ?></p>
                    <p>Date: <?php echo $event['events_date']; ?></p>
                    <p>Budget: <?php echo $event['events_budget']; ?></p>
                </div>
            <?php endforeach; ?>
        </section>
    </main>
    <?php include 'templates/footer.tpl.php'; ?>
</body>

</html>