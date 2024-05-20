<?php
    session_start();

    require_once 'includes/event-functions.inc.php';

    $eventsId = $_GET['events_id'];
    $event = getEvent($conn, $eventsId);

    require_once 'includes/user-functions.inc.php';
    requireLogin();
    checkSessionTimeout();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "templates/meta-tags.tpl.php"; ?>
    <title>Update Event</title>
    <?php include "templates/external-links.tpl.php"; ?>
</head>

<body>
    <?php include 'templates/header.tpl.php'; ?>
    <main>
        <section class="section-container">
            <h1>Update Event</h1>
            <form method="post" action="includes/update-event.inc.php">
                <input type="hidden" name="events_id" value="<?php echo $eventsId; ?>">

                <label for="events_name">Event Name:</label>
                <input type="text" id="events_name" name="events_name" value="<?php echo $event['events_name']; ?>" required>

                <label for="events_start_date">Event Start Date and Time:</label>
                <input type="datetime-local" id="events_start_date" name="events_start_date" value="<?php echo date('Y-m-d\TH:i', strtotime($event['events_start_date'])); ?>" required>

                <label for="events_end_date">Event End Date and Time:</label>
                <input type="datetime-local" id="events_end_date" name="events_end_date" value="<?php echo date('Y-m-d\TH:i', strtotime($event['events_end_date'])); ?>" required>

                <label for="events_venue">Event Venue:</label>
                <input type="text" id="events_venue" name="events_venue" value="<?php echo $event['events_venue']; ?>" required>

                <label for="events_budget">Event Budget:</label>
                <input type="number" id="events_budget" name="events_budget" value="<?php echo $event['events_budget']; ?>" required>

                <label for="events_status">Event Status:</label>
                <select id="events_status" name="events_status" required>
                    <option value="" disabled>Select an Event Status</option>
                    <option value="Upcoming" <?php echo $event['events_status'] == 'Upcoming' ? 'selected' : ''; ?>>Upcoming</option>
                    <option value="Ongoing" <?php echo $event['events_status'] == 'Ongoing' ? 'selected' : ''; ?>>Ongoing</option>
                    <option value="Done" <?php echo $event['events_status'] == 'Done' ? 'selected' : ''; ?>>Done</option>
                    <option value="Canceled" <?php echo $event['events_status'] == 'Canceled' ? 'selected' : ''; ?>>Canceled</option>
                </select>

                <label for="events_description">Event Description:</label>
                <textarea id="events_description" name="events_description" required><?php echo $event['events_description']; ?></textarea>

                <label for="events_remarks">Event Remarks:</label>
                <input type="text" id="events_remarks" name="events_remarks" value="<?php echo $event['events_remarks']; ?>" placeholder="(Optional)">

                <label for="events_documentation_pictures">Event Documentation Pictures:</label>
                <input type="file" id="events_documentation_pictures" name="events_documentation_pictures" multiple>

                <div class="two-grid-column-container">
                    <a class="button margin-top-16" href="events-overview.php"><i class="bi bi-arrow-left"></i> Back</a>
                    <button class="button margin-top-16" type="submit" name="update-event"><i class="bi bi-save"></i> Update Event</button>
                </div>
            </form>
            <?php
                if (isset($_GET["error"])) {
                    if ($_GET["error"] == "stmtfailed") {
                        echo "<p class='error-message'>Something went wrong. Please try again!</p>";
                    } else if ($_GET["error"] == "none") {
                        echo "<p class='success-message'>Event updated successfully!</p>";
                    }
                }
            ?>
        </section>
    </main>
    <?php include 'templates/footer.tpl.php'; ?>
</body>

</html>