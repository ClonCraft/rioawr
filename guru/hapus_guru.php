<?php
session_start();
include "../config/config.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Menghapus berdasarkan kode_guru sesuai database kamu
    $delete = mysqli_query($conn, "DELETE FROM guru WHERE kode_guru = '$id'");

    if ($delete) {
        echo "<script>alert('Access Revoked! Data Guru Telah Dihapus.'); window.location='data_guru.php';</script>";
    } else {
        echo "<script>alert('System Error! Gagal Menghapus Data.'); window.location='data_guru.php';</script>";
    }
} else {
    header("Location: data_guru.php");
}
?>