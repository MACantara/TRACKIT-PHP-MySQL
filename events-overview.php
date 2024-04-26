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
        <section class="section-container">
            <h1>Events Overview</h1>
            <div class="button-container">
                <a class="button margin-top-16" href="create-event.php">Create New Event</a>
            </div>
        </section>
        <div class="events-grid">
            <?php foreach ($events as $event): ?>
                <section>
                    <div>
                        <h2><a href="event-dashboard.php?events_id=<?php echo $event['events_id']; ?>"><?php echo $event['events_name']; ?></a></h2>
                        <p><?php echo $event['events_description']; ?></p>
                        <p class="margin-top-16">Date: <?php echo date('F j, Y', strtotime($event['events_date'])); ?> <?php echo date('h:i A', strtotime($event['events_date'])); ?></p>
                        <p>Budget: &#8369; <?php echo number_format($event['events_budget'], 2); ?></p>
                        <div class="grid-container">
                            <a class="button button-primary margin-top-16" href="event-dashboard.php?events_id=<?php echo $event['events_id']; ?>">View</a>
                            <a class="button secondary-outline-button margin-top-16" href="update-event.php?events_id=<?php echo $event['events_id']; ?>">Update</a>
                            <a class="button secondary-outline-button margin-top-16" href="invite-user.php?events_id=<?php echo $event['events_id']; ?>">Invite</a>
                        </div>
                        <form method="post" action="includes/delete-event.inc.php">
                            <input type="hidden" name="events_id" value="<?php echo $event['events_id']; ?>">
                            <button type="submit" class="button button-outline-danger margin-top-16">Delete</button>
                        </form>
                    </div>
                </section>
            <?php endforeach; ?>
        </div>
    </main>
    <?php include 'templates/footer.tpl.php'; ?>
</body>

</html>