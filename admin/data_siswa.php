<?php
session_start();
include "../koneksi/koneksi.php";

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login/login.php");
    exit();
}

$query = "SELECT * FROM siswa";
$result = mysqli_query($koneksi, $query);

if (!$result) {
    die("Query Error: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa - Dashboard Admin</title>
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
        .nav { display: flex; gap: 1rem; }
        .nav a {
            text-decoration: none;
            color: #667eea;
            padding: 0.5rem 1rem;
            border-radius: 5px;
        }
        .nav a:hover { background: #667eea; color: white; }

        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 2rem;
        }

        .welcome {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 1rem;
            text-align: center;
        }

        .action-bar {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 1rem;
        }

        .btn-tambah {
            background: #667eea;
            color: white;
            padding: 10px 18px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 14px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        th { background: #667eea; color: white; }
        tr:hover { background: #f1f1f1; }

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
        <a href="../login/logout.php">Keluar</a>
    </nav>
</header>

<div class="container">

    <div class="welcome">
        <h2>Data Siswa</h2>
        <p>Kelola dan lihat data siswa yang terdaftar di sekolah.</p>
    </div>

    <div class="action-bar">
        <a href="tambah_siswa.php" class="btn-tambah">+ Tambah Siswa</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>NIS</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Total Poin</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= $row['nis']; ?></td>
                    <td><?= $row['nama']; ?></td>
                    <td><?= $row['kelas']; ?></td>
                    <td><?= $row['total_poin']; ?></td>
                    <td>
                        <a href="edit_siswa.php?nis=<?= $row['nis']; ?>">Edit</a> |
                        <a href="delete_siswa.php?nis=<?= $row['nis']; ?>"
                           onclick="return confirm('Yakin ingin menghapus data ini?')">
                           Hapus
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="5">Data siswa belum tersedia.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<footer class="footer">
    <p>&copy; 2026 Sistem Manajemen Sekolah. Hak cipta dilindungi.</p>
</footer>

</body>
</html>
