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
            <h1>Reset Password</h1>
            <p>Please enter your email address. You will receive a link to create a new password via email.</p>
            <form action="classes/PasswordResetController.class.php" method="post">
                <label for="email">Email</label>
                <input type="email" name="email" required>
                <button type="submit" name="reset-request-submit">Request Password Reset</button>
            </form>
        </section>
    </main>
    <?php include 'templates/footer.tpl.php'; ?>
</body>

</html>