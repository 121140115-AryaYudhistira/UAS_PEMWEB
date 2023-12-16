<?php
ob_start();
session_start();
include "db_connect.php";
if (isset($_GET['logout'])) {
    // Unset all session variables
    $_SESSION = array();
    // Destroy the session
    session_destroy();
    // Delete the 'username' cookie
    setcookie('username', '', time() - 3600, '/');
    // Redirect to the login page or any other appropriate page
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UAS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/tokobarokah.css">
</head>

<body>
    <div class="container">
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Cek apakah ada cookie
                var usernameCookie = getCookie('username');

                if (!usernameCookie) {
                    window.location.href = 'login.php';
                }
            });

            // Fungsi fetch cookie berdasarkan username
            function getCookie(name) {
                var cookies = document.cookie.split(';');
                for (var i = 0; i < cookies.length; i++) {
                    var cookie = cookies[i].trim();
                    if (cookie.indexOf(name + '=') === 0) {
                        return cookie.substring(name.length + 1);
                    }
                }
                return null;
            }
        </script>
        //fungsi fetch username untuk ditampilkan di page
        <?php
        if (isset($_SESSION['username'])) {
            echo "<div style='display:flex; align-self:end; align-items: center; justify-content:center;'>";
            echo "<p style='margin-right:10px;margin-top:30px;'>" . $_SESSION['username'] . "</p>";
            echo "<button onclick='logout()'>Logout</button>";
            echo "</div>";
        }
        ?>
        <h2>Data Barang Toko Komputer Barokah</h2>
        <div class="search-box">
            <h3 style="margin-bottom: -6px;">Pencarian:</h3>
            <form method="get">
                <div>
                    <label for="kategori_filter">Cari berdasarkan Kategori:</label>
                    <select name="kategori_filter" id="kategori_filter">
                        <option value="Semua Kategori">Semua Kategori</option>
                        <option value="PC">PC</option>
                        <option value="Laptop">Laptop</option>
                        <option value="Komponen">Komponen</option>
                        <option value="Aksesoris">Aksesoris</option>
                        <option value="Monitor">Monitor</option>
                    </select>
                </div>
                <label for="search">Cari berdasarkan Seri atau Nama:</label>
                <input type="text" name="search" id="search">
                <input type="submit" value="Cari">
            </form>
        </div>
        <?php if (isset($_SESSION['logadd'])) { ?>
            <p class="logadd"><?php echo $_SESSION['logadd']; ?> </p>
        <?php
            unset($_SESSION['logadd']);
        } ?>

        <?php

        if (isset($_GET["hapus"])) {
            $seri_to_delete = $_GET["hapus"];
            $delete_sql = "DELETE FROM barang WHERE seri='$seri_to_delete'";
            if ($conn->query($delete_sql) === TRUE) {
                $_SESSION["logadd"] = "Data berhasil dihapus.";
                exit(header('Location: ' . $_SERVER['PHP_SELF']));
            } else {
                $_SESSION["logadd"] = "Data gagal dihapus.";
                exit(header('Location: ' . $_SERVER['PHP_SELF']));
            }
        }

        // Query untuk mengambil data dari database
        $sql = "SELECT * FROM barang";

        // Filter data berdasarkan prodi jika dipilih
        if (isset($_GET['kategori_filter'])) {
            $kategori_filter = $_GET['kategori_filter'];
            if ($kategori_filter === "Semua Kategori") {
                $sql = "SELECT * FROM barang";
            } else {
                $sql .= " WHERE kategori='$kategori_filter'";
            }
        }

        if (isset($_GET['search'])) {
            $search = $_GET['search'];
            $sql .= (strpos($sql, 'WHERE') !== false) ? " AND (seri LIKE '%$search%' OR nama LIKE '%$search%')" : " WHERE (seri LIKE '%$search%' OR nama LIKE '%$search%')";
        }

        $result = $conn->query($sql);

        // Tampilkan data dalam tabel HTML
        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>Seri</th><th>Nama</th><th>Merk</th><th>Kategori</th><th>Harga</th><th>Stok</th><th>Aksi</th></tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>
            <td class='actions'>{$row['seri']}</td>
            <td class='actions'>{$row['nama']}</td>
            <td class='actions'>{$row['merk']}</td>
            <td class='actions'>{$row['kategori']}</td>
            <td class='actions'>{$row['harga']}</td>
            <td class='actions'>{$row['stok']}</td>
            <td class='actions'>
                <a href='javascript:void(0);' onclick=\"confirmDelete('{$row['seri']}')\">Hapus</a> | 
                <a href='javascript:void(0);' onclick=\"openModal('edit', '{$row['seri']}', '{$row['nama']}', '{$row['merk']}', '{$row['kategori']}', '{$row['harga']}', '{$row['stok']}')\">Edit</a>
            </td>
        </tr>";
            }


            echo "</table>";
        } else {
            echo "Tidak ada data.";
        }

        // Tutup koneksi
        $conn->close();
        ?>

        <div id="myModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <form method="post" id="formBarang">
                    <h3><span id="modalTitle">Tambah Data</span></h3>
                    <input type="hidden" name="action" id="action">
                    <div class="input-container">
                        <label for="seri">Seri:</label>
                        <input type="text" name="seri" id="seri" required>
                        <label for="nama">Nama:</label>
                        <input type="text" name="nama" id="nama" required>
                        <label for="merk">Merk:</label>
                        <input type="text" name="merk" id="merk" required>
                        <label for="kategori">Kategori:</label>
                        <select style="margin-top: -8px;" name="kategori" id="kategori">
                            <option value="PC">PC</option>
                            <option value="Laptop">Laptop</option>
                            <option value="Komponen">Komponen</option>
                            <option value="Aksesoris">Aksesoris</option>
                            <option value="Monitor">Monitor</option>
                        </select>
                        <label for="harga">Harga:</label>
                        <input type="number" name="harga" id="harga" required>
                        <label for="stok">Stok:</label>
                        <input type="number" name="stok" id="stok" required>
                    </div>
                    <input type="hidden" name="seri_lama" id="seri_lama">
                    <input type="submit" value="Simpan">


                </form>

            </div>
        </div>

        <div class="add-button" onclick="openModal('add','', '', '');">Tambah Data</div>
    </div>

    <script>
        function openModal(action, seri, nama, merk, kategori, harga, stok) {
            document.getElementById("modalTitle").innerText = (action === 'edit') ? "Edit Data" : "Tambah Data";
            document.getElementById("formBarang").action = `${action}Barang.php`;
            document.getElementById("myModal").style.display = "block";
            document.getElementById("action").value = action; // Tambahkan input hidden untuk menyimpan aksi (add atau edit)
            document.getElementById("seri").value = seri;
            document.getElementById("nama").value = nama;
            document.getElementById("merk").value = merk;
            document.getElementById("kategori").value = kategori;
            document.getElementById("harga").value = harga;
            document.getElementById("stok").value = stok;
            document.getElementById("seri_lama").value = seri;
        }

        function closeModal() {
            document.getElementById("myModal").style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == document.getElementById("myModal")) {
                closeModal();
            }
        }

        function confirmDelete(seri) {
            var confirmDelete = confirm("Apakah Anda yakin ingin menghapus data dengan seri " + seri + "?");

            if (confirmDelete) {
                window.location.href = "tokobarokah.php?hapus=" + seri;
            }
        }

        function logout() {
            var confirmLogout = confirm("Apakah Anda yakin ingin logout?");
            if (confirmLogout) {
                window.location.href = "tokobarokah.php?logout=1";
            }
        }
    </script>


</body>

</html>
<?php ob_end_flush(); ?>