<?php
session_start();
include "../koneksi/koneksi.php";

// Proteksi halaman admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login/login.php");
    exit();
}

// Ambil data realtime dari database
// Total siswa
$result_siswa = mysqli_query($koneksi, "SELECT COUNT(*) AS total_siswa FROM siswa");
$row_siswa = mysqli_fetch_assoc($result_siswa);
$total_siswa = $row_siswa['total_siswa'];

// Total guru
$result_guru = mysqli_query($koneksi, "SELECT COUNT(*) AS total_guru FROM users WHERE role IN ('bk','mapel')");
$row_guru = mysqli_fetch_assoc($result_guru);
$total_guru = $row_guru['total_guru'];

// Total kelas aktif
$result_kelas = mysqli_query($koneksi, "SELECT COUNT(DISTINCT kelas) AS total_kelas FROM siswa");
$row_kelas = mysqli_fetch_assoc($result_kelas);
$total_kelas = $row_kelas['total_kelas'];

// Status sistem
$status_sistem = "Online";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: #333;
        }
        .header {
            background: rgba(255, 255, 255, 0.95);
            padding: 1rem 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header h1 { color: #667eea; }
        .nav { display: flex; gap: 1rem; }
        .nav a {
            text-decoration: none;
            color: #667eea;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            transition: background 0.3s;
        }
        .nav a:hover { background: #667eea; color: white; }

        .container { max-width: 1200px; margin: 2rem auto; padding: 0 2rem; }

        .welcome {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
            text-align: center;
        }
        .welcome h2 { color: #667eea; margin-bottom: 1rem; }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }
        .stat-card {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            text-align: center;
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        }
        .stat-card h3 { color: #667eea; margin-bottom: 1rem; }
        .stat-card .number {
            font-size: 2.5rem;
            font-weight: bold;
            color: #333;
        }

        .menu {
            display: flex;
            justify-content: space-evenly;
            gap: 20px;
            margin-bottom: 2rem;
        }
        .menu a {
            background: #667eea;
            color: white;
            padding: 20px 30px;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
            border-radius: 10px;
            text-align: center;
            width: 100%;
            max-width: 200px;
            transition: background 0.3s, transform 0.3s;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .menu a:hover {
            background: #5a6fd8;
            transform: translateY(-5px);
        }
        .menu a .icon {
            font-size: 40px;
            margin-bottom: 10px;
        }

        .footer {
            text-align: center;
            padding: 2rem;
            color: white;
            margin-top: 2rem;
        }
    </style>
</head>
<body>

<header class="header">
    <h1>Dashboard Admin</h1>
    <nav class="nav">
        <a href="../login/logout.php">Keluar</a>
    </nav>
</header>

<div class="container">
    <div class="welcome">
        <h2>Selamat Datang, <?= htmlspecialchars($_SESSION['username']); ?>!</h2>
        <p>Kelola sistem sekolah dengan mudah melalui dashboard ini.</p>
    </div>

    <div class="stats">
        <div class="stat-card">
            <h3>Total Siswa</h3>
            <div class="number"><?= $total_siswa; ?></div>
        </div>
        <div class="stat-card">
            <h3>Total Guru</h3>
            <div class="number"><?= $total_guru; ?></div>
        </div>
        <div class="stat-card">
            <h3>Jumlah Kelas Aktif</h3>
            <div class="number"><?= $total_kelas; ?></div>
        </div>
        <div class="stat-card">
            <h3>Status Sistem</h3>
            <div class="number" style="color: green;"><?= $status_sistem; ?></div>
        </div>
    </div>
</div>

<div class="menu">
    <a href="data_siswa.php">
        <span class="icon">👨‍🎓</span>
        Data Siswa
    </a>
    <a href="jenis_pelanggaran.php">
        <span class="icon">⚠️</span>
        Jenis Pelanggaran
    </a>
    <a href="laporan.php">
        <span class="icon">📊</span>
        Laporan
    </a>
</div>

<footer class="footer">
    <p>&copy; 2026 Sistem Manajemen Sekolah. Hak cipta dilindungi.</p>
</footer>

</body>
</html>
