<?php
session_start();
include "../koneksi/koneksi.php";

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login/login.php");
    exit();
}

$id = $_GET['id'];

mysqli_query($koneksi, "DELETE FROM jenis_pelanggaran WHERE id_pelanggaran=$id");

header("Location: jenis_pelanggaran.php");
exit();
