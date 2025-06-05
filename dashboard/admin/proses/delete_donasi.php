<?php
session_start();

// Cek apakah user sudah login dan memiliki peran yang sesuai
if (!isset($_SESSION['id_user']) || !isset($_SESSION['peran'])) {
    header("Location: ../../../auth/login.php");
    exit;
}

$peran = strtolower($_SESSION['peran']);
if ($peran !== 'kolaborator' && $peran !== 'admin') {
    header("Location: ../../../auth/login.php");
    exit;
}

// Pastikan ada parameter id_donasi di URL
if (!isset($_GET['id_donasi'])) {
    header("Location: ../donasi.php");
    exit;
}

$id_donasi = $_GET['id_donasi'];

// Koneksi ke database
include '../../../config/db.php';

// Siapkan dan jalankan query untuk menghapus donasi
$stmt = $conn->prepare("DELETE FROM donasi WHERE id_donasi = ?");
$stmt->bind_param("i", $id_donasi);

if ($stmt->execute()) {
    // Redirect kembali ke halaman donasi dengan pesan sukses
    header("Location: ../donasi.php?status=deleted");
} else {
    // Jika gagal, tampilkan pesan error
    echo "Gagal menghapus data donasi: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
