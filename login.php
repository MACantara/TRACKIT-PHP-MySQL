<?php
    include_once 'header.php';
?>
<main>
    <h2>Log In</h2>
    <form action="includes/login.inc.php" method="post">
        <label for="name">Name</label>
        <input type="text" name="uid" id="name" placeholder="username/email" required><br>
        <label for="pwd">Password</label>
        <input type="password" name="pwd" id="pwd" required><br>
        <button type="submit" name="submit">Log In</button>
    </form>
    <?php
        if (isset($_GET["error"])) {
            if ($_GET["error"] == "emptyinput") {
                echo "<p>Please fill in all fields!</p>";
            }
            else if ($_GET["error"] == "wronglogin") {
                echo "<p>Incorrect login information!</p>";
            }
        }
    ?>
</main>
<?php
    include_once 'footer.php';
?>