<?php
require_once "EventModel.php";

class EventController {
    private $eventModel;

    public function __construct() {
        $this->eventModel = new EventModel();
    }

    public function createEvent($userId, $eventName, $eventDescription, $eventDate, $eventBudget) {
        $this->eventModel->createEvent($userId, $eventName, $eventDescription, $eventDate, $eventBudget);
    }

    public function getEventsByUserId($userId) {
        return $this->eventModel->getEventsByUserId($userId);
    }
}