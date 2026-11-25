<?php

require_once __DIR__ . '/helpers/functions.php';

session_start();

$navigation = [
    'dashboard' => ['Home', 'index.php'],
    'profil' => ['Profil', 'index.php?page=profil'],
    'kontak' => ['Kontak', 'index.php?page=kontak'],
    'barang/list' => ['Data Barang', 'index.php?page=barang/list'],
];
$routes = [
    'dashboard' => ['Home', 'views/dashboard.php', ['GET', 'HEAD']],
    'profil' => ['Profil', 'views/profil.php', ['GET', 'HEAD']],
    'kontak' => ['Kontak', 'views/kontak.php', ['GET', 'HEAD']],
    'barang/list' => ['Data Barang', 'modules/barang/list.php', ['GET', 'HEAD']],
    'barang/add' => ['Tambah Barang', 'modules/barang/add.php', ['GET', 'HEAD', 'POST']],
    'barang/edit' => ['Ubah Barang', 'modules/barang/edit.php', ['GET', 'HEAD', 'POST']],
    'barang/delete' => ['Hapus Barang', 'modules/barang/delete.php', ['POST']],
];

$page = $_GET['page'] ?? 'dashboard';
$method = $_SERVER['REQUEST_METHOD'];
$baseUrl = './';
$showBarangLink = true;

if (!is_string($page) || !isset($routes[$page])) {
    http_response_code(404);
    $title = 'Halaman tidak ditemukan';
    $view = 'views/404.php';
} else {
    [$title, $view, $allowedMethods] = $routes[$page];

    if (!in_array($method, $allowedMethods, true)) {
        http_response_code(405);
        header('Allow: ' . implode(', ', $allowedMethods));
        $title = 'Metode tidak diizinkan';
        $message = 'Gunakan form aplikasi untuk melakukan tindakan ini.';
        $view = 'views/error.php';
    } elseif ($method === 'POST' && !csrfValid($_POST['csrf'] ?? null)) {
        http_response_code(403);
        $title = 'Form tidak valid';
        $message = 'Muat ulang halaman dan kirim kembali form.';
        $view = 'views/error.php';
    }
}

// Modul dapat menentukan status HTTP atau mengalihkan sebelum layout dikirim.
ob_start();
try {
    require __DIR__ . '/' . $view;
} catch (mysqli_sql_exception $exception) {
    ob_clean();
    error_log($exception->getMessage());
    http_response_code(500);
    $title = 'Database tidak dapat diakses';
    $message = 'Periksa MySQL dan konfigurasi database latihan1.';
    require __DIR__ . '/views/error.php';
}
$content = ob_get_clean();

require_once __DIR__ . '/views/header.php';
echo $content;
require_once __DIR__ . '/views/footer.php';
