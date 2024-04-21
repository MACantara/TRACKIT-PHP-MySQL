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
    <title><?php echo $_SESSION["users_username"] ?>'s Profile Settings</title>
    <?php include "templates/external-links.tpl.php"; ?>
</head>

<body>
    <?php include 'templates/header.tpl.php'; ?>
    <main>
        <section>
            <h1>Profile Settings</h1>
            <form action="includes/profile-information.inc.php" method="post">
                <label for="profileAbout">About</label>
                <textarea type="text" name="profileAbout" rows="5" cols="20" id="profileAbout"><?php echo $profileInformation->fetchAbout($_SESSION["users_id"])?></textarea><br>
                <label for="profileTitle">Title</label>
                <input type="text" name="profileTitle" id="profileTitle" value='<?php echo $profileInformation->fetchTitle($_SESSION["users_id"])?>'><br>
                <label for="profileText">Text</label>
                <textarea type="text" name="profileText" rows="5" cols="20"  id="profileText"><?php echo $profileInformation->fetchText($_SESSION["users_id"])?></textarea><br>
                <button type="submit" name="profile-settings">Save</button>
                <a href="profile-information.php"><button type="button">Back</button></a>
            </form>
        </section>
    </main>
    <?php include 'templates/footer.tpl.php'; ?>
</body>

</html>