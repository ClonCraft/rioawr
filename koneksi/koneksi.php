<?php
$host     = "localhost";
$user     = "root";        // sesuaikan username database
$password = "";            // sesuaikan password database
$database = "db_pss";

// Membuat koneksi
$koneksi = mysqli_connect($host, $user, $password, $database);

// Cek koneksi
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>
