<?php
session_start();
include "../config/config.php";
include "../includes/header.php";

$nis = mysqli_real_escape_string($conn, $_GET['nis']);

// Ambil data singkat siswa
$query = mysqli_query($conn, "SELECT nama_siswa, nis FROM siswa WHERE nis = '$nis'");
$s = mysqli_fetch_array($query);
?>

<div class="p-8 flex flex-col items-center justify-center min-h-[70vh] space-y-10">
    <div class="text-center space-y-2">
        <h2 class="text-rose-500 font-bold text-[10px] uppercase tracking-[4px]">Action Required</h2>
        <h1 class="text-4xl font-black text-white tracking-tighter uppercase italic">Proses Dokumen <span class="text-rose-500">Siswa</span></h1>
        <div class="inline-block px-6 py-2 bg-white/5 border border-white/10 rounded-2xl mt-4">
            <p class="text-slate-400 text-xs font-bold uppercase tracking-widest">
                Target: <span class="text-white italic"><?= $s['nama_siswa'] ?></span> (<?= $s['nis'] ?>)
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 w-full max-w-4xl">
        
        <a href="buat_surat_panggilan.php?nis=<?= $nis ?>" class="group relative bg-[#050a18]/60 border border-white/5 p-10 rounded-[2.5rem] hover:border-sky-500/50 hover:bg-sky-500/[0.02] transition-all duration-500 shadow-2xl overflow-hidden">
            <div class="w-14 h-14 bg-sky-500/20 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-all duration-500">
                <i class="fas fa-envelope-open-text text-sky-500 text-xl"></i>
            </div>
            <div class="mt-8">
                <h3 class="text-white font-black text-xl tracking-tight group-hover:text-sky-500 transition-colors uppercase italic">Cetak Panggilan Ortu</h3>
                <p class="text-slate-500 text-[10px] font-bold uppercase tracking-[3px] mt-2">Parental Summon Notice</p>
            </div>
            <div class="mt-6 flex items-center text-sky-500 text-[10px] font-black uppercase tracking-widest opacity-0 group-hover:opacity-100 transition-all">
                Execute Process <i class="fas fa-arrow-right ml-2"></i>
            </div>
            <i class="fas fa-bullhorn absolute -bottom-6 -right-6 text-white/[0.02] text-9xl group-hover:text-sky-500/5 transition-all duration-700"></i>
        </a>

        <a href="buat_surat_perjanjian.php?nis=<?= $nis ?>" class="group relative bg-[#050a18]/60 border border-white/5 p-10 rounded-[2.5rem] hover:border-emerald-500/50 hover:bg-emerald-500/[0.02] transition-all duration-500 shadow-2xl overflow-hidden">
            <div class="w-14 h-14 bg-emerald-500/20 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-all duration-500">
                <i class="fas fa-file-contract text-emerald-500 text-xl"></i>
            </div>
            <div class="mt-8">
                <h3 class="text-white font-black text-xl tracking-tight group-hover:text-emerald-500 transition-colors uppercase italic">Cetak Perjanjian Ortu</h3>
                <p class="text-slate-500 text-[10px] font-bold uppercase tracking-[3px] mt-2">Student Agreement Letter</p>
            </div>
            <div class="mt-6 flex items-center text-emerald-500 text-[10px] font-black uppercase tracking-widest opacity-0 group-hover:opacity-100 transition-all">
                Execute Process <i class="fas fa-arrow-right ml-2"></i>
            </div>
            <i class="fas fa-signature absolute -bottom-6 -right-6 text-white/[0.02] text-9xl group-hover:text-emerald-500/5 transition-all duration-700"></i>
        </a>

    </div>

    <a href="laporan_panggilan.php" class="text-slate-600 hover:text-white text-[10px] font-black uppercase tracking-[5px] transition-all italic">
        <i class="fas fa-chevron-left mr-2"></i> Back to Archive
    </a>
</div>

<?php include "../includes/footer.php"; ?>