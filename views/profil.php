<section class="content">
    <h2>Profil</h2>
    <p>Aplikasi ini menyimpan data kategori, harga beli, harga jual, stok, dan gambar barang.</p>
</section>

<section class="content">
    <h2>Contoh penggunaan fungsi</h2>
    <dl>
        <div><dt>Harga barang</dt><dd><?= e(formatRupiah(275000)) ?></dd></div>
        <div><dt>Diskon 15% dari Rp 200.000</dt><dd><?= e(formatRupiah(hitungDiskon(200000, 15))) ?></dd></div>
        <div><dt>Email <code>alamat-tidak-lengkap</code></dt><dd><?= validasiEmail('alamat-tidak-lengkap') ? 'Valid' : 'Tidak valid' ?></dd></div>
        <div><dt>Ringkasan deskripsi</dt><dd><?= e(ringkasTeks('Harga dan stok dapat diperbarui dari tabel barang.', 30)) ?></dd></div>
        <div><dt>Konversi 0 °C</dt><dd><?= konversiCelciusKeFahrenheit(0) ?> °F</dd></div>
        <div><dt>Predikat nilai 92</dt><dd><?= e(tentukanStatusNilai(92)) ?></dd></div>
        <div><dt>Total dua barang @ Rp 75.000</dt><dd><?= e(formatRupiah(hitungTotal(75000, 2))) ?></dd></div>
    </dl>
</section>
