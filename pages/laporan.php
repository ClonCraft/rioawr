<?php
session_start();
include "../config/config.php";
include "../includes/header.php";
?>

<div class="p-8 space-y-10">
    <div class="space-y-2">
        <h2 class="text-emerald-500 font-bold text-[10px] uppercase tracking-[4px]">Reporting Node</h2>
        <h1 class="text-4xl font-black text-white tracking-tighter uppercase italic">Rio <span class="text-emerald-500">Report System</span></h1>
        <p class="text-slate-500 text-xs font-medium max-w-2xl italic">Pilih jenis laporan yang ingin dikelola atau dicetak oleh Rio-System.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        
        <a href="../core/laporan_pelanggaran.php" class="group relative bg-[#050a18]/60 border border-white/5 p-8 rounded-[2.5rem] hover:border-emerald-500/50 hover:bg-emerald-500/[0.02] transition-all duration-500 overflow-hidden shadow-2xl">
            <div class="w-12 h-12 bg-emerald-500/20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-all duration-500">
                <i class="fas fa-file-invoice text-emerald-500"></i>
            </div>
            <div class="mt-6">
                <h3 class="text-white font-bold text-lg tracking-tight group-hover:text-emerald-500 transition-colors">Laporan Pelanggaran</h3>
                <p class="text-slate-500 text-[10px] font-black uppercase tracking-[3px] mt-1">Student Violation Log</p>
            </div>
            <i class="fas fa-list-ol absolute -bottom-4 -right-4 text-white/[0.02] text-8xl group-hover:text-emerald-500/5 transition-all duration-700"></i>
        </a>

        <a href="../core/laporan_panggilan.php" class="group relative bg-[#050a18]/60 border border-white/5 p-8 rounded-[2.5rem] hover:border-emerald-500/50 hover:bg-emerald-500/[0.02] transition-all duration-500 overflow-hidden shadow-2xl">
            <div class="w-12 h-12 bg-emerald-500/20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-all duration-500">
                <i class="fas fa-envelope-open-text text-emerald-500"></i>
            </div>
            <div class="mt-6">
                <h3 class="text-white font-bold text-lg tracking-tight group-hover:text-emerald-500 transition-colors">Surat Panggilan Ortu</h3>
                <p class="text-slate-500 text-[10px] font-black uppercase tracking-[3px] mt-1">Parental Call Notice</p>
            </div>
            <i class="fas fa-users absolute -bottom-4 -right-4 text-white/[0.02] text-8xl group-hover:text-emerald-500/5 transition-all duration-700"></i>
        </a>

        <a href="../core/laporan_perjanjian.php" class="group relative bg-[#050a18]/60 border border-white/5 p-8 rounded-[2.5rem] hover:border-emerald-500/50 hover:bg-emerald-500/[0.02] transition-all duration-500 overflow-hidden shadow-2xl">
            <div class="w-12 h-12 bg-emerald-500/20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-all duration-500">
                <i class="fas fa-file-contract text-emerald-500"></i>
            </div>
            <div class="mt-6">
                <h3 class="text-white font-bold text-lg tracking-tight group-hover:text-emerald-500 transition-colors">Surat Perjanjian</h3>
                <p class="text-slate-500 text-[10px] font-black uppercase tracking-[3px] mt-1">Student Agreement</p>
            </div>
            <i class="fas fa-signature absolute -bottom-4 -right-4 text-white/[0.02] text-8xl group-hover:text-emerald-500/5 transition-all duration-700"></i>
        </a>

        <a href="../core/laporan_pindah.php" class="group relative bg-[#050a18]/60 border border-white/5 p-8 rounded-[2.5rem] hover:border-emerald-500/50 hover:bg-emerald-500/[0.02] transition-all duration-500 overflow-hidden shadow-2xl">
            <div class="w-12 h-12 bg-emerald-500/20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-all duration-500">
                <i class="fas fa-exchange-alt text-emerald-500"></i>
            </div>
            <div class="mt-6">
                <h3 class="text-white font-bold text-lg tracking-tight group-hover:text-emerald-500 transition-colors">Laporan Surat Pindah</h3>
                <p class="text-slate-500 text-[10px] font-black uppercase tracking-[3px] mt-1">Transfer Certificate</p>
            </div>
            <i class="fas fa-route absolute -bottom-4 -right-4 text-white/[0.02] text-8xl group-hover:text-emerald-500/5 transition-all duration-700"></i>
        </a>

        <a href="../core/rekap_perjanjian.php" class="group relative bg-[#050a18]/60 border border-white/5 p-8 rounded-[2.5rem] hover:border-emerald-500/50 hover:bg-emerald-500/[0.02] transition-all duration-500 overflow-hidden shadow-2xl md:col-span-2 lg:col-span-1">
            <div class="w-12 h-12 bg-emerald-500/20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-all duration-500">
                <i class="fas fa-chart-pie text-emerald-500"></i>
            </div>
            <div class="mt-6">
                <h3 class="text-white font-bold text-lg tracking-tight group-hover:text-emerald-500 transition-colors">Rekap Perjanjian</h3>
                <p class="text-slate-500 text-[10px] font-black uppercase tracking-[3px] mt-1">Agreement Recapitulation</p>
            </div>
            <i class="fas fa-copy absolute -bottom-4 -right-4 text-white/[0.02] text-8xl group-hover:text-emerald-500/5 transition-all duration-700"></i>
        </a>

    </div>
</div>

<?php include "../includes/footer.php"; ?>