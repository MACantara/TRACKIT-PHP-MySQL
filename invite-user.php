<?php
session_start();
require_once "includes/event-functions.inc.php";
$eventId = $_GET['events_id'];
$row = getEvent($conn, $eventId);
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
        <section>
            <h1>Invite a User to Manage <?php echo $row['events_name']; ?></h1>
            <p>Enter the email address of the user you would like to invite.</p>
            <form action="includes/invite-user.inc.php" method="post">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Enter your email" required><br>
                <input type="hidden" name="events_id" value="<?php echo $eventId; ?>">
                <button class="button" type="submit" name="Send Invite">Send Invite</button>
            </form>
            <?php
            if (isset($_GET["reset"])) {
                if ($_GET["reset"] == "success") {
                    echo "<p class='success-message'>Invite sent!</p>";
                }
            }
            ?>
        </section>
    </main>
    <?php include 'templates/footer.tpl.php'; ?>
</body>

</html>