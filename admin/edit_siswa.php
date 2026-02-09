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

// ambil data siswa
$query = mysqli_query($koneksi, "SELECT * FROM siswa WHERE nis='$nis'");
$siswa = mysqli_fetch_assoc($query);

if (!$siswa) {
    die("Data siswa tidak ditemukan");
}

// proses update
if (isset($_POST['update'])) {
    $nama  = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $kelas = mysqli_real_escape_string($koneksi, $_POST['kelas']);

    $update = mysqli_query($koneksi, "
        UPDATE siswa 
        SET nama='$nama', kelas='$kelas'
        WHERE nis='$nis'
    ");

    if ($update) {
        header("Location: data_siswa.php");
        exit();
    } else {
        $error = "Gagal mengubah data";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Siswa</title>
</head>
<body>

<h2>Edit Siswa</h2>

<?php if (isset($error)) echo "<p style='color:red'>$error</p>"; ?>

<form method="post">
    <label>NIS</label><br>
    <input type="text" value="<?= $siswa['nis']; ?>" disabled><br><br>

    <label>Nama</label><br>
    <input type="text" name="nama" value="<?= $siswa['nama']; ?>" required><br><br>

    <label>Kelas</label><br>
    <input type="text" name="kelas" value="<?= $siswa['kelas']; ?>" required><br><br>

    <button type="submit" name="update">Simpan Perubahan</button>
</form>

</body>
</html>
