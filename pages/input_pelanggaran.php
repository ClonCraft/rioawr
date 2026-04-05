<?php
session_start();
include "../config/config.php";
include "../includes/header.php";

// Proses Simpan Pelanggaran
if (isset($_POST['submit'])) {
    $nis = $_POST['nis'];
    $id_jenis = $_POST['id_jenis_pelanggaran'];
    $keterangan = $_POST['keterangan'];
    $tanggal = date('Y-m-d'); // Otomatis ambil tanggal hari ini

    $insert = mysqli_query($conn, "INSERT INTO pelanggaran_siswa (nis, id_jenis_pelanggaran, keterangan, tanggal) 
                                   VALUES ('$nis', '$id_jenis', '$keterangan', '$tanggal')");

    if ($insert) {
        echo "<script>alert('Sistem: Pelanggaran Siswa Berhasil Dicatat!'); window.location='input_pelanggaran.php';</script>";
    } else {
        echo "<script>alert('Gagal mencatat! Periksa koneksi.');</script>";
    }
}
?>

<div class="p-8 max-w-5xl mx-auto">
    <div class="mb-10 text-center">
        <h2 class="text-rose-500 font-bold text-[10px] uppercase tracking-[4px]">Disciplinary Action</h2>
        <h1 class="text-4xl font-black text-white tracking-tighter uppercase italic">Input <span class="text-rose-500">Pelanggaran</span></h1>
        <p class="text-slate-500 text-[10px] font-bold uppercase tracking-[3px] mt-2">Recording Student Misconduct Node</p>
    </div>

    <form action="" method="POST" class="bg-[#050a18]/60 border border-white/5 p-10 rounded-[3rem] shadow-2xl space-y-8 backdrop-blur-xl">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-slate-300">
            
            <div class="space-y-3">
                <label class="text-[10px] font-black text-rose-500 uppercase tracking-[3px] ml-1">Student (NIS - Nama)</label>
                <select name="nis" class="w-full bg-black/60 border border-white/10 rounded-2xl py-4 px-6 text-white outline-none focus:border-rose-500/50 transition-all select2" required>
                    <option value="">-- Pilih Siswa --</option>
                    <?php
                    // Ambil data siswa dan kelasnya
                    $siswa = mysqli_query($conn, "SELECT siswa.nis, siswa.nama_siswa, tingkat.tingkat, program_keahlian.program_keahlian, kelas.rombel 
                                                 FROM siswa 
                                                 JOIN kelas ON siswa.id_kelas = kelas.id_kelas
                                                 JOIN tingkat ON kelas.id_tingkat = tingkat.id_tingkat
                                                 JOIN program_keahlian ON kelas.id_program_keahlian = program_keahlian.id_program_keahlian
                                                 WHERE status = 'aktif'");
                    while($s = mysqli_fetch_array($siswa)) {
                        echo "<option value='".$s['nis']."'>".$s['nis']." - ".$s['nama_siswa']." (".$s['tingkat']." ".$s['program_keahlian']." ".$s['rombel'].")</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="space-y-3">
                <label class="text-[10px] font-black text-rose-500 uppercase tracking-[3px] ml-1">Violation Type</label>
                <select name="id_jenis_pelanggaran" class="w-full bg-black/60 border border-white/10 rounded-2xl py-4 px-6 text-white outline-none focus:border-rose-500/50 transition-all" required>
                    <option value="">-- Pilih Jenis --</option>
                    <?php
                    $jenis = mysqli_query($conn, "SELECT * FROM jenis_pelanggaran ORDER BY poin DESC");
                    while($j = mysqli_fetch_array($jenis)) {
                        echo "<option value='".$j['id_jenis_pelanggaran']."'>".$j['jenis']." (".$j['poin']." Poin)</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="space-y-3 md:col-span-2">
                <label class="text-[10px] font-black text-rose-500 uppercase tracking-[3px] ml-1">Violation Description / Details</label>
                <textarea name="keterangan" rows="4" placeholder="Jelaskan detail kejadian pelanggaran..." class="w-full bg-black/60 border border-white/10 rounded-3xl py-4 px-6 text-white outline-none focus:border-rose-500/50 transition-all" required></textarea>
            </div>

        </div>

        <button type="submit" name="submit" class="w-full bg-rose-600 hover:bg-rose-500 text-white font-black py-5 rounded-3xl shadow-xl shadow-rose-900/40 transition-all transform hover:scale-[1.01] tracking-[6px] text-[10px]">
            EXECUTE DISCIPLINARY LOG <i class="fas fa-gavel ml-2"></i>
        </button>
    </form>
</div>

<?php include "../includes/footer.php"; ?>