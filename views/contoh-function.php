<section class="content">
    <h2>Contoh Function pada PHP</h2>
    <ol>
        <li>Tanpa parameter — <?php tampilkanSalam(); ?></li>
        <li>Dengan parameter — <?php sapaPengguna('Rina'); ?></li>
        <li>Nilai kembalian — Luas persegi panjang 8 × 5 adalah <?= hitungLuasPersegiPanjang(8, 5) ?>.</li>
        <li>Parameter default — Diskon default <?= e(formatRupiah(hitungDiskon(200000))) ?> dan diskon 15% <?= e(formatRupiah(hitungDiskon(200000, 15))) ?>.</li>
        <li>Helper — <?= e(formatRupiah(150000)) ?> dan teks HTML <code><?= e('<em>uji</em>') ?></code>.</li>
    </ol>
</section>
