<?php
session_start();
require_once "EventController.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $eventController = new EventController();
    $userId = $_SESSION["users_id"]; // assuming the user ID is stored in the session
    $eventName = $_POST["event_name"];
    $eventDescription = $_POST["event_description"];
    $eventDate = $_POST["event_date"];
    $eventBudget = $_POST["event_budget"];

    $eventController->createEvent($userId, $eventName, $eventDescription, $eventDate, $eventBudget);

    header("Location: events_overview.php");
    exit();
}
?>

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