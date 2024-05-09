<?php
session_start();

require_once "includes/user-functions.inc.php";
checkSessionTimeout();
?>

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
        <section class="section-container">
            <h1>Sign Up</h1>
            <form action="includes/sign-up.inc.php" method="post">
                <label for="firstName">First Name</label>
                <input type="text" name="firstName" id="firstName" placeholder="First Name" required>
                <label for="lastName">Last Name</label>
                <input type="text" name="lastName" id="lastName" placeholder="Last Name" required>
                <label for="username">Username</label>
                <input type="text" name="username" id="username" placeholder="Username" required>
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Email" required>
                <label for="password"><i class="bi bi-lock-fill"></i> Password</label>
                <input type="password" id="password" name="password" placeholder="Password" required>
                <div id="strengthBar"
                    style="height: 10px; width: 0; background: linear-gradient(to right, red, yellow, green);"></div>
                <div class="password-container">
                    <p id="strengthLabel"></p>
                    <button class="show-button" id="showPasswordButton" type="button"
                        onclick="togglePasswordVisibility('password', 'showPasswordButton')">Show Password</button>
                </div>
                <ul class="password-requirements" id="password-requirements">
                    <li id="length"><i class="bi bi-x-circle-fill text-danger"></i> Must be at least 8 characters long
                    </li>
                    <li id="uppercase"><i class="bi bi-x-circle-fill text-danger"></i> Must contain at least one
                        uppercase
                        letter</li>
                    <li id="lowercase"><i class="bi bi-x-circle-fill text-danger"></i> Must contain at least one
                        lowercase
                        letter</li>
                    <li id="number"><i class="bi bi-x-circle-fill text-danger"></i> Must contain at least one number
                    </li>
                    <li id="special"><i class="bi bi-x-circle-fill text-danger"></i> Must contain at least one special
                        character</li>
                </ul>
                <label for="confirmPassword"><i class="bi bi-lock-fill"></i> Confirm Password</label>
                <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirm Password" required>
                <div class="password-container">
                    <div id="passwordMatchStatus" style="display: none; text-align: left;"></div>
                    <button class="show-button" id="showConfirmPasswordButton" type="button"
                        onclick="togglePasswordVisibility('confirmPassword', 'showConfirmPasswordButton')">Show
                        Password</button>
                </div>
                <button class="button" type="submit" name="sign-up"><i class="bi bi-box-arrow-in-right"></i> Sign
                    Up</button>
                <p class="account-information-text">Already have an account? <a href="log-in.php">Log In</a></p>
            </form>
            <?php
            if (isset($_GET["error"])) {
                if ($_GET["error"] == "emptyinput") {
                    echo "<p class='error-message'>Fill in all fields!</p>";
                } else if ($_GET["error"] == "invalidusername") {
                    echo "<p class='error-message'>Choose a proper username!</p>";
                } else if ($_GET["error"] == "usernametaken") {
                    echo "<p class='error-message'>Username already taken!</p>";
                } else if ($_GET["error"] == "invalidemail") {
                    echo "<p class='error-message'>Choose a proper email!</p>";
                } else if ($_GET["error"] == "emailtaken") {
                    echo "<p class='error-message'>Email already taken!</p>";
                } else if ($_GET["error"] == "invalidpassword") {
                    echo "<p class='error-message'>Choose a proper password!</p>";
                } else if ($_GET["error"] == "passwordsdontmatch") {
                    echo "<p class='error-message'>Passwords don't match!</p>";
                } else if ($_GET["error"] == "stmtfailed") {
                    echo "<p class='error-message'>Something went wrong, try again!</p>";
                } else if ($_GET["error"] == "none") {
                    echo "<p class='success-message'>You have signed up!</p>";
                }
            }
            ?>
        </section>
    </main>
    <?php include 'templates/footer.tpl.php'; ?>
    <?php include 'includes/password-check-js-functions.inc.php' ?>
</body>

</html>