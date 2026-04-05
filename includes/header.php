<?php
// Mendapatkan nama file aktif (misal: data_siswa.php)
$current_page = basename($_SERVER['PHP_SELF']);

// Mendapatkan nama folder tempat file ini berada (misal: siswa, guru, atau pages)
$folder_saat_ini = basename(dirname($_SERVER['PHP_SELF']));

/**
 * LOGIKA PREFIX DINAMIS
 * Jika kita berada di dalam sub-folder (pages, guru, siswa), 
 * kita butuh '../' untuk kembali ke root folder.
 */
$sub_folders = ['pages', 'guru', 'siswa'];
$prefix = in_array($folder_saat_ini, $sub_folders) ? '../' : '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RIO-SYS | Discipline Core</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;900&display=swap" rel="stylesheet">
    
    <style>
        body { 
            font-family: 'Outfit', sans-serif; 
            background-color: #020617; 
            overflow-x: hidden; 
        }
        
        /* Custom Scrollbar Sidebar */
        aside::-webkit-scrollbar { width: 4px; }
        aside::-webkit-scrollbar-thumb { 
            background: rgba(56, 189, 248, 0.1); 
            border-radius: 10px; 
        }
        
        /* CSS Global Hover Tabel RIO-SYS */
        .hover-effect tr:hover {
            background-color: rgba(255, 255, 255, 0.05) !important;
            transition: all 0.2s ease;
        }
    </style>
</head>
<body class="bg-slate-950 text-slate-200">

<div class="flex relative">
    <aside class="w-72 bg-slate-950 border-r border-sky-500/10 fixed h-full z-[100] hidden md:flex flex-col justify-between p-8">
        <div>
            <div class="mb-12 px-2">
                <div class="flex items-center gap-3 group">
                    <div class="w-10 h-10 bg-sky-600 rounded-xl flex items-center justify-center shadow-lg shadow-sky-600/20 transform -rotate-6 group-hover:rotate-0 transition-transform duration-500 text-white font-black italic text-xl">R</div>
                    <div>
                        <h1 class="text-white font-black text-xl tracking-tighter leading-none uppercase">
                            RIO-<span class="text-sky-400">SYS</span>
                        </h1>
                        <p class="text-[8px] text-slate-500 font-bold tracking-[3px] mt-1 uppercase">Discipline Core</p>
                    </div>
                </div>
            </div>

            <nav class="space-y-2">
                <p class="text-[10px] text-slate-600 font-bold uppercase tracking-[4px] mb-4 ml-2 italic">Main Terminal</p>
                
                <?php $is_dash = ($current_page == 'dashboard.php'); ?>
                <a href="<?= $prefix ?>pages/dashboard.php" 
                   class="flex items-center gap-4 px-4 py-3 rounded-2xl font-bold transition-all <?= $is_dash ? 'bg-sky-500/10 text-sky-400 border border-sky-500/20' : 'text-slate-400 hover:bg-white/5 hover:text-white' ?>">
                    <div class="w-6 flex justify-center"><i class="fas fa-layer-group text-lg"></i></div>
                    <span>Dashboard</span>
                </a>

                <?php 
                    $data_pages = ['data.php', 'data_guru.php', 'guru_nonaktif.php', 'data_siswa.php'];
                    $is_data = in_array($current_page, $data_pages); 
                ?>
                <a href="<?= $prefix ?>pages/data.php" 
                   class="flex items-center gap-4 px-4 py-3 rounded-2xl font-bold transition-all <?= $is_data ? 'bg-sky-500/10 text-sky-400 border border-sky-500/20' : 'text-slate-400 hover:bg-white/5 hover:text-white' ?>">
                    <div class="w-6 flex justify-center"><i class="fas fa-database text-lg"></i></div>
                    <span>Data</span>
                </a>

                <a href="#" class="flex items-center gap-4 px-4 py-3 rounded-2xl text-slate-400 hover:bg-white/5 hover:text-white transition-all font-semibold">
                    <div class="w-6 flex justify-center"><i class="fas fa-file-signature text-lg"></i></div>
                    <span>Input Pelanggaran</span>
                </a>

                <a href="#" class="flex items-center gap-4 px-4 py-3 rounded-2xl text-slate-400 hover:bg-white/5 hover:text-white transition-all font-semibold">
                    <div class="w-6 flex justify-center"><i class="fas fa-print text-lg"></i></div>
                    <span>Rekap Laporan</span>
                </a>
            </nav>
        </div>

        <div class="space-y-6">
            <div class="bg-white/5 rounded-3xl p-5 border border-white/5">
                <div class="flex items-center gap-3 mb-4 text-xs">
                    <div class="w-8 h-8 rounded-full bg-sky-500 flex items-center justify-center font-bold text-white shadow-lg">
                        <?= strtoupper(substr($_SESSION['username'] ?? 'U', 0, 1)); ?>
                    </div>
                    <div class="overflow-hidden">
                        <p class="font-bold text-white truncate"><?= $_SESSION['username'] ?? 'Admin'; ?></p>
                        <p class="text-sky-500 font-black uppercase tracking-tighter text-[9px] animate-pulse">System Active</p>
                    </div>
                </div>
                <a href="<?= $prefix ?>logout.php" 
                   onclick="return confirm('Akhiri sesi sistem?')"
                   class="flex items-center justify-center gap-2 w-full py-3 bg-rose-500/10 hover:bg-rose-500 text-rose-500 hover:text-white rounded-xl transition-all text-[10px] font-black uppercase tracking-widest">
                    <i class="fas fa-power-off"></i> Terminate
                </a>
            </div>
            <p class="text-[8px] text-slate-700 text-center font-bold tracking-[2px] uppercase">Dev: Rio Nata Meranggi</p>
        </div>
    </aside>

    <div class="flex-1 md:ml-72 min-h-screen relative z-10 pointer-events-auto">