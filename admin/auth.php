<?php
session_start();
if (!isset($_SESSION['user'])) {
    // Ensure we redirect to the correct login page even if trailing slash is missing
    // or simply use the absolute path relative to web root
    header('Location: /admin/login.php');
    exit;
}
?>
