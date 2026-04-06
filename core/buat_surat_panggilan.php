<?php
session_start();
include "../config/config.php";
include "../includes/header.php";

$nis = mysqli_real_escape_string($conn, $_GET['nis']);

// 1. Ambil data siswa untuk info di atas form
$query = mysqli_query($conn, "SELECT nama_siswa FROM siswa WHERE nis = '$nis'");
$s = mysqli_fetch_array($query);

// 2. Logika Simpan Data ke tabel surat_keluar
if (isset($_POST['submit'])) {
    $no_surat = mysqli_real_escape_string($conn, $_POST['no_surat']);
    $tgl_panggil = $_POST['tgl_panggil'];
    $jam_panggil = $_POST['jam_panggil'];
    $keperluan = mysqli_real_escape_string($conn, $_POST['keperluan']);
    $tgl_buat = date('Y-m-d');
    $jenis_surat = "Panggilan Orang Tua";

    $ins = mysqli_query($conn, "INSERT INTO surat_keluar (no_surat, jenis_surat, nis, tanggal_pembuatan_surat, tanggal_pemanggilan, keperluan, id_profil_sekolah, id_tahun_ajaran) 
                                VALUES ('$no_surat', '$jenis_surat', '$nis', '$tgl_buat', '$tgl_panggil $jam_panggil', '$keperluan', 1, 5)");

    if ($ins) {
        $last_id = mysqli_insert_id($conn);
        echo "<script>alert('Data Berhasil Disimpan! Menuju Halaman Cetak...'); window.location='cetak_surat_panggilan.php?id=$last_id';</script>";
    } else {
        echo "<script>alert('Gagal menyimpan data!');</script>";
    }
}
?>

<div class="p-8 flex flex-col items-center justify-center min-h-[80vh]">
    <div class="w-full max-w-2xl space-y-8">
        
        <div class="text-center">
            <h1 class="text-3xl font-black text-white uppercase italic tracking-tighter">Surat <span class="text-sky-500">Panggilan Orang Tua</span></h1>
            <p class="text-slate-500 text-[10px] font-black uppercase tracking-[5px] mt-2">Input Document Details</p>
        </div>

        <div class="bg-[#050a18]/60 border border-white/5 p-10 rounded-[2.5rem] shadow-2xl backdrop-blur-md">
            <div class="mb-8 p-4 bg-sky-500/10 border border-sky-500/20 rounded-2xl flex justify-between items-center">
                <span class="text-[10px] font-black text-sky-500 uppercase tracking-widest">Siswa Terpilih:</span>
                <span class="text-sm font-black text-white uppercase italic"><?= $s['nama_siswa'] ?> (<?= $nis ?>)</span>
            </div>

            <form action="" method="POST" class="space-y-6">
                <div class="flex items-center gap-4">
                    <label class="w-32 text-slate-400 text-[10px] font-black uppercase tracking-widest">No Surat :</label>
                    <input type="text" name="no_surat" required placeholder="Contoh: 892323/SMK TI/BG/IV/2026" class="flex-1 bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-white text-xs outline-none focus:border-sky-500 transition-all">
                </div>

                <div class="flex items-center gap-4">
                    <label class="w-32 text-slate-400 text-[10px] font-black uppercase tracking-widest">Tanggal :</label>
                    <input type="date" name="tgl_panggil" required class="flex-1 bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-white text-xs outline-none focus:border-sky-500 transition-all">
                </div>

                <div class="flex items-center gap-4">
                    <label class="w-32 text-slate-400 text-[10px] font-black uppercase tracking-widest">Jam :</label>
                    <input type="time" name="jam_panggil" required class="flex-1 bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-white text-xs outline-none focus:border-sky-500 transition-all">
                </div>

                <div class="flex items-start gap-4">
                    <label class="w-32 text-slate-400 text-[10px] font-black uppercase tracking-widest mt-3">Keperluan :</label>
                    <textarea name="keperluan" rows="4" required placeholder="Contoh: Menindaklanjuti pelanggaran tata tertib sekolah..." class="flex-1 bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-white text-xs outline-none focus:border-sky-500 transition-all resize-none"></textarea>
                </div>

                <div class="pt-6 flex justify-center">
                    <button type="submit" name="submit" class="px-10 py-3 bg-sky-600 hover:bg-sky-500 text-white text-[11px] font-black uppercase tracking-[3px] rounded-2xl shadow-lg shadow-sky-900/40 transition-all transform hover:-translate-y-1">
                        Generate & Cetak Surat
                    </button>
                </div>
            </form>
        </div>

        <div class="text-center">
            <a href="buat_surat.php?nis=<?= $nis ?>" class="text-slate-600 hover:text-white text-[9px] font-black uppercase tracking-[5px] transition-all italic">
                <i class="fas fa-chevron-left mr-2"></i> Cancel Process
            </a>
        </div>
    </div>
</div>

<?php include "../includes/footer.php"; ?>