<?php
    include_once 'header.php';
?>
    <h1>Hello World</h1>
    <?php
        if (isset($_SESSION["useruid"])) {
            echo "<p>Hello there " . $_SESSION["useruid"] . "</p>";
        }
        else {
            echo "<p>You are not logged in</p>";
        }
    ?>
<?php
    include_once 'footer.php';
?>