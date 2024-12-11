<?php 
// Sertakan file koneksi ke database
include('koneksi.php');    

// Ambil parameter `nama` dari URL
if (isset($_GET['nama'])) {
    $nama = $_GET['nama'];

    // Lakukan validasi input untuk menghindari SQL Injection
    $nama = mysqli_real_escape_string($koneksi, $nama);

    // Eksekusi query untuk menghapus data berdasarkan nama
    $query = "DELETE FROM siswa WHERE nama = '$nama'";

    // Cek apakah query berhasil dieksekusi
    if ($nama) {
        echo "<script>alert('Data berhasil dihapus!');</script>";
    } else {
        echo "<script>alert('Gagal menghapus data: " . mysqli_error($koneksi) . "');</script>";
    }

    // Redirect ke halaman `menampilkandata.php` setelah penghapusan
    echo "<meta http-equiv='refresh' content='1;url=http://localhost/web%20sahbeni/menampilkandata.php'>";
} else {
    echo "<script>alert('Nama siswa tidak ditemukan!');</script>";
    echo "<meta http-equiv='refresh' content='1;url=http://localhost/web%20sahbeni/menampilkandata.php'>";
}
?>
