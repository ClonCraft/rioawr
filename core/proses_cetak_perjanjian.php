<?php
session_start();
include "../config/config.php";

if (!isset($_POST['nis'])) {
    header("Location: laporan_panggilan.php");
    exit;
}

$nis = mysqli_real_escape_string($conn, $_POST['nis']);
$nama_ortu = $_POST['nama_ortu'];
$pekerjaan = $_POST['pekerjaan'];
$alamat = $_POST['alamat'];
$no_hp = $_POST['no_hp'];
$sebagai = $_POST['sebagai'];

$sql = "SELECT siswa.*, tingkat.tingkat, program_keahlian.program_keahlian, kelas.rombel,
        SUM(jenis_pelanggaran.poin) as total_poin
        FROM siswa 
        JOIN kelas ON siswa.id_kelas = kelas.id_kelas
        JOIN tingkat ON kelas.id_tingkat = tingkat.id_tingkat
        JOIN program_keahlian ON kelas.id_program_keahlian = program_keahlian.id_program_keahlian
        JOIN pelanggaran_siswa ON siswa.nis = pelanggaran_siswa.nis
        JOIN jenis_pelanggaran ON pelanggaran_siswa.id_jenis_pelanggaran = jenis_pelanggaran.id_jenis_pelanggaran
        WHERE siswa.nis = '$nis'
        GROUP BY siswa.nis";

$query = mysqli_query($conn, $sql);
$d = mysqli_fetch_array($query);

$bulan_indo = [1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Perjanjian - <?= $d['nama_siswa'] ?></title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; background: #f0f0f0; margin: 0; padding: 10px; color: #000; line-height: 1.3; }
        .btn-area { max-width: 800px; margin: 0 auto 5px; display: flex; gap: 10px; justify-content: center; }
        .btn { padding: 5px 15px; border-radius: 5px; cursor: pointer; text-decoration: none; font-size: 13px; border: 1px solid #ccc; background: white; }
        
        /* Layout A4 Optimasi */
        .paper { width: 210mm; height: 296mm; padding: 10mm 15mm; margin: 0 auto; background: white; box-sizing: border-box; overflow: hidden; }
        .kop-surat { width: 100%; border-bottom: 3px double black; margin-bottom: 15px; padding-bottom: 5px; }
        .kop-surat img { width: 100%; display: block; }
        
        .title { text-align: center; font-weight: bold; font-size: 15px; text-transform: uppercase; margin-bottom: 2px; }
        .subtitle { text-align: center; font-size: 13px; margin-bottom: 15px; }
        
        .content { font-size: 14px; text-align: justify; }
        .identitas { margin: 10px 0 10px 20px; }
        .identitas td { padding: 1px 0; vertical-align: top; }
        
        .poin-box { border: 2px solid black; padding: 8px; margin: 10px 0; text-align: center; font-weight: bold; font-size: 15px; background: #f9f9f9; }

        .ttd-table { width: 100%; margin-top: 20px; text-align: center; font-size: 14px; }
        .ttd-table td { width: 33%; vertical-align: top; }
        .space { height: 60px; } /* Diperpendek agar tidak luber */

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
    <button onclick="window.print()" class="btn"> Cetak</button>
</div>

<div class="paper">
    <div class="kop-surat">
        <img src="../img/cetak.jpg" alt="Kop Sekolah">
    </div>

    <div class="title">SURAT PERNYATAAN / PERJANJIAN SISWA</div>
    <div class="subtitle">Nomor: ..... / SMK TI-BG / <?= date('Y') ?></div>

    <div class="content">
        Yang bertanda tangan di bawah ini, saya selaku orang tua (<b><?= $sebagai ?></b>) dari :
        <table class="identitas">
            <tr><td width="130">Nama Siswa</td><td width="15">:</td><td><b><?= strtoupper($d['nama_siswa']) ?></b></td></tr>
            <tr><td>NIS / Kelas</td><td>:</td><td><?= $d['nis'] ?> / <?= $d['tingkat'] ?> <?= $d['rombel'] ?></td></tr>
            <tr><td>Program Keahlian</td><td>:</td><td><?= $d['program_keahlian'] ?></td></tr>
        </table>

        Menyatakan dengan sebenarnya data diri saya sebagai berikut :
        <table class="identitas">
            <tr><td width="130">Nama Orang Tua</td><td width="15">:</td><td><?= $nama_ortu ?></td></tr>
            <tr><td>Pekerjaan</td><td>:</td><td><?= $pekerjaan ?></td></tr>
            <tr><td>Alamat</td><td>:</td><td><?= $alamat ?></td></tr>
            <tr><td>No. HP</td><td>:</td><td><?= $no_hp ?></td></tr>
        </table>

        Bahwa sehubungan dengan pelanggaran tata tertib sekolah yang dilakukan oleh anak kami tersebut dengan akumulasi poin sebesar :

        <div class="poin-box">
            POIN PELANGGARAN SAAT INI : <?= $d['total_poin'] ?> POIN
        </div>

        Maka dengan ini kami menyatakan berjanji akan membimbing dan mengawasi anak kami dengan lebih ketat agar tidak mengulangi pelanggaran apapun. Apabila di kemudian hari anak kami mengulangi pelanggaran lagi, kami bersedia menerima sanksi sesuai aturan sekolah termasuk jika harus **Dikeluarkan / Dikembalikan** kepada orang tua.
        <br><br>
        Demikian surat pernyataan ini kami buat dengan sebenarnya untuk dipergunakan sebagaimana mestinya.
    </div>

    <table class="ttd-table">
        <tr>
            <td>Mengetahui,<br>Waka Kesiswaan</td>
            <td><br>Siswa</td>
            <td>Denpasar, <?= date('d') ?> <?= $bulan_indo[(int)date('m')] ?> <?= date('Y') ?><br>Orang Tua / Wali</td>
        </tr>
        <tr class="space">
            <td></td>
            <td></td>
            <td style="font-size: 9px; vertical-align: bottom;">(Materai 10.000)</td>
        </tr>
        <tr>
            <td style="text-decoration: underline; font-weight: bold;">Bagus Putu Eka Wijaya, S.Kom.</td>
            <td style="text-decoration: underline; font-weight: bold;"><?= $d['nama_siswa'] ?></td>
            <td style="text-decoration: underline; font-weight: bold;">( <?= $nama_ortu ?> )</td>
        </tr>
    </table>
</div>

</body>
</html>