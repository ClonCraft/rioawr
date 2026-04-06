<?php
session_start();
include "../config/config.php";

if (!isset($_GET['id'])) {
    header("Location: laporan_panggilan.php");
    exit;
}

$id_surat = mysqli_real_escape_string($conn, $_GET['id']);

$sql = "SELECT surat_keluar.*, siswa.nama_siswa, tingkat.tingkat, kelas.rombel 
        FROM surat_keluar 
        JOIN siswa ON surat_keluar.nis = siswa.nis 
        JOIN kelas ON siswa.id_kelas = kelas.id_kelas
        JOIN tingkat ON kelas.id_tingkat = tingkat.id_tingkat
        WHERE surat_keluar.id_surat_keluar = '$id_surat'";

$query = mysqli_query($conn, $sql);
$d = mysqli_fetch_array($query);

function hari_indo($tanggal){
    $hari = date('D', strtotime($tanggal));
    $list_hari = ['Sun'=>'Minggu','Mon'=>'Senin','Tue'=>'Selasa','Wed'=>'Rabu','Thu'=>'Kamis','Fri'=>'Jumat','Sat'=>'Sabtu'];
    return $list_hari[$hari];
}

$bulan_indo = [1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Surat Panggilan - <?= $d['nama_siswa'] ?></title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; background: #f0f0f0; margin: 0; padding: 10px; color: #000; line-height: 1.3; }
        .btn-area { max-width: 800px; margin: 0 auto 5px; display: flex; gap: 10px; justify-content: center; }
        .btn { padding: 5px 15px; border-radius: 5px; cursor: pointer; text-decoration: none; font-size: 13px; border: 1px solid #ccc; background: white; font-family: Arial, sans-serif; }
        
        /* Layout A4 Optimasi */
        .paper { width: 210mm; height: 296mm; padding: 10mm 15mm; margin: 0 auto; background: white; box-sizing: border-box; overflow: hidden; }
        .kop-surat { width: 100%; border-bottom: 3px double black; margin-bottom: 15px; padding-bottom: 5px; }
        .kop-surat img { width: 100%; display: block; }
        
        .content { font-size: 15px; }
        .table-no { width: 100%; margin-bottom: 15px; }
        .table-no td { vertical-align: top; padding: 1px 0; }

        .kepada { margin-bottom: 15px; }
        .isi-surat { text-align: justify; margin-bottom: 10px; }
        
        .table-detail { margin: 10px 0 10px 30px; }
        .table-detail td { padding: 2px 0; }

        .penutup { margin-bottom: 20px; }

        .ttd-table { width: 100%; margin-top: 30px; text-align: center; }
        .ttd-table td { width: 50%; vertical-align: top; }
        .space { height: 65px; } /* Dipangkas agar tidak luber */
        .nama-ttd { font-weight: bold; text-decoration: underline; }

        @media print {
            @page { margin: 0; size: A4; }
            body { background: none; padding: 0; margin: 0; }
            .btn-area { display: none; }
            .paper { box-shadow: none; margin: 0; width: 100%; height: 100%; padding: 15mm; }
        }
    </style>
</head>
<body>

<div class="btn-area">
    <button onclick="window.history.back()" class="btn"> Kembali</button>
    <button onclick="window.print()" class="btn"> Cetak Surat</button>
</div>

<div class="paper">
    <div class="kop-surat">
        <img src="../img/cetak.jpg" alt="Kop Sekolah">
    </div>

    <div class="content">
        <table class="table-no">
            <tr><td width="80">No.</td><td width="20">:</td><td><?= $d['no_surat'] ?></td></tr>
            <tr><td>Lamp.</td><td>:</td><td>-</td></tr>
            <tr><td>Perihal</td><td>:</td><td><b>Pemanggilan Orang Tua / Wali Siswa</b></td></tr>
        </table>

        <div class="kepada">
            Kepada<br>
            Yth. Bapak/ Ibu<br>
            <table style="margin-left: 20px; margin-top: 2px;">
                <tr><td width="140">Orang Tua / Wali dari</td><td width="15">:</td><td><b><?= $d['nama_siswa'] ?></b></td></tr>
                <tr><td>Kelas / Nis</td><td>:</td><td><?= $d['tingkat'] ?> <?= $d['rombel'] ?> / <?= $d['nis'] ?></td></tr>
            </table>
        </div>

        <div class="isi-surat">
            Dengan hormat,<br>
            Bersama surat ini, kami mengharapkan kehadiran Bapak / Ibu pada :
        </div>

        <table class="table-detail">
            <tr>
                <td width="140">Hari / Tanggal</td><td width="15">:</td>
                <td><?= hari_indo($d['tanggal_pemanggilan']) ?> / <?= date('d', strtotime($d['tanggal_pemanggilan'])) ?> <?= $bulan_indo[(int)date('m', strtotime($d['tanggal_pemanggilan']))] ?> <?= date('Y', strtotime($d['tanggal_pemanggilan'])) ?></td>
            </tr>
            <tr><td>Pukul</td><td>:</td><td><?= date('H:i', strtotime($d['tanggal_pemanggilan'])) ?> WITA</td></tr>
            <tr><td>Tempat</td><td>:</td><td>SMK TI Bali Global Denpasar</td></tr>
            <tr><td>Keperluan</td><td>:</td><td><?= $d['keperluan'] ?></td></tr>
        </table>

        <div class="penutup">
            Demikian surat ini kami sampaikan, besar harapan kami pertemuan ini agar tidak diwakilkan. Atas perhatian dan kerjasamanya, kami ucapkan terimakasi.
        </div>

        <table class="ttd-table">
            <tr>
                <td>Mengetahui,<br>Waka Kesiswaan</td>
                <td>Denpasar, <?= date('d', strtotime($d['tanggal_pembuatan_surat'])) ?> <?= $bulan_indo[(int)date('m', strtotime($d['tanggal_pembuatan_surat']))] ?> <?= date('Y', strtotime($d['tanggal_pembuatan_surat'])) ?><br>Guru BK</td>
            </tr>
            <tr class="space"><td></td><td></td></tr>
            <tr>
                <td class="nama-ttd">Bagus Putu Eka Wijaya, S.Kom.</td>
                <td class="nama-ttd">Ida Gusti Ayu Rinjani, M.Pd.</td>
            </tr>
        </table>
    </div>
</div>

</body>
</html>