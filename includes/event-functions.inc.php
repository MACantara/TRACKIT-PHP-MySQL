<?php
require_once 'event.inc.php';

function handleCreateEvent($conn) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $userId = $_SESSION["users_id"];
        $eventName = $_POST["event_name"];
        $eventDescription = $_POST["event_description"];
        $eventDate = $_POST["event_date"];
        $eventBudget = $_POST["event_budget"];

        createEvent($conn, $userId, $eventName, $eventDescription, $eventDate, $eventBudget);

        header("Location: events-overview.php");
        exit();
    }
}