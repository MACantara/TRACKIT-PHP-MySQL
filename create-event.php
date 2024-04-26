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
    <title>Create New Event</title>
    <?php include "templates/external-links.tpl.php"; ?>
</head>

<body>
    <?php include 'templates/header.tpl.php'; ?>
    <main>
        <section class="section-container">
            <h1>Create a New Event</h1>
            <form method="post" action="create-event.php">
                <label for="event_name">Event Name:</label>
                <input type="text" id="event_name" name="event_name" required>

                <label for="event_description">Event Description:</label>
                <textarea id="event_description" name="event_description" required></textarea>

                <label for="event_date">Event Date:</label>
                <input type="date" id="event_date" name="event_date" required>

                <label for="event_time">Event Time:</label>
                <input type="time" id="event_time" name="event_time" required>

                <label for="event_budget">Event Budget:</label>
                <input type="number" id="event_budget" name="event_budget" required>

                <div class="two-grid-column-container">
                    <a class="button margin-top-16" href="events-overview.php">Back</a>
                    <button class="button margin-top-16" type="submit" name="create-event">Create Event</button>
                </div>
            </form>
            <?php
            if (isset($_GET["error"])) {
                if ($_GET["error"] == "emptyinput") {
                    echo "<p class='error-message'>Please fill in all fields!</p>";
                } else if ($_GET["error"] == "eventnametaken") {
                    echo "<p class='error-message'>Event name already taken!</p>";
                } else if ($_GET["error"] == "toolongeventname") {
                    echo "<p class='error-message'>Event name too long!</p>";
                } else if ($_GET["error"] == "invalideventdate") {
                    echo "<p class='error-message'>Invalid event date!</p>";
                } else if ($_GET["error"] == "invalideventtime") {
                    echo "<p class='error-message'>Invalid event time!</p>";
                } else if ($_GET["error"] == "invalideventbudget") {
                    echo "<p class='error-message'>Invalid event budget!</p>";
                } else if ($_GET["error"] == "stmtfailed") {
                    echo "<p class='error-message'>Something went wrong. Please try again!</p>";
                } else if ($_GET["error"] == "none") {
                    echo "<p class='success-message'>Event created successfully!</p>";
                }
            }
            ?>
        </section>
    </main>
    <?php include 'templates/footer.tpl.php'; ?>
</body>

</html>