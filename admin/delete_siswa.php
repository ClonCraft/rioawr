<?php
session_start();
include "../koneksi/koneksi.php";

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login/login.php");
    exit();
}

if (!isset($_GET['nis'])) {
    header("Location: data_siswa.php");
    exit();
}

$nis = mysqli_real_escape_string($koneksi, $_GET['nis']);

$hapus = mysqli_query($koneksi, "DELETE FROM siswa WHERE nis='$nis'");

if ($hapus && mysqli_affected_rows($koneksi) > 0) {
    header("Location: data_siswa.php");
    exit();
} else {
    die("Data gagal dihapus atau tidak ditemukan");
}
