<?php
session_start();
include "../config/config.php";
include "../includes/header.php";

$id = mysqli_real_escape_string($conn, $_GET['id']);
$type = $_GET['type']; // 'siswa' atau 'ortu'

// Tentukan tabel berdasarkan tipe
if ($type == 'siswa') {
    $query = mysqli_query($conn, "SELECT foto_dokumen, nama_siswa FROM perjanjian_siswa 
                                  JOIN pelanggaran_siswa ON perjanjian_siswa.id_pelanggaran_siswa = pelanggaran_siswa.id_pelanggaran_siswa
                                  JOIN siswa ON pelanggaran_siswa.nis = siswa.nis
                                  WHERE id_perjanjian_siswa = '$id'");
} else {
    $query = mysqli_query($conn, "SELECT foto_dokumen, nama_siswa FROM perjanjian_orang_tua 
                                  JOIN pelanggaran_siswa ON perjanjian_orang_tua.id_pelanggaran_siswa = pelanggaran_siswa.id_pelanggaran_siswa
                                  JOIN siswa ON pelanggaran_siswa.nis = siswa.nis
                                  WHERE id_perjanjian_ortu = '$id'");
}

$data = mysqli_fetch_array($query);
$gambar = $data['foto_dokumen'];
?>

<div class="p-8 flex flex-col items-center justify-center min-h-[80vh] space-y-6">
    
    <div class="text-center">
        <h2 class="text-white font-black text-xl uppercase italic tracking-tighter">Preview <span class="text-sky-500">Dokumen Fisik</span></h2>
        <p class="text-slate-500 text-[10px] font-bold uppercase tracking-[5px] mt-1">Siswa: <?= $data['nama_siswa'] ?></p>
    </div>

    <div class="rio-card p-4 bg-[#050a18]/80 border border-white/10 rounded-[2.5rem] shadow-2xl backdrop-blur-xl max-w-4xl w-full">
        <?php if ($gambar && file_exists("../uploads/perjanjian/" . $gambar)): ?>
            <img src="../uploads/perjanjian/<?= $gambar ?>" class="w-full rounded-[1.5rem] shadow-2xl border border-white/5" alt="Bukti Perjanjian">
        <?php else: ?>
            <div class="p-20 text-center space-y-4">
                <i class="fas fa-image-slash text-slate-700 text-6xl"></i>
                <p class="text-slate-500 font-black uppercase text-[10px] tracking-widest italic">File Gambar Tidak Ditemukan di Server</p>
            </div>
        <?php endif; ?>
    </div>

    <div class="flex gap-4">
        <a href="laporan_perjanjian.php" class="btn-action btn-outline px-8 py-3">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Laporan
        </a>
        <?php if ($gambar): ?>
            <a href="../uploads/perjanjian/<?= $gambar ?>" download class="btn-action btn-blue px-8 py-3" style="background: #10b981;">
                <i class="fas fa-download mr-2"></i> Download Original
            </a>
        <?php endif; ?>
    </div>

</div>

<?php include "../includes/footer.php"; ?>