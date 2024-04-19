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
    <title><?php echo $_SESSION["users_username"] ?>'s Profile Settings</title>
    <?php include "templates/external-links.template.php"; ?>
</head>

<body>
    <?php include 'templates/header.template.php'; ?>
    <main>
        <section>
            <h1>Profile Settings</h1>
            <form action="includes/profileinfo.include.php" method="post">
                <label for="about">About</label>
                <textarea type="text" name="profileAbout" rows="5" cols="20" id="about"><?php echo $profileInfo->fetchAbout($_SESSION["users_id"])?></textarea><br>
                <label for="title">Title</label>
                <input type="text" name="profileTitle" id="title" value='<?php echo $profileInfo->fetchTitle($_SESSION["users_id"])?>'><br>
                <label for="text">Text</label>
                <textarea type="text" name="profileText" rows="5" cols="20"  id="text"><?php echo $profileInfo->fetchText($_SESSION["users_id"])?></textarea><br>
                <button type="submit" name="profile-settings">Save</button>
                <a href="profile.php"><button type="button">Back</button></a>
            </form>
        </section>
    </main>
    <?php include 'templates/footer.template.php'; ?>
</body>

</html>