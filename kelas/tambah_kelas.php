<?php
session_start();
include "../config/config.php";
include "../includes/header.php";

if (isset($_POST['submit'])) {
    $tingkat = $_POST['id_tingkat'];
    $program = $_POST['id_program_keahlian'];
    $rombel  = $_POST['rombel'];
    $guru    = $_POST['kode_guru'];

    $insert = mysqli_query($conn, "INSERT INTO kelas (id_tingkat, id_program_keahlian, rombel, kode_guru) 
                                   VALUES ('$tingkat', '$program', '$rombel', '$guru')");

    if ($insert) {
        echo "<script>alert('Kelas Baru Berhasil Diinisialisasi!'); window.location='data_kelas.php';</script>";
    } else {
        echo "<script>alert('Gagal! Periksa koneksi database.');</script>";
    }
}
?>

<div class="p-8 max-w-5xl mx-auto">
    <div class="mb-10 text-center">
        <h1 class="text-4xl font-black text-white tracking-tighter uppercase italic">Create <span class="text-indigo-500">New Class</span></h1>
        <p class="text-slate-500 text-[10px] font-bold uppercase tracking-[4px] mt-2">Academic Node Initialization</p>
    </div>

    <form action="" method="POST" class="bg-[#050a18]/60 border border-white/5 p-10 rounded-[3rem] shadow-2xl space-y-8 backdrop-blur-xl">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-slate-300">
            
            <div class="space-y-3">
                <label class="text-[10px] font-black text-indigo-500 uppercase tracking-[3px] ml-1">Grade Level (Tingkat)</label>
                <select name="id_tingkat" class="w-full bg-black/60 border border-white/10 rounded-2xl py-4 px-6 text-white outline-none focus:border-indigo-500/50 transition-all" required>
                    <?php
                    $tkt = mysqli_query($conn, "SELECT * FROM tingkat");
                    while($t = mysqli_fetch_array($tkt)) echo "<option value='".$t['id_tingkat']."'>".$t['tingkat']."</option>";
                    ?>
                </select>
            </div>

            <div class="space-y-3">
                <label class="text-[10px] font-black text-indigo-500 uppercase tracking-[3px] ml-1">Major (Program Keahlian)</label>
                <select name="id_program_keahlian" class="w-full bg-black/60 border border-white/10 rounded-2xl py-4 px-6 text-white outline-none focus:border-indigo-500/50 transition-all" required>
                    <?php
                    $prg = mysqli_query($conn, "SELECT * FROM program_keahlian");
                    while($p = mysqli_fetch_array($prg)) echo "<option value='".$p['id_program_keahlian']."'>".$p['program_keahlian']."</option>";
                    ?>
                </select>
            </div>

            <div class="space-y-3">
                <label class="text-[10px] font-black text-indigo-500 uppercase tracking-[3px] ml-1">Rombel Number</label>
                <input type="number" name="rombel" placeholder="Contoh: 1" class="w-full bg-black/60 border border-white/10 rounded-2xl py-4 px-6 text-white outline-none focus:border-indigo-500/50 transition-all" required>
            </div>

            <div class="space-y-3">
                <label class="text-[10px] font-black text-indigo-500 uppercase tracking-[3px] ml-1">Assign Wali Kelas</label>
                <select name="kode_guru" class="w-full bg-black/60 border border-white/10 rounded-2xl py-4 px-6 text-white outline-none focus:border-indigo-500/50 transition-all" required>
                    <option value="">-- Pilih Guru --</option>
                    <?php
                    $guru = mysqli_query($conn, "SELECT * FROM guru WHERE aktif = 'Y'");
                    while($g = mysqli_fetch_array($guru)) echo "<option value='".$g['kode_guru']."'>".$g['nama_pengguna']."</option>";
                    ?>
                </select>
            </div>

        </div>

        <button type="submit" name="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-black py-5 rounded-3xl shadow-xl shadow-indigo-900/40 transition-all transform hover:scale-[1.01] tracking-[6px] text-[10px]">
            REGISTER CLASS NODE <i class="fas fa-save ml-2"></i>
        </button>
    </form>
</div>

<?php include "../includes/footer.php"; ?>