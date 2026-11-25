<?php

function konversiCelciusKeFahrenheit(float $celsius): float
{
    return $celsius * 9 / 5 + 32;
}

function tentukanStatusNilai(float $nilai): string
{
    return match (true) {
        $nilai >= 85 => 'A',
        $nilai >= 75 => 'B',
        $nilai >= 65 => 'C',
        $nilai >= 55 => 'D',
        default => 'E',
    };
}

function hitungTotal(float $harga, int $jumlah): float
{
    return $harga * $jumlah;
}

function formatRupiah(float $angka): string
{
    return 'Rp ' . number_format($angka, 0, ',', '.');
}

function hitungDiskon(float $harga, float $persen = 10): float
{
    return $harga * $persen / 100;
}

function validasiEmail(string $email): bool
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function ringkasTeks(string $teks, int $batas = 40): string
{
    if ($batas <= 0 || $teks === '') {
        return '';
    }

    if (mb_strlen($teks, 'UTF-8') <= $batas) {
        return $teks;
    }

    return rtrim(mb_substr($teks, 0, $batas - 1, 'UTF-8')) . '…';
}

function e(?string $nilai): string
{
    return htmlspecialchars($nilai ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function csrfToken(): string
{
    return $_SESSION['csrf'] ??= bin2hex(random_bytes(32));
}

function csrfValid(mixed $token): bool
{
    return is_string($token) && isset($_SESSION['csrf']) && hash_equals($_SESSION['csrf'], $token);
}

function tampilkanSalam(): void
{
    echo 'Selamat belajar PHP modular!';
}

function sapaPengguna(string $nama): void
{
    echo 'Halo, ' . e($nama);
}

function hitungLuasPersegiPanjang(float $panjang, float $lebar): float
{
    return $panjang * $lebar;
}
