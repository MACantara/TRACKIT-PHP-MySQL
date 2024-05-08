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
    <title>Home</title>
    <?php include "templates/external-links.tpl.php"; ?>
</head>

<body>
    <?php include 'templates/header.tpl.php'; ?>
    <main>
        <section class="section-container">
            <h1><i class="bi bi-wallet2"></i> TRACKIT</h1>
            <h2 class="margin-top-16">Tracking Real-time Accounts, Costs, and Keeping It Tidy</h2>
            <?php if (isset($_SESSION['users_id'])): ?>
                <div class="button-container">
                    <a class="button margin-top-16" href="events-overview.php"><i class="bi bi-calendar2-week"></i> Go to Events Overview</a>
                </div>
            <?php else: ?>
                <div class="login-signup-buttons">
                    <a href="log-in.php" class="button margin-top-16"><i class="bi bi-box-arrow-in-right"></i> Log In</a>
                    <a href="sign-up.php" class="secondary-outline-button margin-top-16"><i class="bi bi-person-plus"></i> Sign Up</a>
                </div>
            <?php endif; ?>
        </section>
    </main>
    <?php include 'templates/footer.tpl.php'; ?>
</body>

</html>