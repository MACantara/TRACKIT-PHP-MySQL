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
            if (isset($_SESSION["users_id"])) {
            ?>
                <p>Welcome back <?php echo $_SESSION["users_username"] ?>!</p>
                <p>You are currently logged in using <?php echo $_SESSION["users_email"] ?>.</p>
                <form action="#">
                    <label for="firstName">First Name</label>
                    <input type="text" name="firstName" id="firstName" value='<?php echo $_SESSION["users_first_name"] ?>' readonly><br>
                    <label for="lastName">Last Name</label>
                    <input type="text" name="lastName" id="lastName" value='<?php echo $_SESSION["users_last_name"] ?>' readonly><br>
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" value='<?php echo $_SESSION["users_username"] ?>' readonly><br>
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" value='<?php echo $_SESSION["users_email"] ?>' readonly><br>
                </form>
            <?php
            } else {
            ?>
                <p>You are not logged in.</p>
            <?php
            }
            ?>
        </section>
    </main>
    <?php include 'templates/footer.template.php'; ?>
</body>

</html>