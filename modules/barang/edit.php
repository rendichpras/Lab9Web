<?php
require_once __DIR__ . '/bootstrap.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
$barang = $id ? cariBarang($conn, $id) : null;
if ($barang === null) {
    http_response_code(404);
    $title = 'Barang tidak ditemukan';
    $message = 'Periksa ID barang atau kembali ke daftar.';
    require dirname(__DIR__, 2) . '/views/error.php';
    return;
}

$errors = [];
$action = 'index.php?page=barang/edit&id=' . $id;

if ($method === 'POST') {
    $barang = bacaBarang($_POST) + $barang;
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
            $berhasil = ubahBarang($conn, $id, $barang, $gambar);
        } catch (Throwable $exception) {
            hapusGambarLab9($gambar);
            throw $exception;
        }
        if ($berhasil) {
            kembaliKeDaftar('Perubahan barang berhasil disimpan.');
        }
        hapusGambarLab9($gambar);
        http_response_code(404);
        $title = 'Barang tidak ditemukan';
        $message = 'Data barang sudah tidak tersedia.';
        require dirname(__DIR__, 2) . '/views/error.php';
        return;
    }

    http_response_code(422);
}

require __DIR__ . '/form.php';
