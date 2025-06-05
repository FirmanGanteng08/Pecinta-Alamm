<?php
// Mulai session
session_start();

// Menghubungkan ke database
include '../../config/db.php';

// Ambil ID informasi alam dari URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Ambil data informasi alam berdasarkan ID
$sql = "SELECT * FROM perpustakaan WHERE id_perpustakaan = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$alam = $result->fetch_assoc();

// Jika informasi alam tidak ditemukan
if (!$alam) {
    die("Informasi alam tidak ditemukan!");
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Informasi Alam - <?= htmlspecialchars($alam['judul']) ?></title>
    <link rel="stylesheet" href="../../assets/css/detail_alam.css"> <!-- Sesuaikan dengan CSS Anda -->
</head>
<body>

<div class="book-info">
    <h2><?= htmlspecialchars($alam['judul']) ?></h2>
    <p><strong>Kategori:</strong> <?= htmlspecialchars($alam['kategori']) ?></p>
    <p><strong>Tahun Terbit:</strong> <?= htmlspecialchars($alam['tahun_terbit']) ?></p>
    <p><strong>Deskripsi:</strong></p>
    <p><?= nl2br(htmlspecialchars($alam['deskripsi'])) ?></p>
</div>

<a class="back" href="../perpustakaan.php">Kembali ke Daftar Informasi Alam</a>

</body>
</html>
