<?php

$pesan = __DIR__ . '/pesan.php';

if (($_GET['mode'] ?? '') === 'require') {
    echo 'require_once dipanggil dua kali.<br>';
    require_once $pesan;
    require_once $pesan;
} else {
    echo 'include_once dipanggil dua kali.<br>';
    include_once $pesan;
    include_once $pesan;
}
