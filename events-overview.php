<?php
session_start();
require_once 'includes/db-connection.inc.php';

$userId = $_SESSION["users_id"];
$sql = "SELECT events.events_id, events.events_name, events.events_description, events.events_date, events.events_budget FROM events JOIN event_users ON events.events_id = event_users.events_id WHERE event_users.users_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $userId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events Overview</title>
    <?php include "templates/external-links.tpl.php"; ?>
</head>

<body>
    <?php include 'templates/header.tpl.php'; ?>
    <main>
        <section>
            <h1>Events Overview</h1>
            <a href="create-event.php">Create Event</a>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div>
                    <h2><a href="event-dashboard.php?events_id=<?php echo $row['events_id']; ?>"><?php echo $row['events_name']; ?></a></h2>
                    <p><?php echo $row['events_description']; ?></p>
                    <p>Date: <?php echo $row['events_date']; ?></p>
                    <p>Budget: <?php echo $row['events_budget']; ?></p>
                </div>
            <?php endwhile; ?>
        </section>
    </main>
    <?php include 'templates/footer.tpl.php'; ?>
</body>

</html>