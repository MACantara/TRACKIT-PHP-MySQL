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
        <section class="section-container">
            <h2>Log In</h2>            <form action="includes/log-in.inc.php" method="post">
                <label for="username"><i class="bi bi-person-fill"></i> Username/Email</label>
                <input type="text" name="username" id="username" placeholder="Username/Email" required><br>
                <div class="password-container">
                    <label for="password"><i class="bi bi-lock-fill"></i> Password</label>
                    <input type="password" name="password" id="password" placeholder="Password" required>
                    <button class="show-button" type="button" onclick="togglePasswordVisibility('password')">Show</button><br>
                </div>
                <a href="forgot-password.php">Forgot Password?</a><br>
                <button class="button" type="submit" name="submit"><i class="bi bi-box-arrow-in-right"></i> Log In</button>
                <p class="account-information-text">Don't have an account yet? <a href="sign-up.php">Sign Up</a></p>
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
    <script>
        function togglePasswordVisibility(id) {
            var passwordInput = document.getElementById(id);
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
            } else {
                passwordInput.type = "password";
            }
        }
    </script>
</body>

</html>