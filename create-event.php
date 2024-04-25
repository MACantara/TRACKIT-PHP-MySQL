<?php
session_start();

require_once 'includes/event-functions.inc.php';

handleCreateEvent($conn);
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
            <h1>Create a New Event</h1>
            <form method="post" action="create-event.php">
                <label for="event_name">Event Name:</label>
                <input type="text" id="event_name" name="event_name" required>

                <label for="event_description">Event Description:</label>
                <textarea id="event_description" name="event_description" required></textarea>

                <label for="event_date">Event Date:</label>
                <input type="date" id="event_date" name="event_date" required>

                <label for="event_budget">Event Budget:</label>
                <input type="number" id="event_budget" name="event_budget" required>

                <input type="submit" value="Create Event">
            </form>
        </section>
    </main>
    <?php include 'templates/footer.tpl.php'; ?>
</body>

</html>