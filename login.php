<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Siswa</title>
    <link rel="icon" type="image/png" href="assets/logo.png" />
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }

        .back-button {
            position: absolute;
            top: 20px;
            left: 20px;
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
            display: inline-block;
        }

        .back-button:hover {
            background-color: #0056b3;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.9);
            padding: 20px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 100%;
            max-width: 400px;
        }

        .login-container h1 {
            margin-bottom: 20px;
            color: #333;
        }

        .login-container label {
            display: block;
            margin-bottom: 5px;
            color: #666;
            text-align: left;
        }

        .login-container input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .login-container button {
            background-color: #007bff; 
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }

        .login-container button:hover {
            background-color: #0056b3;
        }

        .login-container a {
            color: #007bff;
            text-decoration: none;
            font-size: 14px;
        }

        .login-container a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <a class="back-button" href="pilihlogin.php">← Kembali</a>
    <div class="login-container">
        <h1>Login Siswa</h1>
        <form action="proses_login_siswa.php" method="POST">
            <label for="username">Username atau Email :</label>
            <input type="text" id="username" name="username" placeholder="Masukkan username atau email anda" required>
            
            <label for="password">Password :</label>
            <input type="password" id="password" name="password" placeholder="Masukkan password" required>
            
            <button type="submit">Login</button>
        </form>
        <p><a href="/lupa-password">Lupa Password?</a></p>
    </div>
</body>
</html>