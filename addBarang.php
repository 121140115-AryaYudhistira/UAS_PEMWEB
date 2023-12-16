<?php include "db_connect.php";
session_start();
// menambahkan data jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"]) && $_POST["action"] === "add") {
    $seri = $_POST["seri"];
    $nama = $_POST["nama"];
    $merk = $_POST["merk"];
    $kategori = $_POST["kategori"];
    $harga = $_POST["harga"];
    $stok = $_POST["stok"];

    // Periksa apakah seri sudah ada
    $check_seri_sql = "SELECT * FROM barang WHERE seri='$seri'";
    $result_check_seri = $conn->query($check_seri_sql);

    if ($result_check_seri->num_rows > 0) {
        echo "Error: seri sudah ada dalam database.";
    } else {
        // menambahkan data baru jika seri belum ada
        $insert_sql = "INSERT INTO barang (seri, nama, merk, kategori, harga, stok) VALUES ('$seri', '$nama', '$merk','$kategori', '$harga', '$stok')";
        if ($conn->query($insert_sql) === TRUE) {
            $_SESSION["logadd"] = "Data berhasil dimasukkan.";
            header("Location: index.php");
            exit();
        } else {
            $_SESSION["logadd"] = "Data gagal dimasukkan.";
            header("Location: index.php");
            exit();
        }
    }
} else {
    header("Location: index.php");
    exit();
}
