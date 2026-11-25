<?php

function daftarBarang(mysqli $conn): mysqli_result
{
    return $conn->query('SELECT id_barang, nama, kategori, gambar, harga_beli, harga_jual, stok FROM data_barang ORDER BY id_barang');
}

function cariBarang(mysqli $conn, int $id, bool $kunci = false): ?array
{
    $sql = 'SELECT id_barang, nama, kategori, gambar, harga_beli, harga_jual, stok FROM data_barang WHERE id_barang = ?';
    if ($kunci) {
        $sql .= ' FOR UPDATE';
    }

    return $conn->execute_query($sql, [$id])->fetch_assoc();
}

function tambahBarang(mysqli $conn, array $barang, ?string $gambar): void
{
    $conn->execute_query(
        'INSERT INTO data_barang (nama, kategori, harga_beli, harga_jual, stok, gambar) VALUES (?, ?, ?, ?, ?, ?)',
        [$barang['nama'], $barang['kategori'], $barang['harga_beli'], $barang['harga_jual'], $barang['stok'], $gambar],
    );
}

function ubahBarang(mysqli $conn, int $id, array $barang, ?string $gambar): bool
{
    $conn->begin_transaction();
    try {
        $lama = cariBarang($conn, $id, true);
        if ($lama === null) {
            $conn->rollback();
            return false;
        }

        $conn->execute_query(
            'UPDATE data_barang SET nama = ?, kategori = ?, harga_beli = ?, harga_jual = ?, stok = ?, gambar = COALESCE(?, gambar) WHERE id_barang = ?',
            [$barang['nama'], $barang['kategori'], $barang['harga_beli'], $barang['harga_jual'], $barang['stok'], $gambar, $id],
        );
        $conn->commit();
    } catch (Throwable $exception) {
        $conn->rollback();
        throw $exception;
    }

    if ($gambar !== null) {
        hapusGambarLab9($lama['gambar']);
    }
    return true;
}

function hapusBarang(mysqli $conn, int $id): bool
{
    $conn->begin_transaction();
    try {
        $barang = cariBarang($conn, $id, true);
        if ($barang === null) {
            $conn->rollback();
            return false;
        }

        $conn->execute_query('DELETE FROM data_barang WHERE id_barang = ?', [$id]);
        $conn->commit();
    } catch (Throwable $exception) {
        $conn->rollback();
        throw $exception;
    }

    hapusGambarLab9($barang['gambar']);
    return true;
}
