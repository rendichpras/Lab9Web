<?php

function bacaBarang(array $input): array
{
    $barang = [];
    foreach (['nama', 'kategori', 'harga_beli', 'harga_jual', 'stok'] as $field) {
        $nilai = $input[$field] ?? '';
        $barang[$field] = is_string($nilai) ? trim($nilai) : '';
    }
    return $barang;
}

function validasiBarang(array $barang): array
{
    $errors = [];

    if ($barang['nama'] === '' || mb_strlen($barang['nama'], 'UTF-8') > 30) {
        $errors[] = 'Nama barang wajib diisi dengan maksimal 30 karakter.';
    }
    if ($barang['kategori'] === '' || mb_strlen($barang['kategori'], 'UTF-8') > 30) {
        $errors[] = 'Pilih kategori yang valid.';
    }
    if (!preg_match('/\A[0-9]{1,10}\z/', $barang['harga_beli'])) {
        $errors[] = 'Harga beli harus berupa bilangan bulat dengan maksimal 10 digit.';
    }
    if (!preg_match('/\A[0-9]{1,10}\z/', $barang['harga_jual'])) {
        $errors[] = 'Harga jual harus berupa bilangan bulat dengan maksimal 10 digit.';
    }
    if (!preg_match('/\A[0-9]{1,10}\z/', $barang['stok']) || (float) $barang['stok'] > 2147483647) {
        $errors[] = 'Stok harus berupa bilangan bulat antara 0 dan 2.147.483.647.';
    }

    return $errors;
}

function simpanGambar(?array $file): ?string
{
    if ($file === null || $file['error'] === UPLOAD_ERR_NO_FILE) {
        return null;
    }
    if ($file['error'] !== UPLOAD_ERR_OK || $file['size'] > 2 * 1024 * 1024) {
        throw new RuntimeException('Unggah gambar berukuran maksimal 2 MB.');
    }

    $extensions = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']);
    if (!isset($extensions[$mime])) {
        throw new RuntimeException('Gunakan gambar JPG, PNG, atau WebP.');
    }

    $nama = 'gambar/lab9-' . bin2hex(random_bytes(16)) . '.' . $extensions[$mime];
    if (!move_uploaded_file($file['tmp_name'], dirname(__DIR__, 2) . '/' . $nama)) {
        throw new RuntimeException('Gambar gagal disimpan. Periksa folder gambar.');
    }
    return $nama;
}

function urlGambar(?string $gambar): ?string
{
    if ($gambar === null || $gambar === '') {
        return null;
    }

    $nama = basename(str_replace('\\', '/', $gambar));
    if (!preg_match('/\.(?:jpe?g|png|webp|gif)\z/i', $nama)) {
        return null;
    }

    $root = dirname(__DIR__, 2);
    if (is_file($root . '/gambar/' . $nama)) {
        return 'gambar/' . rawurlencode($nama);
    }
    if (is_file(dirname($root) . '/lab8_php_database/gambar/' . $nama)) {
        return '../lab8_php_database/gambar/' . rawurlencode($nama);
    }
    return null;
}

function hapusGambarLab9(?string $gambar): void
{
    if ($gambar === null || !preg_match('~\Agambar/lab9-[a-f0-9]{32}\.(jpg|png|webp)\z~', $gambar)) {
        return;
    }

    $path = dirname(__DIR__, 2) . '/' . $gambar;
    if (is_file($path) && !@unlink($path)) {
        error_log('Gagal membersihkan gambar Lab 9: ' . $gambar);
    }
}

function kembaliKeDaftar(string $pesan): never
{
    $_SESSION['pesan_barang'] = $pesan;
    header('Location: index.php?page=barang/list', true, 303);
    exit;
}
