<?php
session_start();
include "../config/config.php";
include "../includes/header.php";

/** * 1. QUERY POIN > 25 
 **/
$sql_25 = "SELECT s.nis, s.nama_siswa, GROUP_CONCAT(DISTINCT jp.jenis SEPARATOR ', ') as daftar, SUM(jp.poin) as total 
           FROM pelanggaran_siswa ps 
           JOIN siswa s ON ps.nis = s.nis 
           JOIN jenis_pelanggaran jp ON ps.id_jenis_pelanggaran = jp.id_jenis_pelanggaran
           GROUP BY s.nis HAVING total >= 25";
$query_25 = mysqli_query($conn, $sql_25);

/** * 2. QUERY POIN > 50 (Calon Perjanjian)
 **/
$sql_50 = "SELECT s.nis, s.nama_siswa, GROUP_CONCAT(DISTINCT jp.jenis SEPARATOR ', ') as daftar, SUM(jp.poin) as total 
           FROM pelanggaran_siswa ps 
           JOIN siswa s ON ps.nis = s.nis 
           JOIN jenis_pelanggaran jp ON ps.id_jenis_pelanggaran = jp.id_jenis_pelanggaran
           GROUP BY s.nis HAVING total >= 50";
$query_50 = mysqli_query($conn, $sql_50);

/** * 3. QUERY ARSIP PERJANJIAN SISWA (Join 2x agar NIS & Nama muncul)
 **/
$sql_laporan_siswa = "SELECT pjs.*, s.nama_siswa, s.nis 
                      FROM perjanjian_siswa pjs 
                      JOIN pelanggaran_siswa pls ON pjs.id_pelanggaran_siswa = pls.id_pelanggaran_siswa 
                      JOIN siswa s ON pls.nis = s.nis 
                      ORDER BY pjs.tanggal DESC";
$query_laporan_siswa = mysqli_query($conn, $sql_laporan_siswa);

/** * 4. QUERY ARSIP PERJANJIAN ORTU (Menggunakan nama tabel: perjanjian_orang_tua)
 **/
$sql_laporan_ortu = "SELECT pjo.*, s.nama_siswa, s.nis 
                     FROM perjanjian_orang_tua pjo 
                     JOIN pelanggaran_siswa pls ON pjo.id_pelanggaran_siswa = pls.id_pelanggaran_siswa 
                     JOIN siswa s ON pls.nis = s.nis 
                     ORDER BY pjo.tanggal DESC";
$query_laporan_ortu = mysqli_query($conn, $sql_laporan_ortu);
?>

