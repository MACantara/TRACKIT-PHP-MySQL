<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <?php include "templates/external-links.tpl.php"; ?>
</head>

<body>
    <?php include 'templates/header.tpl.php'; ?>
    <main>
        <section>
            <h2>Sign Up</h2>
            <form action="includes/sign-up.inc.php" method="post">
                <label for="firstName">First Name</label>
                <input type="text" name="firstName" id="firstName" required><br>
                <label for="lastName">Last Name</label>
                <input type="text" name="lastName" id="lastName" required><br>
                <label for="username">Username</label>
                <input type="text" name="username" id="username" required><br>
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required><br>
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
                <p class="info-text">Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.</p><br>
                <label for="confirmPassword">Confirm Password</label>
                <input type="password" name="confirmPassword" id="confirmPassword" required><br>
                <button type="submit" name="sign-up">Sign Up</button>
            </form>
            <?php
            if (isset($_GET["error"])) {
                if ($_GET["error"] == "emptyinput") {
                    echo "<p class='error-message'>Fill in all fields!</p>";
                } else if ($_GET["error"] == "invalidemail") {
                    echo "<p class='error-message'>Invalid email!</p>";
                } else if ($_GET["error"] == "passwordsdontmatch") {
                    echo "<p class='error-message'>Passwords don't match!</p>";
                }else if ($_GET["error"] == "none") {
                    echo "<p class='success-message'>You have signed up! <a style='color: #4F8A10;' href='log-in.php'>Log in</a> now.</p>";
                }
            }
            ?>
        </section>
    </main>
    <?php include 'templates/footer.tpl.php'; ?>
</body>

</html>