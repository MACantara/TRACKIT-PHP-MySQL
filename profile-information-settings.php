<?php
session_start();
require_once "includes/db-connection.inc.php";
require_once "includes/profile-information-functions.inc.php";
$profileData = getProfileInformation($conn, $_SESSION["users_id"]);
$userData = getUserInformation($conn, $_SESSION["users_id"]);

require_once 'includes/user-functions.inc.php';
require_login();
checkSessionTimeout();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "templates/meta-tags.tpl.php"; ?>
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
                <label for="profileAbout">About</label>
                <textarea type="text" name="profileAbout" rows="5" cols="20"
                    id="profileAbout"><?php echo $profileData['profiles_about']; ?></textarea>
                <label for="profileTitle">Title</label>
                <input type="text" name="profileTitle" id="profileTitle"
                    value='<?php echo $profileData['profiles_introduction_title']; ?>'>
                <label for="profileText">Text</label>
                <textarea type="text" name="profileText" rows="5" cols="20"
                    id="profileText"><?php echo $profileData['profiles_introduction_text']; ?></textarea>
                <label for="currentPassword">Current Password:</label>
                <input type="password" id="currentPassword" name="currentPassword" required>
                <div class="two-grid-column-container">
                    <a class="button" href="profile-information.php"><i class="bi bi-arrow-left"></i> Back</a>
                    <button class="button" type="submit" name="profile-settings"><i class="bi bi-save"></i>
                        Save</button>
                </div>
            </form>
            <?php
            if (isset($_GET["error"])) {
                if ($_GET["error"] == "none") {
                    echo "<p class='success-message'>Your profile has been updated successfully!</p>";
                } else if ($_GET["error"] == "wrongcurrentpasswordprofile") {
                    echo "<p class='error-message'>Incorrect current password!</p>";
                }
            }
            ?>
        </section>
        <!-- Email Section -->
        <section class="section-container">
            <h2>Update Email</h2>
            <form action="includes/update-email.inc.php" method="post">
                <div class="email-container">
                    <label for="email">Email</label>
                    <?php
                    if ($userData['users_email_verified'] == 0) {
                        echo "<span class='error-message'>Not Verified</span>";
                        echo "<button class='button' type='button' onclick='location.href=\"includes/send-verification-email.inc.php\"'><i class='bi bi-envelope'></i> Verify Email</button>";
                    } else {
                        echo "<span class='success-message'>Verified</span>";
                    }
                    ?>
                </div>
                <input type="email" name="email" id="email" value='<?php echo $userData['users_email']; ?>'>
                <label for="currentPassword">Current Password:</label>
                <input type="password" id="currentPassword" name="currentPassword" required>
                <button class="button" type="submit" name="update-email"><i class="bi bi-save"></i> Update
                    Email</button>
            </form>
            <?php
            if (isset($_GET["error"])) {
                if ($_GET["error"] == "wrongcurrentpasswordemail") {
                    echo "<p class='error-message'>Incorrect current password!</p>";
                }
            }
            if (isset($_GET["emailupdaterequest"])) {
                if ($_GET["emailupdaterequest"] == "success") {
                    echo "<p class='success-message'>Your email update request have been sent to your new email! Please check your inbox to verify your email.</p>";
                }
            }
            if (isset($_GET["emailverificationsent"])) {
                echo "<p class='success-message'>Verification email has been sent! Please check your inbox.</p>";
            }
            ?>
        </section>
        <section class="section-container">
            <h2>Update Password</h2>
            <form action="includes/update-password.inc.php" method="post">
                <label for="currentPassword">Current Password:</label>
                <input type="password" id="currentPassword" name="currentPassword" required>
                <label for="password">New Password:</label>
                <input type="password" id="password" name="password" required>
                <div id="strengthBar"
                    style="height: 10px; width: 0; background: linear-gradient(to right, red, yellow, green);"></div>
                <div class="password-container">
                    <p id="strengthLabel"></p>
                    <button class="show-button" id="showPasswordButton" type="button"
                        onclick="togglePasswordVisibility('password', 'showPasswordButton')"><i class='bi bi-eye'></i> Show Password</button>
                </div>
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
                <label for="confirmPassword">Confirm New Password:</label>
                <input type="password" id="confirmPassword" name="confirmPassword" required>
                <div class="password-container">
                    <div id="passwordMatchStatus" style="display: none; text-align: left;"></div>
                    <button class="show-button" id="showConfirmPasswordButton" type="button"
                        onclick="togglePasswordVisibility('confirmPassword', 'showConfirmPasswordButton')"><i class='bi bi-eye'></i> Show
                        Password</button>
                </div>
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
                } else if ($_GET["error"] == "wrongcurrentpasswordupdatepassword") {
                    echo "<p class='error-message'>Incorrect current password!</p>";
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
    <?php include 'includes/password-check-js-functions.inc.php' ?>
</body>

</html>