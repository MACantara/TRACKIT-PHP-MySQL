<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TRACKIT - Home</title>
</head>
<body>
    <header>
        <h1>TRACKIT</h1>
    </header>
    <main>
        <h2>Registration Form</h2>
        <form action="register.php" method="post">
            <label for="first-name">First Name:</label>
            <input type="text" id="first-name" name="first-name"><br>
            <label for="last-name">Last Name:</label>
            <input type="text" id="last-name" name="last-name"><br>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username"><br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email"><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password"><br>
            <label for="confirm-password">Confirm Password:</label>
            <input type="password" id="confirm-password" name="confirm-password"><br>
            <input type="submit" value="Submit" id="submit" name="submit">
        </form>
        <h2>Add New Event</h2>
        <form action="add-new-event.php" method="post">
            <label for="event-name">Event Name:</label>
            <input type="text" id="event-name" name="event-name"><br>
            <label for="event-description">Event Description:</label>
            <input type="text" id="event-description" name="event-description"><br>
            <label for="event-date">Event Date:</label>
            <input type="date" id="event-date" name="event-date"><br>
            <label for="event-budget">Event Budget:</label>
            <input type="number" id="event-budget" name="event-budget"><br>
            <input type="submit" value="Submit" id="submit" name="submit">
        </form>
    </main>
    <footer>
    </footer>
</body>
</html>