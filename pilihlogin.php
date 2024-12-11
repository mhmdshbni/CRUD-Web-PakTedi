<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Pilih Login</title>
    <link rel="icon" type="image/png" href="assets/logo.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-image: url('./assets/smkn4.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            color: white;
        }

        h1 {
            color: white;
            font-weight: 700;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7);
        }

        .container {
            text-align: center;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background-color: rgba(255, 255, 255, 0.8);
            margin: 15px;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0px 15px 50px rgba(0, 0, 0, 0.3);
        }

        .card h4 {
            font-size: 24px;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .btn {
            width: 100%;
            font-size: 16px;
            padding: 12px;
            border-radius: 25px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background-color: #3498db;
            border-color: #3498db;
        }

        .btn-primary:hover {
            background-color: #2980b9;
            border-color: #2980b9;
        }

        .btn-success {
            background-color: #2ecc71;
            border-color: #2ecc71;
        }

        .btn-success:hover {
            background-color: #27ae60;
            border-color: #27ae60;
        }

        .row {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .col-md-4 {
            margin: 15px;
        }
    </style>
</head>
<body>
    <div class="container text-center">
        <h1 class="mb-5">Pilih Login Sebagai</h1>
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card p-4">
                    <h4>Siswa</h4>
                    <a href="login.php" class="btn btn-primary mt-3">Login Siswa</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-4">
                    <h4>Guru</h4>
                    <a href="loginguru.php" class="btn btn-primary mt-3">Login Guru</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-4">
                    <h4>Admin</h4>
                    <a href="loginadmin.php" class="btn btn-success mt-3">Login Admin</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>