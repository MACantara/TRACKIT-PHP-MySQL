<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
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
                if (isset($_SESSION['username'])) {
                    echo '<li>
                            <a href="includes/logout.include.php">Logout</a>
                        </li>';
                } else {
                    echo '<li>
                            <a href="signup.php">Sign Up</a>
                        </li>';
                    echo '<li>
                            <a href="login.php">Log In</a>
                        </li>';
                }
                ?>
            </ul>
        </nav>
    </header>
    <main>
        <section>
            <h2>Sign Up</h2>
            <form action="includes/signup.include.php" method="post">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" required><br>
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required><br>
                <label for="confirmPassword">Confirm Password</label>
                <input type="password" name="confirmPassword" id="confirmPassword" required><br>
                <button type="submit" name="submit">Sign Up</button>
            </form>
            <?php
            if (isset($_GET["error"])) {
                if ($_GET["error"] == "invalidusername") {
                    echo "<p class='error-message'>Choose a proper username!</p>";
                } else if ($_GET["error"] == "passwordsdontmatch") {
                    echo "<p class='error-message'>Passwords don't match!</p>";
                } else if ($_GET["error"] == "stmtfailed") {
                    echo "<p class='error-message'>Something went wrong, try again!</p>";
                } else if ($_GET["error"] == "usernametaken") {
                    echo "<p class='error-message'>Username already taken!</p>";
                } else if ($_GET["error"] == "none") {
                    echo "<p class='success-message'>You have signed up! <a style='color: #4F8A10;' href='login.php'>Log in</a> now.</p>";
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