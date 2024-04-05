<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
</head>

<body>
    <header>
        <nav>
            <ul>
                <li>
                    <a href="index.php">Home</a>
                </li>
                <?php
                if (isset($_SESSION['useruid'])) {
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
        <h2>Sign Up</h2>
        <form action="includes/signup.include.php" method="post">
            <label for="uid">Username</label>
            <input type="text" name="uid" id="uid" required><br>
            <label for="pwd">Password</label>
            <input type="password" name="pwd" id="pwd" required><br>
            <label for="pwdrepeat">Repeat Password</label>
            <input type="password" name="pwdrepeat" id="pwdrepeat" required><br>
            <button type="submit" name="submit">Sign Up</button>
        </form>
        <?php
        if (isset($_GET["error"])) {
            if ($_GET["error"] == "invaliduid") {
                echo "<p>Choose a proper username!</p>";
            } else if ($_GET["error"] == "passwordsdontmatch") {
                echo "<p>Passwords don't match!</p>";
            } else if ($_GET["error"] == "stmtfailed") {
                echo "<p>Something went wrong, try again!</p>";
            } else if ($_GET["error"] == "usernametaken") {
                echo "<p>Username already taken!</p>";
            } else if ($_GET["error"] == "none") {
                echo "<p>You have signed up!</p>";
            }
        }
        ?>
    </main>
    <footer>
        <p>&copy;
            <?php echo date('Y'); ?> - All Rights Reserved
        </p>
    </footer>
</body>

</html>