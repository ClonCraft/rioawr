<?php
session_start();
include "../koneksi/koneksi.php";

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login/login.php");
    exit();
}

$result = mysqli_query($koneksi, "SELECT * FROM jenis_pelanggaran");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Jenis Pelanggaran</title>

<style>
    * { box-sizing: border-box; }
    body {
        margin: 0;
        font-family: 'Segoe UI', sans-serif;
        background: linear-gradient(135deg, #667eea, #764ba2);
    }

    .header {
        background: #fff;
        padding: 20px 40px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 2px 10px rgba(0,0,0,.1);
    }
    .header h1 { color: #667eea; margin: 0; }
    .nav a {
        text-decoration: none;
        color: #667eea;
        margin-left: 20px;
        font-weight: 500;
    }

    .container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 0 20px;
    }

    .card {
        background: white;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0,0,0,.15);
        text-align: center;
        margin-bottom: 20px;
    }

    .action-bar {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 15px;
    }

    .btn-tambah {
        background: #6c8cff;
        color: white;
        padding: 10px 18px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: bold;
    }

    table {
        width: 100%;
        background: white;
        border-collapse: collapse;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,.15);
    }
    th {
        background: #6c8cff;
        color: white;
        padding: 14px;
    }
    td {
        padding: 14px;
        text-align: center;
        border-bottom: 1px solid #ddd;
    }

    .aksi a {
        text-decoration: none;
        margin: 0 5px;
        font-weight: 500;
    }
    .edit { color: #6c8cff; }
    .hapus { color: #e74c3c; }

    .footer {
        text-align: center;
        color: white;
        margin: 40px 0;
    }
</style>
</head>

<body>

<div class="header">
    <h1>Dashboard Admin</h1>
    <div class="nav">
        <a href="dashboard.php">Dashboard</a>
        <a href="../login/logout.php">Keluar</a>
    </div>
</div>

<div class="container">

    <div class="card">
        <h2>Jenis Pelanggaran</h2>
        <p>Kelola jenis pelanggaran dan poin yang diberikan.</p>
    </div>

    <div class="action-bar">
        <a href="tambah_pelanggaran.php" class="btn-tambah">+ Tambah Pelanggaran</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Pelanggaran</th>
                <th>Poin</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= $row['id_pelanggaran']; ?></td>
                <td><?= $row['nama_pelanggaran']; ?></td>
                <td><?= $row['poin']; ?></td>
                <td class="aksi">
                    <a class="edit" href="edit_pelanggaran.php?id=<?= $row['id_pelanggaran']; ?>">Edit</a> |
                    <a class="hapus" href="hapus_pelanggaran.php?id=<?= $row['id_pelanggaran']; ?>"
                       onclick="return confirm('Yakin ingin menghapus data ini?')">
                       Hapus
                    </a>
                </td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="4">Data pelanggaran belum tersedia</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="footer">
    © 2026 Sistem Manajemen Sekolah
</div>

</body>
</html>
