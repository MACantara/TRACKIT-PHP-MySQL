<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="static/css/style.css">
</head>

<body>
    <header>
        <nav>
            <ul>
                <li>
                    <a href="index.php">Home</a>
                </li>
                <?php
                if (isset($_SESSION['users_id'])) {
                ?>
                    <li>
                        <a href="includes/log-out.include.php">Logout</a>
                    </li>
                    <li>
                        <a href="#"><?php echo $_SESSION["users_email"]; ?></a>
                    </li>
                <?php
                } else {
                ?>
                    <li><a href="templates/sign-up.template.php">Sign Up</a></li>
                    <li><a href="templates/log-in.template.php">Log In</a></li>
                <?php
                }
                ?>
            </ul>
        </nav>
    </header>
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
    <footer>
        <p>&copy;
            <?php echo date('Y'); ?> - All Rights Reserved
        </p>
    </footer>
</body>

</html>