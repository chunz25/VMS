<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Destroy the session
$_SESSION = []; // Clear session data
session_destroy(); // Destroy session on the server side

// Unset session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Clear other cookies
foreach ($_COOKIE as $cookie_name => $cookie_value) {
    setcookie($cookie_name, '', time() - 42000, '/');
}

// Redirect to logout page
$hostUri = $_SERVER["HTTP_HOST"];
$urlLogout = '/index.php?main=010';
header("Location: https://$hostUri$urlLogout");
exit;
