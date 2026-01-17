<?php
require_once 'auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $file = '../data/products.json';
    $products = file_exists($file) ? json_decode(file_get_contents($file), true) : [];

    $id = $_POST['id'] ? intval($_POST['id']) : null;
    $newItem = [
        'id' => $id ?: time(), // Use timestamp as simple ID if new
        'name' => $_POST['name'],
        'image' => $_POST['image'],
        'description' => $_POST['description'],
        'tags' => array_map('trim', explode(',', $_POST['tags'])),
        'link' => $_POST['link'],
    ];

    if ($id) {
        // Edit
        foreach ($products as &$p) {
            if ($p['id'] === $id) {
                $p = $newItem;
                break;
            }
        }
    } else {
        // Add
        $products[] = $newItem;
    }

    file_put_contents($file, json_encode($products, JSON_PRETTY_PRINT));
    header('Location: index.php');
}
