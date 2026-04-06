<?php
session_start();
include "../config/config.php";
include "../includes/header.php";

// Logika Pencarian untuk Tabel Laporan
$keyword = "";
$condition = "";
if (isset($_POST['cari'])) {
    $keyword = mysqli_real_escape_string($conn, $_POST['keyword']);
    $condition = " AND (siswa.nama_siswa LIKE '%$keyword%' OR siswa.nis LIKE '%$keyword%' OR surat_keluar.no_surat LIKE '%$keyword%') ";
}

/**
 * 1. QUERY CALON PEMBUAT SURAT (POIN >= 50)
 * Menampilkan siswa yang akumulasi poinnya sudah mencapai ambang batas
 */
$sql_calon = "SELECT siswa.nis, siswa.nama_siswa, 
              GROUP_CONCAT(DISTINCT jenis_pelanggaran.jenis SEPARATOR ', ') as daftar_pelanggaran,
              SUM(jenis_pelanggaran.poin) as total_poin
              FROM pelanggaran_siswa
              JOIN siswa ON pelanggaran_siswa.nis = siswa.nis
              JOIN jenis_pelanggaran ON pelanggaran_siswa.id_jenis_pelanggaran = jenis_pelanggaran.id_jenis_pelanggaran
              GROUP BY siswa.nis
              HAVING total_poin >= 50";
$query_calon = mysqli_query($conn, $sql_calon);

/**
 * 2. QUERY LAPORAN SURAT KELUAR (Panggilan Ortu)
 * Disesuaikan dengan nama tabel di DB kamu: surat_keluar
 */
$sql_laporan = "SELECT surat_keluar.*, siswa.nama_siswa 
                FROM surat_keluar 
                JOIN siswa ON surat_keluar.nis = siswa.nis 
                WHERE surat_keluar.jenis_surat = 'Panggilan Orang Tua'
                $condition
                ORDER BY surat_keluar.tanggal_pembuatan_surat DESC";
$query_laporan = mysqli_query($conn, $sql_laporan);
?>

