<?php
require_once __DIR__ . '/bootstrap.php';

$barang = bacaBarang($method === 'POST' ? $_POST : []);
$errors = [];
$action = 'index.php?page=barang/add';

if ($method === 'POST') {
    $errors = validasiBarang($barang);
    if ($errors === []) {
        try {
            $gambar = simpanGambar($_FILES['file_gambar'] ?? null);
        } catch (RuntimeException $exception) {
            $errors[] = $exception->getMessage();
        }
    }

    if ($errors === []) {
        try {
            tambahBarang($conn, $barang, $gambar);
        } catch (Throwable $exception) {
            hapusGambarLab9($gambar);
            throw $exception;
        }
        kembaliKeDaftar('Barang berhasil ditambahkan.');
    }

    http_response_code(422);
}

require __DIR__ . '/form.php';
