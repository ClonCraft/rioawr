<?php
session_start();
include "../config/config.php";
include "../includes/header.php";

if (isset($_POST['submit'])) {
    $jenis = $_POST['jenis'];
    $poin  = $_POST['poin'];

    $insert = mysqli_query($conn, "INSERT INTO jenis_pelanggaran (jenis, poin) VALUES ('$jenis', '$poin')");

    if ($insert) {
        echo "<script>alert('Jenis Pelanggaran Berhasil Ditambahkan!'); window.location='data_jenis.php';</script>";
    } else {
        echo "<script>alert('Gagal Menambah Data!');</script>";
    }
}
?>

<div class="p-8 max-w-4xl mx-auto">
    <div class="mb-10">
        <a href="data_jenis.php" class="text-amber-500 text-xs font-bold uppercase tracking-widest hover:text-white transition-all flex items-center gap-2 mb-4">
            <i class="fas fa-arrow-left"></i> Kembali ke List
        </a>
        <h1 class="text-4xl font-black text-white tracking-tighter uppercase italic">Create <span class="text-amber-500">New Rule</span></h1>
        <p class="text-slate-500 text-[10px] font-bold uppercase tracking-[3px] mt-2">Sistem Poin Pelanggaran RIO-SYS</p>
    </div>

    <form action="" method="POST" class="bg-[#050a18]/60 border border-white/5 p-10 rounded-[3rem] shadow-2xl space-y-8 backdrop-blur-xl">
        <div class="space-y-6">
            <div class="space-y-3">
                <label class="text-[10px] font-black text-amber-500 uppercase tracking-[3px] ml-1">Nama Jenis Pelanggaran</label>
                <input type="text" name="jenis" placeholder="Misal: Rambut Gondrong, Bolos, dll" class="w-full bg-black/60 border border-white/10 rounded-2xl py-4 px-6 text-white outline-none focus:border-amber-500/50 focus:ring-4 focus:ring-amber-500/5 transition-all" required>
            </div>

            <div class="space-y-3">
                <label class="text-[10px] font-black text-amber-500 uppercase tracking-[3px] ml-1">Bobot Poin (PTS)</label>
                <input type="number" name="poin" placeholder="Contoh: 10" class="w-full bg-black/60 border border-white/10 rounded-2xl py-4 px-6 text-white outline-none focus:border-amber-500/50 focus:ring-4 focus:ring-amber-500/5 transition-all" required>
            </div>
        </div>

        <div class="pt-4">
            <button type="submit" name="submit" class="w-full bg-amber-600 hover:bg-amber-500 text-white font-black py-5 rounded-3xl shadow-xl shadow-amber-900/40 transition-all transform hover:scale-[1.01] tracking-[6px] text-[10px]">
                DEPLOY NEW RULE <i class="fas fa-gavel ml-2"></i>
            </button>
        </div>
    </form>
</div>

<?php include "../includes/footer.php"; ?>