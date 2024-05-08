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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $userData["users_username"] ?>'s Profile</title>
    <?php include "templates/external-links.tpl.php"; ?>
</head>

<body>
    <?php include 'templates/header.tpl.php'; ?>
    <main>
        <section class="section-container">
            <h1><?php echo $userData["users_username"] ?>'s Profile</h1>
            <div class="button-container">
                <a class="button margin-top-16" href="profile-information-settings.php"><i class="bi bi-pencil"></i>
                    Edit Profile</a>
            </div>
            <?php
            if (isset($_GET['error'])) {
                if ($_GET['error'] == 'none') {
                    echo '<p class="success-message">Your profile has been updated successfully!</p>';
                }
            }
            ?>
        </section>
        <section class="section-container">
            <h2>About</h2>
            <p><?php echo $profileData['profiles_about']; ?></p>
        </section>
        <section class="section-container">
            <h2>Title</h2>
            <p><?php echo $profileData['profiles_introduction_title']; ?></p>
        </section>
        <section class="section-container">
            <h2>Text</h2>
            <p><?php echo $profileData['profiles_introduction_text']; ?></p>
        </section>
        <section class="section-container">
            <h2>First Name</h2>
            <p><?php echo $userData['users_first_name']; ?></p>
        </section>
        <section class="section-container">
            <h2>Last Name</h2>
            <p><?php echo $userData['users_last_name']; ?></p>
        </section>
        <section class="section-container">
            <h2>Username</h2>
            <p><?php echo $userData['users_username']; ?></p>
        </section>
        <section class="section-container">
            <h2>Email</h2>
            <p><?php echo $userData['users_email']; ?></p>
        </section>
    </main>
    <?php include 'templates/footer.tpl.php'; ?>
</body>

</html>