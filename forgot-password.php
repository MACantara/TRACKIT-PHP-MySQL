<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <?php include "templates/external-links.tpl.php"; ?>
</head>

<body>
    <?php include 'templates/header.tpl.php'; ?>
    <main>
        <section>
            <h1>Reset your password</h1>
            <p>Enter your email address and we will send you a link to reset your password.</p>
            <form action="includes/reset-request.inc.php" method="post">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Enter your email" required><br>
                <button class="button" type="submit" name="reset-request-submit">Reset Password</button>
            </form>
            <?php
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