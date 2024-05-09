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
            <h2>Sign Up</h2>
            <form action="includes/sign-up.inc.php" method="post">
                <label for="firstName">First Name</label>
                <input type="text" name="firstName" id="firstName" required>
                <label for="lastName">Last Name</label>
                <input type="text" name="lastName" id="lastName" required>
                <label for="username">Username</label>
                <input type="text" name="username" id="username" required>
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required>
                <label for="password"><i class="bi bi-lock-fill"></i> Password</label>
                <input type="password" id="password" name="password" required>
                <div class="password-container">
                    <button class="show-button" id="showPasswordButton" type="button" onclick="togglePasswordVisibility('password', 'showPasswordButton')">Show Password</button>
                </div>
                <ul class="password-requirements" id="password-requirements">
                    <li id="length">❌ Must be at least 8 characters long</li>
                    <li id="uppercase">❌ Must contain at least one uppercase letter</li>
                    <li id="lowercase">❌ Must contain at least one lowercase letter</li>
                    <li id="number">❌ Must contain at least one number</li>
                    <li id="special">❌ Must contain at least one special character</li>
                </ul>
                <label for="confirmPassword"><i class="bi bi-lock-fill"></i> Password</label>
                <input type="password" name="password" id="confirmPassword" placeholder="Confirm Password" required>
                <div class="password-container">
                    <button class="show-button" id="showConfirmPasswordButton" type="button" onclick="togglePasswordVisibility('confirmPassword', 'showConfirmPasswordButton')">Show Password</button>
                </div>
                <button class="button" type="submit" name="sign-up"><i class="bi bi-box-arrow-in-right"></i> Sign Up</button>
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
    <script src="static/js/password-visibility.js"></script>
    <script>
        var passwordInput = document.getElementById('password');
        var lengthRequirement = document.getElementById('length');
        var uppercaseRequirement = document.getElementById('uppercase');
        var lowercaseRequirement = document.getElementById('lowercase');
        var numberRequirement = document.getElementById('number');
        var specialRequirement = document.getElementById('special');

        passwordInput.oninput = function() {
            var password = passwordInput.value;

            // Check length
            if (password.length >= 8) {
                lengthRequirement.innerHTML = "✔️ Must be at least 8 characters long";
            } else {
                lengthRequirement.innerHTML = "❌ Must be at least 8 characters long";
            }

            // Check uppercase
            if (/[A-Z]/.test(password)) {
                uppercaseRequirement.innerHTML = "✔️ Must contain at least one uppercase letter";
            } else {
                uppercaseRequirement.innerHTML = "❌ Must contain at least one uppercase letter";
            }

            // Check lowercase
            if (/[a-z]/.test(password)) {
                lowercaseRequirement.innerHTML = "✔️ Must contain at least one lowercase letter";
            } else {
                lowercaseRequirement.innerHTML = "❌ Must contain at least one lowercase letter";
            }

            // Check number
            if (/[0-9]/.test(password)) {
                numberRequirement.innerHTML = "✔️ Must contain at least one number";
            } else {
                numberRequirement.innerHTML = "❌ Must contain at least one number";
            }

            // Check special character
            if (/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/.test(password)) {
                specialRequirement.innerHTML = "✔️ Must contain at least one special character";
            } else {
                specialRequirement.innerHTML = "❌ Must contain at least one special character";
            }
        };
    </script>
</body>

</html>