<style>
    /* RIO-SYS DARK THEME CUSTOM */
    .rio-card { background: rgba(5, 10, 24, 0.4); border: 1px solid rgba(255,255,255,0.05); border-radius: 2rem; margin-bottom: 3rem; overflow: hidden; backdrop-filter: blur(15px); }
    .rio-header { padding: 1.5rem 2rem; border-bottom: 1px solid rgba(255,255,255,0.05); display: flex; justify-content: space-between; align-items: center; background: rgba(255,255,255,0.01); }
    .rio-header h3 { color: #f8fafc; font-weight: 900; text-transform: uppercase; letter-spacing: 2px; font-size: 0.75rem; margin: 0; }
    
    .rio-table { width: 100%; border-collapse: collapse; }
    .rio-table th { color: #38bdf8; font-size: 9px; font-weight: 900; text-transform: uppercase; padding: 1.2rem; text-align: center; letter-spacing: 1px; border-bottom: 1px solid rgba(255,255,255,0.05); }
    .rio-table td { padding: 1.2rem; font-size: 11px; color: #94a3b8; border-bottom: 1px solid rgba(255,255,255,0.03); text-align: center; vertical-align: middle; }
    .rio-table tr:hover { background: rgba(255,255,255,0.01); }

    /* ACTION BUTTONS */
    .btn-action { padding: 0.6rem 1.2rem; border-radius: 1rem; font-size: 9px; font-weight: 900; text-transform: uppercase; cursor: pointer; text-decoration: none; display: inline-block; border: none; transition: 0.3s; }
    .btn-blue { background: #0ea5e9; color: white; box-shadow: 0 4px 15px rgba(14, 165, 233, 0.2); }
    .btn-orange { background: #f59e0b; color: white; box-shadow: 0 4px 15px rgba(245, 158, 11, 0.2); }
    .btn-outline { background: transparent; border: 1px solid rgba(255,255,255,0.1); color: #64748b; }
    .btn-outline:hover { border-color: #38bdf8; color: white; }

    /* UPLOAD FORM STYLE */
    .upload-container { margin-top: 10px; padding-top: 10px; border-top: 1px dashed rgba(255,255,255,0.05); }
    .input-file-custom { font-size: 9px; color: #475569; width: 100%; margin-bottom: 8px; }
    .input-file-custom::-webkit-file-upload-button { background: rgba(255,255,255,0.05); border: none; padding: 4px 8px; border-radius: 4px; color: #cbd5e1; cursor: pointer; font-weight: bold; text-transform: uppercase; margin-right: 10px; }
</style>

<div class="p-8">

    <div class="rio-card">
        <div class="rio-header">
            <h3>Daftar Pelanggaran Per Siswa (Poin > 25)</h3>
        </div>
        <table class="rio-table">
            <thead>
                <tr><th width="50">No</th><th width="100">NIS</th><th>Nama Siswa</th><th>Pelanggaran Terdeteksi</th><th width="80">Poin</th><th width="120">Aksi</th></tr>
            </thead>
            <tbody>
                <?php $n=1; while($r = mysqli_fetch_array($query_25)): ?>
                <tr>
                    <td><?= $n++ ?></td>
                    <td style="color:white; font-weight:bold;"><?= $r['nis'] ?></td>
                    <td style="color:white; font-weight:900; italic"><?= strtoupper($r['nama_siswa']) ?></td>
                    <td style="font-style:italic; text-align:left;"><?= $r['daftar'] ?></td>
                    <td><span style="color:#f43f5e; font-weight:bold;"><?= $r['total'] ?></span></td>
                    <td><a href="detail_pelanggaran.php?nis=<?= $r['nis'] ?>" class="btn-action btn-blue">Detail</a></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <div class="rio-card">
        <div class="rio-header">
            <h3>Calon Pembuat Surat Perjanjian Ortu (Poin > 50)</h3>
        </div>
        <table class="rio-table">
            <thead>
                <tr><th width="50">No</th><th width="100">NIS</th><th>Nama Siswa</th><th>Status Pelanggaran</th><th width="80">Poin</th><th width="180">Aksi</th></tr>
            </thead>
            <tbody>
                <?php $n=1; while($r = mysqli_fetch_array($query_50)): ?>
                <tr>
                    <td><?= $n++ ?></td>
                    <td style="color:white; font-weight:bold;"><?= $r['nis'] ?></td>
                    <td style="color:white; font-weight:900;"><?= strtoupper($r['nama_siswa']) ?></td>
                    <td style="font-style:italic; text-align:left;"><?= $r['daftar'] ?></td>
                    <td><span style="color:#f43f5e; font-weight:bold;"><?= $r['total'] ?></span></td>
                    <td>
                        <a href="buat_surat.php?nis=<?= $r['nis'] ?>" class="btn-action btn-outline">Proses Surat</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <div style="text-align: center; margin: 4rem 0;">
        <h2 style="color:white; font-weight:900; text-transform:uppercase; letter-spacing:10px; font-size: 1.5rem; opacity: 0.5;">Laporan Arsip Perjanjian</h2>
    </div>

    <div class="rio-card">
        <div class="rio-header"><h3>Arsip Surat Perjanjian Siswa</h3></div>
        <table class="rio-table">
            <thead>
                <tr><th width="50">No</th><th>Tgl Terbit</th><th>NIS</th><th>Nama Siswa</th><th>Status</th><th>Lampiran & Upload</th></tr>
            </thead>
            <tbody>
                <?php $n=1; while($r = mysqli_fetch_array($query_laporan_siswa)): ?>
                <tr>
                    <td><?= $n++ ?></td>
                    <td><?= date('d/m/Y', strtotime($r['tanggal'])) ?></td>
                    <td><?= $r['nis'] ?></td>
                    <td style="color:white; font-weight:bold;"><?= $r['nama_siswa'] ?></td>
                    <td><span style="color:#10b981; font-weight:bold;"><?= $r['status'] ?></span></td>
                    <td>
                        <?php if($r['foto_dokumen']): ?>
                            <a href="../uploads/perjanjian/<?= $r['foto_dokumen'] ?>" target="_blank" class="btn-action btn-blue mb-2 w-full text-center">Lihat Gambar</a>
                        <?php endif; ?>

                        <div class="upload-container">
                            <form action="upload_perjanjian.php" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?= $r['id_perjanjian_siswa'] ?>">
                                <input type="file" name="foto" class="input-file-custom" required>
                                <button type="submit" name="upload" class="btn-action btn-orange w-full">Upload Baru</button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</div>

<?php include "../includes/footer.php"; ?>