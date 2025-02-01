<?php
// auth/logout.php
require_once '../includes/config.php';

// Hancurkan semua data sesi
$_SESSION = array();

// Hapus cookie sesi
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

// Hancurkan sesi
session_destroy();

// Redirect ke halaman login
redirect('login.php');
// Hapus semua variabel sesi
session_unset();

// Regenerasi ID sesi untuk mencegah session fixation
session_regenerate_id(true);

// Pastikan cookie sesi dihapus
setcookie(session_name(), '', time() - 3600, '/');

// Set header no-cache
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");