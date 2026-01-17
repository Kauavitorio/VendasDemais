<?php
require_once 'session.php';
if (empty($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}
