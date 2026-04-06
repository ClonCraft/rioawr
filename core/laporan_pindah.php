<?php
session_start();
include "../config/config.php";
include "../includes/header.php";

// Logika Pencarian
$keyword = isset($_POST['keyword']) ? mysqli_real_escape_string($conn, $_POST['keyword']) : "";
$condition = $keyword ? " AND (s.nama_siswa LIKE '%$keyword%' OR s.nis LIKE '%$keyword%' OR sk.no_surat LIKE '%$keyword%')" : "";

/**
 * QUERY DATA SURAT PINDAH
 * Menghubungkan surat_keluar, surat_pindah, dan siswa
 */
$sql = "SELECT sk.*, sp.sekolah_tujuan, sp.alasan_pindah, s.nama_siswa 
        FROM surat_keluar sk
        JOIN surat_pindah sp ON sk.id_surat_pindah = sp.id_surat_pindah
        JOIN siswa s ON sk.nis = s.nis
        WHERE sk.jenis_surat = 'Pindah Sekolah'
        $condition
        ORDER BY sk.tanggal_pembuatan_surat DESC";

$query = mysqli_query($conn, $sql);
?>

<style>
    .rio-card { background: rgba(5, 10, 24, 0.4); border: 1px solid rgba(255,255,255,0.05); border-radius: 2rem; overflow: hidden; backdrop-filter: blur(15px); }
    .rio-header { padding: 1.5rem 2rem; border-bottom: 1px solid rgba(255,255,255,0.05); display: flex; justify-content: space-between; align-items: center; }
    .rio-header h3 { color: #f8fafc; font-weight: 900; text-transform: uppercase; letter-spacing: 2px; font-size: 0.8rem; margin: 0; }
    
    .rio-table { width: 100%; border-collapse: collapse; }
    .rio-table th { color: #38bdf8; font-size: 9px; font-weight: 900; text-transform: uppercase; padding: 1.2rem; text-align: center; border-bottom: 1px solid rgba(255,255,255,0.05); }
    .rio-table td { padding: 1.2rem; font-size: 11px; color: #94a3b8; border-bottom: 1px solid rgba(255,255,255,0.03); text-align: center; }
    
    .btn-cetak { background: #0ea5e9; color: white; padding: 0.6rem 1.5rem; border-radius: 1rem; font-size: 9px; font-weight: 900; text-transform: uppercase; text-decoration: none; display: inline-block; transition: 0.3s; }
    .btn-cetak:hover { background: #0284c7; box-shadow: 0 0 20px rgba(14, 165, 233, 0.3); }

    .search-input { background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.1); border-radius: 0.75rem; padding: 0.5rem 1rem; color: white; font-size: 11px; outline: none; }
</style>

<div class="p-8">
    
    <div class="mb-8 flex items-center gap-4">
        <div class="w-12 h-12 bg-sky-500/10 rounded-2xl flex items-center justify-center">
            <i class="fas fa-paper-plane text-sky-500"></i>
        </div>
        <div>
            <h1 class="text-2xl font-black text-white uppercase italic tracking-tighter">Laporan <span class="text-sky-500">Surat Pindah</span></h1>
            <p class="text-slate-500 text-[10px] font-bold uppercase tracking-[5px]">Transfer Student Archive System</p>
        </div>
    </div>

    <div class="rio-card shadow-2xl">
        <div class="rio-header">
            <h3>Daftar Surat Pindah Sekolah</h3>
            <form action="" method="POST" class="flex gap-2">
                <input type="text" name="keyword" value="<?= $keyword ?>" class="search-input" placeholder="NIS / Nama / No Surat...">
                <button type="submit" class="btn-cetak" style="background: #fbbf24; color: black; border: none;">Cari</button>
                <a href="laporan_pindah.php" class="btn-cetak" style="background: #f43f5e; border: none;">Reset</a>
            </form>
        </div>

        <table class="rio-table">
            <thead>
                <tr>
                    <th width="50">No</th>
                    <th>Tanggal Pembuatan</th>
                    <th>No Surat</th>
                    <th>NIS</th>
                    <th>Nama Siswa</th>
                    <th>Sekolah Tujuan</th>
                    <th>Alasan Pindah</th>
                    <th width="100">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                if(mysqli_num_rows($query) > 0):
                    while($r = mysqli_fetch_array($query)): 
                ?>
                <tr class="hover:bg-white/[0.01]">
                    <td><?= $no++ ?></td>
                    <td><?= date('d F Y', strtotime($r['tanggal_pembuatan_surat'])) ?></td>
                    <td class="font-mono text-sky-500 text-[10px]"><?= $r['no_surat'] ?></td>
                    <td class="font-bold text-white"><?= $r['nis'] ?></td>
                    <td class="text-white uppercase font-black italic"><?= $r['nama_siswa'] ?></td>
                    <td><span class="px-3 py-1 bg-white/5 rounded-lg text-slate-300"><?= $r['sekolah_tujuan'] ?></span></td>
                    <td class="text-left italic text-[10px] leading-relaxed"><?= $r['alasan_pindah'] ?></td>
                    <td>
                        <a href="cetak_surat_pindah.php?id=<?= $r['id_surat_keluar'] ?>" class="btn-cetak">Cetak</a>
                    </td>
                </tr>
                <?php endwhile; else: ?>
                <tr>
                    <td colspan="8" class="p-20 text-slate-700 text-[10px] font-black uppercase tracking-[10px] italic text-center">Data Arsip Kosong</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include "../includes/footer.php"; ?>