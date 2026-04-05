<?php
session_start();
include "../config/config.php";

if (isset($_GET['nis'])) {
    $nis = $_GET['nis'];

    // Perintah hapus berdasarkan NIS
    $delete = mysqli_query($conn, "DELETE FROM siswa WHERE nis = '$nis'");

    if ($delete) {
        echo "<script>alert('Siswa Purged! Data telah dihapus.'); window.location='data_siswa.php';</script>";
    } else {
        echo "<script>alert('Error! Gagal menghapus data.'); window.location='data_siswa.php';</script>";
    }
} else {
    header("Location: data_siswa.php");
}
?>