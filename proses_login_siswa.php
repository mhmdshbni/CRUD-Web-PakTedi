<?php
session_start();

$host = "localhost";
$dbname = "presensi_sahbanii";
$username_db = "root";
$password_db = "";

$conn = new mysqli($host, $username_db, $password_db, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username']; 
    $password = $_POST['password']; 

    // Menyiapkan query untuk memeriksa apakah username dan password cocok
    $stmt = $conn->prepare("SELECT * FROM usersiswa WHERE user = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Jika login berhasil, set session
        $_SESSION['usersiswa'] = $username; // Pastikan session sesuai dengan yang digunakan untuk login
        header("Location: menampilkanpresensi.php");
        exit();
    } else {
        // Jika login gagal, tampilkan alert
        echo "<script>
            alert('Username atau Password salah!');
            window.location.href='login.php';
        </script>";
    }

    $stmt->close();
}

$conn->close();
?>
