<?php
session_start();
// Menentukan path utama proyek agar mudah memanggil file lain
define('ROOTPATH', $_SERVER['DOCUMENT_ROOT'] . '/UK_RIO');

// Menyertakan file konfigurasi database
include ROOTPATH . "/config/config.php";

//mengambil data dari form
$username = $_POST['username'];
$password_input = $_POST['password'];

//query untuk mengambil data guru dan siswa dari database
$query_guru = mysqli_query($conn, "SELECT nama_pengguna, username, password, role FROM guru WHERE username = '$username'");
$query_siswa = mysqli_query($conn, "SELECT nama_siswa, nis, password FROM siswa WHERE nis = '$username'");

//mengecek apakah akun guru ada atau tidak
if(mysqli_num_rows($query_guru) > 0){
    //mengambil data guru
    $row_guru = mysqli_fetch_assoc($query_guru);
    //mengecek password guru
    if(password_verify($password_input, $row_guru['password'])){
        $_SESSION['username'] = $username;
        $_SESSION['nama_pengguna'] = $row_guru['nama_pengguna'];
        $_SESSION['role'] = $row_guru['role'];
        header("Location: ../pages/dashboard.php");
    }else{
        echo "password Salah";
    }
//mengecek apakah akun siswa ada atau tidak
}elseif(mysqli_num_rows($query_siswa) > 0){
    //mengambil data siswa
    $row_siswa = mysqli_fetch_assoc($query_siswa);
    //mengecek password siswa
    if(password_verify($password_input, $row_siswa['password'])){
        $_SESSION['username'] = $username;
        $_SESSION['nama_pengguna'] = $row_siswa['nama_siswa'];
        $_SESSION['role'] = "siswa";
        header("Location: ../pages/dashboard.php");
    }else{
        echo "password Salah";
    }
}else{
    echo "akun tidak ditemukan";
}


?>