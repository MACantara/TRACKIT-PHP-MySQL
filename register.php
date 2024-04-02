<?php 

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
        $conn = mysqli_connect('localhost', 'root', '', 'TRACKIT') or die('Connection failed:' .mysqli_connect_error());
        if(isset($_POST['first-name']) && isset($_POST['last-name']) && isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password'])) {
            $first_name = $_POST['first-name'];
            $last_name = $_POST['last-name'];
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            $sql = "INSERT INTO users (first_name, last_name, username, email, password) VALUES ('$first_name', '$last_name', '$username', '$email', '$password')";

            $query = mysqli_query($conn, $sql);

            if($query) {
                echo "Registration Successful";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        }
    }
?>