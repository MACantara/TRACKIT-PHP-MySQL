<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <link rel="stylesheet" href="static/css/style.css">
</head>

<body>
    <?php include 'templates/header.template.php'; ?>
    <main>
        <section>
            <h2>Log In</h2>
            <form action="includes/log-in.include.php" method="post">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" placeholder="username" required><br>
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required><br>
                <button type="submit" name="log-in">Log In</button>
            </form>
            <?php
            if (isset($_GET["error"])) {
                if ($_GET["error"] == "wronglogin") {
                    echo "<p class='error-message'>Incorrect login information!</p>";
                }
                if ($_GET["error"] == "stmtfailed") {
                    echo "<p class='error-message'>Something went wrong. Please try again!</p>";
                }
                if ($_GET["error"] == "usernotfound") {
                    echo "<p class='error-message'>User not found!</p>";
                }
            }
            ?>
        </section>
    </main>
    <?php include 'templates/footer.template.php'; ?>
</body>

</html>