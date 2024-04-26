<?php
session_start();
require_once "includes/accept-invitation.inc.php";

// Check if user is linked to event
if (isset($user)) {
    $message = "You have successfully accepted the invitation to manage the event: " . $row['events_name'];
} else {
    $message = "The invitation could not be accepted. Please make sure you have an account with the email address the invitation was sent to.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accept Invitation</title>
    <?php include "templates/external-links.tpl.php"; ?>
</head>

<body>
    <?php include 'templates/header.tpl.php'; ?>
    <main>
        <section class="section-container">
            <h1>Accept Invitation</h1>
            <p><?php echo $message; ?></p>
        </section>
    </main>
    <?php include 'templates/footer.tpl.php'; ?>
</body>

</html>