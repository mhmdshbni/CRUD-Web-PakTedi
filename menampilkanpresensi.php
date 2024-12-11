<?php
session_start();

// Cek apakah siswa sudah login
if (!isset($_SESSION['usersiswa'])) {
    // Jika belum login, arahkan ke halaman login
    header("Location: login.php");
    exit;
}

// Koneksi ke database presensi
$host = "localhost";
$user = "root";
$password = "";
$database = "presensi_sahbanii"; // Database presensi

$koneksi = mysqli_connect($host, $user, $password, $database);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$error = "";

if (isset($_POST['submit'])) {
    $username = trim($_POST['user']);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {
        $sql = "SELECT * FROM usersiswa WHERE user = ?";
        $stmt = mysqli_prepare($koneksi, $sql);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user_data = mysqli_fetch_assoc($result);

        if ($user_data && password_verify($password, $user_data['password'])) {
            // Set session dan arahkan ke halaman menampilkanpresensi.php
            $_SESSION['usersiswa'] = $user_data['user'];
            header("Location: menampilkanpresensi.php");
            exit();
        } else {
            $error = "Username atau password salah!";
        }
        mysqli_stmt_close($stmt);
    } else {
        $error = "Silakan masukkan username dan password!";
    }
}

// Ambil parameter sukses jika ada
$sukses = isset($_GET['sukses']) ? $_GET['sukses'] : "";

// Operasi DELETE
if (isset($_GET['op']) && $_GET['op'] == 'delete') {
    $id = $_GET['id'];
    $sql1 = "DELETE FROM presensi WHERE id = '$id'";
    $q1 = mysqli_query($koneksi, $sql1);
    if ($q1) {
        $sukses = "Berhasil menghapus data";
    } else {
        $error = "Gagal menghapus data: " . mysqli_error($koneksi);
    }
}

// Operasi EDIT: Menampilkan data ke form
if (isset($_GET['op']) && $_GET['op'] == 'edit') {
    $id = $_GET['id'];
    $sql1 = "SELECT * FROM presensi WHERE id = '$id'";
    $q1 = mysqli_query($koneksi, $sql1);
    $r2 = mysqli_fetch_array($q1);
    $status_kehadiran = $r2['status_kehadiran'] ?? '';
    $waktu = $r2['waktu'] ?? '';
    $tanggal = $r2['tanggal'] ?? '';
    $kelas = $r2['kelas'] ?? '';
    $nisn = $r2['nisn'] ?? '';
}

// Operasi TAMBAH/EDIT: Memproses form submit
if (isset($_POST['submit'])) {
    $status_kehadiran = $_POST['status_kehadiran'];
    $waktu            = $_POST['waktu'];
    $tanggal          = $_POST['tanggal'];
    $kelas            = $_POST['kelas'];
    $nisn             = $_POST['nisn'];

    if ($status_kehadiran && $waktu && $tanggal && $kelas && $nisn) {
        if (isset($_GET['op']) && $_GET['op'] == 'edit') {
            // Update data
            $id = $_GET['id'];
            $sql1 = "UPDATE presensi SET status_kehadiran = '$status_kehadiran', waktu = '$waktu', tanggal = '$tanggal', kelas = '$kelas', nisn = '$nisn' WHERE id = '$id'";
            $q1 = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data berhasil diperbarui";
            } else {
                $error = "Data gagal diperbarui: " . mysqli_error($koneksi);
            }
        } else {
            // Tambah data baru
            $sql1 = "INSERT INTO presensi (status_kehadiran, waktu, tanggal, kelas, nisn) 
                     VALUES ('$status_kehadiran', '$waktu', '$tanggal', '$kelas', '$nisn')";
            $q1 = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Berhasil memasukkan data baru";
            } else {
                $error = "Gagal memasukkan data: " . mysqli_error($koneksi);
            }
        }
    } else {
        $error = "Silakan masukkan data dengan benar";
    }
}

$search = "";
if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($koneksi, $_GET['search']);
}

// Modifikasi query untuk pencarian
$sql1 = "SELECT * FROM upressiswakelas WHERE nama LIKE '%$search%' OR nisn LIKE '%$search%' OR kelas LIKE '%$search%'";

$q1 = mysqli_query($koneksi, $sql1);
$urut = 1;

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kehadiran</title>
    <link rel="icon" type="image/x-icon" href="assets/logo.png" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: #1e40af;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            color: white;
            font-weight: bold;
            font-size: 1.6rem;
        }

        .navbar-brand:hover {
            color: #f39c12;
        }

        .navbar-toggler-icon {
            background-color: #ffffff;
        }

        .search-bar {
            position: absolute;
            top: 70px;
            right: 20px;
            width: 250px;
        }

        .search-bar .form-control {
            font-size: 14px;
            border-radius: 25px;
        }

        .search-bar .btn {
            font-size: 14px;
            border-radius: 25px;
            background-color: #007bff;
            color: white;
            border: none;
        }

        .search-bar .btn:hover {
            background-color: #0056b3;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            background-color: white;
        }

        h1.card-header {
            font-size: 1.6rem;
            text-transform: uppercase;
            font-weight: bold;
            background-color: #007bff;
            color: white;
            padding: 15px;
            text-align: center;
        }

        .table {
            border-collapse: collapse;
            font-size: 16px;
            width: 100%;
        }

        .table thead th {
            background-color: #007bff;
            color: white;
            padding: 10px;
        }

        .table tbody tr {
            transition: background-color 0.3s;
        }

        .table tbody tr:hover {
            background-color: #f1f1f1;
        }

        .btn-primary {
            border-radius: 10px;
            font-weight: bold;
            background-color: #007bff;
            color: white;
            border: none;
            padding: 8px 16px;
            transition: background-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-success, .btn-danger {
            border-radius: 10px;
            font-weight: bold;
            padding: 8px 16px;
            transition: background-color 0.3s;
        }

        .btn-success:hover {
            background-color: #28a745;
        }

        .btn-danger:hover {
            background-color: #dc3545;
        }

        .alert {
            margin-top: 20px;
        }

        .container {
            margin-top: 20px;
        }

        .mb-3 {
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="#">Kehadiran</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="btn btn-outline-light mb-3" href="pilihlogin.php">Log Out</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
    <form method="GET" class="search-bar">
    <div class="input-group">
        <input type="text" name="search" class="form-control" placeholder="Cari..." value="<?= htmlspecialchars($search) ?>">
        <button class="btn" type="submit"><i class="bi bi-search"></i> Cari</button>
    </div>
    </form>

        <a href="tambah_hadir.php" class="btn btn-primary mb-3">
            <i class="bi bi-plus-lg"></i> Tambah Kehadiran
        </a>

        <div class="card">
            <h1 class="card-header">Daftar Data Presensi XI PPLG B</h1>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Status Kehadiran</th>
                            <th>Waktu</th>
                            <th>Tanggal</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>NISN</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql1 = "SELECT * FROM upressiswakelas";
                        $q1 = mysqli_query($koneksi, $sql1);
                        $urut = 1;
                        while ($row = mysqli_fetch_assoc($q1)):
                        ?>
                            <tr>
                                <td><?= $urut++ ?></td>
                                <td><?= $row['status_kehadiran'] ?></td>
                                <td><?= $row['waktu'] ?></td>
                                <td><?= $row['tanggal'] ?></td>
                                <td><?= $row['nama'] ?></td>
                                <td><?= $row['kelas'] ?></td>
                                <td><?= $row['nisn'] ?></td>
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
