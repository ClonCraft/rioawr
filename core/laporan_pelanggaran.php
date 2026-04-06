<?php
session_start();
include "../config/config.php";
include "../includes/header.php";

// 1. Logika Filter Pencarian
$keyword = "";
$condition = "";
if (isset($_POST['cari'])) {
    $keyword = mysqli_real_escape_string($conn, $_POST['keyword']);
    $condition = " WHERE siswa.nama_siswa LIKE '%$keyword%' OR siswa.nis LIKE '%$keyword%' ";
}

/**
 * 2. QUERY UTAMA RIO-SYS
 * Menggabungkan tabel pelanggaran_siswa, siswa, dan jenis_pelanggaran.
 * SUM(poin) untuk total poin, GROUP_CONCAT untuk list pelanggaran.
 */
$sql = "SELECT 
            MAX(pelanggaran_siswa.tanggal) as tanggal, 
            siswa.nis,
            siswa.nama_siswa,
            GROUP_CONCAT(jenis_pelanggaran.jenis SEPARATOR ', ') as list_pelanggaran,
            SUM(jenis_pelanggaran.poin) as total_poin
        FROM pelanggaran_siswa
        JOIN siswa ON pelanggaran_siswa.nis = siswa.nis
        JOIN jenis_pelanggaran ON pelanggaran_siswa.id_jenis_pelanggaran = jenis_pelanggaran.id_jenis_pelanggaran
        $condition
        GROUP BY siswa.nis, siswa.nama_siswa 
        ORDER BY tanggal DESC";

$query = mysqli_query($conn, $sql);
?>

<div class="p-8 space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="space-y-1">
            <h2 class="text-emerald-500 font-bold text-[10px] uppercase tracking-[4px]">Violation Archives</h2>
            <h1 class="text-4xl font-black text-white tracking-tighter uppercase italic text-emerald-500">Laporan <span class="text-white">Pelanggaran</span></h1>
            <p class="text-slate-500 text-[10px] font-bold uppercase tracking-widest italic mt-1 italic">Daftar Pelanggaran Per Siswa (Core Node)</p>
        </div>

        <form action="" method="POST" class="flex items-center gap-2 bg-[#050a18]/80 border border-white/5 p-2 rounded-2xl backdrop-blur-xl">
            <div class="relative">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 text-xs"></i>
                <input type="text" name="keyword" value="<?= $keyword ?>" placeholder="Masukkan NIS / Nama Siswa" class="bg-black/40 border border-white/5 rounded-xl py-2 pl-10 pr-4 text-xs text-white outline-none focus:border-emerald-500/50 w-48 md:w-64 transition-all">
            </div>
            <button type="submit" name="cari" class="px-5 py-2 bg-emerald-600 hover:bg-emerald-500 text-white rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shadow-lg shadow-emerald-900/20">
                Cari
            </button>
            <a href="laporan_pelanggaran.php" class="px-5 py-2 bg-rose-600 hover:bg-rose-500 text-white rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shadow-lg shadow-rose-900/20 text-center">
                Reset
            </a>
        </form>
    </div>

    <div class="bg-[#050a18]/50 border border-white/5 rounded-[2.5rem] overflow-hidden backdrop-blur-xl shadow-2xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse hover-effect">
                <thead>
                    <tr class="border-b border-white/5 bg-white/[0.02]">
                        <th class="px-6 py-6 text-emerald-500 font-black uppercase text-[10px] tracking-widest text-center italic border-r border-white/5">No</th>
                        <th class="px-6 py-6 text-emerald-500 font-black uppercase text-[10px] tracking-widest italic text-center">Tanggal</th>
                        <th class="px-6 py-6 text-emerald-500 font-black uppercase text-[10px] tracking-widest italic text-center border-r border-white/5">NIS</th>
                        <th class="px-6 py-6 text-emerald-500 font-black uppercase text-[10px] tracking-widest italic">Nama Siswa</th>
                        <th class="px-6 py-6 text-emerald-500 font-black uppercase text-[10px] tracking-widest italic">Jenis Pelanggaran</th>
                        <th class="px-6 py-6 text-emerald-500 font-black uppercase text-[10px] tracking-widest text-center italic">Point</th>
                        <th class="px-6 py-6 text-emerald-500 font-black uppercase text-[10px] tracking-widest text-center italic">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    <?php 
                    $no = 1;
                    if(mysqli_num_rows($query) > 0):
                        while($data = mysqli_fetch_array($query)): 
                    ?>
                    <tr class="transition-all duration-300 group">
                        <td class="px-6 py-6 text-center text-slate-700 font-bold text-xs border-r border-white/5"><?= $no++ ?></td>
                        <td class="px-6 py-6 text-center">
                            <div class="text-slate-200 font-bold text-[11px] uppercase tracking-tighter">
                                <?= date('d F Y', strtotime($data['tanggal'])) ?>
                            </div>
                            <div class="text-[9px] text-slate-500 font-mono italic mt-1"><?= date('H:i:s', strtotime($data['tanggal'])) ?></div>
                        </td>
                        <td class="px-6 py-6 text-center text-indigo-400 font-black text-xs italic border-r border-white/5"><?= $data['nis'] ?></td>
                        <td class="px-6 py-6">
                            <div class="text-slate-200 font-bold text-sm tracking-tight italic uppercase"><?= $data['nama_siswa'] ?></div>
                        </td>
                        <td class="px-6 py-6">
                            <div class="text-slate-400 text-[11px] leading-relaxed max-w-sm italic">
                                <?= $data['list_pelanggaran'] ?>.
                            </div>
                        </td>
                        <td class="px-6 py-6 text-center">
                            <span class="px-4 py-2 bg-emerald-500/10 border border-emerald-500/20 rounded-xl text-xs text-emerald-500 font-black italic">
                                <?= $data['total_poin'] ?>
                            </span>
                        </td>
                        <td class="px-6 py-6 text-center">
                            <a href="detail_pelanggaran.php?nis=<?= $data['nis'] ?>" class="px-6 py-2 bg-sky-600 hover:bg-sky-500 text-white rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shadow-lg shadow-sky-900/30">
                                Detail
                            </a>
                        </td>
                    </tr>
                    <?php 
                        endwhile; 
                    else:
                    ?>
                    <tr>
                        <td colspan="7" class="p-20 text-center">
                            <i class="fas fa-search text-4xl text-slate-800 mb-4 block"></i>
                            <span class="text-[10px] font-black uppercase tracking-[10px] text-slate-700 italic">Data Tidak Ditemukan</span>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include "../includes/footer.php"; ?>