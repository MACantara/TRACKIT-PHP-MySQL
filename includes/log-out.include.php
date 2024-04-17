<?php

/**
 * Destroys the session and redirects to the index page.
 */
session_start();
session_unset();  // removes all session data
session_destroy();  // destroys the session cookie

header("Location: ../index.php");  // redirects to the index page
exit();  // exits the script after redirect