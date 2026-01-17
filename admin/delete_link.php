<?php
require_once 'session.php';
require_once 'auth.php';

if (isset($_GET['id'])) {
    $file = '../data/links.json';
    $links = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
    $id = intval($_GET['id']);

    $links = array_filter($links, function($l) use ($id) {
        return $l['id'] !== $id;
    });

    $links = array_values($links);
    file_put_contents($file, json_encode($links, JSON_PRETTY_PRINT));
}

header('Location: links.php');
