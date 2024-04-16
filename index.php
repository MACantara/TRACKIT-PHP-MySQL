<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="static/css/style.css">
</head>

<body>
    <?php include 'templates/header.template.php'; ?>
    <main>
        <section>
            <h1>Simple Log In and Sign Up System</h1>
            <?php
            if (isset($_SESSION["users_username"])) {
                echo "<p>Welcome back " . $_SESSION["users_username"] . "!</p>";
                echo "<p>You are currently logged in using " . $_SESSION["users_email"] . ".</p>";
            } else {
                echo "<p>You are not logged in.</p>";
            }
            ?>
        </section>
    </main>
    <?php include 'templates/footer.template.php'; ?>
</body>

</html>