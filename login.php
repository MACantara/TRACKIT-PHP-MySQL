<?php session_start(); ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Log In</title>
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
        <main>
            <section>
                <h2>Log In</h2>
                <form action="includes/login.include.php" method="post">
                    <label for="name">Name</label>
                    <input type="text" name="uid" id="name" placeholder="username" required><br>
                    <label for="pwd">Password</label>
                    <input type="password" name="pwd" id="pwd" required><br>
                    <button type="submit" name="submit">Log In</button>
                </form>
                <?php
                if (isset($_GET["error"])) {
                    if ($_GET["error"] == "wronglogin") {
                        echo "<p class='error-message'>Incorrect login information!</p>";
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