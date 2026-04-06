<?php
session_start();
include "../config/config.php";

if (!isset($_GET['id'])) {
    header("Location: laporan_pindah.php");
    exit;
}

$id_surat = mysqli_real_escape_string($conn, $_GET['id']);

// Query Join Lengkap (Siswa, Ortu, Kelas, & Detail Pindah)
$sql = "SELECT sk.*, sp.*, s.*, k.rombel, t.tingkat, ow.wali, ow.ayah, ow.ibu, ow.alamat_ayah
        FROM surat_keluar sk
        JOIN surat_pindah sp ON sk.id_surat_pindah = sp.id_surat_pindah
        JOIN siswa s ON sk.nis = s.nis
        JOIN kelas k ON s.id_kelas = k.id_kelas
        JOIN tingkat t ON k.id_tingkat = t.id_tingkat
        LEFT JOIN ortu_wali ow ON s.id_ortu_wali = ow.id_ortu_wali
        WHERE sk.id_surat_keluar = '$id_surat'";

$query = mysqli_query($conn, $sql);
$d = mysqli_fetch_array($query);

// Logika Nama Ortu (Prioritas Wali, lalu Ayah, lalu Ibu)
$nama_ortu = $d['wali'] ?? ($d['ayah'] ?? ($d['ibu'] ?? '-'));

$bulan_indo = [1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Keterangan Pindah - <?= $d['nama_siswa'] ?></title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; background: #f0f0f0; margin: 0; padding: 20px; color: #000; line-height: 1.5; }
        .btn-area { max-width: 800px; margin: 0 auto 10px; display: flex; gap: 10px; justify-content: center; }
        .btn { padding: 8px 15px; border-radius: 5px; cursor: pointer; text-decoration: none; font-size: 14px; border: 1px solid #ccc; background: white; font-family: Arial, sans-serif; }
        
        .paper { width: 210mm; min-height: 297mm; padding: 15mm 20mm; margin: 0 auto; background: white; box-sizing: border-box; }
        .kop-surat { width: 100%; border-bottom: 3px double black; margin-bottom: 20px; padding-bottom: 5px; }
        .kop-surat img { width: 100%; display: block; }
        
        .title { text-align: center; font-weight: bold; font-size: 16px; text-decoration: underline; text-transform: uppercase; margin-bottom: 2px; }
        .nomor-surat { text-align: center; font-weight: bold; font-size: 15px; margin-bottom: 30px; }
        
        .content { font-size: 15px; text-align: justify; }
        .identitas { margin: 15px 0 15px 30px; border-collapse: collapse; width: 100%; }
        .identitas td { padding: 2px 0; vertical-align: top; }
        
        .paragraf { margin-bottom: 15px; text-indent: 0px; }

        .ttd-area { width: 100%; margin-top: 50px; }
        .ttd-table { width: 100%; }
        .ttd-table td { width: 50%; text-align: center; }
        .space { height: 80px; }
        .nama-ttd { font-weight: bold; text-decoration: underline; }

        @media print {
            body { background: none; padding: 0; }
            .btn-area { display: none; }
            .paper { box-shadow: none; margin: 0; width: 100%; height: 100%; }
            @page { margin: 0; size: A4; }
        }
    </style>
</head>
<body>

<div class="btn-area">
    <button onclick="window.history.back()" class="btn"> Kembali</button>
    <button onclick="window.print()" class="btn"> Cetak Surat Pindah</button>
</div>

<div class="paper">
    <div class="kop-surat">
        <img src="../img/cetak.jpg" alt="Kop Sekolah">
    </div>

    <div class="title">KETERANGAN PINDAH SEKOLAH</div>
    <div class="nomor-surat"><?= $d['no_surat'] ?></div>

    <div class="content">
        <div class="paragraf">
            Yang bertandatangan di bawah ini Kepala SMK TI BALI GLOBAL Denpasar, kecamatan Denpasar Selatan, Kota Denpasar, Provinsi Bali, Menerangkan bahwa :
        </div>

        <table class="identitas">
            <tr><td width="160">Nama Siswa</td><td width="20">:</td><td><b><?= $d['nama_siswa'] ?></b></td></tr>
            <tr><td>Kelas/Program</td><td>:</td><td><?= $d['tingkat'] ?> <?= $d['rombel'] ?></td></tr>
            <tr><td>NIS</td><td>:</td><td><?= $d['nis'] ?></td></tr>
            <tr><td>Jenis Kelamin</td><td>:</td><td><?= $d['jenis_kelamin'] ?></td></tr>
            <tr><td>Alamat</td><td>:</td><td><?= $d['alamat'] ?></td></tr>
        </table>

        <div class="paragraf">
            Sesuai dengan surat permohonan pindah sekolah dari Orang Tua/Wali siswa :
        </div>

        <table class="identitas">
            <tr><td width="160">Nama</td><td width="20">:</td><td><?= $nama_ortu ?></td></tr>
            <tr><td>Alamat</td><td>:</td><td><?= $d['alamat_ayah'] ?? '-' ?></td></tr>
        </table>

        <div class="paragraf">
            Telah mengajukan surat permohonan pindah ke <b><?= $d['sekolah_tujuan'] ?></b>, dengan alasan <b><?= $d['alasan_pindah'] ?></b> dan untuk kelengkapan administrasi sudah diselesaikan.
        </div>

        <div class="paragraf">
            Demikian surat pindah ini dibuat untuk dipergunakan sebagaimana mestinya.
        </div>
    </div>

    <div class="ttd-area">
        <table class="ttd-table">
            <tr>
                <td></td>
                <td>Denpasar, <?= date('d', strtotime($d['tanggal_pembuatan_surat'])) ?> <?= $bulan_indo[(int)date('m', strtotime($d['tanggal_pembuatan_surat']))] ?> <?= date('Y', strtotime($d['tanggal_pembuatan_surat'])) ?></td>
            </tr>
            <tr>
                <td></td>
                <td>Kepala SMK TI Bali Global Denpasar</td>
            </tr>
            <tr class="space"><td></td><td></td></tr>
            <tr>
                <td></td>
                <td class="nama-ttd">Drs. I Gusti Made Murjana, M.Pd.</td>
            </tr>
        </table>
    </div>
</div>

</body>
</html>