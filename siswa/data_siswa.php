<?php
session_start();
include "../config/config.php"; 
include "../includes/header.php";

// Ambil data siswa dari tabel database kamu
$query = mysqli_query($conn, "SELECT * FROM siswa ORDER BY nis ASC");
?>

<div class="p-8 space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="space-y-1">
            <h2 class="text-sky-500 font-bold text-[10px] uppercase tracking-[4px]">Student Database</h2>
            <h1 class="text-4xl font-black text-white tracking-tighter uppercase italic">Registry <span class="text-sky-500">Siswa</span></h1>
            <p class="text-slate-500 text-[10px] font-bold uppercase tracking-widest italic mt-1">Node Status: Database Synchronized</p>
        </div>
        
        <div class="flex items-center gap-3">
             <a href="tambah_siswa.php" class="flex items-center gap-2 px-6 py-3 bg-sky-600 hover:bg-sky-500 text-white rounded-2xl font-bold transition-all shadow-xl shadow-sky-600/30 text-[10px] tracking-widest uppercase">
                <i class="fas fa-plus"></i>
                <span>Tambah Siswa</span>
            </a>
        </div>
    </div>

    <div class="bg-[#050a18]/50 border border-white/5 rounded-[2.5rem] overflow-hidden backdrop-blur-sm shadow-2xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse hover-effect">
                <thead>
                    <tr class="border-b border-white/5 bg-white/[0.02]">
                        <th class="px-6 py-6 text-sky-500 font-black uppercase text-[10px] tracking-widest text-center italic">No</th>
                        <th class="px-6 py-6 text-sky-500 font-black uppercase text-[10px] tracking-widest italic">NIS</th>
                        <th class="px-6 py-6 text-sky-500 font-black uppercase text-[10px] tracking-widest italic">Nama Siswa</th>
                        <th class="px-6 py-6 text-sky-500 font-black uppercase text-[10px] tracking-widest italic">L/P</th>
                        <th class="px-6 py-6 text-sky-500 font-black uppercase text-[10px] tracking-widest italic text-center">Status</th>
                        <th class="px-6 py-6 text-sky-500 font-black uppercase text-[10px] tracking-widest italic text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    <?php 
                    $no = 1;
                    if(mysqli_num_rows($query) > 0):
                        while($data = mysqli_fetch_array($query)): 
                            // Logika warna status dinamis
                            $status_class = 'text-slate-400 bg-white/5 border-white/10';
                            if($data['status'] == 'aktif') $status_class = 'text-emerald-400 bg-emerald-500/10 border-emerald-500/20';
                            if($data['status'] == 'lulus') $status_class = 'text-sky-400 bg-sky-500/10 border-sky-500/20';
                            if($data['status'] == 'pindah') $status_class = 'text-rose-400 bg-rose-500/10 border-rose-500/20';
                    ?>
                    <tr class="transition-all duration-300 group">
                        <td class="px-6 py-5 text-center text-slate-600 font-bold text-xs"><?= $no++; ?></td>
                        <td class="px-6 py-5">
                            <span class="text-sky-400 font-mono text-[11px] font-bold italic">#<?= $data['nis']; ?></span>
                        </td>
                        <td class="px-6 py-5">
                            <div class="text-slate-200 font-bold text-sm tracking-tight"><?= $data['nama_siswa']; ?></div>
                            <div class="text-[9px] text-slate-500 font-mono italic truncate max-w-[250px]"><?= $data['alamat']; ?></div>
                        </td>
                        <td class="px-6 py-5">
                             <span class="text-slate-400 font-bold text-xs"><?= ($data['jenis_kelamin'] == 'Laki - Laki') ? 'L' : 'P'; ?></span>
                        </td>
                        <td class="px-6 py-5 text-center">
                            <span class="px-3 py-1 border rounded-lg text-[9px] font-black uppercase tracking-tighter <?= $status_class ?>">
                                <?= $data['status']; ?>
                            </span>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center justify-center gap-2">
                                <button onclick="alert('DETAIL SISWA\n-------------------\nAyah: <?= $data['id_ortu_wali']; ?>\nAlamat: <?= $data['alamat']; ?>')" class="w-8 h-8 rounded-lg bg-sky-500/10 text-sky-500 flex items-center justify-center hover:bg-sky-500 hover:text-white transition-all shadow-lg" title="View Details">
                                    <i class="fas fa-eye text-[10px]"></i>
                                </button>
                                <a href="edit_siswa.php?nis=<?= $data['nis']; ?>" class="w-8 h-8 rounded-lg bg-amber-500/10 text-amber-500 flex items-center justify-center hover:bg-amber-500 hover:text-white transition-all shadow-lg" title="Edit Data">
                                    <i class="fas fa-edit text-[10px]"></i>
                                </a>
                                <a href="hapus_siswa.php?nis=<?= $data['nis']; ?>" onclick="return confirm('Hapus permanen data siswa ini?')" class="w-8 h-8 rounded-lg bg-rose-500/10 text-rose-500 flex items-center justify-center hover:bg-rose-500 hover:text-white transition-all shadow-lg" title="Delete Data">
                                    <i class="fas fa-trash-alt text-[10px]"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php 
                        endwhile; 
                    else:
                    ?>
                    <tr>
                        <td colspan="6" class="p-20 text-center">
                            <div class="flex flex-col items-center opacity-20">
                                <i class="fas fa-users-slash text-5xl mb-4"></i>
                                <span class="text-[10px] font-black uppercase tracking-[10px]">No Student Data Found</span>
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="flex justify-between items-center px-6 opacity-30">
        <p class="text-[8px] font-black uppercase tracking-[4px]">RIO-SYSTEM STUDENT NODE</p>
        <p class="text-[8px] font-black uppercase tracking-[4px]">Total: <?= mysqli_num_rows($query); ?> Students</p>
    </div>
</div>

<?php include "../includes/footer.php"; ?>