<?php
session_start();
include "../config/config.php";
include "../includes/header.php";

// 1. Ambil NIS dari URL
if (!isset($_GET['nis'])) {
    echo "<script>window.location='data_siswa.php';</script>";
    exit;
}

$nis = $_GET['nis'];

// 2. Query ambil data siswa lama
$query = mysqli_query($conn, "SELECT * FROM siswa WHERE nis = '$nis'");
$data = mysqli_fetch_array($query);

if (mysqli_num_rows($query) < 1) {
    echo "<script>alert('Data tidak ditemukan!'); window.location='data_siswa.php';</script>";
    exit;
}

// 3. Proses Update Data
if (isset($_POST['update'])) {
    $nama     = $_POST['nama_siswa'];
    $jk       = $_POST['jenis_kelamin'];
    $alamat   = $_POST['alamat'];
    $status   = $_POST['status'];
    $id_ortu  = $_POST['id_ortu_wali'];
    $id_kelas = $_POST['id_kelas'];

    $update = mysqli_query($conn, "UPDATE siswa SET 
                nama_siswa = '$nama', 
                jenis_kelamin = '$jk', 
                alamat = '$alamat', 
                status = '$status',
                id_ortu_wali = '$id_ortu',
                id_kelas = '$id_kelas'
                WHERE nis = '$nis'");

    if ($update) {
        echo "<script>alert('Data Siswa Berhasil Disinkronisasi!'); window.location='data_siswa.php';</script>";
    } else {
        echo "<script>alert('Gagal Update Data!');</script>";
    }
}
?>

<div class="p-8 max-w-6xl mx-auto">
    <div class="mb-10">
        <a href="data_siswa.php" class="text-sky-500 text-xs font-bold uppercase tracking-widest hover:text-white transition-all flex items-center gap-2 mb-4">
            <i class="fas fa-arrow-left"></i> Abort Mission
        </a>
        <h1 class="text-4xl font-black text-white tracking-tighter uppercase italic">Modify <span class="text-amber-500">Student Node</span></h1>
        <p class="text-slate-500 text-[10px] font-bold uppercase tracking-[3px] mt-2">Editing NIS: <span class="text-sky-400"><?= $nis; ?></span></p>
    </div>

    <form action="" method="POST" class="bg-[#050a18]/60 border border-white/5 p-10 rounded-[3rem] shadow-2xl space-y-8 backdrop-blur-xl text-slate-300">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            
            <div class="space-y-3 opacity-60">
                <label class="text-[10px] font-black text-slate-500 uppercase tracking-[3px] ml-1">Student ID (Locked)</label>
                <input type="text" value="<?= $data['nis']; ?>" readonly class="w-full bg-black/40 border border-white/5 rounded-2xl py-4 px-6 text-slate-500 cursor-not-allowed outline-none">
            </div>

            <div class="space-y-3">
                <label class="text-[10px] font-black text-sky-500 uppercase tracking-[3px] ml-1">Full Name</label>
                <input type="text" name="nama_siswa" value="<?= $data['nama_siswa']; ?>" class="w-full bg-black/60 border border-white/10 rounded-2xl py-4 px-6 text-white outline-none focus:border-amber-500/50 transition-all" required>
            </div>

            <div class="space-y-3">
                <label class="text-[10px] font-black text-sky-500 uppercase tracking-[3px] ml-1">Gender</label>
                <select name="jenis_kelamin" class="w-full bg-black/60 border border-white/10 rounded-2xl py-4 px-6 text-white outline-none focus:border-amber-500/50 transition-all">
                    <option value="Laki - Laki" <?= ($data['jenis_kelamin'] == 'Laki - Laki') ? 'selected' : ''; ?>>Laki - Laki</option>
                    <option value="Perempuan" <?= ($data['jenis_kelamin'] == 'Perempuan') ? 'selected' : ''; ?>>Perempuan</option>
                </select>
            </div>

            <div class="space-y-3">
                <label class="text-[10px] font-black text-sky-500 uppercase tracking-[3px] ml-1">Parent Link ID</label>
                <input type="number" name="id_ortu_wali" value="<?= $data['id_ortu_wali']; ?>" class="w-full bg-black/60 border border-white/10 rounded-2xl py-4 px-6 text-white outline-none focus:border-amber-500/50 transition-all" required>
            </div>

            <div class="space-y-3">
                <label class="text-[10px] font-black text-sky-500 uppercase tracking-[3px] ml-1">Class ID</label>
                <input type="number" name="id_kelas" value="<?= $data['id_kelas']; ?>" class="w-full bg-black/60 border border-white/10 rounded-2xl py-4 px-6 text-white outline-none focus:border-amber-500/50 transition-all" required>
            </div>

            <div class="space-y-3">
                <label class="text-[10px] font-black text-sky-500 uppercase tracking-[3px] ml-1">Account Status</label>
                <select name="status" class="w-full bg-black/60 border border-white/10 rounded-2xl py-4 px-6 text-white outline-none focus:border-amber-500/50 transition-all">
                    <option value="aktif" <?= ($data['status'] == 'aktif') ? 'selected' : ''; ?>>Aktif</option>
                    <option value="lulus" <?= ($data['status'] == 'lulus') ? 'selected' : ''; ?>>Lulus</option>
                    <option value="pindah" <?= ($data['status'] == 'pindah') ? 'selected' : ''; ?>>Pindah</option>
                </select>
            </div>

            <div class="space-y-3 md:col-span-2 lg:col-span-3">
                <label class="text-[10px] font-black text-sky-500 uppercase tracking-[3px] ml-1">Residential Address</label>
                <textarea name="alamat" rows="3" class="w-full bg-black/60 border border-white/10 rounded-2xl py-4 px-6 text-white outline-none focus:border-amber-500/50 transition-all" required><?= $data['alamat']; ?></textarea>
            </div>
        </div>

        <button type="submit" name="update" class="w-full bg-amber-600 hover:bg-amber-500 text-white font-black py-5 rounded-3xl shadow-xl shadow-amber-900/40 transition-all transform hover:scale-[1.01] tracking-[6px] text-[10px]">
            UPDATE SYSTEM CORE <i class="fas fa-sync-alt ml-2"></i>
        </button>
    </form>
</div>

<?php include "../includes/footer.php"; ?>