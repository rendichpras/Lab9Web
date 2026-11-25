<?php
if (!isset($barang, $action, $errors, $title)) {
    http_response_code(404);
    return;
}

$kategori = ['Komputer', 'Elektronik', 'Hand Phone'];
$kategoriSekarang = $barang['kategori'] ?? '';
if ($kategoriSekarang !== '' && !in_array($kategoriSekarang, $kategori, true)) {
    $kategori[] = $kategoriSekarang;
}
$gambarSaatIni = urlGambar($barang['gambar'] ?? null);
?>
<section class="content">
<h2><?= e($title) ?></h2>

<?php if ($errors !== []): ?>
    <div role="alert">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= e($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form action="<?= e($action) ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="csrf" value="<?= e(csrfToken()) ?>">
    <div class="input">
        <label for="nama">Nama Barang</label>
        <input id="nama" name="nama" value="<?= e($barang['nama']) ?>" maxlength="30" required>
    </div>
    <div class="input">
        <label for="kategori">Kategori</label>
        <select id="kategori" name="kategori" required>
            <option value="">Pilih kategori</option>
            <?php foreach ($kategori as $pilihan): ?>
                <option value="<?= e($pilihan) ?>"<?= $barang['kategori'] === $pilihan ? ' selected' : '' ?>><?= e($pilihan) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="input">
        <label for="harga_beli">Harga Beli (Rp)</label>
        <input id="harga_beli" name="harga_beli" value="<?= e((string) $barang['harga_beli']) ?>" type="number" min="0" max="9999999999" step="1" required>
    </div>
    <div class="input">
        <label for="harga_jual">Harga Jual (Rp)</label>
        <input id="harga_jual" name="harga_jual" value="<?= e((string) $barang['harga_jual']) ?>" type="number" min="0" max="9999999999" step="1" required>
    </div>
    <div class="input">
        <label for="stok">Stok</label>
        <input id="stok" name="stok" value="<?= e((string) $barang['stok']) ?>" type="number" min="0" max="2147483647" step="1" required>
    </div>
    <div class="input">
        <label for="file_gambar">Gambar (opsional)</label>
        <input id="file_gambar" name="file_gambar" type="file" accept="image/jpeg,image/png,image/webp" aria-describedby="batas-gambar">
        <small id="batas-gambar">JPG, PNG, atau WebP. Maksimal 2 MB.</small>
        <?php if ($gambarSaatIni !== null): ?>
            <img src="<?= e($gambarSaatIni) ?>" alt="Gambar barang saat ini" width="56" height="56">
        <?php endif; ?>
    </div>
    <div class="submit">
        <button type="submit">Simpan</button>
        <a href="index.php?page=barang/list">Kembali ke Daftar</a>
    </div>
</form>
</section>
