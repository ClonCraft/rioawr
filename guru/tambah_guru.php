<?php
session_start();
include "../config/config.php"; // Keluar folder guru, cari config
include "../includes/header.php"; // Keluar folder guru, cari includes

if (isset($_POST['submit'])) {
    $kode = $_POST['kode_guru'];
    $nama = $_POST['nama_pengguna'];
    $user = $_POST['username'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT); 
    $jabatan = $_POST['jabatan'];
    $telp = $_POST['telp'];

    // Pastikan variabel koneksi kamu bernama $conn atau $koneksi sesuai config.php
    $insert = mysqli_query($conn, "INSERT INTO guru (kode_guru, nama_pengguna, role, username, password, aktif, jabatan, telp) 
               VALUES ('$kode', '$nama', 'Guru', '$user', '$pass', 'Y', '$jabatan', '$telp')");

    if ($insert) {
        echo "<script>alert('Data Guru Berhasil Diinisialisasi!'); window.location='data_guru.php';</script>";
    } else {
        echo "<script>alert('Gagal Menambahkan Data! Periksa database anda.');</script>";
    }
}
?>

<div class="p-8 max-w-5xl mx-auto">
    <div class="mb-10">
        <a href="data_guru.php" class="text-sky-500 text-xs font-bold uppercase tracking-widest hover:text-white transition-all flex items-center gap-2 mb-4">
            <i class="fas fa-arrow-left"></i> Back to Database
        </a>
        <h1 class="text-4xl font-black text-white tracking-tighter uppercase italic">Initialize <span class="text-sky-500">Personnel</span></h1>
    </div>

    <form action="" method="POST" class="bg-white/[0.02] border border-white/5 p-10 rounded-[3rem] shadow-2xl space-y-8 backdrop-blur-xl">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            
            <div class="space-y-3">
                <label class="text-[10px] font-black text-sky-500 uppercase tracking-[3px] ml-1">Personnel ID / Kode Guru</label>
                <input type="text" name="kode_guru" placeholder="NODE-001" class="w-full bg-black/60 border border-white/10 rounded-2xl py-4 px-6 text-white outline-none focus:border-sky-500/50 focus:ring-4 focus:ring-sky-500/5 transition-all" required>
            </div>

            <div class="space-y-3">
                <label class="text-[10px] font-black text-sky-500 uppercase tracking-[3px] ml-1">Full Identity / Nama Lengkap</label>
                <input type="text" name="nama_pengguna" placeholder="Masukkan Nama & Gelar" class="w-full bg-black/60 border border-white/10 rounded-2xl py-4 px-6 text-white outline-none focus:border-sky-500/50 focus:ring-4 focus:ring-sky-500/5 transition-all" required>
            </div>

            <div class="space-y-3">
                <label class="text-[10px] font-black text-sky-500 uppercase tracking-[3px] ml-1">Access Username</label>
                <input type="text" name="username" placeholder="username_access" class="w-full bg-black/60 border border-white/10 rounded-2xl py-4 px-6 text-white outline-none focus:border-sky-500/50 focus:ring-4 focus:ring-sky-500/5 transition-all" required>
            </div>

            <div class="space-y-3">
                <label class="text-[10px] font-black text-sky-500 uppercase tracking-[3px] ml-1">Security Key / Password</label>
                <input type="password" name="password" placeholder="••••••••" class="w-full bg-black/60 border border-white/10 rounded-2xl py-4 px-6 text-white outline-none focus:border-sky-500/50 focus:ring-4 focus:ring-sky-500/5 transition-all" required>
            </div>

            <div class="space-y-3">
                <label class="text-[10px] font-black text-sky-500 uppercase tracking-[3px] ml-1">Assigned Position / Jabatan</label>
                <select name="jabatan" class="w-full bg-black/60 border border-white/10 rounded-2xl py-4 px-6 text-white outline-none focus:border-sky-500/50 transition-all appearance-none cursor-pointer">
                    <option value="Guru Mapel">Guru Mapel</option>
                    <option value="Kepala Sekolah">Kepala Sekolah</option>
                    <option value="Waka Kesiswaan">Waka Kesiswaan</option>
                    <option value="Komka TKJ">Komka TKJ</option>
                </select>
            </div>

            <div class="space-y-3">
                <label class="text-[10px] font-black text-sky-500 uppercase tracking-[3px] ml-1">Comm Line / Telepon</label>
                <input type="text" name="telp" placeholder="08XXXXXXXXXX" class="w-full bg-black/60 border border-white/10 rounded-2xl py-4 px-6 text-white outline-none focus:border-sky-500/50 focus:ring-4 focus:ring-sky-500/5 transition-all" required>
            </div>

        </div>

        <button type="submit" name="submit" class="w-full bg-sky-600 hover:bg-sky-500 text-white font-black py-5 rounded-3xl shadow-xl shadow-sky-900/20 transition-all transform hover:scale-[1.01] active:scale-[0.98] mt-6 tracking-[6px] text-[10px]">
            UPLOAD TO DATABASE <i class="fas fa-cloud-upload-alt ml-2"></i>
        </button>
    </form>
</div>

<?php include "../includes/footer.php"; ?>