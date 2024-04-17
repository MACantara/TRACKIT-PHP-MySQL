<?php
class Event extends DbConnection {
    private $event_title;
    private $event_description;
    private $event_date;
    private $event_time;
    private $event_location;

    public function __construct($event_title, $event_description, $event_date, $event_time, $event_location) {
        $this->event_title = $event_title;
        $this->event_description = $event_description;
        $this->event_date = $event_date;
        $this->event_time = $event_time;
        $this->event_location = $event_location;
    }

    public function addEvent($event_title, $event_description, $event_date, $event_time, $event_location) {
        $sql = "INSERT INTO events (event_title, event_description, event_date, event_time, event_location) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$event_title, $event_description, $event_date, $event_time, $event_location]);
    }

    // Add other methods for CRUD operations as needed
}