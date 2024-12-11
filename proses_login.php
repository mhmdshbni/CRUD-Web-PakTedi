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

    $stmt = $conn->prepare("SELECT * FROM user WHERE user = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['logged_in'] = true;
        $_SESSION['user'] = $username;
        header("Location: index.php");
        exit();
    } else {
        echo "<script>
            alert('Username atau Password salah!');
            window.location.href='loginadmin.php';
        </script>";
    }

    $stmt->close();
}

$conn->close();
?>