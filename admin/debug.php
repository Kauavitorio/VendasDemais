<?php
require_once 'session.php';
echo "<h1>Session Debug</h1>";
echo "<p>Session ID: " . session_id() . "</p>";
echo "<p>Session Save Path: " . session_save_path() . "</p>";
echo "<p>Session Status: " . session_status() . "</p>";
echo "<pre>Content of \$_SESSION:\n";
print_r($_SESSION);
echo "</pre>";

if (is_writable(session_save_path())) {
    echo "<p style='color:green'>Session save path is writable.</p>";
} else {
    echo "<p style='color:red'>Session save path is NOT writable (or default).</p>";
}

echo "<hr>";
echo "<a href='login.php'>Go to Login</a> | <a href='index.php'>Go to Index</a>";
