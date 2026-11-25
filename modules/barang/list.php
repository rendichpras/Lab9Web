<?php
require_once __DIR__ . '/bootstrap.php';
$rows = daftarBarang($conn);
$pesan = $_SESSION['pesan_barang'] ?? null;
unset($_SESSION['pesan_barang']);
?>
<section class="content">
    <h2>Data Barang</h2>
    <p><a href="index.php?page=barang/add">Tambah Barang</a></p>

<?php if ($pesan !== null): ?>
    <p role="status"><?= e($pesan) ?></p>
<?php endif; ?>

    <table aria-label="Daftar barang">
        <thead>
            <tr>
                <th scope="col">Gambar</th>
                <th scope="col">Nama Barang</th>
                <th scope="col">Kategori</th>
                <th scope="col">Harga Beli</th>
                <th scope="col">Harga Jual</th>
                <th scope="col">Stok</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($rows->num_rows === 0): ?>
                <tr><td colspan="7">Belum ada data barang.</td></tr>
            <?php endif; ?>
            <?php foreach ($rows as $barang): ?>
                <?php $gambar = urlGambar($barang['gambar']); ?>
                <tr>
                    <td>
                        <?php if ($gambar !== null): ?>
                            <img src="<?= e($gambar) ?>" alt="<?= e($barang['nama']) ?>" width="56" height="56">
                        <?php else: ?>
                            Tanpa gambar
                        <?php endif; ?>
                    </td>
                    <th scope="row"><?= e($barang['nama']) ?></th>
                    <td><?= e($barang['kategori']) ?></td>
                    <td><?= e(formatRupiah((float) $barang['harga_beli'])) ?></td>
                    <td><?= e(formatRupiah((float) $barang['harga_jual'])) ?></td>
                    <td><?= e((string) $barang['stok']) ?></td>
                    <td>
                        <a href="index.php?page=barang/edit&amp;id=<?= (int) $barang['id_barang'] ?>">Ubah</a>
                        <form action="index.php?page=barang/delete" method="post" onsubmit="return confirm('Hapus barang ini?');">
                            <input type="hidden" name="id" value="<?= (int) $barang['id_barang'] ?>">
                            <input type="hidden" name="csrf" value="<?= e(csrfToken()) ?>">
                            <button type="submit">Hapus</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>
