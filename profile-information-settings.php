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
                <textarea type="text" name="profileAbout" rows="5" cols="20" id="profileAbout"><?php echo $profileData['profiles_about']; ?></textarea><br>
                <label for="profileTitle">Title</label>
                <input type="text" name="profileTitle" id="profileTitle" value='<?php echo $profileData['profiles_introduction_title']; ?>'><br>
                <label for="profileText">Text</label>
                <textarea type="text" name="profileText" rows="5" cols="20"  id="profileText"><?php echo $profileData['profiles_introduction_text']; ?></textarea><br>
                <button class="button" type="submit" name="profile-settings">Save</button>
                <a href="profile-information.php"><button class="button" type="button">Back</button></a>
            </form>
        </section>
    </main>
    <?php include 'templates/footer.tpl.php'; ?>
</body>

</html>