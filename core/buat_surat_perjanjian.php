<?php
session_start();
include "../config/config.php";
include "../includes/header.php";

// 1. CEK NIS (Penting agar tidak error)
if (!isset($_GET['nis']) || empty($_GET['nis'])) {
    echo "<script>alert('Akses Ilegal: NIS tidak ditemukan!'); window.location='laporan_panggilan.php';</script>";
    exit;
}

$nis = mysqli_real_escape_string($conn, $_GET['nis']);

// 2. QUERY KE DATABASE (Sesuai kolom di screenshot kamu)
$sql = "SELECT siswa.*, ortu_wali.ayah, ortu_wali.ibu, ortu_wali.pekerjaan_ayah, 
               ortu_wali.pekerjaan_ibu, ortu_wali.no_telp_ayah, ortu_wali.no_telp_ibu, ortu_wali.alamat_ayah
        FROM siswa 
        LEFT JOIN ortu_wali ON siswa.id_ortu_wali = ortu_wali.id_ortu_wali 
        WHERE siswa.nis = '$nis'";

$query = mysqli_query($conn, $sql);
$s = mysqli_fetch_array($query);
?>

<div class="p-8 space-y-10">
    <div class="text-center">
        <h1 class="text-3xl font-black text-white uppercase italic tracking-tighter">Surat <span class="text-emerald-500">Perjanjian Ortu</span></h1>
        <p class="text-slate-500 text-[10px] font-bold uppercase tracking-[5px] mt-2 italic">
            Target Node: <?= $s ? $s['nama_siswa'] : 'Unknown' ?>
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 max-w-6xl mx-auto">
        
        <div class="bg-[#050a18]/60 border border-white/5 p-8 rounded-[2.5rem] shadow-2xl backdrop-blur-md">
            <h3 class="text-emerald-500 font-black uppercase italic text-sm mb-6 tracking-widest">Data Ayah</h3>
            <form action="proses_cetak_perjanjian.php" method="POST" class="space-y-4">
                <input type="hidden" name="nis" value="<?= $nis ?>">
                <input type="hidden" name="sebagai" value="Ayah">
                
                <div class="space-y-1">
                    <label class="text-[9px] font-black text-slate-500 uppercase ml-2 italic">Nama Ayah</label>
                    <input type="text" name="nama_ortu" value="<?= $s['ayah'] ?? '' ?>" class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-xs text-white outline-none focus:border-emerald-500 transition-all">
                </div>
                <div class="space-y-1">
                    <label class="text-[9px] font-black text-slate-500 uppercase ml-2 italic">Pekerjaan Ayah</label>
                    <input type="text" name="pekerjaan" value="<?= $s['pekerjaan_ayah'] ?? '' ?>" class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-xs text-white outline-none focus:border-emerald-500 transition-all">
                </div>
                <div class="space-y-1">
                    <label class="text-[9px] font-black text-slate-500 uppercase ml-2 italic">No. HP Ayah</label>
                    <input type="text" name="no_hp" value="<?= $s['no_telp_ayah'] ?? '' ?>" class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-xs text-white outline-none focus:border-emerald-500 transition-all">
                </div>
                <div class="space-y-1">
                    <label class="text-[9px] font-black text-slate-500 uppercase ml-2 italic">Alamat Ayah</label>
                    <textarea name="alamat" rows="3" class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-xs text-white outline-none focus:border-emerald-500 transition-all resize-none"><?= $s['alamat_ayah'] ?? '' ?></textarea>
                </div>
                <button type="submit" class="w-full mt-4 py-4 bg-emerald-600 hover:bg-emerald-500 text-white text-[10px] font-black uppercase tracking-[3px] rounded-2xl shadow-lg shadow-emerald-900/20">Cetak Surat (Ayah)</button>
            </form>
        </div>

        <div class="bg-[#050a18]/60 border border-white/5 p-8 rounded-[2.5rem] shadow-2xl backdrop-blur-md">
            <h3 class="text-rose-500 font-black uppercase italic text-sm mb-6 tracking-widest">Data Ibu</h3>
            <form action="proses_cetak_perjanjian.php" method="POST" class="space-y-4">
                <input type="hidden" name="nis" value="<?= $nis ?>">
                <input type="hidden" name="sebagai" value="Ibu">

                <div class="space-y-1">
                    <label class="text-[9px] font-black text-slate-500 uppercase ml-2 italic">Nama Ibu</label>
                    <input type="text" name="nama_ortu" value="<?= $s['ibu'] ?? '' ?>" class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-xs text-white outline-none focus:border-rose-500 transition-all">
                </div>
                <div class="space-y-1">
                    <label class="text-[9px] font-black text-slate-500 uppercase ml-2 italic">Pekerjaan Ibu</label>
                    <input type="text" name="pekerjaan" value="<?= $s['pekerjaan_ibu'] ?? '' ?>" class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-xs text-white outline-none focus:border-rose-500 transition-all">
                </div>
                <div class="space-y-1">
                    <label class="text-[9px] font-black text-slate-500 uppercase ml-2 italic">No. HP Ibu</label>
                    <input type="text" name="no_hp" value="<?= $s['no_telp_ibu'] ?? '' ?>" class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-xs text-white outline-none focus:border-rose-500 transition-all">
                </div>
                <div class="space-y-1">
                    <label class="text-[9px] font-black text-slate-500 uppercase ml-2 italic">Alamat Ibu</label>
                    <textarea name="alamat" rows="3" class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-xs text-white outline-none focus:border-rose-500 transition-all resize-none"><?= $s['alamat_ayah'] ?? '' ?></textarea>
                </div>
                <button type="submit" class="w-full mt-4 py-4 bg-rose-600 hover:bg-rose-500 text-white text-[10px] font-black uppercase tracking-[3px] rounded-2xl shadow-lg shadow-rose-900/20">Cetak Surat (Ibu)</button>
            </form>
        </div>
    </div>
</div>

<?php include "../includes/footer.php"; ?>