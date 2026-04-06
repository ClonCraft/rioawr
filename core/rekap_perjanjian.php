<?php
session_start();
include "../config/config.php";

/**
 * 1. QUERY REKAP PERJANJIAN SISWA
 */
$sql_siswa = "SELECT ps.*, s.nama_siswa, s.nis, SUM(jp.poin) as total_poin 
              FROM perjanjian_siswa ps
              JOIN pelanggaran_siswa pls ON ps.id_pelanggaran_siswa = pls.id_pelanggaran_siswa
              JOIN siswa s ON pls.nis = s.nis 
              JOIN jenis_pelanggaran jp ON pls.id_jenis_pelanggaran = jp.id_jenis_pelanggaran
              GROUP BY ps.id_perjanjian_siswa
              ORDER BY ps.tanggal DESC";
$query_siswa = mysqli_query($conn, $sql_siswa);

/**
 * 2. QUERY REKAP PERJANJIAN ORANG TUA
 */
$sql_ortu = "SELECT po.*, s.nama_siswa, s.nis, SUM(jp.poin) as total_poin 
             FROM perjanjian_orang_tua po
             JOIN pelanggaran_siswa pls ON po.id_pelanggaran_siswa = pls.id_pelanggaran_siswa
             JOIN siswa s ON pls.nis = s.nis 
             JOIN jenis_pelanggaran jp ON pls.id_jenis_pelanggaran = jp.id_jenis_pelanggaran
             GROUP BY po.id_perjanjian_ortu
             ORDER BY po.tanggal DESC";
$query_ortu = mysqli_query($conn, $sql_ortu);

$bulan_indo = [1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekapitulasi Surat Perjanjian - RIO-SYS</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; background: #f0f0f0; margin: 0; padding: 20px; color: #000; }
        .btn-area { max-width: 900px; margin: 0 auto 10px; text-align: center; }
        .btn { padding: 8px 20px; border-radius: 5px; cursor: pointer; background: white; border: 1px solid #ccc; font-weight: bold; }
        
        .paper { width: 210mm; min-height: 297mm; padding: 15mm; margin: 0 auto; background: white; box-sizing: border-box; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .kop-surat { width: 100%; border-bottom: 3px double black; margin-bottom: 20px; padding-bottom: 5px; }
        .kop-surat img { width: 100%; display: block; }
        
        .title { text-align: center; font-weight: bold; font-size: 16px; text-transform: uppercase; margin-bottom: 30px; }
        .sub-title { font-weight: bold; font-size: 18px; margin: 30px 0 15px 0; display: block; }

        .table-rekap { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .table-rekap th, .table-rekap td { border: 1px solid black; padding: 10px; font-size: 13px; text-align: center; }
        .table-rekap th { background: #f2f2f2; }

        @media print {
            body { background: none; padding: 0; }
            .btn-area { display: none; }
            .paper { box-shadow: none; margin: 0; width: 100%; }
            @page { size: A4; margin: 0; }
        }
    </style>
</head>
<body>

<div class="btn-area">
    <button onclick="window.print()" class="btn">🖨️ Cetak Dokumen</button>
</div>

<div class="paper">
    <div class="kop-surat">
        <img src="../img/cetak.jpg" alt="Kop Sekolah">
    </div>

    <div class="title">LAPORAN REKAPITULASI SURAT PERJANJIAN</div>

    <span class="sub-title">Surat Perjanjian Siswa</span>
    <table class="table-rekap">
        <thead>
            <tr>
                <th width="40">No</th>
                <th width="150">Tanggal Pembuatan Surat</th>
                <th width="80">NIS</th>
                <th>Nama Siswa</th>
                <th width="70">Tingkat</th>
                <th width="100">Status Dokumen</th>
                <th width="70">Total Poin</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; while($s = mysqli_fetch_array($query_siswa)): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= date('d F Y', strtotime($s['tanggal'])) ?><br><small><?= date('H:i:s', strtotime($s['tanggal'])) ?></small></td>
                <td><?= $s['nis'] ?></td>
                <td style="text-align: left; padding-left: 15px;"><?= $s['nama_siswa'] ?></td>
                <td><?= $s['tingkat'] ?></td>
                <td><?= $s['status'] ?></td>
                <td><b><?= $s['total_poin'] ?></b></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <span class="sub-title">Surat Perjanjian Orang Tua</span>
    <table class="table-rekap">
        <thead>
            <tr>
                <th width="40">No</th>
                <th width="150">Tanggal Pembuatan Surat</th>
                <th width="80">NIS</th>
                <th>Nama Siswa</th>
                <th width="70">Tingkat</th>
                <th width="100">Status Dokumen</th>
                <th width="70">Total Poin</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; while($o = mysqli_fetch_array($query_ortu)): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= date('d F Y', strtotime($o['tanggal'])) ?><br><small><?= date('H:i:s', strtotime($o['tanggal'])) ?></small></td>
                <td><?= $o['nis'] ?></td>
                <td style="text-align: left; padding-left: 15px;"><?= $o['nama_siswa'] ?></td>
                <td><?= $o['tingkat'] ?></td>
                <td><?= $o['status'] ?></td>
                <td><b><?= $o['total_poin'] ?></b></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>