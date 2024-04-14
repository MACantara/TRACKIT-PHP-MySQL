<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <link rel="stylesheet" href="../static/css/style.css">
</head>

<body>
    <header>
        <nav>
            <ul>
                <li>
                    <a href="../index.php">Home</a>
                </li>
                <?php
                if (isset($_SESSION['username'])) {
                    echo '<li>
                            <a href="includes/log-out.include.php">Logout</a>
                        </li>';
                } else {
                    echo '<li>
                            <a href="sign-up.template.php">Sign Up</a>
                        </li>';
                    echo '<li>
                            <a href="log-in.template.php">Log In</a>
                        </li>';
                }
                ?>
            </ul>
        </nav>
    </header>
    <main>
        <section>
            <h2>Log In</h2>
            <form action="../includes/log-in.include.php" method="post">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" placeholder="username" required><br>
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required><br>
                <button type="submit" name="log-in">Log In</button>
            </form>
            <?php
            if (isset($_GET["error"])) {
                if ($_GET["error"] == "wronglogin") {
                    echo "<p class='error-message'>Incorrect login information!</p>";
                }
                if ($_GET["error"] == "stmtfailed") {
                    echo "<p class='error-message'>Something went wrong. Please try again!</p>";
                }
                if ($_GET["error"] == "usernotfound") {
                    echo "<p class='error-message'>User not found!</p>";
                }
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