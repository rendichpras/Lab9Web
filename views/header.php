<?php
$activePage = is_string($page) && str_starts_with($page, 'barang/') ? 'barang/list' : $page;
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aplikasi PHP Modular</title>
    <link rel="stylesheet" href="<?= e($baseUrl) ?>assets/css/style.css">
</head>
<body>
<div class="container">
    <header>
        <h1>Aplikasi PHP Modular</h1>
        <p>Contoh pemisahan template dan konten</p>
    </header>
    <nav aria-label="Menu utama">
        <?php foreach ($navigation as $key => [$label, $url]): ?>
            <a href="<?= e($url) ?>"<?= $activePage === $key ? ' aria-current="page"' : '' ?>><?= e($label) ?></a>
        <?php endforeach; ?>
    </nav>
    <main>
