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

// Ambil data presensi
$sql = "SELECT * FROM upressiswakelas";
$result = mysqli_query($koneksi, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Print Data Presensi</title>
    <link rel="icon" type="image/png" href="assets/logo.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        @media print {
            .no-print {
                display: none;
            }
        }
        body {
            font-family: Arial, sans-serif;
        }
        .table th, .table td {
            text-align: center;
            vertical-align: middle;
        }
    </style>
</head>
<body>
    <div class="container my-4">
        <div class="text-center mb-4">
            <h2>Data Presensi Siswa</h2>
            <p>Dicetak pada: <?= date('d-m-Y H:i:s') ?></p>
        </div>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NISN</th>
                    <th>Nama Siswa</th>
                    <th>Kelas</th>
                    <th>Waktu</th>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                while ($row = mysqli_fetch_assoc($result)):
                ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $row['nisn'] ?></td>
                        <td><?= $row['nama'] ?></td>
                        <td><?= $row['kelas'] ?></td>
                        <td><?= $row['waktu'] ?></td>
                        <td><?= $row['tanggal'] ?></td>
                        <td><?= $row['status_kehadiran'] ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <div class="text-center mt-4 no-print">
            <button onclick="window.print()" class="btn btn-primary">Cetak Halaman</button>
            <a href="menampilkandata.php" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</body>
</html>
