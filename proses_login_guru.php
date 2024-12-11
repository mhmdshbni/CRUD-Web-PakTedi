<?php
session_start();

$host = "localhost";
$user = "root";
$password = "";
$database = "presensi_sahbanii";

// Buat koneksi ke database
$koneksi = mysqli_connect($host, $user, $password, $database);

// Periksa koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Cek apakah pengguna sudah login
if (isset($_SESSION['loginguru']) && !empty($_SESSION['loginguru'])) {
    header("Location: menampilkandataguru.php");
    exit();
}

$error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = trim(mysqli_real_escape_string($koneksi, $_POST['user']));
    $password = trim(mysqli_real_escape_string($koneksi, $_POST['password']));

    if (!empty($user) && !empty($password)) {
        // Query untuk mendapatkan data pengguna
        $sql = "SELECT * FROM userguru WHERE user = '$user'";
        $result = mysqli_query($koneksi, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);
            // Verifikasi password
            if (password_verify($password, $user_data['password'])) {
                $_SESSION['loginguru'] = $user_data['user'];
                header("Location: menampilkandataguru.php");
                exit();
            } else {
                $error = "Password salah.";
            }
        } else {
            $error = "Username tidak ditemukan.";
        }
    } else {
        $error = "Mohon isi semua data dengan benar.";
    }
}
?>

<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "presensi_sahbanii";

// Buat koneksi
$koneksi = mysqli_connect($host, $user, $password, $database);

//Cek koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$nip    = "";
$nama   = "";
$jabatan = "";
$no_telp = "";
$error  = "";
$sukses = "";

$search = "";
if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($koneksi, $_GET['search']);
}

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}

if ($op == 'delete') {
    $nip = $_GET['nip'];
    $sql1 = "DELETE FROM guru WHERE nip = '$nip'";
    $q1 = mysqli_query($koneksi, $sql1);
    if ($q1) {
        $sukses = "Berhasil menghapus data";
    } else {
        $error = "Gagal menghapus data!";
    }
}

if ($op == 'edit') {
    $nip = $_GET['nip'];
    $sql1 = "SELECT * FROM guru WHERE nip = '$nip'";
    $q1 = mysqli_query($koneksi, $sql1);
    $r2 = mysqli_fetch_array($q1);
    $nip   = $r2['nip'] ?? '';
    $nama  = $r2['nama'] ?? '';
    $jabatan = $r2['jabatan'] ?? '';
    $no_telp = $r2['no_telp'] ?? '';
}

if (isset($_POST['submit'])) {
    $nip    = mysqli_real_escape_string($koneksi, $_POST['nip']);
    $nama   = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $jabatan = mysqli_real_escape_string($koneksi, $_POST['jabatan']);
    $no_telp = mysqli_real_escape_string($koneksi, $_POST['no_telp']);

    if ($nip && $nama && $jabatan && $no_telp) {
        if ($op == 'edit') {
            $sql1 = "UPDATE guru SET nama = '$nama', jabatan = '$jabatan', no_telp = '$no_telp' WHERE nip = '$nip'";
            $q1 = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data berhasil diperbarui";
            } else {
                $error = "Data gagal diperbarui: " . mysqli_error($koneksi);
            }
        } else {
            $sql1 = "INSERT INTO guru (nip, nama, jabatan, no_telp) VALUES ('$nip', '$nama', '$jabatan', '$no_telp')";
            $q1 = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Berhasil memasukkan data baru";
            } else {
                $error = "Gagal memasukkan data: " . mysqli_error($koneksi);
            }
        }
    } else {
        $error = "Silakan masukkan semua data dengan benar";
    }
}

$sql1 = "SELECT * FROM guru";
if ($search) {
    $sql1 .= " WHERE nama LIKE '%$search%'";
}

$q1 = mysqli_query($koneksi, $sql1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kehadiran Guru</title>
    <link rel="icon" type="image/x-icon" href="assets/logo.png" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f9f9f9;
        }
        .navbar {
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
        }
        .card {
            border-radius: 15px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
        }
        .search-bar {
            position: absolute;
            top: 70px;
            right: 70px;
            width: 250px;
        }
        .search-bar .form-control {
            font-size: 14px;
        }
        .search-bar .btn {
            font-size: 14px;
        }
        .table {
            border-collapse: collapse;
            font-size: 16px;
        }
        .table thead th {
            background-color: #007bff;
            color: white;
        }
        .btn-primary {
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.15);
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn-success,
        .btn-danger {
            font-size: 14px;
            font-weight: 600;
            border-radius: 8px;
        }
        .btn-success:hover {
            background-color: #218838;
        }
        .btn-danger:hover {
            background-color: #dc3545;
        }
        .alert {
            margin-bottom: 20px;
        }
        h1.card-header {
            font-size: 1.5rem;
            text-transform: uppercase;
            font-weight: 700;
            background-color: #007bff;
            color: white;
            text-align: center;
            padding: 15px;
            border-radius: 15px 15px 0 0;
        }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="#">Data Guru</a>
            <a href="logout.php" class="btn btn-primary">Logout</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <div class="container my-5">
        <form method="GET" class="search-bar">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari..." value="<?= htmlspecialchars($search) ?>">
                <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i> Cari</button>
            </div>
        </form>
        
        <a href="tambahguru.php" class="btn btn-primary mb-3">
            <i class="bi bi-plus-lg"></i> Tambah Data Guru
        </a>

        <div class="card">
            <h1 class="card-header">Daftar Nama Guru SMKN 4 Paadalarang</h1>
            <div class="card-body">
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIP</th>
                            <th>Nama Guru</th>
                            <th>Jabatan</th>
                            <th>No.Telepon</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $urut = 1;
                        while ($row = mysqli_fetch_assoc($q1)):
                        ?>
                            <tr>
                                <td><?= $urut++ ?></td>
                                <td><?= $row['nip'] ?></td>
                                <td><?= $row['nama'] ?></td>
                                <td><?= $row['jabatan'] ?></td>
                                <td><?= $row['no_telp'] ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>