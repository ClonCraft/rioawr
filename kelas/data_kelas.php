<?php
session_start();
include "../config/config.php";
include "../includes/header.php";

/**
 * QUERY JOIN RIO-SYS
 * Menghubungkan tabel kelas, tingkat, dan program_keahlian.
 * Nama kolom disesuaikan dengan database: program_keahlian.program_keahlian
 */
$sql = "SELECT 
            kelas.id_kelas,
            kelas.rombel,
            tingkat.tingkat, 
            program_keahlian.program_keahlian, 
            guru.nama_pengguna as wali_kelas
        FROM kelas
        INNER JOIN tingkat ON kelas.id_tingkat = tingkat.id_tingkat
        INNER JOIN program_keahlian ON kelas.id_program_keahlian = program_keahlian.id_program_keahlian
        LEFT JOIN guru ON kelas.kode_guru = guru.kode_guru
        ORDER BY tingkat.tingkat DESC, kelas.rombel ASC";

$query = mysqli_query($conn, $sql);
?>

<div class="p-8 space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="space-y-1">
            <h2 class="text-indigo-500 font-bold text-[10px] uppercase tracking-[4px]">Academic Structure</h2>
            <h1 class="text-4xl font-black text-white tracking-tighter uppercase italic">Data <span class="text-indigo-500">Kelas</span></h1>
            <p class="text-slate-500 text-[10px] font-bold uppercase tracking-widest italic mt-1">Status: System Synchronized</p>
        </div>
        
        <a href="tambah_kelas.php" class="flex items-center gap-2 px-6 py-3 bg-indigo-600 hover:bg-indigo-500 text-white rounded-2xl font-bold transition-all shadow-xl shadow-indigo-900/30 text-[10px] tracking-widest uppercase">
            <i class="fas fa-plus-square"></i>
            <span>Tambah Kelas</span>
        </a>
    </div>

    <div class="bg-[#050a18]/50 border border-white/5 rounded-[2.5rem] overflow-hidden backdrop-blur-sm shadow-2xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse hover-effect">
                <thead>
                    <tr class="border-b border-white/5 bg-white/[0.02]">
                        <th class="px-6 py-6 text-indigo-500 font-black uppercase text-[10px] tracking-widest text-center italic border-r border-white/5">No</th>
                        <th class="px-6 py-6 text-indigo-500 font-black uppercase text-[10px] tracking-widest italic">Kelas</th>
                        <th class="px-6 py-6 text-indigo-500 font-black uppercase text-[10px] tracking-widest italic">Wali Kelas</th>
                        <th class="px-6 py-6 text-indigo-500 font-black uppercase text-[10px] tracking-widest italic text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    <?php 
                    $no = 1;
                    if(mysqli_num_rows($query) > 0):
                        while($data = mysqli_fetch_array($query)): 
                    ?>
                    <tr class="transition-all duration-300 group">
                        <td class="px-6 py-5 text-center text-slate-700 font-bold text-xs border-r border-white/5"><?= $no++; ?></td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <div class="px-4 py-2 bg-indigo-500/10 border border-indigo-500/20 rounded-xl text-indigo-400 font-black text-sm italic tracking-tighter group-hover:bg-indigo-500 group-hover:text-white transition-all">
                                    <?= $data['tingkat']; ?> <?= $data['program_keahlian']; ?> <?= $data['rombel']; ?>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <div class="text-slate-200 font-bold text-sm tracking-tight italic">
                                <?= $data['wali_kelas'] ?? '<span class="text-rose-500/40">Belum Ditentukan</span>'; ?>
                            </div>
                            <p class="text-[9px] text-slate-600 font-mono font-bold mt-1 uppercase tracking-widest">System Node ID: #CLS-0<?= $data['id_kelas']; ?></p>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center justify-center gap-2">
                                <a href="edit_kelas.php?id=<?= $data['id_kelas']; ?>" class="w-9 h-9 rounded-xl bg-indigo-500/10 text-indigo-500 flex items-center justify-center hover:bg-indigo-500 hover:text-white transition-all shadow-lg transform hover:scale-110">
                                    <i class="fas fa-edit text-xs"></i>
                                </a>
                                <a href="hapus_kelas.php?id=<?= $data['id_kelas']; ?>" onclick="return confirm('Sistem: Hapus node kelas ini?')" class="w-9 h-9 rounded-xl bg-rose-500/10 text-rose-500 flex items-center justify-center hover:bg-rose-500 hover:text-white transition-all shadow-lg transform hover:scale-110">
                                    <i class="fas fa-trash-alt text-xs"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php 
                        endwhile; 
                    else:
                    ?>
                    <tr>
                        <td colspan="4" class="p-24 text-center">
                            <i class="fas fa-folder-open text-4xl text-slate-800 mb-4 block"></i>
                            <span class="text-[10px] font-black uppercase tracking-[10px] text-slate-700">Database Empty</span>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include "../includes/footer.php"; ?>