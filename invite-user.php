<?php
session_start();
require_once "includes/event-functions.inc.php";
$eventsId = $_GET['events_id'];
$row = getEvent($conn, $eventsId);

require_once 'includes/user-functions.inc.php';
require_login();
checkSessionTimeout();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invite User</title>
    <?php include "templates/external-links.tpl.php"; ?>
</head>

<body>
    <?php include 'templates/header.tpl.php'; ?>
    <main>
        <section class="section-container">
            <h1>Invite a User</h1>
            <p class="margin-top-16">Enter the email address of the user you would like to invite to help you manage <?php echo $row['events_name']; ?>.</p>
            <form class="margin-top-16" action="includes/invite-user.inc.php" method="post">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Enter your email" required>
                <input type="hidden" name="events_id" value="<?php echo $eventsId; ?>">
                <div class="two-grid-column-container">
                    <a class="button" href="event-dashboard.php?events_id=<?php echo $eventsId; ?>"><i class="bi bi-arrow-left"></i> Back</a>
                    <button class="button" type="submit" name="Send Invite"><i class="bi bi-envelope"></i> Send Invite</button>
                </div>
            </form>
            <?php
            if (isset($_GET['error'])) {
                if ($_GET['error'] == "none") {
                    echo "<p class='success-message'>The event management invite has been sent!</p>";
                } else if ($_GET['error'] == "userexistasmanager") {
                    echo "<p class='error-message'>User is already a manager!</p>";
                } else if ($_GET['error'] == "userinviteexists") {
                    echo "<p class='error-message'>User already invited!</p>";
                } 
            }
            ?>
        </section>
    </main>
    <?php include 'templates/footer.tpl.php'; ?>
</body>

</html>