<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "presensi_sahbanii";

$koneksi = mysqli_connect($host, $user, $password, $database);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$nip    = "";
$nama   = "";
$jabatan = "";
$no_telp = "";
$error  = "";
$sukses = "";

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
        $check_nip = "SELECT * FROM guru WHERE nip = '$nip'";
        $result = mysqli_query($koneksi, $check_nip);
    
        if (mysqli_num_rows($result) > 0 && $op != 'edit') {
            $error = "NIP sudah terdaftar, gunakan NIP lain.";
        } else {
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
        }
    } else {
        $error = "Silakan masukkan semua data dengan benar";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Guru</title>
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
<a class="btn btn-outline-primary mb-3" href="menampilkanguru.php">← Kembali</a>
    <div class="card shadow">
        <h5 class="card-header text-center">Form Tambah Data Guru</h5>
        <div class="card-body">
            <form action="menampilkanguru.php" method="POST">
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Guru :</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama; ?>" placeholder="Masukkan nama guru">
                </div>
                <div class="mb-3">
                    <label for="nip" class="form-label">NIP :</label>
                    <input type="text" class="form-select" id="nip" name="nip" placeholder="Masukan NIP Guru" value="<?php echo $nip; ?>">
                </div>
                <div class="mb-3">
                    <label for="jabatan" class="form-label">Jabatan :</label>
                    <input type="text" class="form-control" id="jabatan" name="jabatan" placeholder="Masukkan jabatan anda" value="<?php echo $jabatan; ?>">
                </div>
                <div class="mb-3">
                    <label for="no-telp" class="form-label">No Telepon :</label>
                    <input type="number" class="form-control" id="no_telp" name="no_telp" placeholder="Masukkan nomor telepon"><?= $no_telp ?>
                </div>
                <div class="text-center">
                    <button type="submit" name="submit" class="btn btn-success">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>