<?php
session_start();
include "../config/config.php";
include "../includes/header.php";

$id = $_GET['id'];
$data_lama = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM kelas WHERE id_kelas = '$id'"));

if (isset($_POST['update'])) {
    $tingkat = $_POST['id_tingkat'];
    $program = $_POST['id_program_keahlian'];
    $rombel  = $_POST['rombel'];
    $guru    = $_POST['kode_guru'];

    $update = mysqli_query($conn, "UPDATE kelas SET id_tingkat='$tingkat', id_program_keahlian='$program', rombel='$rombel', kode_guru='$guru' WHERE id_kelas='$id'");

    if ($update) {
        echo "<script>alert('Sistem: Data Kelas Berhasil Disinkronisasi!'); window.location='data_kelas.php';</script>";
    }
}
?>

<div class="p-8 max-w-5xl mx-auto">
    <div class="mb-10 text-center">
        <h1 class="text-4xl font-black text-white tracking-tighter uppercase italic">Modify <span class="text-indigo-500">Class Node</span></h1>
        <p class="text-slate-500 text-[10px] font-bold uppercase tracking-[4px] mt-2">ID_NODE: #CLS-<?= $id; ?></p>
    </div>

    <form action="" method="POST" class="bg-[#050a18]/60 border border-white/5 p-10 rounded-[3rem] shadow-2xl space-y-8 backdrop-blur-xl">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-slate-300">
            
            <div class="space-y-3">
                <label class="text-[10px] font-black text-indigo-500 uppercase tracking-[3px]">Grade Level</label>
                <select name="id_tingkat" class="w-full bg-black/60 border border-white/10 rounded-2xl py-4 px-6 text-white outline-none">
                    <?php
                    $tkt = mysqli_query($conn, "SELECT * FROM tingkat");
                    while($t = mysqli_fetch_array($tkt)) {
                        $sel = ($t['id_tingkat'] == $data_lama['id_tingkat']) ? 'selected' : '';
                        echo "<option value='".$t['id_tingkat']."' $sel>".$t['tingkat']."</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="space-y-3">
                <label class="text-[10px] font-black text-indigo-500 uppercase tracking-[3px]">Major</label>
                <select name="id_program_keahlian" class="w-full bg-black/60 border border-white/10 rounded-2xl py-4 px-6 text-white outline-none">
                    <?php
                    $prg = mysqli_query($conn, "SELECT * FROM program_keahlian");
                    while($p = mysqli_fetch_array($prg)) {
                        $sel = ($p['id_program_keahlian'] == $data_lama['id_program_keahlian']) ? 'selected' : '';
                        echo "<option value='".$p['id_program_keahlian']."' $sel>".$p['program_keahlian']."</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="space-y-3">
                <label class="text-[10px] font-black text-indigo-500 uppercase tracking-[3px]">Rombel</label>
                <input type="number" name="rombel" value="<?= $data_lama['rombel']; ?>" class="w-full bg-black/60 border border-white/10 rounded-2xl py-4 px-6 text-white outline-none">
            </div>

            <div class="space-y-3">
                <label class="text-[10px] font-black text-indigo-500 uppercase tracking-[3px]">Wali Kelas</label>
                <select name="kode_guru" class="w-full bg-black/60 border border-white/10 rounded-2xl py-4 px-6 text-white outline-none">
                    <?php
                    $guru = mysqli_query($conn, "SELECT * FROM guru WHERE aktif = 'Y'");
                    while($g = mysqli_fetch_array($guru)) {
                        $sel = ($g['kode_guru'] == $data_lama['kode_guru']) ? 'selected' : '';
                        echo "<option value='".$g['kode_guru']."' $sel>".$g['nama_pengguna']."</option>";
                    }
                    ?>
                </select>
            </div>

        </div>

        <button type="submit" name="update" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-black py-5 rounded-3xl shadow-xl transition-all tracking-[6px] text-[10px]">
            SYNCHRONIZE CHANGES <i class="fas fa-sync ml-2"></i>
        </button>
    </form>
</div>

<?php include "../includes/footer.php"; ?>