<?php
require_once __DIR__ . '/../../app/includes/auth.php';

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Clear session cookie if it exists
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Redirect to login page
header('Location: /admin/login.php');
exit;
?>