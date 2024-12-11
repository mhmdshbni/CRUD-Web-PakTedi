<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "presensi_sahbanii";

$koneksi = mysqli_connect($host, $user, $password, $database);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$nip = "";
$nama = "";
$jabatan = "";
$no_telp = "";
$error = "";
$sukses = "";
$nip_lama = "";

if (isset($_GET['op']) && $_GET['op'] === 'edit') {
    $nip = $_GET['nip'] ?? '';
    $nip = mysqli_real_escape_string($koneksi, $nip);

    if ($nip !== '') {
        $sql1 = "SELECT * FROM guru WHERE nip = '$nip'";
        $q1 = mysqli_query($koneksi, $sql1);

        if ($q1 && mysqli_num_rows($q1) > 0) {
            $r1 = mysqli_fetch_assoc($q1);
            $nip = $r1['nip'] ?? "";
            $nip_lama = $nip; 
            $nama = $r1['nama'] ?? "";
            $jabatan = $r1['jabatan'] ?? "";
            $no_telp = $r1['no_telp'] ?? "";
        } else {
            $error = "Data tidak ditemukan!";
        }
    } else {
        $error = "NIP tidak valid!";
    }
}

if (isset($_POST['submit'])) {
    $nip_baru = mysqli_real_escape_string($koneksi, $_POST['nip']);
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $jabatan = mysqli_real_escape_string($koneksi, $_POST['jabatan']);
    $no_telp = mysqli_real_escape_string($koneksi, $_POST['no_telp']);

    if ($nip_baru && $nama && $jabatan && $no_telp) {
        $sql1 = "UPDATE guru SET nip = '$nip_baru', nama = '$nama', jabatan = '$jabatan', no_telp = '$no_telp' WHERE nip = '$nip_lama'";
        $q1 = mysqli_query($koneksi, $sql1);

        if ($q1) {
            $sukses = "Data berhasil diperbarui.";
            header("Location: menampilkanguru.php?sukses=" . urlencode($sukses));
            exit();
        } else {
            $error = "Gagal memperbarui data: " . mysqli_error($koneksi);
        }
    } else {
        $error = "Silakan isi semua data dengan lengkap.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Guru</title>
    <link rel="icon" type="image/x-icon" href="assets/logo.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
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
<body>
<div class="container mt-5">
    <a class="btn btn-outline-primary mb-3" href="menampilkanguru.php">← Kembali</a>
    <div class="card shadow">
        <h5 class="card-header text-center">Form Edit Data Guru</h5>
        <div class="card-body">
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="nip" class="form-label">NIP:</label>
                    <input type="text" class="form-control" id="nip" name="nip" value="<?php echo $nip; ?>" placeholder="Masukkan NIP">
                </div>
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Guru:</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama; ?>" placeholder="Masukkan nama guru">
                </div>
                <div class="mb-3">
                    <label for="jabatan" class="form-label">Jabatan:</label>
                    <input type="text" class="form-control" id="jabatan" name="jabatan" value="<?php echo $jabatan; ?>" placeholder="Masukkan jabatan">
                </div>
                <div class="mb-3">
                    <label for="no_telp" class="form-label">No Telepon:</label>
                    <input type="text" class="form-control" id="no_telp" name="no_telp" value="<?php echo $no_telp; ?>" placeholder="Masukkan nomor telepon">
                </div>
                <div class="text-center">
                    <button type="submit" name="submit" class="btn btn-success">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>