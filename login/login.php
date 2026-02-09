<?php
session_start();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
            text-align: center;
        }
        .school-info {
            color: #fff;
            font-size: 20px;
            margin-bottom: 15px;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
        }
        .login-container {
            background: #fff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
            width: 100%;
            max-width: 450px;
            margin-top: 20px;
        }
        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            color: #333;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 15px;
        }
        button {
            width: 100%;
            padding: 12px;
            background: #667eea;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background: #5a6fd8;
        }
        .register-btn {
            margin-top: 10px;
            background-color: #50b0a2;
        }
        .register-btn:hover {
            background-color: #4e9f92;
        }
        .footer {
            margin-top: 20px;
            color: #fff;
            font-size: 14px;
            opacity: 0.8;
            font-weight: normal;
        }
    </style>
</head>
<body>

    <div class="school-info">
        Sekolah SMK TI Bali Global Denpasar
    </div>

    <div class="login-container">
        <h2>Login Sistem</h2>

        <form action="proses_login.php" method="POST">
            <label>Username</label>
            <input type="text" name="username" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <button type="submit">Login</button>
        </form>

        <!-- Register button -->
        <form action="register.php" method="GET">
            <button type="submit" class="register-btn">Register</button>
        </form>
    </div>

    <div class="footer">
        © 2026 SMK TI Bali Global Denpasar
    </div>

</body>
</html>
