<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <?php include "templates/external-links.tpl.php"; ?>
</head>

<body>
    <?php include 'templates/header.tpl.php'; ?>
    <main>
        <section>
            <h1>TRACKIT</h1>
            <h2>Tracking Real-time Accounts, Costs, and Keeping It Tidy</h2>
            <?php if (isset($_SESSION['users_id'])): ?>
                <div class="button-container">
                    <a class="button" href="events-overview.php">Go to Events Overview</a>
                </div>
            <?php else: ?>
                <div class="login-signup-buttons">
                    <a href="log-in.php" class="button">Log In</a>
                    <a href="sign-up.php" class="secondary-outline-button">Sign Up</a>
                </div>
            <?php endif; ?>
        </section>
    </main>
    <?php include 'templates/footer.tpl.php'; ?>
</body>

</html>