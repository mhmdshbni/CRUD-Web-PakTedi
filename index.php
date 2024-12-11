<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: pilihlogin.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard</title>
    <link rel="icon" type="image/png" href="assets/logo.png" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f4f6f9;
        }

        .navbar {
            background-color: #007bff;
            transition: background-color 0.3s ease;
        }
        .navbar:hover {
            background-color: #0056b3;
        }

        .navbar-brand span {
            font-size: 1.8rem;
            font-weight: bold;
            color: white;
        }

        .section-header {
            font-size: 2.5rem;
            font-weight: 700;
            color: #007bff;
            margin-bottom: 30px;
            text-transform: uppercase;
            animation: fadeIn 1s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .card {
            border-radius: 15px;
            transition: transform 0.3s, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            background-color: #ffffff;
            border-radius: 15px;
        }

        .icon {
            font-size: 3rem;
            margin-bottom: 20px;
            transition: color 0.3s ease;
        }

        .icon:hover {
            color: #0056b3;
        }

        .footer {
            background-color: #007bff;
            color: white;
            padding: 20px 0;
            box-shadow: 0 -5px 15px rgba(0, 0, 0, 0.1);
        }
        .footer a {
            color: white;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        .footer a:hover {
            color: #ffc107;
        }

        .btn {
            border-radius: 25px;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .btn:hover {
            transform: scale(1.05);
            background-color: #0056b3;
        }

        .btn-primary { background-color: #007bff; }
        .btn-success { background-color: #28a745; }
        .btn-warning { background-color: #ffc107; }

        .container {
            max-width: 1200px;
        }

        @media (max-width: 768px) {
            .navbar-brand span {
                font-size: 1.5rem;
            }
            .footer {
                font-size: 0.875rem;
            }
        }
    </style>
</head>
<body class="d-flex flex-column h-100">
<main class="d-flex flex-column">
    <nav class="navbar navbar-expand-lg navbar-dark py-3 shadow">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand" href="index.html">
                <span>SELAMAT DATANG DI LMS BANZ</span>
            </a>
            <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
        </div>
    </nav>

    <section class="py-5 flex-grow-1">
        <div class="container">
            <h2 class="section-header text-center mb-5">Dashboard</h2>
            <div class="row justify-content-center">

                <div class="col-md-4 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center">
                            <div class="icon mb-3">
                                <i class="bi bi-people-fill text-primary"></i>
                            </div>
                            <h4 class="card-title mb-3">Data Siswa</h4>
                            <p class="card-text lead">Lihat data siswa yang terdaftar.</p>
                            <a href="menampilkansiswa.php" class="btn btn-primary">Lihat Data</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center">
                            <div class="icon mb-3">
                                <i class="bi bi-person-badge-fill text-success"></i>
                            </div>
                            <h4 class="card-title mb-3">Data Guru</h4>
                            <p class="card-text lead">Lihat data guru yang terdaftar.</p>
                            <a href="menampilkanguru.php" class="btn btn-success">Lihat Data</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center">
                            <div class="icon mb-3">
                                <i class="bi bi-clipboard-data-fill text-warning"></i>
                            </div>
                            <h4 class="card-title mb-3">Data Presensi</h4>
                            <p class="card-text lead">Lihat data presensi siswa dan guru.</p>
                            <a href="menampilkandata.php" class="btn btn-warning">Lihat Data</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<footer class="footer py-4">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-md-6 text-center text-md-start small">
                Copyright &copy; Muhamad Sahbani 2024
            </div>
            <div class="col-md-6 text-center text-md-end small">
                <a href="#">Privacy</a>
                <span class="mx-2">&middot;</span>
                <a href="#">Terms</a>
                <span class="mx-2">&middot;</span>
                <a href="#">Contact</a>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
