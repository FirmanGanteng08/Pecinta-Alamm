<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "pecinta_allam";

// Membuat koneksi
$conn = new mysqli($host, $username, $password, $dbname);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
