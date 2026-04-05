<?php
session_start();
include "../config/config.php";
include "../includes/header.php";
?>

<div class="p-8 space-y-10">
    <div class="space-y-1">
        <h2 class="text-sky-500 font-bold text-xs uppercase tracking-[4px]">Central Node</h2>
        <h1 class="text-4xl font-black text-white tracking-tight">Rio <span class="text-slate-500 font-light">Data System</span></h1>
        <p class="text-slate-500 text-sm italic">Pilih kategori data yang ingin dikelola oleh Rio-System.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        
        <a href="../guru/data_guru.php" class="group relative overflow-hidden bg-white/[0.03] border border-white/10 p-8 rounded-[2.5rem] hover:bg-sky-500/5 hover:border-sky-500/50 transition-all duration-500 shadow-2xl">
            <div class="relative z-10 flex items-center justify-between">
                <div>
                    <div class="bg-sky-500/20 w-14 h-14 rounded-2xl flex items-center justify-center text-sky-400 mb-6 group-hover:scale-110 transition-transform">
                        <i class="fas fa-chalkboard-teacher text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white group-hover:text-sky-400 transition-colors">Data Guru</h3>
                    <p class="text-slate-500 text-xs mt-2 font-medium uppercase tracking-widest">Management Pendidik</p>
                </div>
                <i class="fas fa-arrow-right text-slate-700 group-hover:text-sky-400 group-hover:translate-x-2 transition-all"></i>
            </div>
            <i class="fas fa-user-tie absolute -right-6 -bottom-6 text-9xl text-white/[0.02] group-hover:text-sky-500/5 transition-all"></i>
        </a>

        <a href="../siswa/data_siswa.php" class="group relative overflow-hidden bg-white/[0.03] border border-white/10 p-8 rounded-[2.5rem] hover:bg-blue-500/5 hover:border-blue-500/50 transition-all duration-500 shadow-2xl">
            <div class="relative z-10 flex items-center justify-between">
                <div>
                    <div class="bg-blue-500/20 w-14 h-14 rounded-2xl flex items-center justify-center text-blue-400 mb-6 group-hover:scale-110 transition-transform">
                        <i class="fas fa-user-graduate text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white group-hover:text-blue-400 transition-colors">Data Siswa</h3>
                    <p class="text-slate-500 text-xs mt-2 font-medium uppercase tracking-widest">Database Peserta Didik</p>
                </div>
                <i class="fas fa-arrow-right text-slate-700 group-hover:text-blue-400 group-hover:translate-x-2 transition-all"></i>
            </div>
            <i class="fas fa-users absolute -right-6 -bottom-6 text-9xl text-white/[0.02] group-hover:text-blue-500/5 transition-all"></i>
        </a>

        <a href="../pages/data_pelanggaran.php" class="group relative overflow-hidden bg-white/[0.03] border border-white/10 p-8 rounded-[2.5rem] hover:bg-amber-500/5 hover:border-amber-500/50 transition-all duration-500 shadow-2xl">
            <div class="relative z-10 flex items-center justify-between">
                <div>
                    <div class="bg-amber-500/20 w-14 h-14 rounded-2xl flex items-center justify-center text-amber-400 mb-6 group-hover:scale-110 transition-transform">
                        <i class="fas fa-gavel text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white group-hover:text-amber-400 transition-colors">Jenis Pelanggaran</h3>
                    <p class="text-slate-500 text-xs mt-2 font-medium uppercase tracking-widest">Master Poin & Sanksi</p>
                </div>
                <i class="fas fa-arrow-right text-slate-700 group-hover:text-amber-400 group-hover:translate-x-2 transition-all"></i>
            </div>
            <i class="fas fa-scale-balanced absolute -right-6 -bottom-6 text-9xl text-white/[0.02] group-hover:text-amber-500/5 transition-all"></i>
        </a>

        <a href="../pages/data_kelas.php" class="group relative overflow-hidden bg-white/[0.03] border border-white/10 p-8 rounded-[2.5rem] hover:bg-emerald-500/5 hover:border-emerald-500/50 transition-all duration-500 shadow-2xl">
            <div class="relative z-10 flex items-center justify-between">
                <div>
                    <div class="bg-emerald-500/20 w-14 h-14 rounded-2xl flex items-center justify-center text-emerald-400 mb-6 group-hover:scale-110 transition-transform">
                        <i class="fas fa-door-open text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white group-hover:text-emerald-400 transition-colors">Data Kelas</h3>
                    <p class="text-slate-500 text-xs mt-2 font-medium uppercase tracking-widest">Rombongan Belajar</p>
                </div>
                <i class="fas fa-arrow-right text-slate-700 group-hover:text-emerald-400 group-hover:translate-x-2 transition-all"></i>
            </div>
            <i class="fas fa-school absolute -right-6 -bottom-6 text-9xl text-white/[0.02] group-hover:text-emerald-500/5 transition-all"></i>
        </a>

    </div>
</div>

<?php include "../includes/footer.php"; ?>