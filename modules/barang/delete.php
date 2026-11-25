<?php
require_once __DIR__ . '/bootstrap.php';

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
if ($id && hapusBarang($conn, $id)) {
    kembaliKeDaftar('Barang berhasil dihapus.');
}

http_response_code(404);
$title = 'Barang tidak ditemukan';
$message = 'Data barang sudah tidak tersedia.';
require dirname(__DIR__, 2) . '/views/error.php';
