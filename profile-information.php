<?php
    session_start();
    include "classes/DbConnection.class.php";
    include "classes/ProfileInformation.class.php";
    include "classes/ProfileInformationView.class.php";
    $profileInformation = new ProfileInformationView();
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
            <p><?php echo $profileInformation->fetchAbout($_SESSION["users_id"])?></p>
        </section>
        <section>
            <h2>Title</h2>
            <p><?php echo $profileInformation->fetchTitle($_SESSION["users_id"])?></p>
        </section>
        <section>
            <h2>Text</h2>
            <p><?php echo $profileInformation->fetchText($_SESSION["users_id"])?></p>
        </section>
    </main>
    <?php include 'templates/footer.tpl.php'; ?>
</body>

</html>