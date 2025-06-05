<?php
include '../../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form dan lakukan trim
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $peran = trim($_POST['peran']);
    $no_telepon = trim($_POST['no_telepon']);
    $status_akun = trim($_POST['status_akun']);

    // Validasi: Pastikan tidak ada input yang kosong (kecuali no_telepon & jabatan boleh kosong)
    if (empty($nama) || empty($email) || empty($password) || empty($peran) || empty($status_akun)) {
        echo "Semua bidang wajib diisi, kecuali No Telepon.";
        exit;
    }

    // Validasi email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Format email tidak valid!";
        exit;
    }

    // Validasi nomor telepon (opsional, hanya angka diperbolehkan)
    if (!empty($no_telepon) && !preg_match('/^[0-9]+$/', $no_telepon)) {
        echo "Nomor telepon hanya boleh berisi angka!";
        exit;
    }

    // **CEK APAKAH EMAIL SUDAH ADA DI DATABASE**
    $cek_email = $conn->prepare("SELECT id_user FROM pengguna WHERE email = ?");
    $cek_email->bind_param("s", $email);
    $cek_email->execute();
    $cek_email->store_result();

    if ($cek_email->num_rows > 0) {
        echo "Email sudah terdaftar! Gunakan email lain.";
        $cek_email->close();
        exit;
    }
    $cek_email->close();

    // Enkripsi password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Query untuk memasukkan data ke database
    $stmt = $conn->prepare("INSERT INTO pengguna (nama, email, password, peran, no_telepon, status_akun) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $nama, $email, $hashed_password, $peran, $no_telepon, $status_akun);

    if ($stmt->execute()) {
        // Redirect ke halaman index dengan pesan sukses
        header('Location: ../pengguna.php?status=success');
        exit();
    } else {
        echo "Terjadi kesalahan saat menyimpan data: " . $stmt->error;
    }

    // Tutup statement dan koneksi
    $stmt->close();
}

$conn->close();
?>
