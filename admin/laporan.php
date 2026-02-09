<?php
session_start();
include "../koneksi/koneksi.php";

// PROTEKSI LOGIN ADMIN / BK
if (!isset($_SESSION['username']) || !in_array($_SESSION['role'], ['admin', 'bk'])) {
    header("Location: ../login/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pelanggaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: #333;
            margin: 0;
        }
        .container {
            max-width: 1200px;
            margin: 30px auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
        }
        h2 {
            margin-bottom: 10px;
            color: #5a67d8;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th, td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }
        th {
            background: #667eea;
            color: white;
        }
        .status-aman { color: green; font-weight: bold; }
        .status-peringatan { color: orange; font-weight: bold; }
        .status-bk { color: red; font-weight: bold; }
    </style>
</head>
<body>

<div class="container">

    <h2>📋 Laporan Pelanggaran Per Siswa</h2>

    <table>
        <tr>
            <th>Nama</th>
            <th>Kelas</th>
            <th>Total Poin</th>
            <th>Status</th>
        </tr>

        <?php
        $querySiswa = "
            SELECT nama, kelas, total_poin,
            CASE
                WHEN total_poin >= 75 THEN 'BK'
                WHEN total_poin >= 50 THEN 'Peringatan'
                ELSE 'Aman'
            END AS status
            FROM siswa
            ORDER BY total_poin DESC
        ";
        $resultSiswa = mysqli_query($koneksi, $querySiswa);

        while ($row = mysqli_fetch_assoc($resultSiswa)) {
            $statusClass = strtolower($row['status']);
            echo "
            <tr>
                <td>{$row['nama']}</td>
                <td>{$row['kelas']}</td>
                <td>{$row['total_poin']}</td>
                <td class='status-$statusClass'>{$row['status']}</td>
            </tr>
            ";
        }
        ?>
    </table>

    <h2>📊 Laporan Pelanggaran Per Kelas</h2>

    <table>
        <tr>
            <th>Kelas</th>
            <th>Jumlah Siswa</th>
            <th>Total Poin</th>
        </tr>

        <?php
        $queryKelas = "
            SELECT kelas, COUNT(*) AS jumlah_siswa, SUM(total_poin) AS total_poin
            FROM siswa
            GROUP BY kelas
            ORDER BY total_poin DESC
        ";
        $resultKelas = mysqli_query($koneksi, $queryKelas);

        while ($row = mysqli_fetch_assoc($resultKelas)) {
            echo "
            <tr>
                <td>{$row['kelas']}</td>
                <td>{$row['jumlah_siswa']}</td>
                <td>{$row['total_poin']}</td>
            </tr>
            ";
        }
        ?>
    </table>

</div>

</body>
</html>
