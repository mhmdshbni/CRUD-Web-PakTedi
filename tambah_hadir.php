<?php
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

if (isset($_POST['submit'])) {
    $status_kehadiran = $_POST['status_kehadiran'];
    $waktu            = $_POST['waktu'];
    $tanggal          = $_POST['tanggal'];
    $nisn             = $_POST['nisn'];

    // Validasi data
    if ($status_kehadiran && $waktu && $tanggal && $nisn) {
        // Insert data ke tabel presensi
        $sql = "INSERT INTO presensi (status_kehadiran, waktu, tanggal, nisn) 
                VALUES ('$status_kehadiran', '$waktu', '$tanggal', '$nisn')";
        $query = mysqli_query($koneksi, $sql);

        if ($query) {
            $sukses = "Data berhasil disimpan.";
            // Redirect ke halaman menampilkanpresensi.php dengan pesan sukses
            header("Location: menampilkanpresensi.php?sukses=" . urlencode($sukses));
            exit();
        } else {
            $error = "Data gagal disimpan: " . mysqli_error($koneksi);
        }
    } else {
        $error = "Silakan isi semua data dengan lengkap.";
    }
}


// Ambil data dari tabel siswa
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
    <title>Tambah Data Kehadiran</title>
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
        <a class="btn btn-outline-primary mb-3" href="menampilkanpresensi.php">← Kembali</a>
        <div class="card shadow">
            <h5 class="card-header text-center">Form Tambah Data Kehadiran</h5>
            <div class="card-body">

                <!-- Tampilkan pesan sukses atau error -->
                <?php if ($sukses) { ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses; ?>
                    </div>
                <?php } ?>
                <?php if ($error) { ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error; ?>
                    </div>
                <?php } ?>

                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="status_kehadiran" class="form-label">Status Kehadiran</label>
                        <input type="text" class="form-control" id="status_kehadiran" name="status_kehadiran" value="<?php echo $status_kehadiran; ?>" placeholder="Masukkan status kehadiran">
                    </div>
                    <div class="mb-3">
                        <label for="waktu" class="form-label">Waktu</label>
                        <input type="time" class="form-control" id="waktu" name="waktu" value="<?php echo $waktu; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?php echo $tanggal; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="kelas" class="form-label">Kelas</label>
                        <select class="form-select" id="kelas" name="kelas">
                            <option value="">- Pilih Kelas -</option>
                            <option value="X" <?php if ($kelas == "X") echo "selected"; ?>>X</option>
                            <option value="XI" <?php if ($kelas == "XI") echo "selected"; ?>>XI</option>
                            <option value="XII" <?php if ($kelas == "XI") echo "selected"; ?>>XII</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="nisn" class="form-label">NISN</label>
                        <select class="form-select" id="nisn" name="nisn">
                            <option value="">- Pilih NISN -</option>
                            <?php echo $nisn_options; ?>
                        </select>
                    </div>
                    <div class="text-center">
                        <button type="submit" name="submit" class="btn btn-success">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