<div class="p-8 space-y-12">
    <div class="space-y-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-rose-500/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-exclamation-triangle text-rose-500"></i>
            </div>
            <div>
                <h2 class="text-white font-black text-lg uppercase tracking-tight">Daftar Siswa di atas 50 Poin</h2>
                <p class="text-slate-500 text-[10px] font-bold uppercase tracking-widest italic">Belum / Sedang Proses Pemanggilan</p>
            </div>
        </div>

        <div class="bg-[#050a18]/60 border border-white/5 rounded-[2rem] overflow-hidden shadow-2xl backdrop-blur-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-white/[0.02] border-b border-white/5">
                            <th class="px-6 py-5 text-[10px] font-black text-rose-500 uppercase text-center italic">No</th>
                            <th class="px-6 py-5 text-[10px] font-black text-rose-500 uppercase italic">NIS</th>
                            <th class="px-6 py-5 text-[10px] font-black text-rose-500 uppercase italic">Nama Siswa</th>
                            <th class="px-6 py-5 text-[10px] font-black text-rose-500 uppercase italic">Jenis Pelanggaran Terakhir</th>
                            <th class="px-6 py-5 text-[10px] font-black text-rose-500 uppercase text-center italic">Poin</th>
                            <th class="px-6 py-5 text-[10px] font-black text-rose-500 uppercase text-center italic">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        <?php 
                        $no = 1;
                        if(mysqli_num_rows($query_calon) > 0):
                            while($c = mysqli_fetch_array($query_calon)): 
                        ?>
                        <tr class="hover:bg-white/[0.02] transition-all">
                            <td class="px-6 py-5 text-center text-xs text-slate-600 font-bold"><?= $no++ ?></td>
                            <td class="px-6 py-5 text-xs font-bold text-white"><?= $c['nis'] ?></td>
                            <td class="px-6 py-5 text-xs text-slate-300 uppercase font-black italic"><?= $c['nama_siswa'] ?></td>
                            <td class="px-6 py-5 text-[10px] text-slate-500 italic max-w-xs truncate"><?= $c['daftar_pelanggaran'] ?></td>
                            <td class="px-6 py-5 text-center">
                                <span class="px-3 py-1 bg-rose-500/10 border border-rose-500/20 text-rose-500 rounded-lg font-black text-xs"><?= $c['total_poin'] ?></span>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <a href="buat_surat.php?nis=<?= $c['nis'] ?>&jenis=panggilan" class="px-4 py-2 bg-sky-600 hover:bg-sky-500 text-white text-[10px] font-black rounded-xl transition-all uppercase tracking-widest">
                                    Proses Surat
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; else: ?>
                        <tr><td colspan="6" class="p-16 text-center text-slate-700 text-[10px] font-black uppercase tracking-[10px] italic">Data Tidak Ditemukan</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="space-y-4">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-emerald-500/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-file-invoice text-emerald-500"></i>
                </div>
                <div>
                    <h2 class="text-white font-black text-lg uppercase tracking-tight italic">Laporan Data Surat <span class="text-emerald-500">Panggilan Ortu</span></h2>
                    <p class="text-slate-500 text-[10px] font-bold uppercase tracking-widest italic">Arsip Surat Keluar Node</p>
                </div>
            </div>
            
            <form action="" method="POST" class="flex items-center gap-2 bg-[#050a18]/80 border border-white/5 p-2 rounded-2xl backdrop-blur-xl">
                <input type="text" name="keyword" value="<?= $keyword ?>" placeholder="Cari NIS / Nama / No Surat..." class="bg-black/40 border border-white/5 rounded-xl py-2 px-4 text-xs text-white outline-none focus:border-emerald-500/50 w-48 md:w-64 transition-all">
                <button type="submit" name="cari" class="px-5 py-2 bg-emerald-600 hover:bg-emerald-500 text-white rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">Cari</button>
                <a href="laporan_panggilan.php" class="px-5 py-2 bg-rose-600 hover:bg-rose-500 text-white rounded-xl text-[10px] font-black uppercase tracking-widest text-center">Reset</a>
            </form>
        </div>

        <div class="bg-[#050a18]/60 border border-white/5 rounded-[2.5rem] overflow-hidden shadow-2xl backdrop-blur-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-white/[0.02] border-b border-white/5">
                            <th class="px-4 py-6 text-[9px] font-black text-emerald-500 uppercase text-center italic border-r border-white/5">No</th>
                            <th class="px-4 py-6 text-[9px] font-black text-emerald-500 uppercase text-center italic">Tgl Buat</th>
                            <th class="px-4 py-6 text-[9px] font-black text-emerald-500 uppercase text-center italic">Tgl Panggilan</th>
                            <th class="px-4 py-6 text-[9px] font-black text-emerald-500 uppercase text-center italic">No Surat</th>
                            <th class="px-4 py-6 text-[9px] font-black text-emerald-500 uppercase text-center italic">NIS</th>
                            <th class="px-4 py-6 text-[9px] font-black text-emerald-500 uppercase italic">Nama Siswa</th>
                            <th class="px-4 py-6 text-[9px] font-black text-emerald-500 uppercase italic">Keperluan</th>
                            <th class="px-4 py-6 text-[9px] font-black text-emerald-500 uppercase text-center italic">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        <?php 
                        $no = 1;
                        if(mysqli_num_rows($query_laporan) > 0):
                            while($l = mysqli_fetch_array($query_laporan)): 
                        ?>
                        <tr class="hover:bg-white/[0.01] transition-all group">
                            <td class="px-4 py-6 text-center text-xs text-slate-700 font-bold border-r border-white/5"><?= $no++ ?></td>
                            <td class="px-4 py-6 text-center text-[10px] text-white font-bold italic"><?= date('d/m/Y', strtotime($l['tanggal_pembuatan_surat'])) ?></td>
                            <td class="px-4 py-6 text-center text-[10px] text-slate-400">
                                <?php if($l['tanggal_pemanggilan']): ?>
                                    <div class="font-bold text-white"><?= date('d F Y', strtotime($l['tanggal_pemanggilan'])) ?></div>
                                    <div class="text-[8px] text-emerald-500 font-mono mt-1 uppercase italic">Jam: <?= date('H:i', strtotime($l['tanggal_pemanggilan'])) ?></div>
                                <?php else: ?>
                                    <span class="text-slate-700">-</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-6 text-center text-[10px] font-mono text-indigo-400 italic"><?= $l['no_surat'] ?></td>
                            <td class="px-4 py-6 text-center text-[10px] text-slate-500 font-bold"><?= $l['nis'] ?></td>
                            <td class="px-4 py-6 text-[11px] font-black text-slate-200 uppercase italic"><?= $l['nama_siswa'] ?></td>
                            <td class="px-4 py-6 text-[10px] text-slate-500 italic leading-relaxed truncate max-w-[150px]"><?= $l['keperluan'] ?></td>
                            <td class="px-4 py-6 text-center">
                                <a href="cetak_surat_panggilan.php?id=<?= $l['id_surat_keluar'] ?>" class="px-4 py-2 bg-sky-600/80 hover:bg-sky-500 text-white text-[9px] font-black rounded-xl transition-all uppercase tracking-widest shadow-lg shadow-sky-900/20">
                                    Cetak Ulang
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; else: ?>
                        <tr><td colspan="8" class="p-20 text-center text-slate-700 text-[10px] font-black uppercase tracking-[10px] italic">Belum Ada Riwayat Surat Terbit</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include "../includes/footer.php"; ?>