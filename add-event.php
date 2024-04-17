<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Event</title>
    <link rel="stylesheet" href="static/css/style.css">
</head>
<body>
    <form action="includes/add-event-process.include.php" method="post">
        <input type="text" name="title" placeholder="Event Title">
        <textarea name="description" placeholder="Event Description"></textarea>
        <input type="date" name="date">
        <input type="time" name="time">
        <input type="text" name="location" placeholder="Event Location">
        <button type="submit">Add Event</button>
    </form>
</body>
</html>