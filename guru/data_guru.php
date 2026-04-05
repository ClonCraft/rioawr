<?php
session_start();
include "../config/config.php"; 
include "../includes/header.php";

// Query hanya mengambil data GURU AKTIF (aktif = 'Y')
$query = mysqli_query($conn, "SELECT * FROM guru WHERE aktif = 'Y' ORDER BY kode_guru ASC");
?>

<div class="p-8 space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="space-y-1">
            <h2 class="text-sky-500 font-bold text-xs uppercase tracking-[4px]">Personnel Management</h2>
            <h1 class="text-3xl font-black text-white tracking-tight uppercase italic text-sky-500">Data <span class="text-white">Guru Aktif</span></h1>
            <p class="text-slate-600 text-[10px] font-bold uppercase tracking-widest italic">Node Status: Active Personnel Only</p>
        </div>
        
        <div class="flex flex-wrap gap-3">
            <a href="guru_nonaktif.php" class="flex items-center justify-center gap-2 px-6 py-3 bg-rose-500/10 border border-rose-500/20 text-rose-500 hover:bg-rose-500 hover:text-white rounded-2xl font-bold transition-all text-[10px] tracking-widest uppercase shadow-lg shadow-rose-950/20 group">
                <i class="fas fa-user-slash group-hover:animate-pulse"></i>
                <span>View Archive</span>
            </a>

            <a href="tambah_guru.php" class="flex items-center justify-center gap-2 px-6 py-3 bg-sky-600 hover:bg-sky-500 text-white rounded-2xl font-bold transition-all shadow-xl shadow-sky-600/30 text-[10px] tracking-widest uppercase group">
                <i class="fas fa-user-plus group-hover:scale-110"></i>
                <span>Tambahkan Guru</span>
            </a>
        </div>
    </div>

    <div class="bg-white/[0.03] border border-white/10 rounded-[2.5rem] overflow-hidden backdrop-blur-md shadow-2xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-white/5 bg-white/[0.02]">
                        <th class="px-6 py-5 text-sky-500 font-bold uppercase text-[10px] tracking-widest text-center">No</th>
                        <th class="px-6 py-5 text-sky-500 font-bold uppercase text-[10px] tracking-widest">ID Node</th>
                        <th class="px-6 py-5 text-sky-500 font-bold uppercase text-[10px] tracking-widest">Nama Lengkap</th>
                        <th class="px-6 py-5 text-sky-500 font-bold uppercase text-[10px] tracking-widest">Username</th>
                        <th class="px-6 py-5 text-sky-500 font-bold uppercase text-[10px] tracking-widest text-center">Jabatan</th>
                        <th class="px-6 py-5 text-sky-500 font-bold uppercase text-[10px] tracking-widest">Telepon</th>
                        <th class="px-6 py-5 text-sky-500 font-bold uppercase text-[10px] tracking-widest text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    <?php 
                    $no = 1;
                    while($data = mysqli_fetch_array($query)): 
                    ?>
                    <tr class="hover:bg-white/[0.02] transition-colors group">
                        <td class="px-6 py-5 text-slate-500 font-medium text-center"><?= $no++; ?></td>
                        <td class="px-6 py-5 italic font-mono text-sky-400 font-bold text-xs">#<?= $data['kode_guru']; ?></td>
                        <td class="px-6 py-5">
                            <div class="text-white font-bold text-sm tracking-tight"><?= $data['nama_pengguna']; ?></div>
                        </td>
                        <td class="px-6 py-5 text-slate-400 text-sm font-medium">@<?= $data['username']; ?></td>
                        <td class="px-6 py-5 text-center">
                            <span class="px-3 py-1 bg-sky-500/10 border border-sky-500/20 rounded-full text-[9px] text-sky-400 font-black uppercase tracking-tighter shadow-inner">
                                <?= $data['jabatan']; ?>
                            </span>
                        </td>
                        <td class="px-6 py-5 text-slate-400 text-xs font-mono tracking-tighter"><?= $data['telp']; ?></td>
                        <td class="px-6 py-5">
                            <div class="flex items-center justify-center gap-2">
                                <a href="edit_guru.php?id=<?= $data['kode_guru']; ?>" class="w-9 h-9 rounded-xl bg-amber-500/10 text-amber-500 flex items-center justify-center hover:bg-amber-500 hover:text-white transition-all transform hover:scale-110">
                                    <i class="fas fa-edit text-xs"></i>
                                </a>
                                <a href="hapus_guru.php?id=<?= $data['kode_guru']; ?>" onclick="return confirm('Sistem: Nonaktifkan <?= $data['nama_pengguna']; ?>?')" class="w-9 h-9 rounded-xl bg-rose-500/10 text-rose-500 flex items-center justify-center hover:bg-rose-500 hover:text-white transition-all transform hover:scale-110">
                                    <i class="fas fa-trash text-xs"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include "../includes/footer.php"; ?>