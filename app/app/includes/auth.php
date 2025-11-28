<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function isLoggedIn(): bool
{
    return isset($_SESSION['user_id']);
}

function requireLogin(): void
{
    if (!isLoggedIn()) {
        header('Location: /admin/login.php');
        exit;
    }
}

function getCurrentUserId(): ?int
{
    return $_SESSION['user_id'] ?? null;
}
?>