<?php
session_start();
include "../config/config.php";

if (isset($_POST['upload'])) {
    $id = $_POST['id'];
    $nama_file = $_FILES['foto']['name'];
    $ukuran_file = $_FILES['foto']['size'];
    $error = $_FILES['foto']['error'];
    $tmp_name = $_FILES['foto']['tmp_name'];

    // 1. Cek apakah ada file yang diupload
    if ($error === 4) {
        echo "<script>alert('Pilih gambar terlebih dahulu!'); window.history.back();</script>";
        exit;
    }

    // 2. Cek ekstensi file (hanya jpg, jpeg, png)
    $ekstensiValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $nama_file);
    $ekstensiGambar = strtolower(end($ekstensiGambar));

    if (!in_array($ekstensiGambar, $ekstensiValid)) {
        echo "<script>alert('Bukan gambar! Harap upload file JPG/PNG.'); window.history.back();</script>";
        exit;
    }

    // 3. Cek ukuran (max 2MB)
    if ($ukuran_file > 2000000) {
        echo "<script>alert('Ukuran gambar terlalu besar! Max 2MB.'); window.history.back();</script>";
        exit;
    }

    // 4. Generate Nama File Baru (Biar unik)
    $namaFileBaru = "PERJANJIAN_" . uniqid() . "." . $ekstensiGambar;

    // 5. Tentukan Folder Penyimpanan
    $target_dir = "../uploads/perjanjian/";
    
    // Buat folder jika belum ada
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // 6. Proses Pindah File & Update Database
    if (move_uploaded_file($tmp_name, $target_dir . $namaFileBaru)) {
        
        // Update status jadi 'Selesai' dan simpan nama filenya
        $query = "UPDATE perjanjian_siswa SET 
                  foto_dokumen = '$namaFileBaru', 
                  status = 'Selesai' 
                  WHERE id_perjanjian_siswa = '$id'";
        
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Gambar Berhasil Diupload!'); window.location='laporan_perjanjian.php';</script>";
        } else {
            echo "<script>alert('Gagal update database!'); window.history.back();</script>";
        }

    } else {
        echo "<script>alert('Gagal memindahkan file ke folder!'); window.history.back();</script>";
    }
}