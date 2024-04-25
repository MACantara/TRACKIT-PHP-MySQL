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
            <p>Tracking Real-time Accounts,<br> Costs, and Keeping It Tidy</p>
            <?php if (isset($_SESSION['users_id'])): ?>
                <a href="events-overview.php">Go to Events Overview</a>
            <?php else: ?>
                <a href="log-in.php">Log In</a>
                <a href="sign-up.php">Sign Up</a>
            <?php endif; ?>
        </section>
    </main>
    <?php include 'templates/footer.tpl.php'; ?>
</body>

</html>