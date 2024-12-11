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
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Guru</title>
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
            right: 80px;
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
            <a class="navbar-brand" href="#">Data Guru</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="menampilkansiswa.php">Data Siswa</a></li>
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
        <a href="tambahguru.php" class="btn btn-success mb-3">
            <i class="bi bi-plus-lg"></i> Tambah Data guru</a>
        <div class="card">
            <h1 class="card-header">Daftar Data Nama Guru SMKN 4 Padalarang</h1>
            <div class="card-body">
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIP</th>
                            <th>Nama Guru</th>
                            <th>Jabatan</th>
                            <th>No.Telepon</th>
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
                                <td><?= $row['nip'] ?></td>
                                <td><?= $row['nama'] ?></td>
                                <td><?= $row['jabatan'] ?></td>
                                <td><?= $row['no_telp'] ?></td>
                                <td>
                                    <a href="menampilkanguru.php?op=delete&nip=<?= $row['nip'] ?>" class="btn btn-danger" onclick="return confirm('Yakin hapus data?')">
                                        <i class="bi bi-trash"></i>Delete
                                    </a>
                                    <a href="editguru.php?op=edit&nip=<?= $row['nip'] ?>" class="btn btn-success">
                                        <i class="bi bi-pencil"></i>Update
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