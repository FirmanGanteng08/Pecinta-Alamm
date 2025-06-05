<?php
session_start();
include '../../../config/db.php';

// Cek apakah pengguna sudah login dan memiliki peran admin atau kolaborator
if (!isset($_SESSION['id_user']) || !isset($_SESSION['peran'])) {
    header("Location: ../views/login.php");
    exit();
}

// Konversi peran ke lowercase agar case-insensitive
$peran = strtolower($_SESSION['peran']);
if ($peran !== 'admin' && $peran !== 'kolaborator') {
    header("Location: ../views/login.php");
    exit();
}

// Pastikan ada ID user yang dikirim lewat URL
if (isset($_GET['id_user'])) {
    $id_user = intval($_GET['id_user']); // Pastikan input berupa angka

    // Cek apakah pengguna yang dihapus adalah admin (tidak boleh menghapus admin lain)
    $stmt = $conn->prepare("SELECT peran FROM pengguna WHERE id_user = ?");
    $stmt->bind_param("i", $id_user);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if ($user['peran'] === 'admin' && $peran !== 'admin') {
            echo "Anda tidak memiliki izin untuk menghapus admin.";
            exit();
        }
    } else {
        echo "Pengguna tidak ditemukan.";
        exit();
    }
    $stmt->close();

    // Hapus data pengguna berdasarkan id_user
    $stmt = $conn->prepare("DELETE FROM pengguna WHERE id_user = ?");
    $stmt->bind_param("i", $id_user);

    if ($stmt->execute()) {
        // Redirect ke halaman admin dengan status sukses
        header('Location: ../pengguna.php?status=deleted');
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
