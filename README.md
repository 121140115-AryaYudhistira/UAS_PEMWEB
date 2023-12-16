# UAS PEMWEB

**Nama	: Arya Yudhistira**
**NIM	: 121140115**
**Kelas	: RA**


#  Bagian 1: Client-side Programming (Bobot: 30%)

**1.1 (15%) Buatlah sebuah halaman web sederhana yang memanfaatkan JavaScript untuk melakukan manipulasi DOM.
Penjelasan:**  
- DOM digunakan pada tokobarokah.php untuk mengambil value pada tabel agar terdisplay pada form edit.
- DOM digunakan pada index.php untuk mengambil username yang diinputkan dan memanipulasinya agar tersimpan dalam cookie.

**1.2 (15%) Buatlah beberapa event untuk menghandle interaksi pada halaman web
Penjelasan:**  
- Event handler digunakan pada index.php untuk menyimpan cookie saat adanya submit pada form login.
- Event listener digunakan pada tokobarokah.php untuk menampilkan dan menutup modal edit/add data.


# Bagian 2: Server-side Programming (Bobot: 30%)

**2.1 (20%) Implementasikan script PHP untuk mengelola data dari formulir pada Bagian 1 menggunakan variabel global seperti `$_POST` atau `$_GET`. Tampilkan hasil pengolahan data ke layar.
Penjelasan:**  
- Method POST digunakan pada index.php untuk form login.
- Method GET digunakan pada tokobarokah.php untuk fitur search by nama/seri, fitur search by kategori, fitur logout, dan fitur delete data.
- Method POST digunakan pada tokobarokah.php untuk fitur add dan edit data.

**2.2 (10%) Buatlah sebuah objek PHP berbasis OOP yang memiliki minimal dua metode dan gunakan objek tersebut dalam skenario tertentu pada halaman web Anda.**


# Bagian 3: Database Management (Bobot: 20%)

**3.1 (5%) Buatlah sebuah tabel pada database MySQL
Penjelasan:**  
- Untuk membuat tabel barang 
	CREATE  TABLE  `barang` (
	`seri`  varchar(7) NOT  NULL,
	`nama`  varchar(50) NOT  NULL,
	`merk`  varchar(20) NOT  NULL,
	`kategori`  varchar(12) NOT  NULL,
	`harga`  bigint(255) NOT  NULL,
	`stok`  int(11) NOT  NULL
	)
- Untuk membuat tabel akun
	CREATE  TABLE  `akun` (
	`username`  varchar(16) NOT  NULL,
	`password`  varchar(32) NOT  NULL
	)

**3.2 (5%) Buatlah konfigurasi koneksi ke database MySQL pada file PHP. Pastikan koneksi berhasil dan dapat diakses.
Penjelasan:**  
- Untuk dapat terkoneksi dengan database, dibuat file db_connect.php seperti berikut:

>     <?php
>     $dbhost =  "localhost";
>     $dbuser =  "root";
>     $dbpass =  "";
>     $db =  "barokah";
>     $conn =  new  mysqli($dbhost, $dbuser, $dbpass, $db) or  die("Connect failed: %s\n"  . $conn->error);
>     ?>

**3.3 (10%) Lakukan manipulasi data pada tabel database dengan menggunakan query SQL. Misalnya, tambah data, ambil data, atau update data.
Penjelasan:**  
- Untuk dapat menambahkan data, dibuat file addBarang.php:

>     <?php  include  "db_connect.php";
>     session_start();
>     
>     // Tambahkan data jika form disubmit
>     if ($_SERVER["REQUEST_METHOD"] ==  "POST"  &&  isset($_POST["action"]) && $_POST["action"] ===  "add") {
>     $seri = $_POST["seri"];
>     $nama = $_POST["nama"];
>     $merk = $_POST["merk"];
>     $kategori = $_POST["kategori"];
>     $harga = $_POST["harga"];
>     $stok = $_POST["stok"];
>     
>     // Periksa apakah seri sudah ada
>     $check_seri_sql =  "SELECT  *  FROM barang WHERE seri='$seri'";
>     
>     $result_check_seri = $conn->query($check_seri_sql);
>     
>     if ($result_check_seri->num_rows >  0) {
>     echo  "Error: seri sudah ada dalam database.";
>     } else {
>     // Tambahkan data baru jika seri belum ada
>     $insert_sql =  "INSERT  INTO barang (seri, nama, merk, kategori, harga, stok) VALUES ('$seri', '$nama', '$merk','$kategori', '$harga',
>     '$stok')";
>     
>     if ($conn->query($insert_sql) ===  TRUE) {
>     $_SESSION["logadd"] =  "Data berhasil dimasukkan.";
>     header("Location: index.php");
>     exit();
>     } else {
>     $_SESSION["logadd"] =  "Data gagal dimasukkan.";
>     header("Location: index.php");
>     exit();
>     }
>     }
>     } else {
>     header("Location: index.php");
>     exit();
>     } ?>

- Untuk dapat mengedit data, dibuat file editBarang.php:


