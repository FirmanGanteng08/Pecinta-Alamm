<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: ../../auth/login.php");
    exit;
}

include '../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_user = $_SESSION['id_user'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $nominal = str_replace('.', '', $_POST['nominal']);
    $nominal = (float) str_replace(',', '.', $nominal);

    if ($nominal <= 0) {
        echo "<script>alert('Nominal donasi harus lebih dari 0.'); window.location.href='../donasi.php';</script>";
        exit;
    }

    // Validasi file upload
    if (!isset($_FILES['bukti']) || $_FILES['bukti']['error'] !== UPLOAD_ERR_OK) {
        echo "<script>alert('Harap unggah bukti transfer.'); window.location.href='../donasi.php';</script>";
        exit;
    }

    $allowed_types = ['image/jpeg', 'image/png', 'application/pdf'];
    $file = $_FILES['bukti'];
    $file_type = mime_content_type($file['tmp_name']);
    $file_size = $file['size'];

    if (!in_array($file_type, $allowed_types)) {
        echo "<script>alert('Format bukti transfer tidak valid. Hanya JPG, PNG, atau PDF.'); window.location.href='../donasi.php';</script>";
        exit;
    }

    if ($file_size > 2 * 1024 * 1024) { // 2MB
        echo "<script>alert('Ukuran file terlalu besar. Maksimal 2MB.'); window.location.href='../donasi.php';</script>";
        exit;
    }

    // Simpan file
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $new_filename = uniqid('bukti_') . '.' . $ext;
    $upload_path = '../upload/' . $new_filename;

    if (!move_uploaded_file($file['tmp_name'], $upload_path)) {
        echo "<script>alert('Gagal menyimpan bukti transfer.'); window.location.href='../donasi.php';</script>";
        exit;
    }

    // Simpan data ke database (tambahkan kolom bukti_transfer di tabel donasi)
    $stmt = $conn->prepare("INSERT INTO donasi (id_user, nama, email, nominal, bukti_transfer) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issds", $id_user, $nama, $email, $nominal, $new_filename);

    if ($stmt->execute()) {
        $formatted_nominal = number_format($nominal, 2, ',', '.');
        echo "<script>alert('Terima kasih atas donasi Anda sebesar Rp $formatted_nominal!'); window.location.href='../donasi.php';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan saat menyimpan data.'); window.location.href='../donasi.php';</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: ../donasi.php");
    exit;
}
?>
