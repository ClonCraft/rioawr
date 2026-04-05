<?php
session_start();
include "../config/config.php";
include "../includes/header.php";

// Query mengambil data GURU NON-AKTIF
$query = mysqli_query($conn, "SELECT * FROM guru WHERE aktif = 'N' ORDER BY kode_guru ASC");
?>

<style>
    /* Kontainer utama harus berada di atas agar bisa di-klik */
    .rio-container {
        position: relative;
        z-index: 20;
    }

    /* Memaksa tabel agar bisa menerima interaksi mouse */
    .rio-table-fixed {
        pointer-events: auto !important;
        border-collapse: collapse;
        width: 100%;
    }

    .rio-row {
        transition: all 0.3s ease !important;
        cursor: pointer !important;
        position: relative;
    }

    /* EFEK HOVER: Warna putih transparan agar terlihat di background gelap RIO-SYS */
    .rio-row:hover {
        background-color: rgba(255, 255, 255, 0.08) !important;
    }

    /* Mengubah warna teks saat baris di-hover */
    .rio-row:hover td {
        color: #ffffff !important;
    }

    /* Munculkan tombol aksi saat baris di-hover */
    .rio-row:hover .btn-group {
        opacity: 1 !important;
        transform: scale(1.1);
    }

    /* Efek garis samping merah saat di-hover */
    .rio-row:hover td:first-child {
        border-left: 4px solid #f43f5e;
    }
</style>

<div class="p-8 rio-container">
    <div class="flex justify-between items-center mb-10">
        <div class="space-y-1">
            <h2 class="text-rose-500 font-bold text-[10px] uppercase tracking-[4px]">Restricted Database</h2>
            <h1 class="text-4xl font-black text-white uppercase italic tracking-tighter">Arsip <span class="text-rose-500">Guru</span></h1>
            <p class="text-slate-600 text-[9px] font-bold uppercase tracking-[3px]">Status: Inactive Personnel</p>
        </div>
        <a href="data_guru.php" class="px-6 py-3 border border-white/10 rounded-2xl text-[10px] font-bold text-slate-400 hover:text-white hover:border-sky-500/50 uppercase tracking-widest transition-all backdrop-blur-md">
            <i class="fas fa-arrow-left mr-2"></i> Back to Active
        </a>
    </div>

    <div class="border border-white/5 rounded-[2.5rem] overflow-hidden bg-[#050a18] shadow-2xl">
        <table class="rio-table-fixed text-left">
            <thead>
                <tr class="bg-rose-600/10 border-b border-white/5">
                    <th class="p-6 text-rose-500 text-[10px] font-black uppercase tracking-widest text-center italic">No</th>
                    <th class="p-6 text-rose-500 text-[10px] font-black uppercase tracking-widest italic">ID Node</th>
                    <th class="p-6 text-rose-500 text-[10px] font-black uppercase tracking-widest italic">Nama Lengkap</th>
                    <th class="p-6 text-rose-500 text-[10px] font-black uppercase tracking-widest text-center italic">Status</th>
                    <th class="p-6 text-rose-500 text-[10px] font-black uppercase tracking-widest text-center italic">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                if(mysqli_num_rows($query) > 0):
                    while($data = mysqli_fetch_array($query)): 
                ?>
                <tr class="rio-row border-b border-white/[0.02]">
                    <td class="p-5 text-center text-slate-600 font-bold text-xs"><?= $no++; ?></td>
                    <td class="p-5">
                        <span class="text-rose-400 font-mono text-[10px] bg-rose-500/5 px-2 py-1 rounded-md border border-rose-500/10">#<?= $data['kode_guru']; ?></span>
                    </td>
                    <td class="p-5">
                        <div class="text-slate-500 font-bold italic line-through decoration-rose-500/50 uppercase text-sm tracking-tight">
                            <?= $data['nama_pengguna']; ?>
                        </div>
                    </td>
                    <td class="p-5 text-center">
                        <span class="px-4 py-1.5 bg-rose-500/5 text-rose-800 text-[8px] font-black uppercase rounded-full border border-rose-500/10 tracking-tighter">
                            Restricted
                        </span>
                    </td>
                    <td class="p-5">
                        <div class="btn-group flex justify-center gap-3 opacity-20 transition-all duration-300">
                            <a href="status_guru.php?id=<?= $data['kode_guru']; ?>&status=Y" class="w-9 h-9 rounded-xl bg-emerald-500/10 text-emerald-500 flex items-center justify-center hover:bg-emerald-500 hover:text-white transition-all shadow-lg" title="Aktifkan">
                                <i class="fas fa-power-off text-xs"></i>
                            </a>
                            <a href="hapus_guru.php?id=<?= $data['kode_guru']; ?>" onclick="return confirm('Sistem: Hapus permanen data ini?')" class="w-9 h-9 rounded-xl bg-rose-500/10 text-rose-500 flex items-center justify-center hover:bg-rose-500 hover:text-white transition-all shadow-lg" title="Hapus">
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
                    <td colspan="5" class="p-20 text-center text-slate-700 font-black uppercase tracking-[10px] text-xs opacity-20">
                        Archive Empty
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="mt-8 flex justify-between items-center px-4">
        <p class="text-[8px] text-slate-800 font-black uppercase tracking-[4px]">RIO-SYSTEM SECURE ARCHIVE</p>
        <p class="text-[8px] text-slate-800 font-black uppercase tracking-[4px] italic">Log: Verified</p>
    </div>
</div>

<?php include "../includes/footer.php"; ?>