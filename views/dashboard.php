<section class="content">
    <h2>Halaman Home</h2>
    <p>Ini adalah konten khusus halaman beranda.</p>
    <?php if ($showBarangLink): ?>
        <a href="index.php?page=barang/list">Lihat Data Barang</a>
    <?php endif; ?>
</section>

<section class="content">
    <h2>Contoh penggunaan fungsi</h2>
    <dl>
        <div><dt>Harga barang</dt><dd><?= e(formatRupiah(150000)) ?></dd></div>
        <div><dt>Diskon 10% dari Rp 200.000</dt><dd><?= e(formatRupiah(hitungDiskon(200000))) ?></dd></div>
        <div><dt>Email <code>admin@example.com</code></dt><dd><?= validasiEmail('admin@example.com') ? 'Valid' : 'Tidak valid' ?></dd></div>
        <div><dt>Ringkasan deskripsi</dt><dd><?= e(ringkasTeks('Aplikasi Data Barang untuk pengelolaan inventaris.', 30)) ?></dd></div>
        <div><dt>Konversi 30 °C</dt><dd><?= konversiCelciusKeFahrenheit(30) ?> °F</dd></div>
        <div><dt>Predikat nilai 80</dt><dd><?= e(tentukanStatusNilai(80)) ?></dd></div>
        <div><dt>Total tiga barang @ Rp 50.000</dt><dd><?= e(formatRupiah(hitungTotal(50000, 3))) ?></dd></div>
    </dl>
</section>
