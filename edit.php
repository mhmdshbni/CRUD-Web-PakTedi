<?php
// Aktifkan error reporting untuk debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Koneksi ke database
$host = "localhost";
$user = "root";
$password = "";
$database = "presensi_sahbanii";
$koneksi = mysqli_connect($host, $user, $password, $database);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$status_kehadiran = "";
$waktu            = "";
$tanggal          = "";
$kelas            = "";
$nisn             = "";
$error            = "";
$sukses           = "";

// Validasi parameter ID
if (!isset($_GET['id']) || empty($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Parameter ID tidak valid!");
}

$id = $_GET['id'];

// Operasi EDIT: Menampilkan data ke form
if (isset($_GET['op']) && $_GET['op'] == 'edit') {
    $sql1 = "SELECT * FROM presensi WHERE id = '$id'";
    $q1 = mysqli_query($koneksi, $sql1);
    if ($q1 && mysqli_num_rows($q1) > 0) {
        $r2 = mysqli_fetch_array($q1);
        $status_kehadiran = $r2['status_kehadiran'] ?? '';
        $waktu = $r2['waktu'] ?? '';
        $tanggal = $r2['tanggal'] ?? '';
        $kelas = $r2['kelas'] ?? '';
        $nisn = $r2['nisn'] ?? '';
    } else {
        $error = "Data tidak ditemukan!";
    }
}

// Operasi TAMBAH/EDIT: Memproses form submit
if (isset($_POST['submit'])) {
    $status_kehadiran = $_POST['status_kehadiran'];
    $waktu            = $_POST['waktu'];
    $tanggal          = $_POST['tanggal'];
    $kelas            = $_POST['kelas'];
    $nisn             = $_POST['nisn'];

    if ($status_kehadiran && $waktu && $tanggal && $kelas && $nisn) {
        // Update data
        $sql1 = "UPDATE presensi SET 
                    status_kehadiran = '$status_kehadiran', 
                    waktu = '$waktu', 
                    tanggal = '$tanggal', 
                    kelas = '$kelas', 
                    nisn = '$nisn' 
                 WHERE id = '$id'";
        $q1 = mysqli_query($koneksi, $sql1);
        if ($q1) {
            $sukses = "Data berhasil diperbarui";
            header("Location: menampilkandata.php?sukses=" . urlencode($sukses));
            exit;
        } else {
            $error = "Data gagal diperbarui: " . mysqli_error($koneksi) . " | Query: $sql1";
        }
    } else {
        $error = "Silakan isi semua data!";
    }
}

// Ambil data dari tabel siswa untuk dropdown NISN
$sql = "SELECT nisn, nama FROM siswa";
$result = mysqli_query($koneksi, $sql);

// Siapkan opsi dropdown
$nisn_options = "";
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $selected = ($nisn == $row['nisn']) ? "selected" : "";
        $nisn_options .= "<option value='{$row['nisn']}' $selected>{$row['nisn']} - {$row['nama']}</option>";
    }
} else {
    $nisn_options = "<option value=''>Tidak ada data siswa</option>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Presensi</title>
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
    <a class="btn btn-outline-primary mb-3" href="menampilkandata.php">← Kembali</a>
    <div class="card shadow">
        <h5 class="card-header text-center">Form Edit Data Presensi</h5>
        <div class="card-body">
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="status_kehadiran" class="form-label">Status Kehadiran</label>
                    <input type="text" class="form-control" id="status_kehadiran" name="status_kehadiran" value="<?= htmlspecialchars($status_kehadiran) ?>" placeholder="Masukkan status kehadiran">
                </div>
                <div class="mb-3">
                    <label for="waktu" class="form-label">Waktu</label>
                    <input type="time" class="form-control" id="waktu" name="waktu" value="<?= htmlspecialchars($waktu) ?>">
                </div>
                <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?= htmlspecialchars($tanggal) ?>">
                </div>
                <div class="mb-3">
                    <label for="kelas" class="form-label">Kelas</label>
                    <select class="form-select" id="kelas" name="kelas">
                        <option value="">- Pilih Kelas -</option>
                        <option value="X" <?= ($kelas == "X") ? "selected" : "" ?>>X</option>
                        <option value="XI" <?= ($kelas == "XI") ? "selected" : "" ?>>XI</option>
                        <option value="XII" <?= ($kelas == "XII") ? "selected" : "" ?>>XII</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="nisn" class="form-label">NISN</label>
                    <select class="form-select" id="nisn" name="nisn">
                        <option value="">- Pilih NISN -</option>
                        <?= $nisn_options ?>
                    </select>
                </div>
                <div class="text-center">
                    <button type="submit" name="submit" class="btn btn-success">Update Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>