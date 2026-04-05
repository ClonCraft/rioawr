<?php
session_start();
include "../config/config.php";

// 1. Cek apakah ada ID yang dikirim lewat URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // 2. Jalankan perintah hapus berdasarkan id_jenis_pelanggaran
    $delete = mysqli_query($conn, "DELETE FROM jenis_pelanggaran WHERE id_jenis_pelanggaran = '$id'");

    // 3. Cek apakah berhasil atau gagal
    if ($delete) {
        // Jika berhasil, tampilkan alert dan lempar balik ke halaman data_jenis
        echo "<script>
                alert('SYSTEM: Kategori Pelanggaran Berhasil Dimusnahkan!');
                window.location='data_jenis.php';
              </script>";
    } else {
        // Jika gagal (biasanya karena ID ini sedang dipakai di tabel lain)
        echo "<script>
                alert('ERROR: Gagal menghapus data. Data mungkin sedang digunakan oleh sistem!');
                window.location='data_jenis.php';
              </script>";
    }
} else {
    // Jika tidak ada ID, langsung balik ke halaman utama
    header("Location: data_jenis.php");
}
?>