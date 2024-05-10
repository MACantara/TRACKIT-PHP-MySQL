<?php
session_start();

require_once "includes/user-functions.inc.php";
checkSessionTimeout();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "templates/meta-tags.tpl.php"; ?>
    <title>Log In</title>
    <?php include "templates/external-links.tpl.php"; ?>
</head>

<body>
    <?php include 'templates/header.tpl.php'; ?>
    <main>
        <section class="section-container">
            <h1>Log In</h1>
            <form action="includes/log-in.inc.php" method="post">
                <label for="username"><i class="bi bi-person-fill"></i> Username/Email</label>
                <input type="text" name="username" id="username" placeholder="Username/Email" required>
                <label for="password"><i class="bi bi-lock-fill"></i> Password</label>
                <input type="password" name="password" id="password" placeholder="Password" required>
                <div class="password-container">
                    <a href="forgot-password.php">Forgot Password?</a>
                    <button class="show-button" id="showPasswordButton" type="button"
                        onclick="togglePasswordVisibility('password', 'showPasswordButton')"><i class="bi bi-eye"></i> Show Password</button>
                </div>
                <button class="button" type="submit" name="submit"><i class="bi bi-box-arrow-in-right"></i> Log
                    In</button>
                <p class="account-information-text">Don't have an account yet? <a href="sign-up.php">Sign Up</a></p>
            </form>
            <?php
            if (isset($_GET["error"])) {
                if ($_GET["error"] == "emptyinput") {
                    echo "<p class='error-message'>Fill in all fields!</p>";
                } else if ($_GET["error"] == "wronglogin") {
                    echo "<p class='error-message'>Incorrect login information!</p>";
                } else if ($_GET["error"] == "loginrequired") {
                    echo "<p class='error-message'>Log in is required to access this page!</p>";
                } else if ($_GET["error"] == "toomanyattempts") {
                    echo "<p class='error-message'>Too many failed login attempts. Please try again later.</p>";
                } else if ($_GET["error"] == "sessiontimeout") {
                    echo "<p class='error-message'>Your session has timed out. Please log in again.</p>";
                } else if ($_GET["error"] == "none") {
                    echo "<p class='success-message'>You have successfully created an account! Log in now!</p>";
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
    <?php include 'includes/password-check-js-functions.inc.php' ?>
</body>

</html>