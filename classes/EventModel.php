<?php
require_once "DbConnection.class.php";

class EventModel extends DbConnection {
    public function createEvent($userId, $eventName, $eventDescription, $eventDate, $eventBudget) {
        $sql = "INSERT INTO events (events_name, events_description, events_date, events_budget) VALUES (?, ?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$eventName, $eventDescription, $eventDate, $eventBudget]);

        $eventId = $this->connect()->lastInsertId();

        $sql = "INSERT INTO event_users (events_id, users_id) VALUES (?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$eventId, $userId]);
    }

    public function getEventsByUserId($userId) {
        $sql = "SELECT e.* FROM events e JOIN event_users eu ON e.event_id = eu.event_id WHERE eu.user_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}