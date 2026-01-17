<?php
require_once 'session.php';
require_once 'auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $file = '../data/links.json';
    $links = file_exists($file) ? json_decode(file_get_contents($file), true) : [];

    $id = $_POST['id'] ? intval($_POST['id']) : null;
    $newItem = [
        'id' => $id ?: time(),
        'type' => $_POST['type'],
        'name' => $_POST['name'],
        'link' => $_POST['link'],
        'style' => $_POST['style']
    ];

    if ($id) {
        foreach ($links as &$l) {
            if ($l['id'] === $id) {
                $l = $newItem;
                break;
            }
        }
    } else {
        $links[] = $newItem;
    }

    file_put_contents($file, json_encode($links, JSON_PRETTY_PRINT));
}

header('Location: links.php');
