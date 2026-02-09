<?php
session_start();
include "../koneksi/koneksi.php";

if (isset($_POST['username'])) {

    $nama     = $_POST['nama'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $kelas    = $_POST['kelas'];
    $role     = 'siswa';

    $query = "INSERT INTO users (nama, username, password, kelas, role)
              VALUES ('$nama', '$username', '$password', '$kelas', '$role')";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>
                alert('Registrasi berhasil!');
                window.location='login.php';
              </script>";
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
