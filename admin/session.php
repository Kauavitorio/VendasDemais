<?php
// Set a local session save path to avoid permission issues
$sessionPath = __DIR__ . '/../sessions';
if (!file_exists($sessionPath)) {
    mkdir($sessionPath, 0777, true);
}
session_save_path($sessionPath);
session_set_cookie_params(0, '/');
session_start();
