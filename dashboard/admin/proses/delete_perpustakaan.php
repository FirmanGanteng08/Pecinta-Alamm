<?php
session_start();

if (!isset($_SESSION['id_user']) || !isset($_SESSION['peran'])) {
    header("Location: ../../../auth/login.php");
    exit;
}

$peran = strtolower($_SESSION['peran']);
if ($peran !== 'admin' && $peran !== 'kolaborator') {
    header("Location: ../../../auth/login.php");
    exit;
}

if (!isset($_GET['id_perpustakaan'])) {
    header("Location: ../perpustakaan.php");
    exit;
}

include '../../../config/db.php';

$id_perpustakaan = intval($_GET['id_perpustakaan']); // Hindari SQL Injection dengan casting

$sql = "DELETE FROM perpustakaan WHERE id_perpustakaan = ?";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("i", $id_perpustakaan);
    if ($stmt->execute()) {
        header("Location: ../perpustakaan.php?status=deleted");
        exit;
    } else {
        die("Gagal menghapus data: " . $stmt->error);
    }
} else {
    die("Query error: " . $conn->error);
}
