<?php
// Check if the server name is localhost, if true set the base URL to your local URL, else set it to your production URL
$base_url = ($_SERVER['SERVER_NAME'] == 'localhost') ? 'http://localhost/TRACKIT-PHP-MySQL/' : 'https://mysql-database.alwaysdata.net/';

define('BASE_URL', $base_url);