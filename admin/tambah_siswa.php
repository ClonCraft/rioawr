<?php
session_start();
include "../koneksi/koneksi.php";

// Proteksi halaman admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login/login.php");
    exit();
}

// Proses simpan data
if (isset($_POST['simpan'])) {
    $nis   = mysqli_real_escape_string($koneksi, $_POST['nis']);
    $nama  = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $kelas = mysqli_real_escape_string($koneksi, $_POST['kelas']);

    // total_poin default 0
    $query = "INSERT INTO siswa (nis, nama, kelas, total_poin)
              VALUES ('$nis', '$nama', '$kelas', 0)";

    if (mysqli_query($koneksi, $query)) {
        header("Location: data_siswa.php");
        exit();
    } else {
        $error = "Gagal menambahkan siswa. Pastikan NIS belum terdaftar.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Siswa</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .container {
            max-width: 500px;
            margin: 4rem auto;
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        h2 {
            text-align: center;
            color: #667eea;
            margin-bottom: 1.5rem;
        }
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 6px;
        }
        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 1rem;
            border-radius: 6px;
            border: 1px solid #ccc;
        }
        .btn {
            display: flex;
            justify-content: space-between;
            margin-top: 1rem;
        }
        button {
            background: #667eea;
            color: white;
            border: none;
            padding: 10px 18px;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
        }
        button:hover {
            background: #5a6fd8;
        }
        .batal {
            background: #aaa;
            text-decoration: none;
            color: white;
            padding: 10px 18px;
            border-radius: 8px;
            font-weight: bold;
        }
        .batal:hover {
            background: #888;
        }
        .error {
            background: #ffe0e0;
            color: #b00000;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 1rem;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Tambah Data Siswa</h2>

    <?php if (isset($error)): ?>
        <div class="error"><?= $error; ?></div>
    <?php endif; ?>

    <form method="post">
        <label>NIS</label>
        <input type="text" name="nis" required>

        <label>Nama Siswa</label>
        <input type="text" name="nama" required>

        <label>Kelas</label>
        <input type="text" name="kelas" required>

        <div class="btn">
            <button type="submit" name="simpan">Simpan</button>
            <a href="data_siswa.php" class="batal">Batal</a>
        </div>
    </form>
</div>

</body>
</html>
