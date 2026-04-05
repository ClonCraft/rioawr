<?php
session_start();
include "../config/config.php";
include "../includes/header.php";

// Ambil data dari tabel jenis_pelanggaran
$query = mysqli_query($conn, "SELECT * FROM jenis_pelanggaran ORDER BY id_jenis_pelanggaran ASC");
?>

<div class="p-8 space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="space-y-1">
            <h2 class="text-amber-500 font-bold text-[10px] uppercase tracking-[4px]">Violation Rules</h2>
            <h1 class="text-4xl font-black text-white tracking-tighter uppercase italic">Jenis <span class="text-amber-500">Pelanggaran</span></h1>
            <p class="text-slate-500 text-[10px] font-bold uppercase tracking-widest italic mt-1">Point System: Active</p>
        </div>
        
        <a href="tambah_jenis.php" class="flex items-center gap-2 px-6 py-3 bg-amber-600 hover:bg-amber-500 text-white rounded-2xl font-bold transition-all shadow-xl shadow-amber-900/30 text-[10px] tracking-widest uppercase">
            <i class="fas fa-plus-circle"></i>
            <span>Tambah Jenis</span>
        </a>
    </div>

    <div class="bg-[#050a18]/50 border border-white/5 rounded-[2.5rem] overflow-hidden backdrop-blur-sm shadow-2xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse hover-effect">
                <thead>
                    <tr class="border-b border-white/5 bg-white/[0.02]">
                        <th class="px-6 py-6 text-amber-500 font-black uppercase text-[10px] tracking-widest text-center italic">No</th>
                        <th class="px-6 py-6 text-amber-500 font-black uppercase text-[10px] tracking-widest italic">Jenis Pelanggaran</th>
                        <th class="px-6 py-6 text-amber-500 font-black uppercase text-[10px] tracking-widest text-center italic">Point</th>
                        <th class="px-6 py-6 text-amber-500 font-black uppercase text-[10px] tracking-widest text-center italic">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    <?php 
                    $no = 1;
                    while($data = mysqli_fetch_array($query)): 
                    ?>
                    <tr class="transition-all duration-300 group">
                        <td class="px-6 py-5 text-center text-slate-600 font-bold text-xs"><?= $no++; ?></td>
                        <td class="px-6 py-5">
                            <div class="text-slate-200 font-bold text-sm tracking-tight uppercase"><?= $data['jenis']; ?></div>
                            <div class="text-[9px] text-slate-500 font-mono italic">ID_NODE: #00<?= $data['id_jenis_pelanggaran']; ?></div>
                        </td>
                        <td class="px-6 py-5 text-center">
                            <span class="px-4 py-1.5 bg-amber-500/10 border border-amber-500/20 rounded-xl text-xs text-amber-500 font-black">
                                <?= $data['poin']; ?> <span class="text-[8px] ml-1">PTS</span>
                            </span>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center justify-center gap-2">
                                <a href="edit_jenis.php?id=<?= $data['id_jenis_pelanggaran']; ?>" class="w-9 h-9 rounded-xl bg-amber-500/10 text-amber-500 flex items-center justify-center hover:bg-amber-500 hover:text-white transition-all transform hover:scale-110 shadow-lg">
                                    <i class="fas fa-edit text-xs"></i>
                                </a>
                                <a href="hapus_jenis.php?id=<?= $data['id_jenis_pelanggaran']; ?>" onclick="return confirm('Hapus jenis pelanggaran ini?')" class="w-9 h-9 rounded-xl bg-rose-500/10 text-rose-500 flex items-center justify-center hover:bg-rose-500 hover:text-white transition-all transform hover:scale-110 shadow-lg">
                                    <i class="fas fa-trash-alt text-xs"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="p-6 bg-white/[0.02] border border-white/5 rounded-3xl">
            <p class="text-[8px] text-slate-500 font-black uppercase tracking-[3px] mb-2">Total Kategori</p>
            <p class="text-2xl font-black text-white"><?= mysqli_num_rows($query); ?></p>
        </div>
        <div class="p-6 bg-white/[0.02] border border-white/5 rounded-3xl">
            <p class="text-[8px] text-slate-500 font-black uppercase tracking-[3px] mb-2">Sistem Poin</p>
            <p class="text-2xl font-black text-emerald-500">TERVERIFIKASI</p>
        </div>
    </div>
</div>

<?php include "../includes/footer.php"; ?>