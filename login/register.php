<?php
session_start();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        .register-container {
            background: #fff;
            padding: 40px;
            border-radius: 15px;
            width: 420px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        h2 { text-align: center; margin-bottom: 20px; }
        label { font-weight: bold; }
        input, select {
            width: 100%;
            padding: 12px;
            margin: 8px 0 18px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            width: 100%;
            padding: 12px;
            background: #667eea;
            border: none;
            color: white;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover { background: #5a6fd8; }
    </style>
</head>
<body>

<div class="register-container">
    <h2>Register Akun Siswa</h2>

    <form action="proses_register.php" method="POST">
        <label>Username</label>
        <input type="text" name="username" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <label>Kelas</label>
        <select name="kelas" required>
            <option value="">-- Pilih Kelas --</option>

            <!-- RPL 1–5 -->
            <?php
            foreach (['X','XI','XII'] as $tingkat) {
                for ($i = 1; $i <= 5; $i++) {
                    echo "<option value='$tingkat RPL $i'>$tingkat RPL $i</option>";
                }
            }
            ?>

            <!-- TKJ 1 -->
            <?php
            foreach (['X','XI','XII'] as $tingkat) {
                echo "<option value='$tingkat TKJ 1'>$tingkat TKJ 1</option>";
            }
            ?>

            <!-- DKV 1–4 -->
            <?php
            foreach (['X','XI','XII'] as $tingkat) {
                for ($i = 1; $i <= 4; $i++) {
                    echo "<option value='$tingkat DKV $i'>$tingkat DKV $i</option>";
                }
            }
            ?>

            <!-- ANIMASI 1 -->
            <?php
            foreach (['X','XI','XII'] as $tingkat) {
                echo "<option value='$tingkat ANIMASI 1'>$tingkat ANIMASI 1</option>";
            }
            ?>
        </select>

        <button type="submit">Register</button>
    </form>
</div>

</body>
</html>
