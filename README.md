# Praktikum 9: PHP Modular

Laporan praktikum Pemrograman Web. Proyek ini melanjutkan CRUD Data Barang dari Lab 8. Koneksi MySQLi, layout, fungsi, dan modul barang dipisahkan ke berkas masing-masing. Semua halaman aplikasi dibuka melalui `index.php`. [Lab8Web](https://github.com/rendichpras/Lab8Web)

| Identitas | Keterangan |
| --- | --- |
| Nama | Rendi Ichtiar Prasetyo |
| NIM | 312510087 |
| Kelas | I251A |

## Tujuan

- Membedakan perilaku `include`, `require`, `include_once`, dan `require_once`.
- Memakai template dan fungsi yang sama di beberapa halaman.
- Membatasi rute ke daftar yang diizinkan dan mengembalikan HTTP 404 untuk rute yang tidak dikenal.
- Menata ulang CRUD Data Barang dari Praktikum 8 dengan tetap memakai tabel `data_barang`.

## Perangkat

- PHP 8.2 atau lebih baru dengan ekstensi `mysqli`, `mbstring`, dan `fileinfo`
- Apache, MySQL atau MariaDB, dan phpMyAdmin dari XAMPP
- Visual Studio Code dan browser

## Struktur proyek

```text
lab9_php_modular/
├── index.php             # Router dan pengelola template
├── config/database.php   # Koneksi MySQLi
├── helpers/functions.php # Library function
├── views/                # Header, footer, dan isi halaman
├── modules/barang/       # Daftar, tambah, ubah, hapus, form, dan query
├── assets/css/style.css  # CSS Modul 9 bagian D.6
├── gambar/               # Penyimpanan unggahan
├── latihan/              # Contoh pemanggilan file dan template
└── screenshots/          # Bukti kode dan hasil di browser
```

## Persiapan dan cara menjalankan

1. Letakkan folder ini di `C:\xampp\htdocs\lab9_php_modular`.
2. Jalankan **Apache** dan **MySQL** melalui XAMPP. Periksa tabel `latihan1.data_barang` dari Praktikum 8 di [phpMyAdmin](http://localhost/phpmyadmin/).
3. Sesuaikan pengaturan MySQLi di `config/database.php` jika konfigurasi lokal berbeda. Konfigurasi bawaan memakai `localhost` dan database `latihan1`.
4. Buka [halaman Lab 9](http://localhost/lab9_php_modular/). Gunakan satu barang uji saat mencoba tambah, ubah, dan hapus karena Lab 8 dan Lab 9 memakai tabel yang sama.

<details>
<summary>SQL untuk instalasi tanpa tabel Lab 8</summary>

Jalankan SQL berikut lewat tab **SQL** di phpMyAdmin. Tambahkan barang contoh Modul 8 atau isi melalui form.

```sql
CREATE DATABASE IF NOT EXISTS latihan1;
USE latihan1;

CREATE TABLE IF NOT EXISTS data_barang (
    id_barang INT AUTO_INCREMENT PRIMARY KEY,
    kategori VARCHAR(30),
    nama VARCHAR(30),
    gambar VARCHAR(100),
    harga_beli DECIMAL(10, 0),
    harga_jual DECIMAL(10, 0),
    stok INT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

</details>

## Daftar rute

Tambahkan rute berikut setelah `index.php?page=`. Membuka `index.php` langsung akan menampilkan Home.

| Rute | Metode | Hasil |
| --- | --- | --- |
| `dashboard` | GET | Home |
| `profil` | GET | Profil dan contoh fungsi |
| `kontak` | GET | Kontak |
| `barang/list` | GET | Daftar barang |
| `barang/add` | GET, POST | Form dan penyimpanan barang baru |
| `barang/edit` | GET, POST | Form dan simpan perubahan. Tambahkan `&id=ID_BARANG` pada URL. |
| `barang/delete` | POST | Hapus barang berdasarkan ID dari form |

## Bukti langkah praktikum

### 1. Memanggil file dengan PHP

Buka `latihan/pemanggilan/include.php`. Ketiga pesan muncul saat file tersedia. Tambahkan `?uji=hilang` untuk memilih file yang sengaja tidak ada. `include` menampilkan peringatan dan masih mencetak “Sesudah pemanggilan”. `require.php?uji=hilang` berhenti sebelum baris itu. File `once.php` memuat pesan sekali meskipun dipanggil dua kali. Tambahkan `?mode=require` untuk menguji `require_once`.

<details>
<summary>Lihat kode dan hasil percobaan</summary>

![Kode pesan, include, dan require](screenshots/kode-01-pemanggilan.png)

![Tiga pesan saat include berhasil](screenshots/01-include-normal.png)

![Peringatan include diikuti pesan Sesudah pemanggilan](screenshots/02-include-hilang.png)

![Galat fatal dari require saat file hilang](screenshots/03-require-hilang.png)

![Kode include_once dan require_once](screenshots/kode-09-once.png)

![include_once mencetak pesan satu kali](screenshots/16-include-once.png)

![require_once mencetak pesan satu kali](screenshots/17-require-once.png)

</details>

### 2. Membuat template yang dipakai bersama

Jalankan `latihan/template/home.php` dan buka Home, Tentang, lalu Kontak. Ketiganya memuat `views/header.php` dan `views/footer.php` melalui `layout.php`. Aplikasi utama memakai template tersebut pada Home, Profil, dan Kontak. CSS mengikuti Modul 9 bagian D.6.

<details>
<summary>Lihat kode dan tampilan template</summary>

![Kode template dan halaman Tentang](screenshots/kode-02-template.png)

![CSS Modul 9 bagian D.6](screenshots/kode-08-css-modul.png)

![Home pada latihan template](screenshots/04-template-home-dan-fungsi.png)

![Tentang Aplikasi](screenshots/15-template-tentang.png)

![Kontak pada latihan template](screenshots/06-template-kontak.png)

![Kontak pada aplikasi utama](screenshots/19-template-kontak-router.png)

</details>

### 3. Memakai fungsi dari satu library

Halaman `latihan/template/contoh-panggil.php` menampilkan contoh fungsi tanpa parameter, fungsi berparameter, nilai kembalian, dan parameter default. Luas persegi panjang 8 × 5 menghasilkan 40. Home dan Profil memakai fungsi format Rupiah, hitung diskon, validasi email, serta ringkas teks dari `helpers/functions.php`. Contoh suhu 30 °C menghasilkan 86 °F. Potongan 10% dan 15% dari Rp200.000 menghasilkan Rp20.000 dan Rp30.000.

<details>
<summary>Lihat kode, contoh dasar, dan keluaran di Profil</summary>

![Deklarasi dan pemanggilan fungsi dasar](screenshots/kode-10-contoh-function.png)

![Keluaran contoh fungsi di browser](screenshots/18-contoh-function.png)

![Library function dan pemanggilannya pada dua halaman](screenshots/kode-03-functions.png)

![Profil menampilkan hasil fungsi dengan argumen lain](screenshots/05-template-profil-dan-fungsi.png)

</details>

### 4. Menata direktori dan memindahkan koneksi

Koneksi dari `koneksi.php` Lab 8 dipindah ke `config/database.php`. Bagian tampilan berada di `views/`, fungsi umum di `helpers/`, dan operasi Data Barang di `modules/barang/`. Modul barang memuat koneksi melalui `require_once`.

<details>
<summary>Lihat struktur folder dan koneksi MySQLi</summary>

![Struktur folder dan file Lab 9](screenshots/kode-00-struktur.png)

![Konfigurasi dan pemanggilan koneksi MySQLi](screenshots/kode-05-database.png)

</details>

### 5. Membuat router dan halaman 404

`index.php` memilih berkas dari daftar rute yang diizinkan. Permintaan tanpa parameter menampilkan dashboard. `?page=tidak-ada`, `?page=`, dan `?page[]=profil` menghasilkan HTTP 404. Kode status dapat dilihat di tab **Network** pada alat pengembang browser.

<details>
<summary>Lihat kode router, dashboard, dan halaman 404</summary>

![Daftar rute dan pemilihan file saat memproses permintaan](screenshots/kode-04-router.png)

![Dashboard yang tampil tanpa parameter page](screenshots/07-router-dashboard.png)

![Halaman 404 untuk rute tidak terdaftar](screenshots/08-router-404.png)

</details>

### 6. Menguji CRUD Data Barang

Buka **Data Barang**. Tambahkan barang uji dengan harga beli Rp50.000, harga jual Rp75.000, stok 3, dan gambar PNG. Ubah stoknya menjadi 8, simpan, lalu hapus barang uji. Form tambah, ubah, dan hapus memakai `POST` serta token CSRF. Form yang tidak valid menghasilkan HTTP 422. Membuka rute hapus lewat `GET` menghasilkan HTTP 405.

| Operasi | Hasil pengujian |
| --- | --- |
| Lihat | Tiga barang contoh Modul 8 tampil dari `latihan1.data_barang`. |
| Tambah | Barang uji muncul dengan stok 3 dan gambar PNG. |
| Ubah | Stok berubah menjadi 8 dan gambar sebelumnya tetap tampil. |
| Hapus | Pesan berhasil tampil. Baris barang uji dan gambar unggahannya terhapus. |

<details>
<summary>Lihat query, form, dan hasil setiap operasi</summary>

![Query untuk operasi lihat, tambah, ubah, dan hapus](screenshots/kode-06-query-crud.png)

![Daftar barang sebelum menambah data uji](screenshots/09-crud-daftar.png)

![Kode form, simpan barang baru, dan hapus](screenshots/kode-07-form-dan-hapus.png)

![Form tambah terisi data dan gambar PNG](screenshots/10-crud-form-tambah.png)

![Barang uji muncul dengan stok 3](screenshots/11-crud-hasil-tambah.png)

![Kode pengambilan data dan penyimpanan perubahan](screenshots/kode-11-ubah.png)

![Form ubah berisi stok baru](screenshots/12-crud-form-ubah.png)

![Daftar barang setelah stok berubah menjadi 8](screenshots/13-crud-hasil-ubah.png)

![Daftar barang setelah penghapusan barang uji](screenshots/14-crud-hasil-hapus.png)

</details>

## Catatan pengujian

Tangkapan browser diambil dari server PHP lokal dengan basis data MariaDB sementara yang berisi tiga barang contoh Modul 8. Tiga JPG contoh belum tersedia di folder gambar, sehingga halaman daftar menampilkan **Tanpa gambar** pada ketiga baris itu. Pengujian unggah memakai gambar PNG bertuliskan “UJI”.

URL ringkas dengan `.htaccess` merupakan bagian opsional Modul 9. Proyek ini memakai pola `index.php?page=...`.
