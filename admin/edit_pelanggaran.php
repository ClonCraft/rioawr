<?php
session_start();
include "../koneksi/koneksi.php";

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login/login.php");
    exit();
}

$id = $_GET['id'];

$data = mysqli_query($koneksi, "SELECT * FROM jenis_pelanggaran WHERE id_pelanggaran=$id");
$row = mysqli_fetch_assoc($data);

if (isset($_POST['update'])) {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $poin = (int) $_POST['poin'];

    mysqli_query($koneksi, "
        UPDATE jenis_pelanggaran 
        SET nama_pelanggaran='$nama', poin=$poin
        WHERE id_pelanggaran=$id
    ");

    header("Location: jenis_pelanggaran.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head><title>Edit Pelanggaran</title></head>
<body>

<h2>Edit Jenis Pelanggaran</h2>

<form method="post">
    <label>Nama Pelanggaran</label><br>
    <input type="text" name="nama" value="<?= $row['nama_pelanggaran']; ?>" required><br><br>

    <label>Poin</label><br>
    <input type="number" name="poin" value="<?= $row['poin']; ?>" required><br><br>

    <button type="submit" name="update">Update</button>
</form>

</body>
</html>
