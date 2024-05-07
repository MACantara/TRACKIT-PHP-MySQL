<?php
    session_start();
    require_once "includes/db-connection.inc.php";
    require_once "includes/profile-information-functions.inc.php";
    $profileData = getProfileInformation($conn, $_SESSION["users_id"]);
    $userData = getUserInformation($conn, $_SESSION["users_id"]);
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
                <input type="text" name="firstName" id="firstName" value='<?php echo $userData['users_first_name']; ?>'><br>
                <label for="lastName">Last Name</label>
                <input type="text" name="lastName" id="lastName" value='<?php echo $userData['users_last_name']; ?>'><br>
                <label for="username">Username</label>
                <input type="text" name="username" id="username" value='<?php echo $userData['users_username']; ?>'><br>
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value='<?php echo $userData['users_email']; ?>'><br>
                <label for="profileAbout">About</label>
                <textarea type="text" name="profileAbout" rows="5" cols="20" id="profileAbout"><?php echo $profileData['profiles_about']; ?></textarea><br>
                <label for="profileTitle">Title</label>
                <input type="text" name="profileTitle" id="profileTitle" value='<?php echo $profileData['profiles_introduction_title']; ?>'><br>
                <label for="profileText">Text</label>
                <textarea type="text" name="profileText" rows="5" cols="20"  id="profileText"><?php echo $profileData['profiles_introduction_text']; ?></textarea><br>
                <div class="two-grid-column-container">
                    <a class="button" href="profile-information.php"><i class="bi bi-arrow-left"></i> Back</a>
                    <button class="button" type="submit" name="profile-settings"><i class="bi bi-save"></i> Save</button>
                </div>
            </form>
        </section>
    </main>
    <?php include 'templates/footer.tpl.php'; ?>
</body>

</html>