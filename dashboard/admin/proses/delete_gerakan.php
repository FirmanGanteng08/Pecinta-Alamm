<?php
session_start();

if (!isset($_SESSION['id_user']) || !isset($_SESSION['peran'])) {
    header("Location: ../../../auth/login.php");
    exit;
}

$peran = strtolower($_SESSION['peran']);
if ($peran !== 'kolaborator' && $peran !== 'admin') {
    header("Location: ../../../auth/login.php");
    exit;
}

if (!isset($_GET['id_gerakan'])) {
    header("Location: ../gerakan.php?status=error");
    exit;
}

$id_gerakan = intval($_GET['id_gerakan']);

include '../../../config/db.php';

// Cek apakah gerakan dengan ID tersebut ada
$cek_sql = "SELECT * FROM gerakan WHERE id_gerakan = ?";
$stmt = $conn->prepare($cek_sql);
$stmt->bind_param("i", $id_gerakan);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    // Tidak ditemukan gerakan
    header("Location: ../gerakan.php?status=notfound");
    exit;
}

// Lanjutkan ke penghapusan
$delete_sql = "DELETE FROM gerakan WHERE id_gerakan = ?";
$stmt_delete = $conn->prepare($delete_sql);
$stmt_delete->bind_param("i", $id_gerakan);

if ($stmt_delete->execute()) {
    header("Location: ../gerakan.php?status=deleted");
    exit;
} else {
    echo "Gagal menghapus data: " . $conn->error;
}
?>
