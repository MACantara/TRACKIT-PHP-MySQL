<?php
    session_start();
    include "classes/db-connection.class.php";
    include "classes/profileinfo.classes.php";
    include "classes/profileinfo-view.classes.php";
    $profileInfo = new ProfileInfoView();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $_SESSION["users_username"] ?>'s Profile</title>
    <?php include "templates/external-links.template.php"; ?>
</head>

<body>
    <?php include 'templates/header.template.php'; ?>
    <main>
        <section>
            <h1><?php echo $_SESSION["users_username"] ?>'s Profile</h1>
            <a href="profilesettings.php">Edit Profile</a>
            <h2>About</h2>
            <p><?php echo $profileInfo->fetchAbout($_SESSION["users_id"])?></p>
        </section>
        <section>
            <h2>Title</h2>
            <p><?php echo $profileInfo->fetchTitle($_SESSION["users_id"])?></p>
        </section>
        <section>
            <h2>Text</h2>
            <p><?php echo $profileInfo->fetchText($_SESSION["users_id"])?></p>
        </section>
    </main>
    <?php include 'templates/footer.template.php'; ?>
</body>

</html>