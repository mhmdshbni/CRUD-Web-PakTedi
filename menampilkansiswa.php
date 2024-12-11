<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "presensi_sahbanii";

// Buat koneksi
$koneksi = mysqli_connect($host, $user, $password, $database);

// Cek koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$nama   = "";
$nisn   = "";
$kelas  = "";
$jurusan = "";
$alamat = "";
$error  = "";
$sukses = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}

if ($op == 'delete') {
    $nama = $_GET['nama'];
    $sql1 = "DELETE FROM siswa WHERE nama = '$nama'";
    $q1 = mysqli_query($koneksi, $sql1);
    if ($q1) {
        $sukses = "Berhasil menghapus data";
    } else {
        $error = "Gagal menghapus data!";
    }
}

if ($op == 'edit') {
    $nama = $_GET['nama'];
    $sql1 = "SELECT * FROM siswa WHERE nama = '$nama'";
    $q1 = mysqli_query($koneksi, $sql1);
    $r2 = mysqli_fetch_array($q1);
    $nisn   = $r2['nisn'] ?? '';
    $kelas  = $r2['kelas'] ?? '';
    $jurusan = $r2['jurusan'] ?? '';
    $alamat = $r2['alamat'] ?? '';
}

if (isset($_POST['submit'])) {
    $nama    = $_POST['nama'];
    $nisn    = $_POST['nisn'];
    $kelas   = $_POST['kelas'];
    $jurusan = $_POST['jurusan'];
    $alamat  = $_POST['alamat'];

    if ($nama && $nisn && $kelas && $jurusan && $alamat) {
        $sql_check = "SELECT * FROM siswa WHERE nama = '$nama'";
        $result_check = mysqli_query($koneksi, $sql_check);

        if (mysqli_num_rows($result_check) > 0) {
            $sql_update = "UPDATE siswa SET nisn = '$nisn', kelas = '$kelas', jurusan = '$jurusan', alamat = '$alamat' WHERE nama = '$nama'";
            $result_update = mysqli_query($koneksi, $sql_update);
            if ($result_update) {
                $sukses = "Data berhasil diperbarui";
            } else {
                $error = "Data gagal diperbarui: " . mysqli_error($koneksi);
            }
        } else {
            $sql_insert = "INSERT INTO siswa (nama, nisn, kelas, jurusan, alamat) 
                           VALUES ('$nama', '$nisn', '$kelas', '$jurusan', '$alamat')";
            $result_insert = mysqli_query($koneksi, $sql_insert);
            if ($result_insert) {
                $sukses = "Data berhasil ditambahkan";
            } else {
                $error = "Data gagal ditambahkan: " . mysqli_error($koneksi);
            }
        }
    } else {
        $error = "Silakan masukkan semua data dengan benar";
    }
}

$search = isset($_GET['search']) ? $_GET['search'] : '';

$sql1 = "SELECT * FROM siswa";
if ($search) {
    $sql1 .= " WHERE nama LIKE '%$search%' OR nisn LIKE '%$search%'";
}
$q1 = mysqli_query($koneksi, $sql1);

if (!$q1) {
    die("Query error: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Siswa</title>
    <link rel="icon" type="image/x-icon" href="assets/logo.png" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f4f7fc;
        }

        .navbar {
            box-shadow: 0px 2px 15px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: 700;
            color: #0056b3;
        }

        .navbar-nav .nav-link {
            color: #555;
            font-size: 1.1rem;
        }

        .navbar-nav .nav-link:hover {
            color: #007bff;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
        }

        .search-bar {
            position: absolute;
            top: 145px;
            right: 70px;
            width: 300px;
        }

        .search-bar .form-control {
            font-size: 16px;
        }

        .print-btn {
            margin-left: 5px;
            margin-top: 20px;
        }

        .print-btn .btn {
            font-size: 14px;
            font-weight: 600;
            border-radius: 8px;
            padding: 10px 20px;
            transition: background-color 0.3s ease;
        }

        .print-btn .btn:hover {
            background-color: #0056b3;
            color: white;
        }

        .table thead {
            background-color: #007bff;
            color: white;
        }

        .table-striped tbody tr:nth-child(odd) {
            background-color: #f9f9f9;
        }

        .table-bordered th, .table-bordered td {
            border: 1px solid #ddd;
        }

        .btn-primary, .btn-danger, .btn-success {
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-danger:hover {
            background-color: #dc3545;
        }

        .btn-success:hover {
            background-color: #218838;
        }

        .alert {
            margin-bottom: 20px;
        }

        h1.card-header {
            font-size: 1.6rem;
            font-weight: 700;
            background-color: #007bff;
            color: white;
            text-align: center;
            padding: 15px;
            border-radius: 10px 10px 0 0;
        }

        .card-header a {
            text-decoration: none;
            color: #fff;
        }

        .btn-back {
            margin-top: 20px;
            background-color: #28a745;
            color: white;
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
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container">
            <a class="navbar-brand" href="#">Data Siswa</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="menampilkanguru.php">Data Guru</a></li>
                    <li class="nav-item"><a class="nav-link" href="menampilkandata.php">Presensi</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-4">
        <form method="GET" class="search-bar">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari..." value="<?= htmlspecialchars($search) ?>">
                <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i> Cari</button>
            </div>
        </form>
    </div>

    <div class="container">
        <div class="print-btn">
            <a href="#" class="btn btn-secondary" onclick="printData()">
                <i class="bi bi-printer"></i> Print
            </a>
        </div>
    </div>

    <div class="container my-4">
        <a href="tambahsiswa.php" class="btn btn-success mb-3">
            <i class="bi bi-plus-lg"></i> Tambah Data Siswa</a>
        <div class="card">
            <h1 class="card-header">Daftar Data Siswa XI PPLG B</h1>
            <div class="card-body">
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>NISN</th>
                            <th>Kelas</th>
                            <th>Jurusan</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $urut = 1;
                        while ($row = mysqli_fetch_assoc($q1)):
                        ?>
                            <tr>
                                <td><?= $urut++ ?></td>
                                <td><?= $row['nama'] ?></td>
                                <td><?= $row['nisn'] ?></td>
                                <td><?= $row['kelas'] ?></td>
                                <td><?= $row['jurusan'] ?></td>
                                <td><?= $row['alamat'] ?></td>
                                <td>
                                    <a href="menampilkansiswa.php?op=delete&nama=<?= $row['nama'] ?>" class="btn btn-danger" onclick="return confirm('Yakin hapus data?')">
                                        <i class="bi bi-trash"></i> Hapus
                                    </a>
                                    <a href="editsiswa.php?op=edit&nama=<?= $row['nama'] ?>" class="btn btn-success">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function printData() {
            var divToPrint = document.querySelector(".card");
            var newWin = window.open("", "_blank", "width=800,height=600");
            newWin.document.write('<html><head><title>Print</title>');
            newWin.document.write('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">');
            newWin.document.write('</head><body>');
            newWin.document.write(divToPrint.outerHTML);
            newWin.document.write('</body></html>');
            newWin.document.close();
            newWin.focus();
            newWin.print();
            newWin.close();
        }
    </script>
</body>
</html>