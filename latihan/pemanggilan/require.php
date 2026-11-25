<?php
ini_set('display_errors', '1');

$file = ($_GET['uji'] ?? '') === 'hilang' ? 'pesan-tidak-ada.php' : 'pesan.php';

echo 'Sebelum pemanggilan<br>';
require __DIR__ . '/' . $file;
echo 'Sesudah pemanggilan<br>';
