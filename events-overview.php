<?php
session_start();
require_once "classes/EventController.php";

$eventController = new EventController();
$events = $eventController->getEventsByUserId($userId); // replace $userId with the actual user ID

echo '<div class="grid-container">';
foreach ($events as $event) {
    echo '<div class="grid-item">';
    echo '<h2>' . $event['event_name'] . '</h2>';
    echo '<p>' . $event['event_description'] . '</p>';
    echo '<p>Date: ' . $event['event_date'] . '</p>';
    echo '<p>Budget: ' . $event['event_budget'] . '</p>';
    echo '</div>';
}
echo '</div>';