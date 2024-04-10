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
    <h1>Hello World</h1>
    <?php
    if (isset($_SESSION["useruid"])) {
        echo "<p>Hello there " . $_SESSION["useruid"] . "</p>";
    } else {
        echo "<p>You are not logged in</p>";
    }
    ?>
    <footer>
        <p>&copy;
            <?php echo date('Y'); ?> - All Rights Reserved
        </p>
    </footer>
</body>

</html>