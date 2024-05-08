<?php
session_start();
require_once "includes/db-connection.inc.php";
require_once "includes/profile-information-functions.inc.php";
$profileData = getProfileInformation($conn, $_SESSION["users_id"]);
$userData = getUserInformation($conn, $_SESSION["users_id"]);

require_once 'includes/user-functions.inc.php';
require_login();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $userData["users_username"] ?>'s Profile Settings</title>
    <?php include "templates/external-links.tpl.php"; ?>
</head>

<body>
    <?php include 'templates/header.tpl.php'; ?>
    <main>
        <section class="section-container">
            <h1>Profile Settings</h1>
            <form action="includes/profile-information.inc.php" method="post">
                <label for="firstName">First Name</label>
                <input type="text" name="firstName" id="firstName" value='<?php echo $userData['users_first_name']; ?>'>
                <label for="lastName">Last Name</label>
                <input type="text" name="lastName" id="lastName" value='<?php echo $userData['users_last_name']; ?>'>
                <label for="username">Username</label>
                <input type="text" name="username" id="username" value='<?php echo $userData['users_username']; ?>'>
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value='<?php echo $userData['users_email']; ?>'>
                <label for="profileAbout">About</label>
                <textarea type="text" name="profileAbout" rows="5" cols="20"
                    id="profileAbout"><?php echo $profileData['profiles_about']; ?></textarea>
                <label for="profileTitle">Title</label>
                <input type="text" name="profileTitle" id="profileTitle"
                    value='<?php echo $profileData['profiles_introduction_title']; ?>'>
                <label for="profileText">Text</label>
                <textarea type="text" name="profileText" rows="5" cols="20"
                    id="profileText"><?php echo $profileData['profiles_introduction_text']; ?></textarea>
                <div class="two-grid-column-container">
                    <a class="button" href="profile-information.php"><i class="bi bi-arrow-left"></i> Back</a>
                    <button class="button" type="submit" name="profile-settings"><i class="bi bi-save"></i>
                        Save</button>
                </div>
            </form>
        </section>
        <section class="section-container">
            <h2>Update Password</h2>
            <form action="includes/update-password.inc.php" method="post">
                <label for="password">New Password:</label>
                <input type="password" id="password" name="password" required>
                <label for="confirmPassword">Confirm New Password:</label>
                <input type="password" id="confirmPassword" name="confirmPassword" required>
                <input type="hidden" name="usersEmail" value="<?php echo $userData['users_email']; ?>">
                <button class="button margin-top-16" type="submit" name="updatePassword"><i class="bi bi-key-fill"></i>
                    Update Password</button>
            </form>
            <?php
            if (isset($_GET["error"])) {
                if ($_GET["error"] == "emptyinput") {
                    echo "<p class='error-message'>Please fill in all fields!</p>";
                } else if ($_GET["error"] == "passwordsdontmatch") {
                    echo "<p class='error-message'>Passwords don't match!</p>";
                } else if ($_GET["error"] == "invalidpassword") {
                    echo "<p class='error-message'>Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character.</p>";
                }
            }
            if (isset($_GET["newpassword"])) {
                if ($_GET["newpassword"] == "success") {
                    echo "<p class='success-message'>Your password has been reset!</p>";
                }
            }
            ?>
        </section>
    </main>
    <?php include 'templates/footer.tpl.php'; ?>
</body>

</html>