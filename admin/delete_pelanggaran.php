<?php
session_start();
include "../koneksi/koneksi.php"; // Pastikan path ini benar

// Proteksi halaman admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login/login.php");
    exit();
}

// Mendapatkan id pelanggaran dari URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Menghapus data pelanggaran dari database
    $query = "DELETE FROM jenis_pelanggaran WHERE id_pelanggaran = $id";
    if (mysqli_query($koneksi, $query)) {
        header("Location: jenis_pelanggaran.php");  // Redirect kembali ke halaman jenis pelanggaran
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>
