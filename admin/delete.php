<?php
require_once 'auth.php';

if (isset($_GET['id'])) {
    $file = '../data/products.json';
    $products = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
    $id = intval($_GET['id']);

    $products = array_filter($products, function($p) use ($id) {
        return $p['id'] !== $id;
    });

    // Reindex array
    $products = array_values($products);

    file_put_contents($file, json_encode($products, JSON_PRETTY_PRINT));
}

header('Location: index.php');
