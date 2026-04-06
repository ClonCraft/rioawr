<?php
session_start();
include "../config/config.php";

if (!isset($_GET['nis'])) {
    header("Location: laporan_pelanggaran.php");
    exit;
}

$nis = mysqli_real_escape_string($conn, $_GET['nis']);

// Query Data Siswa
$query_siswa = mysqli_query($conn, "SELECT siswa.*, tingkat.tingkat, program_keahlian.program_keahlian, kelas.rombel 
                                    FROM siswa 
                                    JOIN kelas ON siswa.id_kelas = kelas.id_kelas
                                    JOIN tingkat ON kelas.id_tingkat = tingkat.id_tingkat
                                    JOIN program_keahlian ON kelas.id_program_keahlian = program_keahlian.id_program_keahlian
                                    WHERE siswa.nis = '$nis'");
$s = mysqli_fetch_array($query_siswa);

// Query Pelanggaran
$query_pelanggaran = mysqli_query($conn, "SELECT pelanggaran_siswa.*, jenis_pelanggaran.jenis, jenis_pelanggaran.poin 
                                          FROM pelanggaran_siswa 
                                          JOIN jenis_pelanggaran ON pelanggaran_siswa.id_jenis_pelanggaran = jenis_pelanggaran.id_jenis_pelanggaran
                                          WHERE pelanggaran_siswa.nis = '$nis'
                                          ORDER BY pelanggaran_siswa.tanggal DESC");

$bulan_indo = [1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan - <?= $s['nama_siswa'] ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; background: #f0f0f0; }
        .btn-area { max-width: 800px; margin: 0 auto 10px; display: flex; gap: 10px; justify-content: center; }
        .btn { padding: 8px 15px; border-radius: 5px; cursor: pointer; text-decoration: none; font-size: 14px; border: 1px solid #ccc; background: white; }
        
        .paper { width: 210mm; min-height: 297mm; padding: 20mm; margin: 0 auto; background: white; box-sizing: border-box; }
        .kop-surat { width: 100%; border-bottom: 3px double black; margin-bottom: 20px; }
        .kop-surat img { width: 100%; display: block; }
        
        .title { text-align: center; font-weight: bold; font-size: 16px; margin-bottom: 30px; text-transform: uppercase; }
        
        .info-siswa { margin-bottom: 20px; font-size: 14px; }
        .info-siswa table { width: 100%; border: none; }
        .info-siswa td { padding: 3px 0; }
        .titik-titik { border-bottom: 1px dotted black; display: inline-block; width: 100%; }

        /* Tabel Mirip Gambar */
        .tabel-data { width: 100%; border-collapse: collapse; margin-top: 10px; border: 2px solid black; }
        .tabel-data th, .tabel-data td { border: 1px solid black; padding: 10px; font-size: 13px; }
        .tabel-data th { font-weight: bold; text-align: center; }
        
        .detail-row { font-size: 12px; }
        .total-label { text-align: right; font-weight: bold; padding-right: 20px; }
        .total-poin { text-align: center; font-weight: bold; font-size: 15px; }

        @media print {
            body { background: none; padding: 0; }
            .btn-area { display: none; }
            .paper { box-shadow: none; margin: 0; width: 100%; }
            @page { margin: 0; }
        }
    </style>
</head>
<body>

<div class="btn-area">
    <a href="laporan_pelanggaran.php" class="btn"> Kembali</a>
    <button onclick="window.print()" class="btn"> Cetak</button>
</div>

<div class="paper">
    <div class="kop-surat">
        <img src="../img/cetak.jpg" alt="Kop Sekolah">
    </div>

    <div class="title">LAPORAN PELANGGARAN SISWA</div>

    <div class="info-siswa">
        <table>
            <tr>
                <td width="130">Nama</td>
                <td width="10">:</td>
                <td class="titik-titik"><?= $s['nama_siswa'] ?></td>
            </tr>
            <tr>
                <td>NIS</td>
                <td>:</td>
                <td class="titik-titik"><?= $s['nis'] ?></td>
            </tr>
            <tr>
                <td>Kelas</td>
                <td>:</td>
                <td class="titik-titik"><?= $s['tingkat'] ?> <?= $s['rombel'] ?></td>
            </tr>
            <tr>
                <td>Program Keahlian</td>
                <td>:</td>
                <td class="titik-titik"><?= $s['program_keahlian'] ?></td>
            </tr>
            <tr>
                <td>Pelanggaran</td>
                <td>:</td>
                <td></td>
            </tr>
        </table>
    </div>

    <table class="tabel-data">
        <thead>
            <tr>
                <th width="40">No</th>
                <th width="150">Tanggal</th>
                <th>Jenis Pelanggaran</th>
                <th width="80">Point</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            $total = 0;
            while($p = mysqli_fetch_array($query_pelanggaran)): 
                $total += $p['poin'];
                $time = strtotime($p['tanggal']);
                $tgl = date('d', $time).' '.$bulan_indo[(int)date('m', $time)].' '.date('Y', $time);
            ?>
            <tr>
                <td rowspan="2" align="center" valign="middle"><?= $no++ ?></td>
                <td align="center">
                    <?= $tgl ?><br>
                    <small><?= date('H:i:s', $time) ?></small>
                </td>
                <td><?= $p['jenis'] ?></td>
                <td rowspan="2" align="center" valign="middle" class="total-poin"><?= $p['poin'] ?></td>
            </tr>
            <tr>
                <td colspan="2" class="detail-row">
                    Detail Pelanggaran : <?= $p['keterangan'] ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="total-label">Total Poin</td>
                <td class="total-poin"><?= $total ?></td>
            </tr>
        </tfoot>
    </table>
</div>

</body>
</html>