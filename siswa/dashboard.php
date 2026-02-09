<?php
session_start();
include "../koneksi/koneksi.php";

// Proteksi halaman siswa
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'siswa') {
    header("Location: ../login/login.php");
    exit;
}

$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Siswa</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #ff758c, #ff7eb3);
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
        header h1 { color: #ff4a6f; }

        nav {
            display: flex;
            gap: 15px;
        }
        nav a {
            text-decoration: none;
            color: #ff4a6f;
            font-weight: bold;
            padding: 8px 15px;
            border-radius: 5px;
            transition: 0.3s;
        }
        nav a:hover {
            background-color: #ff4a6f;
            color: #fff;
        }

        .container { max-width: 900px; margin: 60px auto; padding:0 20px; }

        .welcome {
            background: #fff;
            padding: 40px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .welcome h2 { color: #ff4a6f; margin-bottom: 10px; }
        .welcome p { font-size: 16px; color: #555; margin-top: 10px; }

        /* Menu */
        .menu {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 30px;
            gap: 20px;
        }
        .menu a {
            display: inline-block;
            width: 160px;
            padding: 20px;
            background: #ff4a6f;
            color: #fff;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
            border-radius: 10px;
            text-align: center;
            transition: 0.3s;
        }
        .menu a:hover { background: #e03d5c; }

        /* Logo di atas menu */
        .menu a .icon {
            display: block;
            font-size: 40px; /* bisa diganti dengan gambar logo */
            margin-bottom: 10px;
        }

        footer {
            text-align: center;
            color: #fff;
            margin-top: 60px;
            padding-bottom: 20px;
        }
    </style>
</head>
<body>

<header>
    <h1>Dashboard Siswa</h1>
    <nav>
        <a href="../login/logout.php">Logout</a>
    </nav>
</header>

<div class="container">
    <div class="welcome">
        <h2>Selamat Datang, <?= htmlspecialchars($username); ?>!</h2>
        <p>Anda login sebagai <b>Siswa</b>.</p>
        <p>Pilih menu di bawah untuk mengakses fitur sistem.</p>
    </div>

    <div class="menu">
        <a href="riwayat_pelanggaran.php">
            <span class="icon">📄</span>
            Riwayat Pelanggaran
        </a>
        <a href="peringatan.php">
            <span class="icon">⚠️</span>
            Peringatan / Info
        </a>
    </div>
</div>

<footer>
    <p>&copy; 2026 Sistem Pelanggaran Siswa</p>
</footer>

</body>
</html>
