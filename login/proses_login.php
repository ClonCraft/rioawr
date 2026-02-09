<?php
session_start();
include "../koneksi/koneksi.php";

$username = $_POST['username'];
$password = ($_POST['password']);

$query = mysqli_query($koneksi,
    "SELECT * FROM users 
     WHERE username='$username' AND password='$password'");

$data = mysqli_fetch_assoc($query);

if ($data) {
    $_SESSION['id_user'] = $data['id_user'];
    $_SESSION['username'] = $data['username'];
    $_SESSION['role'] = $data['role'];

    if ($data['role'] == 'admin') {
        header("Location: ../admin/dashboard.php");
        exit;
    } elseif ($data['role'] == 'bk') {
        header("Location: ../guru_bk/dashboard.php");
        exit;
    } elseif ($data['role'] == 'mapel') {
        header("Location: ../guru_mapel/dashboard.php");
        exit;
    } elseif ($data['role'] == 'siswa') {
        header("Location: ../siswa/dashboard.php");
        exit;
    }
} else {
    echo "<script>
        alert('Username atau Password salah!');
        window.location='login.php';
    </script>";
}
?>
