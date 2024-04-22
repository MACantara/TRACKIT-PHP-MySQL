<?php
session_start();
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
        <section>
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
                            <label for="password-repeat">Repeat new password</label>
                            <input type="password" name="password-repeat" id="password-repeat" required>
                            <button type="submit" name="reset-password-submit">Reset Password</button>
                        </form>
                        <?php
                            if (isset($_GET["error"])) {
                                if ($_GET["error"] == "resubmit") {
                                    echo "<p class='error-message'>The reset link has expired!</p>";
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
</body>

</html>