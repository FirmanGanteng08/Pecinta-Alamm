<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['id_user'])) {
    header("Location: ../../auth/login.php");
    exit;
}

// Sambungkan ke database
include '../../../config/db.php';

// Pastikan data form ada dan tidak kosong
$nama = trim($_POST['nama'] ?? '');
$email = trim($_POST['email'] ?? '');
$no_telepon = trim($_POST['no_telepon'] ?? '');

// Validasi jika data kosong
if (empty($nama) || empty($email) || empty($no_telepon)) {
    echo "Semua field harus diisi!";
    exit;
}

// Ambil id_user dari session
$id_user = $_SESSION['id_user'];

// Update data pengguna
$query = "UPDATE pengguna SET nama = ?, email = ?, no_telepon = ? WHERE id_user = ?";
$stmt = $conn->prepare($query);

if ($stmt === false) {
    die('Error preparing the statement: ' . $conn->error);
}

// Bind parameter
$stmt->bind_param("sssi", $nama, $email, $no_telepon, $id_user);

// Eksekusi statement dan periksa hasilnya
if ($stmt->execute()) {
    // Update data session setelah berhasil update
    $_SESSION['nama'] = $nama;
    $_SESSION['email'] = $email;
    $_SESSION['no_telepon'] = $no_telepon;
    header("Location: ../pengaturan.php?updated=true");
    exit;
} else {
    echo "Gagal memperbarui data: " . $stmt->error;
}

// Menutup statement dan koneksi
$stmt->close();
$conn->close();
?>
