<?php

if (!isset($page, $title, $view)) {
    http_response_code(404);
    return;
}

require_once __DIR__ . '/../../helpers/functions.php';

$baseUrl = '../../';
$showBarangLink = false;
$navigation = [
    'dashboard' => ['Home', 'home.php'],
    'tentang' => ['Tentang', 'about.php'],
    'kontak' => ['Kontak', 'kontak.php'],
];

require_once __DIR__ . '/../../views/header.php';
require __DIR__ . '/../../views/' . $view;
require_once __DIR__ . '/../../views/footer.php';
