<?php
include '../../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form dan lakukan trim
    $judul = trim($_POST['judul_gerakan']);
    $deskripsi = trim($_POST['deskripsi']);
    $mulai = trim($_POST['tanggal_mulai']);
    $selesai = trim($_POST['tanggal_selesai']);
    $lokasi = trim($_POST['lokasi']);

    // Validasi: Pastikan tidak ada input yang kosong (kecuali no_telepon & jabatan boleh kosong)
    if (empty($judul) || empty($deskripsi) || empty($lokasi)) {
        echo "Semua bidang wajib diisi.";
        exit;
    }

    // Query untuk memasukkan data ke database
    $stmt = $conn->prepare("INSERT INTO gerakan (judul_gerakan, deskripsi, tanggal_mulai, tanggal_selesai, lokasi) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $judul, $deskripsi, $mulai, $selesai, $lokasi);

    if ($stmt->execute()) {
        // Redirect ke halaman index dengan pesan sukses
        header('Location: ../gerakan.php?status=success');
        exit();
    } else {
        echo "Terjadi kesalahan saat menyimpan data: " . $stmt->error;
    }

    // Tutup statement dan koneksi
    $stmt->close();
}

$conn->close();
?>
