<?php
    include_once 'header.php';
?>
<main>
    <h2>Sign Up</h2>
    <form action="includes/signup.inc.php" method="post">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" required><br>
        <label for="email">Email</label>
        <input type="text" name="email" id="email" required><br>
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
            if ($_GET["error"] == "emptyinput") {
                echo "<p>Fill in all fields!</p>";
            }
            else if ($_GET["error"] == "invaliduid") {
                echo "<p>Choose a proper username!</p>";
            }
            else if ($_GET["error"] == "invalidemail") {
                echo "<p>Choose a proper email!</p>";
            }
            else if ($_GET["error"] == "passwordsdontmatch") {
                echo "<p>Passwords don't match!</p>";
            }
            else if ($_GET["error"] == "stmtfailed") {
                echo "<p>Something went wrong, try again!</p>";
            }
            else if ($_GET["error"] == "usernametaken") {
                echo "<p>Username already taken!</p>";
            }
            else if ($_GET["error"] == "none") {
                echo "<p>You have signed up!</p>";
            }
        }
    ?>
</main>
<?php
    include_once 'footer.php';
?>