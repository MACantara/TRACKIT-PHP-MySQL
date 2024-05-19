<header>
    <nav>
        <a class="logo" href="index.php">
            <i class="bi bi-wallet2"></i>
            TRACKIT
        </a>
        <ul>
            <li>
                <a href="index.php"><i class="bi bi-house-door"></i> Home</a>
            </li>
            <?php
            if (isset($_SESSION['users_id'])) {
                ?>
                <li>
                    <a href="includes/summary-report-generation.inc.php"><i class="bi bi-file-earmark-text"></i> Generate Summary Report</a>
                </li>
                <li>
                    <a href="events-overview.php"><i class="bi bi-calendar2-week"></i> Events Overview</a>
                </li>
                <li>
                    <a href="profile-information.php"><i class="bi bi-person"></i> <?php echo $_SESSION["users_username"]; ?></a>
                </li>
                <li>
                    <a href="includes/log-out.inc.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
                </li>
                <?php
            } else {
                ?>
                <li>
                    <a href="sign-up.php"><i class="bi bi-person-plus"></i> Sign Up</a>
                </li>
                <li>
                    <a href="log-in.php"><i class="bi bi-box-arrow-in-right"></i> Log In</a>
                </li>
                <?php
            }
            ?>
        </ul>
    </nav>
</header>