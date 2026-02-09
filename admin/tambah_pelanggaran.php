<?php
session_start();
include "../koneksi/koneksi.php";

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login/login.php");
    exit();
}

if (isset($_POST['simpan'])) {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $poin = (int) $_POST['poin'];

    mysqli_query($koneksi, "
        INSERT INTO jenis_pelanggaran (nama_pelanggaran, poin)
        VALUES ('$nama', $poin)
    ");

    header("Location: jenis_pelanggaran.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head><title>Tambah Pelanggaran</title></head>
<body>

<h2>Tambah Jenis Pelanggaran</h2>

<form method="post">
    <label>Nama Pelanggaran</label><br>
    <input type="text" name="nama" required><br><br>

    <label>Poin</label><br>
    <input type="number" name="poin" required><br><br>

    <button type="submit" name="simpan">Simpan</button>
</form>

</body>
</html>
