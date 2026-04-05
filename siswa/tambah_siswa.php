<?php
session_start();
include "../config/config.php";
include "../includes/header.php";

if (isset($_POST['submit'])) {
    $nis = $_POST['nis'];
    $nama = $_POST['nama_siswa'];
    $jk = $_POST['jenis_kelamin'];
    $alamat = $_POST['alamat'];
    $pass = password_hash($_POST['nis'], PASSWORD_DEFAULT);
    $status = $_POST['status'];
    $id_ortu = $_POST['id_ortu_wali'];
    $id_kelas = $_POST['id_kelas'];

    $insert = mysqli_query($conn, "INSERT INTO siswa (nis, nama_siswa, jenis_kelamin, alamat, password, status, id_ortu_wali, id_kelas) 
               VALUES ('$nis', '$nama', '$jk', '$alamat', '$pass', '$status', '$id_ortu', '$id_kelas')");

    if ($insert) {
        echo "<script>alert('Data Siswa Berhasil Disimpan!'); window.location='data_siswa.php';</script>";
    } else {
        $error = mysqli_error($conn);
        echo "<script>alert('Gagal Simpan! Error: $error');</script>";
    }
}
?>

<div class="p-8 max-w-6xl mx-auto">
    <div class="mb-10">
        <a href="data_siswa.php" class="text-sky-500 text-xs font-bold uppercase tracking-widest hover:text-white transition-all flex items-center gap-2 mb-4">
            <i class="fas fa-arrow-left"></i> Back to Database
        </a>
        <h1 class="text-4xl font-black text-white tracking-tighter uppercase italic text-sky-500">Add <span class="text-white">New Student</span></h1>
    </div>

    <form action="" method="POST" class="bg-[#050a18]/60 border border-white/5 p-10 rounded-[3rem] shadow-2xl space-y-8 backdrop-blur-xl">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 text-slate-300">
            
            <div class="space-y-3">
                <label class="text-[10px] font-black text-sky-500 uppercase tracking-[3px] ml-1">NIS (Primary Key)</label>
                <input type="number" name="nis" placeholder="Masukkan NIS" class="w-full bg-black/60 border border-white/10 rounded-2xl py-4 px-6 text-white outline-none focus:border-sky-500/50 transition-all" required>
            </div>

            <div class="space-y-3">
                <label class="text-[10px] font-black text-sky-500 uppercase tracking-[3px] ml-1">Nama Lengkap</label>
                <input type="text" name="nama_siswa" placeholder="Nama Siswa" class="w-full bg-black/60 border border-white/10 rounded-2xl py-4 px-6 text-white outline-none focus:border-sky-500/50 transition-all" required>
            </div>

            <div class="space-y-3">
                <label class="text-[10px] font-black text-sky-500 uppercase tracking-[3px] ml-1">Gender</label>
                <select name="jenis_kelamin" class="w-full bg-black/60 border border-white/10 rounded-2xl py-4 px-6 text-white outline-none focus:border-sky-500/50 transition-all">
                    <option value="Laki - Laki">Laki - Laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>

            <div class="space-y-3">
                <label class="text-[10px] font-black text-sky-500 uppercase tracking-[3px] ml-1">Class Assignment</label>
                <select name="id_kelas" class="w-full bg-black/60 border border-white/10 rounded-2xl py-4 px-6 text-white outline-none focus:border-sky-500/50 transition-all" required>
                    <option value="">-- Pilih Kelas --</option>
                    <?php
                    // Query Join untuk memunculkan nama kelas yang lengkap
                    $ambil_kelas = mysqli_query($conn, "SELECT kelas.id_kelas, kelas.rombel, tingkat.tingkat, program_keahlian.program_keahlian 
                                                        FROM kelas 
                                                        JOIN tingkat ON kelas.id_tingkat = tingkat.id_tingkat 
                                                        JOIN program_keahlian ON kelas.id_program_keahlian = program_keahlian.id_program_keahlian 
                                                        ORDER BY tingkat.tingkat DESC");
                    while($k = mysqli_fetch_array($ambil_kelas)) {
                        echo "<option value='".$k['id_kelas']."'>".$k['tingkat']." ".$k['program_keahlian']." ".$k['rombel']."</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="space-y-3">
                <label class="text-[10px] font-black text-sky-500 uppercase tracking-[3px] ml-1">Parent Link</label>
                <select name="id_ortu_wali" class="w-full bg-black/60 border border-white/10 rounded-2xl py-4 px-6 text-white outline-none focus:border-sky-500/50 transition-all" required>
                    <option value="">-- Pilih Ortu/Wali --</option>
                    <?php
                    $ambil_ortu = mysqli_query($conn, "SELECT * FROM ortu_wali");
                    while($o = mysqli_fetch_array($ambil_ortu)) {
                        $nama_ortu = $o['ayah'] ? $o['ayah'] : $o['wali'];
                        echo "<option value='".$o['id_ortu_wali']."'>ID: ".$o['id_ortu_wali']." - ".$nama_ortu."</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="space-y-3">
                <label class="text-[10px] font-black text-sky-500 uppercase tracking-[3px] ml-1">Status</label>
                <select name="status" class="w-full bg-black/60 border border-white/10 rounded-2xl py-4 px-6 text-white outline-none focus:border-sky-500/50 transition-all">
                    <option value="aktif">Aktif</option>
                    <option value="lulus">Lulus</option>
                    <option value="pindah">Pindah</option>
                </select>
            </div>

            <div class="space-y-3 md:col-span-2 lg:col-span-3">
                <label class="text-[10px] font-black text-sky-500 uppercase tracking-[3px] ml-1">Residential Address</label>
                <textarea name="alamat" rows="3" class="w-full bg-black/60 border border-white/10 rounded-2xl py-4 px-6 text-white outline-none focus:border-sky-500/50 transition-all" required></textarea>
            </div>
        </div>

        <button type="submit" name="submit" class="w-full bg-sky-600 hover:bg-sky-500 text-white font-black py-5 rounded-3xl shadow-xl shadow-sky-900/40 transition-all transform hover:scale-[1.01] tracking-[6px] text-[10px]">
            SAVE TO CORE DATABASE <i class="fas fa-save ml-2"></i>
        </button>
    </form>
</div>

<?php include "../includes/footer.php"; ?>