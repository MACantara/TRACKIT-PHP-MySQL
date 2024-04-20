<header>
    <nav>
        <a class="logo" href="index.php">
            <i class="bi bi-wallet2"></i>
            TRACKIT
        </a>
        <ul>
            <li>
                <a href="index.php">Home</a>
            </li>
            <?php
            if (isset($_SESSION['users_id'])) {
                ?>
                <li>
                    <a href="add-event.php">Add Event</a>
                </li>
                <li>
                    <a href="profile-information.php"><?php echo $_SESSION["users_username"]; ?></a>
                </li>
                <li>
                    <a href="includes/log-out.inc.php">Logout</a>
                </li>
                <?php
            } else {
                ?>
                <li>
                    <a href="sign-up.php">Sign Up</a>
                </li>
                <li>
                    <a href="log-in.php">Log In</a>
                </li>
                <li>
                    <a href="forgot-password.php">Forgot Password</a>
                </li>
                <?php
            }
            ?>
        </ul>
    </nav>
</header>