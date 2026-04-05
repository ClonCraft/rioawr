<?php
session_start();
include "../config/config.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $delete = mysqli_query($conn, "DELETE FROM kelas WHERE id_kelas = '$id'");

    if ($delete) {
        echo "<script>alert('Sistem: Data Kelas Terhapus!'); window.location='data_kelas.php';</script>";
    } else {
        echo "<script>alert('Gagal! Data ini mungkin masih digunakan oleh tabel Siswa.'); window.location='data_kelas.php';</script>";
    }
}
?>