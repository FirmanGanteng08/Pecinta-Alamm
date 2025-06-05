<?php
// Mulai session
session_start();

// Menghubungkan ke database
include '../../config/db.php';

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

// Ambil ID gerakan dari URL
$id_gerakan = $_GET['id'];
$id_user = $_SESSION['id_user'];

// Cek apakah pengguna sudah mengikuti gerakan ini
$check_follow = "SELECT * FROM pengguna_gerakan WHERE id_user = ? AND id_gerakan = ?";
$stmt = $conn->prepare($check_follow);
$stmt->bind_param("ii", $id_user, $id_gerakan);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo "<script>alert('Anda sudah mengikuti gerakan ini.'); window.location.href='../gerakan.php';</script>";
} else {
    // Simpan hubungan pengguna dengan gerakan yang diikuti
    $stmt = $conn->prepare("INSERT INTO pengguna_gerakan (id_user, id_gerakan) VALUES (?, ?)");
    $stmt->bind_param("ii", $id_user, $id_gerakan);
    
    if ($stmt->execute()) {
        echo "<script>alert('Anda berhasil mengikuti gerakan ini!'); window.location.href='../gerakan.php';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan. Mohon coba lagi.'); window.location.href='../gerakan.php';</script>";
    }
}

$stmt->close();
$conn->close();
?>
