<?php
include "db_connect.php";
session_start();

// Edit data jika form edit disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["seri_lama"]) && isset($_POST["action"]) && $_POST["action"] === "edit") {
    $seri_lama = $_POST["seri_lama"];
    $seri_baru = $_POST["seri"];
    $nama = $_POST["nama"];
    $merk = $_POST["merk"];
    $kategori = $_POST["kategori"];
    $harga = $_POST["harga"];
    $stok = $_POST["stok"];

    if ($seri_baru !== $seri_lama) {
        // Periksa apakah seri baru sudah ada dalam database (selain seri yang sedang diubah)
        $check_seri_sql = "SELECT * FROM barang WHERE seri='$seri_baru'";
        $result_check_seri = $conn->query($check_seri_sql);

        if ($result_check_seri->num_rows > 0) {
            echo "Error: seri baru sudah ada dalam database.";
            exit();
        }
    }

    // Edit data baru jika seri belum ada
    $update_sql = "UPDATE barang SET seri='$seri_baru', nama='$nama', merk='$merk', kategori='$kategori', harga='$harga', stok='$stok' WHERE seri='$seri_lama'";

    if ($conn->query($update_sql) === TRUE) {
        $_SESSION["logadd"] = "Data berhasil diupdate.";
        header("Location: index.php");
        exit();
    } else {
        $_SESSION["logadd"] = "Data gagal diupdate.";
        header("Location: index.php");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
