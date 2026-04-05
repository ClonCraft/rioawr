<?php
session_start();
include "../config/config.php";
include "../includes/header.php";

if (!isset($_SESSION['role'])) { header("Location: ../login.php"); exit(); }

// --- Logika Pengambilan Data Riil ---
// 1. Total Seluruh Siswa
$q_siswa = mysqli_query($conn, "SELECT COUNT(*) FROM siswa");
$total_siswa = mysqli_fetch_row($q_siswa)[0];

// 2. Siswa yang Pernah Melanggar (Unique)
$q_melanggar = mysqli_query($conn, "SELECT COUNT(DISTINCT nis) FROM pelanggaran_siswa");
$total_siswa_melanggar = mysqli_fetch_row($q_melanggar)[0];

// 3. Persentase Kepatuhan (Contoh Logika)
$persentase_patuh = ($total_siswa > 0) ? round((($total_siswa - $total_siswa_melanggar) / $total_siswa) * 100) : 100;

// 4. Pelanggaran Terbaru (untuk Tabel Singkat)
$last_records = mysqli_query($conn, "SELECT s.nama_siswa, j.jenis, p.tanggal FROM pelanggaran_siswa p JOIN siswa s USING(nis) JOIN jenis_pelanggaran j USING(id_jenis_pelanggaran) ORDER BY p.tanggal DESC LIMIT 5");
?>

<div class="p-8 space-y-10">
    <div class="flex flex-col md:flex-row justify-between items-end gap-6">
        <div class="space-y-1">
            <h2 class="text-blue-500 font-bold text-xs uppercase tracking-[4px]">System Overview</h2>
            <h1 class="text-4xl font-black text-white tracking-tight">Dashboard <span class="text-slate-500 font-light">Kedisiplinan</span></h1>
        </div>
        <div class="flex gap-4">
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-2xl font-bold text-sm transition-all shadow-lg shadow-blue-600/20 flex items-center gap-2">
                <i class="fas fa-plus text-xs"></i> Entri Baru
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="relative overflow-hidden bg-white/[0.03] border border-white/10 p-6 rounded-[2.5rem] group hover:border-blue-500/50 transition-all">
            <div class="relative z-10">
                <p class="text-slate-500 text-[10px] font-bold uppercase tracking-widest">Total Siswa</p>
                <h3 class="text-4xl font-black text-white mt-2"><?= number_format($total_siswa) ?></h3>
                <p class="text-emerald-400 text-[10px] mt-2 font-bold"><i class="fas fa-arrow-up mr-1"></i> Data Terkini</p>
            </div>
            <i class="fas fa-users absolute -right-4 -bottom-4 text-8xl text-white/[0.02] group-hover:text-blue-500/5 transition-colors"></i>
        </div>

        <div class="relative overflow-hidden bg-white/[0.03] border border-white/10 p-6 rounded-[2.5rem] group hover:border-rose-500/50 transition-all">
            <div class="relative z-10">
                <p class="text-slate-500 text-[10px] font-bold uppercase tracking-widest">Siswa Melanggar</p>
                <h3 class="text-4xl font-black text-white mt-2"><?= $total_siswa_melanggar ?></h3>
                <p class="text-rose-400 text-[10px] mt-2 font-bold italic tracking-tighter">*Perlu Pembinaan</p>
            </div>
            <i class="fas fa-user-slash absolute -right-4 -bottom-4 text-8xl text-white/[0.02] group-hover:text-rose-500/5 transition-colors"></i>
        </div>

        <div class="relative overflow-hidden bg-white/[0.03] border border-white/10 p-6 rounded-[2.5rem] group hover:border-emerald-500/50 transition-all">
            <div class="relative z-10">
                <p class="text-slate-500 text-[10px] font-bold uppercase tracking-widest">Index Kepatuhan</p>
                <h3 class="text-4xl font-black text-emerald-400 mt-2"><?= $persentase_patuh ?>%</h3>
                <div class="w-full bg-white/5 h-1.5 rounded-full mt-3 overflow-hidden">
                    <div class="bg-emerald-500 h-full transition-all duration-1000" style="width: <?= $persentase_patuh ?>%"></div>
                </div>
            </div>
        </div>

        <?php $q_total_k = mysqli_query($conn, "SELECT COUNT(*) FROM pelanggaran_siswa"); $total_k = mysqli_fetch_row($q_total_k)[0]; ?>
        <div class="relative overflow-hidden bg-white/[0.03] border border-white/10 p-6 rounded-[2.5rem] group hover:border-amber-500/50 transition-all">
            <div class="relative z-10">
                <p class="text-slate-500 text-[10px] font-bold uppercase tracking-widest">Total Insiden</p>
                <h3 class="text-4xl font-black text-white mt-2"><?= $total_k ?></h3>
                <p class="text-amber-500 text-[10px] mt-2 font-bold uppercase tracking-tighter">Riwayat Akumulatif</p>
            </div>
            <i class="fas fa-file-invoice absolute -right-4 -bottom-4 text-8xl text-white/[0.02] group-hover:text-amber-500/5 transition-colors"></i>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 bg-white/[0.02] border border-white/5 rounded-[2.5rem] overflow-hidden shadow-2xl">
            <div class="p-8 border-b border-white/5 flex justify-between items-center bg-white/[0.01]">
                <h3 class="font-bold text-lg text-white">Aktivitas Terbaru</h3>
                <a href="laporan.php" class="text-xs text-blue-400 hover:underline">Lihat Semua</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <tbody class="divide-y divide-white/5">
                        <?php while($row = mysqli_fetch_assoc($last_records)): ?>
                        <tr class="hover:bg-white/[0.02] transition-colors group">
                            <td class="px-8 py-5">
                                <p class="text-white font-bold text-sm tracking-tight group-hover:text-blue-400 transition-colors"><?= $row['nama_siswa'] ?></p>
                                <p class="text-[10px] text-slate-500 uppercase mt-1"><?= date("d M Y | H:i", strtotime($row['tanggal'])) ?></p>
                            </td>
                            <td class="px-8 py-5 text-right">
                                <span class="text-[10px] font-black px-3 py-1 bg-rose-500/10 text-rose-500 rounded-lg border border-rose-500/20 uppercase tracking-tighter">
                                    <?= $row['jenis'] ?>
                                </span>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-gradient-to-br from-blue-600/20 to-transparent border border-blue-500/20 rounded-[2.5rem] p-8 flex flex-col justify-between">
            <div>
                <div class="bg-blue-600 w-10 h-10 rounded-xl flex items-center justify-center text-white mb-6">
                    <i class="fas fa-shield-check"></i>
                </div>
                <h4 class="text-xl font-bold text-white leading-tight">Sistem Berjalan Optimal</h4>
                <p class="text-sm text-slate-400 mt-2 leading-relaxed">Database tersinkronisasi dengan baik. Anda dapat mengunduh laporan bulanan sekarang.</p>
            </div>
            <button onclick="window.location='laporan.php'" class="w-full py-4 bg-white/5 hover:bg-white/10 text-white rounded-2xl font-bold text-xs transition-all border border-white/10 mt-6 uppercase tracking-widest">
                Unduh Rekapitulasi
            </button>
        </div>
    </div>
</div>

<?php include "../includes/footer.php"; ?>