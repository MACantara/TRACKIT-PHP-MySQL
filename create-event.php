<?php
session_start();

require_once 'includes/event-functions.inc.php';

handleCreateEvent($conn);

require_once 'includes/user-functions.inc.php';
requireLogin();
checkSessionTimeout();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "templates/meta-tags.tpl.php"; ?>
    <title>Create New Event</title>
    <?php include "templates/external-links.tpl.php"; ?>
</head>

<body>
    <?php include 'templates/header.tpl.php'; ?>
    <main>
        <section class="section-container">
            <h1>Create a New Event</h1>
            <form method="post" action="create-event.php" enctype="multipart/form-data">
                <label for="events_name">Event Name:</label>
                <input type="text" id="events_name" name="events_name" required>

                <label for="events_start_date">Event Start Date and Time:</label>
                <input type="datetime-local" id="events_start_date" name="events_start_date" required>

                <label for="events_end_date">Event End Date and Time:</label>
                <input type="datetime-local" id="events_end_date" name="events_end_date" required>

                <label for="events_venue">Event Venue:</label>
                <input type="text" id="events_venue" name="events_venue" required>

                <label for="events_budget">Event Budget:</label>
                <input type="number" id="events_budget" name="events_budget" required>

                <label for="events_status">Event Status:</label>
                <select id="events_status" name="events_status" required>
                    <option value="" selected disabled>Select an Event Status</option>
                    <option value="Upcoming">Upcoming</option>
                    <option value="Ongoing">Postponed</option>
                    <option value="Done">Done</option>
                    <option value="Canceled">Canceled</option>
                </select>

                <label for="events_description">Event Description:</label>
                <textarea id="events_description" name="events_description" required></textarea>
                <label for="events_objectives">Event Objectives</label>
                <div id="events_objectives">
                    <textarea name="events_objectives[]" placeholder="(Optional)"></textarea>
                </div>
                <button type="button" onclick="addInput('events_objectives')">Add another objective</button>

                <label for="events_problems_encountered">Event Problems Encountered</label>
                <div id="events_problems_encountered">
                    <textarea name="events_problems_encountered[]" placeholder="(Optional)"></textarea>
                </div>
                <button type="button" onclick="addInput('events_problems_encountered')">Add another problem</button>

                <label for="events_actions_taken">Event Actions Taken</label>
                <div id="events_actions_taken">
                    <textarea name="events_actions_taken[]" placeholder="(Optional)"></textarea>
                </div>
                <button type="button" onclick="addInput('events_actions_taken')">Add another action</button>

                <label for="events_recommendations">Event Recommendations</label>
                <div id="events_recommendations">
                    <textarea name="events_recommendations[]" placeholder="(Optional)"></textarea>
                </div>
                <button type="button" onclick="addInput('events_recommendations')">Add another recommendation</button>

                <script>
                function addInput(id) {
                    var input = document.createElement("textarea");
                    input.name = id + "[]";
                    input.placeholder = "(Optional)";
                    document.getElementById(id).appendChild(input);
                }
                </script>
                <label for="events_remarks">Event Remarks:</label>
                <input type="text" id="events_remarks" name="events_remarks" placeholder="(Optional)">

                <label for="events_documentation_pictures">Event Documentation Pictures:</label>
                <input type="file" id="events_documentation_pictures" name="events_documentation_pictures[]" multiple>

                <div class="two-grid-column-container">
                    <a class="button margin-top-16" href="events-overview.php"><i class="bi bi-arrow-left"></i> Back</a>
                    <button class="button margin-top-16" type="submit" name="create-event"><i class="bi bi-calendar-plus"></i> Create Event</button>
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