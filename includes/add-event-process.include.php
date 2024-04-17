<?php
include "../classes/db-connection.class.php";
include "../classes/event.class.php";

$title = htmlspecialchars($_POST['title'], ENT_QUOTES, 'UTF-8');
$description = htmlspecialchars($_POST['description'], ENT_QUOTES, 'UTF-8');
$date = htmlspecialchars($_POST['date'], ENT_QUOTES, 'UTF-8');
$time = htmlspecialchars($_POST['time'], ENT_QUOTES, 'UTF-8');
$location = htmlspecialchars($_POST['location'], ENT_QUOTES, 'UTF-8');

$event = new Event($title, $description, $date, $time, $location);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $event->addEvent($_POST['title'], $_POST['description'], $_POST['date'], $_POST['time'], $_POST['location']);
    echo "Event added successfully!";
}
?>