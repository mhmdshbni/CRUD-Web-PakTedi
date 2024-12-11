<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "presensi_sahbanii"; // Ganti dengan nama database Anda

// Buat koneksi
$koneksi = mysqli_connect($host, $user, $password, $database);

// Cek koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$nama             = "";
$nisn             = "";
$kelas            = "";
$jurusan          = "";
$alamat           = "";
$error            = "";
$sukses           = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}

if ($op == 'edit') {
    $nama = $_GET['nama'];
    $sql1 = "SELECT * FROM siswa WHERE nama = '$nama'";
    $q1 = mysqli_query($koneksi, $sql1);
    $r2 = mysqli_fetch_array($q1);
    $nama = $r2['nama'] ?? '';
    $nisn = $r2['nisn'] ?? '';
    $kelas = $r2['kelas'] ?? '';
    $jurusan = $r2['jurusan'] ?? '';
    $alamat = $r2['alamat'] ?? '';

    if ($nama == '') {
        $error = "Data tidak ditemukan";
    }
}

if (isset($_POST['update'])) { // Untuk edit data
    $nama_baru = $_POST['nama']; // Nama yang baru
    $nisn      = $_POST['nisn'];
    $kelas     = $_POST['kelas'];
    $jurusan   = $_POST['jurusan'];
    $alamat    = $_POST['alamat'];

    if ($nama_baru && $nisn && $kelas && $jurusan && $alamat) {
        if ($op == 'edit') { // Edit data
            $sql1 = "UPDATE siswa SET 
                        nama = '$nama_baru', 
                        nisn = '$nisn', 
                        kelas = '$kelas', 
                        jurusan = '$jurusan', 
                        alamat = '$alamat' 
                     WHERE nama = '$nama'";
            $q1 = mysqli_query($koneksi, $sql1);
            if ($q1) {
                // Redirect ke halaman menampilkansiswa.php
                header("Location: menampilkansiswa.php");
                exit;
            } else {
                $error = "Data gagal diperbarui: " . mysqli_error($koneksi);
            }
        }
    } else {
        $error = "Silahkan masukkan data yang lengkap";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Siswa</title>
    <link rel="icon" type="image/x-icon" href="assets/logo.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<style>
.card-header {
    background-color: #007bff;
    color: #fff;
    font-weight: 600;
    text-align: center;
    border-top-left-radius: 12px;
    border-top-right-radius: 12px;
}
</style>
<div class="container mt-5">
    <a class="btn btn-outline-primary mb-3" href="menampilkansiswa.php">← Kembali</a>
    <div class="card shadow">
        <h5 class="card-header text-center">Form Edit Data Siswa</h5>
        <div class="card-body">
            <form action="?op=edit&nama=<?= $nama ?>" method="POST">
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Siswa</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="<?= $nama ?>" placeholder="Masukkan nama siswa">
                </div>
                <div class="mb-3">
                    <label for="nisn" class="form-label">NISN</label>
                    <input type="text" class="form-control" id="nisn" name="nisn" value="<?= $nisn ?>" placeholder="Masukkan NISN">
                </div>
                <div class="mb-3">
                    <label for="kelas" class="form-label">Kelas</label>
                    <select class="form-select" name="kelas" id="kelas">
                        <option value="">- Pilih Kelas -</option>
                        <option value="X" <?= ($kelas == "X") ? "selected" : "" ?>>X</option>
                        <option value="XI" <?= ($kelas == "XI") ? "selected" : "" ?>>XI</option>
                        <option value="XII" <?= ($kelas == "XII") ? "selected" : "" ?>>XII</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="jurusan" class="form-label">Jurusan</label>
                    <input type="text" class="form-control" id="jurusan" name="jurusan" value="<?= $jurusan ?>" placeholder="Masukkan jurusan">
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea class="form-control" id="alamat" name="alamat" rows="3" placeholder="Masukkan alamat"><?= $alamat ?></textarea>
                </div>
                <div class="text-center">
                    <button type="submit" name="update" class="btn btn-success">Update Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>