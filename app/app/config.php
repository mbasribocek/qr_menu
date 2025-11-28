<?php
define('DB_HOST', getenv('DB_HOST') ?: 'db');
define('DB_NAME', getenv('DB_NAME') ?: 'qr_menu');
define('DB_USER', getenv('DB_USER') ?: 'qr_user');
define('DB_PASS', getenv('DB_PASS') ?: 'qr_pass');

// Include language helper
require_once __DIR__ . '/includes/lang.php';
?>