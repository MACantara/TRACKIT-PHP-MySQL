<?php
session_start();
require_once "includes/event-invitation.inc.php";

require_once "includes/user-functions.inc.php";
checkSessionTimeout();

$action = $_GET['action'] ?? null;

// Check if user is linked to event
if (isset($user)) {
    if ($action === 'accept') {
        $message = "You have successfully accepted the invitation to manage the event: " . $row['events_name'];
    } elseif ($action === 'reject') {
        $message = "You have successfully rejected the invitation to manage the event: " . $row['events_name'];
    } else {
        $message = "Invalid action.";
    }
} else {
    $message = "The invitation could not be processed. Please make sure you have an account with the email address the invitation was sent to.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "templates/meta-tags.tpl.php"; ?>
    <title>Event Invitation</title>
    <?php include "templates/external-links.tpl.php"; ?>
</head>

<body>
    <?php include 'templates/header.tpl.php'; ?>
    <main>
        <section class="section-container">
            <h1>Event Invitation</h1>
            <p class="event-invitation-message"><?php echo $message; ?></p>
            <?php if ($action === 'accept'): ?>
                <a href="events-overview.php" class="button">
                    <i class="bi bi-arrow-left"></i> Return to Event Overview
                </a>
                <a href="event-dashboard.php?events_id=<?php echo $eventId; ?>" class="button">
                    <i class="bi bi-eye"></i> View Event
                </a>
                <?php elseif ($action === 'reject'): ?>
                <a href="events-overview.php" class="button">
                    <i class="bi bi-arrow-left"></i> Return to Event Overview
                </a>
            <?php endif; ?>
        </section>
    </main>
    <?php include 'templates/footer.tpl.php'; ?>
</body>

</html>