<?php
// Mulai session
session_start();

// Periksa apakah pengguna sudah login dan memiliki peran kolaborator
if (!isset($_SESSION['id_user']) || $_SESSION['peran'] != 'kolaborator') {
    header("Location: login.php");
    exit;
}

// Menghubungkan ke database
include 'db.php';

// Cek apakah metode yang digunakan adalah POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_gerakan = $_POST['nama_gerakan'];
    $deskripsi = $_POST['deskripsi'];
    $id_kolaborator = $_SESSION['id_user'];  // Menggunakan ID kolaborator yang sedang login

    // Simpan data ke dalam tabel gerakan
    $stmt = $conn->prepare("INSERT INTO gerakan (nama_gerakan, deskripsi, id_kolaborator) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $nama_gerakan, $deskripsi, $id_kolaborator);

    if ($stmt->execute()) {
        echo "<script>alert('Gerakan berhasil dibuat!'); window.location.href='gerakan.php';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan. Mohon coba lagi.'); window.location.href='buat_gerakan.php';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Gerakan Baru</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1>Buat Gerakan Baru</h1>
    <form method="POST" action="buat_gerakan.php">
        <label for="nama_gerakan">Nama Gerakan:</label>
        <input type="text" id="nama_gerakan" name="nama_gerakan" required>

        <label for="deskripsi">Deskripsi Gerakan:</label>
        <textarea id="deskripsi" name="deskripsi" required></textarea>

        <button type="submit">Buat Gerakan</button>
    </form>
</body>
</html>
