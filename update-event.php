<?php
session_start();

require_once 'includes/event-functions.inc.php';
require_once "includes/db-connection.inc.php";

$eventsId = $_GET['events_id'];
$event = getEvent($conn, $eventsId);

// Fetch data from objectives table
$sql = "SELECT objectives.* FROM objectives
        JOIN event_objectives ON objectives.objectives_id = event_objectives.objectives_id
        WHERE event_objectives.events_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $eventsId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$objectives = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Fetch data from problems_encountered table
$sql = "SELECT problems_encountered.* FROM problems_encountered
        JOIN event_problems_encountered ON problems_encountered.problems_encountered_id = event_problems_encountered.problems_encountered_id
        WHERE event_problems_encountered.events_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $eventsId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$problemsEncountered = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Fetch data from actions_taken table
$sql = "SELECT actions_taken.* FROM actions_taken
        JOIN event_actions_taken ON actions_taken.actions_taken_id  = event_actions_taken.actions_taken_id
        WHERE event_actions_taken.events_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $eventsId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$actionsTaken = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Fetch data from recommendations table
$sql = "SELECT recommendations.* FROM recommendations
        JOIN event_recommendations ON recommendations.recommendations_id = event_recommendations.recommendations_id
        WHERE event_recommendations.events_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $eventsId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$recommendations = mysqli_fetch_all($result, MYSQLI_ASSOC);

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
    <?php include 'templates/generate-summary-report-modal.tpl.php'; ?>
    <main>
        <section class="section-container">
            <h1>Update Event</h1>
            <form method="post" action="includes/update-event.inc.php" enctype="multipart/form-data">
                <input type="hidden" name="events_id" value="<?php echo $eventsId; ?>">

                <label for="events_name">Event Name:</label>
                <input type="text" id="events_name" name="events_name" value="<?php echo $event['events_name']; ?>"
                    required>

                <label for="events_semester">Event Semester:</label>
                <select name="events_semester" id="events_semester">
                    <option value="" disabled <?php echo ($event['events_semester'] != '1st Semester' && $event['events_semester'] != '2nd Semester') ? 'selected' : ''; ?>>Select a Semester</option>
                    <option value="1st Semester" <?php echo $event['events_semester'] == '1st Semester' ? 'selected' : ''; ?>>1st Semester</option>
                    <option value="2nd Semester" <?php echo $event['events_semester'] == '2nd Semester' ? 'selected' : ''; ?>>2nd Semester</option>
                </select>
                
                <?php
                    $sql = "SELECT DISTINCT events_academic_year FROM events ORDER BY events_academic_year DESC";
                    $result = mysqli_query($conn, $sql);
                    $years = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    $selectedYear = null;
                ?>
                <label for="events_academic_year">Event Academic Year:</label>
                <select id="events_academic_year" name="events_academic_year" onchange="checkOther(this)">
                    <option value="" disabled <?php echo is_null($selectedYear) ? 'selected' : ''; ?>>Select an Academic Year</option>
                    <?php foreach ($years as $year): ?>
                        <?php if (!empty($year['events_academic_year'])): ?>
                            <option value="<?php echo $year['events_academic_year']; ?>" <?php echo $year['events_academic_year'] == $event['events_academic_year'] ? 'selected' : ''; ?>><?php echo $year['events_academic_year']; ?></option>
                            <?php
                                if ($year['events_academic_year'] == $event['events_academic_year']) {
                                    $selectedYear = $year['events_academic_year'];
                                }
                            ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <option value="other">Other</option>
                </select>
                
                <div id="otherInput" style="display: none;">
                    <label for="other_academic_year">Enter New Academic Year:</label>
                    <input type="text" id="other_academic_year" name="other_academic_year"
                        oninput="validateYearFormat(this)" onkeyup="formatYear(this)">
                    <p id="error-message" style="color: red; display: none;">Invalid format. Please use the format:
                        YYYY-YYYY</p>
                </div>

                <script>
                    function checkOther(select) {
                        var otherInput = document.getElementById('otherInput');
                        if (select.value == 'other') {
                            otherInput.style.display = 'block';
                        } else {
                            otherInput.style.display = 'none';
                        }
                    }

                    function validateYearFormat(input) {
                        var format = /^\d{4}-\d{4}$/;
                        var errorMessage = document.getElementById('error-message');
                        if (!format.test(input.value)) {
                            errorMessage.style.display = 'block';
                        } else {
                            errorMessage.style.display = 'none';
                        }
                    }

                    function formatYear(input) {
                        var value = input.value;
                        value = value.replace(/[^0-9]/g, ''); // Remove non-numeric characters
                        if (value.length > 4) {
                            value = value.slice(0, 4) + '-' + value.slice(4);
                        }
                        if (value.length > 9) {
                            value = value.slice(0, 9);
                        }
                        input.value = value;
                    }
                </script>

                <label for="events_start_date">Event Start Date and Time:</label>
                <input type="datetime-local" id="events_start_date" name="events_start_date"
                    value="<?php echo date('Y-m-d\TH:i', strtotime($event['events_start_date'])); ?>" required>

                <label for="events_end_date">Event End Date and Time:</label>
                <input type="datetime-local" id="events_end_date" name="events_end_date"
                    value="<?php echo date('Y-m-d\TH:i', strtotime($event['events_end_date'])); ?>" required>

                <label for="events_venue">Event Venue:</label>
                <input type="text" id="events_venue" name="events_venue" value="<?php echo $event['events_venue']; ?>"
                    required>

                <label for="events_budget">Event Budget:</label>
                <input type="number" id="events_budget" name="events_budget"
                    value="<?php echo $event['events_budget']; ?>" required>

                <label for="events_status">Event Status:</label>
                <select id="events_status" name="events_status" required>
                    <option value="" disabled>Select an Event Status</option>
                    <option value="Upcoming" <?php echo $event['events_status'] == 'Upcoming' ? 'selected' : ''; ?>>
                        Upcoming</option>
                    <option value="Ongoing" <?php echo $event['events_status'] == 'Ongoing' ? 'selected' : ''; ?>>Ongoing
                    </option>
                    <option value="Done" <?php echo $event['events_status'] == 'Done' ? 'selected' : ''; ?>>Done</option>
                    <option value="Canceled" <?php echo $event['events_status'] == 'Canceled' ? 'selected' : ''; ?>>
                        Canceled</option>
                </select>

                <label for="events_description">Event Description:</label>
                <textarea id="events_description" name="events_description"
                    required><?php echo $event['events_description']; ?></textarea>

                <label for="events_objectives">Event Objectives</label>
                <div id="events_objectives">
                    <?php foreach ($objectives as $objective): ?>
                        <textarea
                            name="events_objectives[<?php echo $objective['objectives_id']; ?>]"><?php echo $objective['objectives_name']; ?></textarea>
                    <?php endforeach; ?>
                </div>
                <button class="secondary-outline-button" type="button" onclick="addInput('events_objectives')">
                    <i class="bi bi-plus-circle"></i> Add another objective
                </button>

                <label for="events_problems_encountered">Event Problems Encountered</label>
                <div id="events_problems_encountered">
                    <?php foreach ($problemsEncountered as $problem): ?>
                        <textarea
                            name="events_problems_encountered[<?php echo $problem['problems_encountered_id']; ?>]"><?php echo $problem['problems_encountered_name']; ?></textarea>
                    <?php endforeach; ?>
                </div>
                <button class="secondary-outline-button" type="button" onclick="addInput('events_problems_encountered')">
                    <i class="bi bi-plus-circle"></i> Add another problem
                </button>

                <label for="events_actions_taken">Event Actions Taken</label>
                <div id="events_actions_taken">
                    <?php foreach ($actionsTaken as $action): ?>
                        <textarea
                            name="events_actions_taken[<?php echo $action['actions_taken_id']; ?>]"><?php echo $action['actions_taken_name']; ?></textarea>
                    <?php endforeach; ?>
                </div>
                <button class="secondary-outline-button" type="button" onclick="addInput('events_actions_taken')">
                    <i class="bi bi-plus-circle"></i> Add another action
                </button>

                <label for="events_recommendations">Event Recommendations</label>
                <div id="events_recommendations">
                    <?php foreach ($recommendations as $recommendation): ?>
                        <textarea
                            name="events_recommendations[<?php echo $recommendation['recommendations_id']; ?>]"><?php echo $recommendation['recommendations_name']; ?></textarea>
                    <?php endforeach; ?>
                </div>
                <button class="secondary-outline-button" type="button" onclick="addInput('events_recommendations')">
                    <i class="bi bi-plus-circle"></i> Add another recommendation
                </button>

                <script>
                    function addInput(id) {
                        var input = document.createElement("textarea");
                        input.name = id + "[]";
                        document.getElementById(id).appendChild(input);
                    }
                </script>

                <label for="events_remarks">Event Remarks:</label>
                <input type="text" id="events_remarks" name="events_remarks"
                    value="<?php echo $event['events_remarks']; ?>">

                <?php
                // Fetch the documentation pictures for the event
                $sql = "SELECT documentation_pictures.documentation_pictures_item
                        FROM documentation_pictures
                        INNER JOIN event_documentation_pictures ON documentation_pictures.documentation_pictures_id = event_documentation_pictures.documentation_pictures_id
                        WHERE event_documentation_pictures.events_id = '$eventsId'";
                $result = mysqli_query($conn, $sql);
                $pictures = mysqli_fetch_all($result, MYSQLI_ASSOC);
                ?>
                
                <label for="events_documentation_pictures">Event Documentation Pictures:</label>
                <input type="file" id="events_documentation_pictures" name="events_documentation_pictures[]" multiple>
                
                <!-- Display the existing pictures -->
                <div id="existing_pictures">
                    <?php foreach ($pictures as $picture): ?>
                        <?php $src = strstr($picture['documentation_pictures_item'], 'static/img/'); ?>
                        <img src="<?php echo $src; ?>" alt="Event Picture" width="277" height="227" style="border-radius: 8px;">
                    <?php endforeach; ?>
                </div>

                <div class="two-grid-column-container">
                    <a class="secondary-outline-button margin-top-16" href="events-overview.php"><i class="bi bi-arrow-left"></i> Back</a>
                    <button class="button margin-top-16" type="submit" name="update-event"><i class="bi bi-save"></i>
                        Update Event</button>
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