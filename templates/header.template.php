<header>
    <nav>
        <ul>
            <li>
                <a href="index.php">
                    <i class="bi bi-wallet2"></i>
                    TRACKIT
                </a>
            </li>
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
                    <a href="includes/log-out.include.php">Logout</a>
                </li>
                <li>
                    <a href="#"><?php echo $_SESSION["users_username"]; ?></a>
                <li>
                    <a href="#"><?php echo $_SESSION["users_email"]; ?></a>
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
                <?php
            }
            ?>
        </ul>
    </nav>
</header>