<?php
session_start();
include "../koneksi/koneksi.php";

// Proteksi halaman (guru BK & guru mapel)
if (!isset($_SESSION['username']) || 
   ($_SESSION['role'] != 'bk') ) {
    header("Location: ../login/login.php");
    exit;
}

$username = $_SESSION['username'];
$role = $_SESSION['role'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Guru</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #43cea2, #185a9d);
            min-height: 100vh;
            color: #333;
        }
        header {
            background: #fff;
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        header h1 {
            color: #185a9d;
        }
        nav a {
            text-decoration: none;
            margin-left: 15px;
            color: #185a9d;
            font-weight: bold;
        }
        nav a:hover {
            text-decoration: underline;
        }
        .container {
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 20px;
        }
        .welcome {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .welcome h2 {
            margin-bottom: 10px;
            color: #185a9d;
        }
        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
        }
        .card {
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }
        .card:hover {
            transform: translateY(-6px);
        }
        .card h3 {
            color: #185a9d;
            margin-bottom: 10px;
        }
        .card p {
            margin-bottom: 15px;
        }
        .card a {
            display: inline-block;
            padding: 10px 18px;
            background: #185a9d;
            color: #fff;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
        }
        .card a:hover {
            background: #123f6d;
        }
        footer {
            text-align: center;
            color: #fff;
            margin-top: 40px;
            padding-bottom: 20px;
        }
    </style>
</head>
<body>

<header>
    <h1>Dashboard Guru</h1>
    <nav>
        <a href="dashboard.php">Dashboard</a>
        <a href="../login/logout.php">Logout</a>
    </nav>
</header>

<div class="container">

    <div class="welcome">
        <h2>Selamat Datang, <?= htmlspecialchars($username); ?></h2>
        <p>
            Anda login sebagai 
            <b><?= ($role == 'bk') ? 'Guru BK' : 'Guru Mata Pelajaran'; ?></b>
        </p>
    </div>

    <div class="cards">
        <div class="card">
            <h3>Entry Pelanggaran</h3>
            <p>Input pelanggaran siswa beserta poin.</p>
            <a href="entry_pelanggaran.php">Masuk</a>
        </div>

        <?php if ($role == 'bk') { ?>
        <div class="card">
            <h3>Proses Surat</h3>
            <p>Cetak surat panggilan, perjanjian, dan pindah.</p>
            <a href="surat.php">Masuk</a>
        </div>

        <div class="card">
            <h3>Laporan</h3>
            <p>Lihat dan cetak laporan pelanggaran siswa.</p>
            <a href="laporan.php">Masuk</a>
        </div>
        <?php } ?>
    </div>

</div>

<footer>
    <p>&copy; 2026 Sistem Pelanggaran Siswa</p>
</footer>

</body>
</html>
