<?php
    session_start();
    require_once "includes/db-connection.inc.php";
    require_once "includes/profile-information-functions.inc.php";
    $profileData = getProfileInformation($conn, $_SESSION["users_id"]);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $_SESSION["users_username"] ?>'s Profile</title>
    <?php include "templates/external-links.tpl.php"; ?>
</head>

<body>
    <?php include 'templates/header.tpl.php'; ?>
    <main>
        <section>
            <h1><?php echo $_SESSION["users_username"] ?>'s Profile</h1>
            <a href="profile-information-settings.php">Edit Profile</a>
            <h2>About</h2>
            <p><?php echo $profileData['profiles_about']; ?></p>
        </section>
        <section>
            <h2>Title</h2>
            <p><?php echo $profileData['profiles_introduction_title']; ?></p>
        </section>
        <section>
            <h2>Text</h2>
            <p><?php echo $profileData['profiles_introduction_text']; ?></p>
        </section>
    </main>
    <?php include 'templates/footer.tpl.php'; ?>
</body>

</html>