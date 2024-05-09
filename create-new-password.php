<?php
session_start();

require_once 'includes/user-functions.inc.php';
checkSessionTimeout();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Password</title>
    <?php include "templates/external-links.tpl.php"; ?>
</head>

<body>
    <?php include 'templates/header.tpl.php'; ?>
    <main>
        <section class="section-container">
            <?php
            $selector = $_GET["selector"];
            $validator = $_GET["validator"];

            if (empty($selector) || empty($validator)) {
                echo "Could not validate your request!";
            } else {
                if (ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false) {
                    ?>
                    <h1>Create New Password</h1>
                    <form action="includes/reset-password.inc.php" method="post">
                        <input type="hidden" name="selector" value="<?php echo $selector; ?>">
                        <input type="hidden" name="validator" value="<?php echo $validator; ?>">
                        <label for="password">Enter a new password</label>
                        <input type="password" name="password" id="password" required>
                        <ul class="password-requirements" id="password-requirements">
                            <li id="length"><i class="bi bi-x-circle-fill text-danger"></i> Must be at least 8 characters long
                            </li>
                            <li id="uppercase"><i class="bi bi-x-circle-fill text-danger"></i> Must contain at least one
                                uppercase
                                letter</li>
                            <li id="lowercase"><i class="bi bi-x-circle-fill text-danger"></i> Must contain at least one
                                lowercase
                                letter</li>
                            <li id="number"><i class="bi bi-x-circle-fill text-danger"></i> Must contain at least one number
                            </li>
                            <li id="special"><i class="bi bi-x-circle-fill text-danger"></i> Must contain at least one special
                                character</li>
                        </ul>
                        <label for="confirmPassword">Confirm Password</label>
                        <input type="password" name="confirmPassword" id="confirmPassword" required>
                        <div id="passwordMatchStatus" style="display: none; text-align: left;"></div>
                        <button class="button margin-top-16" type="submit" name="reset-password-submit"><i
                                class="bi bi-key"></i> Reset Password</button>
                    </form>
                    <?php
                    if (isset($_GET["error"])) {
                        if ($_GET["error"] == "resubmit") {
                            echo "<p class='error-message'>The reset link has expired!</p>";
                        } else if ($_GET["error"] == "emptyinput") {
                            echo "<p class='error-message'>Please fill in all fields!</p>";
                        } else if ($_GET["error"] == "passwordsdontmatch") {
                            echo "<p class='error-message'>Passwords don't match!</p>";
                        } else if ($_GET["error"] == "invalidpassword") {
                            echo "<p class='error-message'>Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character.</p>";
                        }
                    }
                    ?>
                    <?php
                }
            }
            ?>

        </section>
    </main>
    <?php include 'templates/footer.tpl.php'; ?>
    <script src="static/js/password-check.js"></script>
</body>

</html>