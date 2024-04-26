<?php
session_start();

require_once 'includes/event-functions.inc.php';

$events_id = $_GET['events_id'];
$event = getEvent($conn, $events_id);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Event</title>
    <?php include "templates/external-links.tpl.php"; ?>
</head>

<body>
    <?php include 'templates/header.tpl.php'; ?>
    <main>
        <section class="section-container">
            <h1>Update Event</h1>
            <form method="post" action="includes/update-event.inc.php">
                <input type="hidden" name="events_id" value="<?php echo $events_id; ?>">

                <label for="event_name">Event Name:</label>
                <input type="text" id="event_name" name="event_name" value="<?php echo $event['events_name']; ?>" required>

                <label for="event_description">Event Description:</label>
                <textarea id="event_description" name="event_description" required><?php echo $event['events_description']; ?></textarea>

                <label for="event_date">Event Date:</label>
                <input type="date" id="event_date" name="event_date" value="<?php echo $event['events_date']; ?>" required>

                <label for="event_budget">Event Budget:</label>
                <input type="number" id="event_budget" name="event_budget" value="<?php echo $event['events_budget']; ?>" required>

                <div class="two-grid-column-container">
                    <a class="button margin-top-16" href="events-overview.php">Back</a>
                    <button class="button margin-top-16" type="submit" name="update-event">Update Event</button>
                </div>
            </form>
        </section>
    </main>
    <?php include 'templates/footer.tpl.php'; ?>
</body>

</html>