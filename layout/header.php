<?php
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Dashboard Admin'; ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
        .nav {
            display: flex;
            gap: 1rem;
        }
        .nav a {
            text-decoration: none;
            color: #667eea;
            padding: 0.5rem 1rem;
            border-radius: 5px;
        }
        .nav a:hover {
            background: #667eea;
            color: white;
        }
        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 2rem;
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
        <a href="dashboard.php">Dashboard</a>
        <a href="data_siswa.php">Data Siswa</a>
        <a href="jenis_pelanggaran.php">Jenis Pelanggaran</a>
        <a href="../login/logout.php">Keluar</a>
    </nav>
</header>

<div class="container">
