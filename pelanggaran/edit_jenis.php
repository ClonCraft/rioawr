<?php
session_start();
include "../config/config.php";
include "../includes/header.php";

$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM jenis_pelanggaran WHERE id_jenis_pelanggaran = '$id'");
$data = mysqli_fetch_array($query);

if (isset($_POST['update'])) {
    $jenis = $_POST['jenis'];
    $poin  = $_POST['poin'];

    $update = mysqli_query($conn, "UPDATE jenis_pelanggaran SET jenis = '$jenis', poin = '$poin' WHERE id_jenis_pelanggaran = '$id'");

    if ($update) {
        echo "<script>alert('Aturan Berhasil Diperbarui!'); window.location='data_jenis.php';</script>";
    } else {
        echo "<script>alert('Gagal Update!');</script>";
    }
}
?>

<div class="p-8 max-w-4xl mx-auto">
    <div class="mb-10">
        <a href="data_jenis.php" class="text-amber-500 text-xs font-bold uppercase tracking-widest hover:text-white transition-all flex items-center gap-2 mb-4">
            <i class="fas fa-arrow-left"></i> Batalkan Perubahan
        </a>
        <h1 class="text-4xl font-black text-white tracking-tighter uppercase italic">Modify <span class="text-amber-500">Rule Node</span></h1>
        <p class="text-slate-500 text-[10px] font-bold uppercase tracking-[3px] mt-2">ID Pelanggaran: #<?= $id; ?></p>
    </div>

    <form action="" method="POST" class="bg-[#050a18]/60 border border-white/5 p-10 rounded-[3rem] shadow-2xl space-y-8 backdrop-blur-xl">
        <div class="space-y-6 text-slate-300">
            <div class="space-y-3">
                <label class="text-[10px] font-black text-amber-500 uppercase tracking-[3px] ml-1">Update Jenis Pelanggaran</label>
                <input type="text" name="jenis" value="<?= $data['jenis']; ?>" class="w-full bg-black/60 border border-white/10 rounded-2xl py-4 px-6 text-white outline-none focus:border-amber-500/50 transition-all" required>
            </div>

            <div class="space-y-3">
                <label class="text-[10px] font-black text-amber-500 uppercase tracking-[3px] ml-1">Update Bobot Poin</label>
                <input type="number" name="poin" value="<?= $data['poin']; ?>" class="w-full bg-black/60 border border-white/10 rounded-2xl py-4 px-6 text-white outline-none focus:border-amber-500/50 transition-all" required>
            </div>
        </div>

        <button type="submit" name="update" class="w-full bg-amber-600 hover:bg-amber-500 text-white font-black py-5 rounded-3xl shadow-xl shadow-amber-900/40 transition-all transform hover:scale-[1.01] tracking-[6px] text-[10px]">
            SYNCHRONIZE CHANGES <i class="fas fa-sync ml-2"></i>
        </button>
    </form>
</div>

<?php include "../includes/footer.php"; ?>