>     <?php
>     include  "db_connect.php";
>     session_start();
>     // Edit data jika form edit disubmit
>     if ($_SERVER["REQUEST_METHOD"] ==  "POST"  &&  isset($_POST["seri_lama"]) &&  isset($_POST["action"]) &&
>     $_POST["action"] ===  "edit") {
>     $seri_lama = $_POST["seri_lama"];
>     $seri_baru = $_POST["seri"];
>     $nama = $_POST["nama"];
>     $merk = $_POST["merk"];
>     $kategori = $_POST["kategori"];
>     $harga = $_POST["harga"];
>     $stok = $_POST["stok"];
>     
>     if ($seri_baru !== $seri_lama) {
>     // Periksa apakah seri baru sudah ada dalam database (selain seri yang sedang diubah)
>     $check_seri_sql =  "SELECT  *  FROM barang WHERE seri='$seri_baru'";
>     
>     $result_check_seri = $conn->query($check_seri_sql);
>     
>     if ($result_check_seri->num_rows >  0) {
>     echo  "Error: seri baru sudah ada dalam database.";
>     exit();
>     }
>     }
>     
>     // Tambahkan data baru jika seri belum ada
>     $update_sql =  "UPDATE barang SET seri='$seri_baru', nama='$nama', merk='$merk', kategori='$kategori', harga='$harga', stok='$stok' WHERE
>     seri='$seri_lama'";
>     
>     if ($conn->query($update_sql) ===  TRUE) {
>     $_SESSION["logadd"] =  "Data berhasil diupdate.";
>     header("Location: index.php");
>     exit();
>     } else {
>     $_SESSION["logadd"] =  "Data gagal diupdate.";
>     header("Location: index.php");
>     exit();
>     }
>     } else {
>     header("Location: index.php");
>     exit();
>     }
>     ?>
- Untuk dapat menghapus data, dibuat code seperti berikut:
> 
>     <?php
>     if (isset($_GET["hapus"])) {
>     $seri_to_delete = $_GET["hapus"];
>     $delete_sql =  "DELETE  FROM barang WHERE seri='$seri_to_delete'";
>     
>     if ($conn->query($delete_sql) ===  TRUE) {
>     $_SESSION["logadd"] =  "Data berhasil dihapus.";
>     exit(header('Location: '  . $_SERVER['PHP_SELF']));
>     } else {
>     $_SESSION["logadd"] =  "Data gagal dihapus.";
>     exit(header('Location: '  . $_SERVER['PHP_SELF']));
>     }
>     }
>     ?>

# Bagian 4: State Management (Bobot: 20%)

**4.1 (10%) Buatlah skrip PHP yang menggunakan session untuk menyimpan dan mengelola state pengguna. Implementasikan logika yang memanfaatkan session.**

**Penjelasan:**  
- Session digunakan pada login.php dan index.php untuk menyimpan username dan password yang user inputkan. Jika berhasil login, maka pada tokobarokah.php akan mengambil value session username untuk menampilkannya di page.
- Session digunakan pada semua fungsi CRUD agar dapat menampilkan session log ketika berhasil/gagal melakukan operasi CRUD

**4.2 (10%) Implementasikan pengelolaan state menggunakan cookie dan browser storage pada sisi client menggunakan JavaScript.
Penjelasan:**  
- Cookie digunakan pada index.php dengan cara mengambil value username dengan DOM kemudian menggunakan fungsi SetCookie lalu ketika sudah ada cookie, maka fungsi GetCookie akan melakukan validasi dan langsung malakukan redirect ke tokobarokah.php
- Cookie digunakan pada tokobarokah.php dengan melakukan fungsi getCookie untuk validasi cookie, jika tidak ada cookie maka user akan dikembalikan ke index.php

# Bagian Bonus: Hosting Aplikasi Web (Bobot: 20%)

Bagian bonus ini akan memberikan bobot tambahan 20% jika Anda berhasil meng-host aplikasi web yang Anda buat. Jawablah pertanyaan-pertanyaan berikut:

**1.  (5%) Apa langkah-langkah yang Anda lakukan untuk meng-host aplikasi web Anda?**
	Jawaban: Pertama, membuat akun 00webhost. Kemudian membuat url website. Lalu membuat database dan import database dari localhost ke database 00webhost. Lalu import semua file web (php, dan lain-lain) pada file manager. Web sudah berhasil dihosting
	
**2.  (5%) Pilih penyedia hosting web yang menurut Anda paling cocok untuk aplikasi web Anda. Berikan alasan Anda.**
	Jawaban: Saya memilih 00webhost karena gratis dan dapat mengelola database serta menjalankan fungsi dinamis php sebagaimana mestinya.
	
**3.  (5%) Bagaimana Anda memastikan keamanan aplikasi web yang Anda host?**
	Jawaban: Pertama, dengan memulai sesi menggunakan `session_start()`, script ini memastikan bahwa data pengguna dapat disimpan dan diteruskan antar halaman dengan aman. Fitur validasi data melalui fungsi `validate` membantu membersihkan input pengguna dari karakter berbahaya, mencegah potensi serangan manipulasi input. Pernyataan yang dipersiapkan (prepared statements) digunakan dalam kueri database, mengurangi risiko serangan SQL injection dengan memperlakukan input sebagai data bukan kode eksekusi. Fitur lainnya yaitu penanganan kesalahan dengan mengarahkan pengguna kembali ke halaman login jika username atau password kosong. Setelah login berhasil, script mengarahkan pengguna ke halaman tujuan (`tokobarokah.php`), mengurangi risiko akses tidak sah ke halaman yang memerlukan otentikasi.
	
**4.  (5%) Jelaskan konfigurasi server yang Anda terapkan untuk mendukung aplikasi web Anda.**
	Jawaban: Konfigurasi database dan file web. Pada 00webhost, username, nama, dan password database berbeda dengan localhost sehingga db_connect.php harus diubah confignya. Lalu mengimport database dari localhost ke database 00webhost agar database dan isi tabelnya sama. Terakhir, agar mempermudah proses upload file web, file web dibuat .zip kemudian memanfaatkan unzipper.php yang tersedia di github agar dapat melakukan extract zip di dalam file manager 00webhost.
