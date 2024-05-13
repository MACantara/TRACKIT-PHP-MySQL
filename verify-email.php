<?php
session_start();
require_once 'includes/db-connection.inc.php';
require_once 'includes/user-functions.inc.php';

$message = '';

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $message = verifyUserEmailToken($conn, $token);
} else {
    $message = "No verification token provided!";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "templates/meta-tags.tpl.php"; ?>
    <title>Home</title>
    <?php include "templates/external-links.tpl.php"; ?>
</head>

<body>
    <?php include 'templates/header.tpl.php'; ?>
    <main>
        <section class="section-container">
            <p><?php echo $message; ?></p>
        </section>
    </main>
    <?php include 'templates/footer.tpl.php'; ?>
</body>

</html>