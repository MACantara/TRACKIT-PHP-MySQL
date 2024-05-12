<?php
session_start();
require_once "includes/db-connection.inc.php";
require_once "includes/profile-information-functions.inc.php";
$profileData = getProfileInformation($conn, $_SESSION["users_id"]);
$userData = getUserInformation($conn, $_SESSION["users_id"]);

require_once 'includes/user-functions.inc.php';
requireLogin();
checkSessionTimeout();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "templates/meta-tags.tpl.php"; ?>
    <title><?php echo $userData["users_username"] ?>'s Profile</title>
    <?php include "templates/external-links.tpl.php"; ?>
</head>

<body>
    <?php include 'templates/header.tpl.php'; ?>
    <main>
        <section class="section-container">
            <div class="profile-picture-container">
                <i class="bi bi-person-fill profile-picture"></i>
            </div>
            <h1 class="profile-full-name"><?php echo $userData["users_first_name"] . " " . $userData["users_last_name"]; ?></h1>
            <h2 class="profile-username">@<?php echo $userData["users_username"]; ?></h2>
            <p class="profile-email">Contact me through e-mail: <?php echo $userData['users_email']; ?></p>
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
            <h2 class="profile-section-title">About</h2>
            <p><?php echo $profileData['profiles_about']; ?></p>
            <h2 class="profile-section-title">Title</h2>
            <p><?php echo $profileData['profiles_introduction_title']; ?></p>
            <h2 class="profile-section-title">Text</h2>
            <p><?php echo $profileData['profiles_introduction_text']; ?></p>
        </section>
    </main>
    <?php include 'templates/footer.tpl.php'; ?>
</body>

</html>