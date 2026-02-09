<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: ../index.php");
}
?>
<h2>Dashboard Guru</h2>
<p>Selamat datang, <?= $_SESSION['nama']; ?></p>

<ul>
    <li><a href="#">Data Siswa</a></li>
    <li><a href="#">Data Pelanggaran</a></li>
    <li><a href="../auth/logout.php">Logout</a></li>
</ul>
