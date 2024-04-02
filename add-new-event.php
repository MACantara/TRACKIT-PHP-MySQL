<?php 

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
        $conn = mysqli_connect('localhost', 'root', '', 'TRACKIT') or die('Connection failed:' .mysqli_connect_error());
        if(isset($_POST['event-name']) && isset($_POST['event-description']) && isset($_POST['event-date']) && isset($_POST['event-budget'])) {
            $event_name = $_POST['event-name'];
            $event_description = $_POST['event-description'];
            $event_date = $_POST['event-date'];
            $event_budget = $_POST['event-budget'];

            $sql = "INSERT INTO events (event_name, event_description, event_date, event_budget) VALUES ('$event_name', '$event_description', '$event_date', '$event_budget')";

            $query = mysqli_query($conn, $sql);

            if($query) {
                echo "New Event Added Successful";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        }
    }
?>