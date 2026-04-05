<?php
session_start();
include "../config/config.php";
include "../includes/header.php";

// 1. Ambil ID dari URL
if (!isset($_GET['id'])) {
    header("Location: data_guru.php");
    exit;
}

$id = $_GET['id'];

// 2. Query ambil data guru yang mau diedit
$query = mysqli_query($conn, "SELECT * FROM guru WHERE kode_guru = '$id'");
$data = mysqli_fetch_array($query);

// Jika data tidak ditemukan
if (mysqli_num_rows($query) < 1) {
    echo "<script>alert('Data tidak ditemukan!'); window.location='data_guru.php';</script>";
    exit;
}

// 3. Proses Update Data saat tombol diklik
if (isset($_POST['update'])) {
    $nama     = $_POST['nama_pengguna'];
    $username = $_POST['username'];
    $jabatan  = $_POST['jabatan'];
    $telp     = $_POST['telp'];

    // Update query (Kode Guru tidak diubah karena itu Primary Key/ID)
    $update = mysqli_query($conn, "UPDATE guru SET 
                nama_pengguna = '$nama', 
                username = '$username', 
                jabatan = '$jabatan', 
                telp = '$telp' 
                WHERE kode_guru = '$id'");

    if ($update) {
        echo "<script>alert('Update Berhasil! Sistem Terkoneksi.'); window.location='data_guru.php';</script>";
    } else {
        echo "<script>alert('Gagal Update Data!');</script>";
    }
}
?>

<div class="p-8 max-w-5xl mx-auto">
    <div class="mb-10">
        <a href="data_guru.php" class="text-sky-500 text-xs font-bold uppercase tracking-widest hover:text-white transition-all flex items-center gap-2 mb-4">
            <i class="fas fa-arrow-left"></i> Cancel Edit
        </a>
        <h1 class="text-4xl font-black text-white tracking-tighter uppercase italic text-amber-500">Modify <span class="text-white">Personnel</span></h1>
        <p class="text-slate-500 text-xs mt-2 uppercase tracking-widest">Editing Node ID: <span class="text-sky-400"><?= $id; ?></span></p>
    </div>

    <form action="" method="POST" class="bg-white/[0.02] border border-white/5 p-10 rounded-[3rem] shadow-2xl space-y-8 backdrop-blur-xl">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            
            <div class="space-y-3 opacity-60">
                <label class="text-[10px] font-black text-slate-500 uppercase tracking-[3px] ml-1">Personnel ID (Locked)</label>
                <input type="text" value="<?= $data['kode_guru']; ?>" readonly class="w-full bg-black/20 border border-white/5 rounded-2xl py-4 px-6 text-slate-500 cursor-not-allowed outline-none">
            </div>

            <div class="space-y-3">
                <label class="text-[10px] font-black text-sky-500 uppercase tracking-[3px] ml-1">Full Identity</label>
                <input type="text" name="nama_pengguna" value="<?= $data['nama_pengguna']; ?>" class="w-full bg-black/60 border border-white/10 rounded-2xl py-4 px-6 text-white outline-none focus:border-amber-500/50 focus:ring-4 focus:ring-amber-500/5 transition-all" required>
            </div>

            <div class="space-y-3">
                <label class="text-[10px] font-black text-sky-500 uppercase tracking-[3px] ml-1">Access Username</label>
                <input type="text" name="username" value="<?= $data['username']; ?>" class="w-full bg-black/60 border border-white/10 rounded-2xl py-4 px-6 text-white outline-none focus:border-amber-500/50 focus:ring-4 focus:ring-amber-500/5 transition-all" required>
            </div>

            <div class="space-y-3">
                <label class="text-[10px] font-black text-sky-500 uppercase tracking-[3px] ml-1">Assigned Position</label>
                <select name="jabatan" class="w-full bg-black/60 border border-white/10 rounded-2xl py-4 px-6 text-white outline-none focus:border-amber-500/50 transition-all appearance-none cursor-pointer">
                    <option value="Guru Mapel" <?= ($data['jabatan'] == 'Guru Mapel') ? 'selected' : ''; ?>>Guru Mapel</option>
                    <option value="Kepala Sekolah" <?= ($data['jabatan'] == 'Kepala Sekolah') ? 'selected' : ''; ?>>Kepala Sekolah</option>
                    <option value="Waka Kesiswaan" <?= ($data['jabatan'] == 'Waka Kesiswaan') ? 'selected' : ''; ?>>Waka Kesiswaan</option>
                    <option value="Komka TKJ" <?= ($data['jabatan'] == 'Komka TKJ') ? 'selected' : ''; ?>>Komka TKJ</option>
                    <option value="Komka RPL" <?= ($data['jabatan'] == 'Komka RPL') ? 'selected' : ''; ?>>Komka RPL</option>
                </select>
            </div>

            <div class="space-y-3">
                <label class="text-[10px] font-black text-sky-500 uppercase tracking-[3px] ml-1">Comm Line / Telepon</label>
                <input type="text" name="telp" value="<?= $data['telp']; ?>" class="w-full bg-black/60 border border-white/10 rounded-2xl py-4 px-6 text-white outline-none focus:border-amber-500/50 focus:ring-4 focus:ring-amber-500/5 transition-all" required>
            </div>

        </div>

        <button type="submit" name="update" class="w-full bg-amber-600 hover:bg-amber-500 text-white font-black py-5 rounded-3xl shadow-xl shadow-amber-900/20 transition-all transform hover:scale-[1.01] active:scale-[0.98] mt-6 tracking-[6px] text-[10px]">
            SYNCHRONIZE DATA <i class="fas fa-sync-alt ml-2"></i>
        </button>
    </form>
</div>

<?php include "../includes/footer.php"; ?>