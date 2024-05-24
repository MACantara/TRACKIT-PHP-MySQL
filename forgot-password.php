<?php
session_start();

require_once "includes/user-functions.inc.php";
checkSessionTimeout();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "templates/meta-tags.tpl.php"; ?>
    <title>Forgot Password</title>
    <?php include "templates/external-links.tpl.php"; ?>
</head>

<body>
    <?php include 'templates/header.tpl.php'; ?>
    <main>
        <section class="section-container">
            <h1>Reset your password</h1>
            <p class="margin-top-16">Enter your email address and we will send you a link to reset your password.</p>
            <form class="margin-top-16" action="includes/reset-request.inc.php" method="post">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Enter your email" required>
                <div class="two-grid-column-container">
                    <a class="button" href="log-in.php"><i class="bi bi-arrow-left"></i> Back</a>
                    <button class="button" type="submit" name="reset-request-submit"><i class="bi bi-envelope"></i> Send Reset Link</button>
                </div>
            </form>
            <?php
            if (isset($_GET["error"])) {
                if ($_GET["error"] == "emptyinput") {
                    echo "<p class='error-message'>Fill in all fields!</p>";
                } else if ($_GET["error"] == "passwordresetrequestalreadyexists") {
                    echo "<p class='error-message'>Password reset request already exists! Check your email for a link to reset your password.</p>";
                } else if ($_GET["error"] == "stmtfailed") {
                    echo "<p class='error-message'>Something went wrong, try again!</p>";
                }
            }
            if (isset($_GET["reset"])) {
                if ($_GET["reset"] == "success") {
                    echo "<p class='success-message'>Check your email for a link to reset your password.</p>";
                }
            }
            ?>
        </section>
    </main>
    <?php include 'templates/footer.tpl.php'; ?>
</body>

</html>