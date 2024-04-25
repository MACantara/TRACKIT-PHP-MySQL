<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <?php include "templates/external-links.tpl.php"; ?>
</head>

<body>
    <?php include 'templates/header.tpl.php'; ?>
    <main>
        <section>
            <h2>Log In</h2>
            <form action="includes/log-in.inc.php" method="post">
                <label for="username">Username/Email</label>
                <input type="text" name="username" id="username" placeholder="Username/Email" required><br>
                <div class="password-container">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Password" required><br>
                    <a href="forgot-password.php">Forgot Password?</a>
                </div>
                <button class="button" type="submit" name="submit">Log In</button>
            </form>
            <?php
            if (isset($_GET["error"])) {
                if ($_GET["error"] == "emptyinput") {
                    echo "<p class='error-message'>Fill in all fields!</p>";
                } else if ($_GET["error"] == "wronglogin") {
                    echo "<p class='error-message'>Incorrect login information!</p>";
                }
            }
            if (isset($_GET["newpwd"])) {
                if ($_GET["newpwd"] == "success") {
                    echo "<p class='success-message'>Your password has been reset!</p>";
                }
            }
            ?>
        </section>
    </main>
    <?php include 'templates/footer.tpl.php'; ?>
</body>

</html>