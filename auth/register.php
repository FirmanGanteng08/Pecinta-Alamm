<?php
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $no_telepon = trim($_POST['no_telepon'] ?? ''); // Opsional
    $peran = 'pengguna'; // Default role
    $id_gerakan = null; // Default NULL

    // **Validasi Email**
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Format email tidak valid!";
    } elseif (strlen($password) < 6) { // **Validasi panjang password**
        $error = "Password minimal 6 karakter!";
    } else {
        // **Cek apakah email sudah terdaftar**
        $stmt_check_email = $conn->prepare("SELECT id_user FROM pengguna WHERE email = ?");
        $stmt_check_email->bind_param("s", $email);
        $stmt_check_email->execute();
        $stmt_check_email->store_result();

        if ($stmt_check_email->num_rows > 0) {
            $error = "Email sudah terdaftar!";
        } else {
            // **Hash password menggunakan PASSWORD_DEFAULT**
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // **Simpan data pengguna ke database**
            $stmt = $conn->prepare("INSERT INTO pengguna (nama, email, password, peran, id_gerakan, no_telepon) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $nama, $email, $hashed_password, $peran, $id_gerakan, $no_telepon);

            if ($stmt->execute()) {
                header("Location: login.php?register=success");
                exit();
            } else {
                $error = "Gagal mendaftar. Silakan coba lagi!";
            }
            $stmt->close();
        }
        $stmt_check_email->close();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../assets/css/login.css">
</head>
<body>
    <form method="POST" action="register.php" class="form-container">
        <h2>Register</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <input type="text" name="nama" placeholder="Nama Lengkap" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="text" name="no_telepon" placeholder="Nomor Telepon (Opsional)">
        <button type="submit">Register</button>
        <p>Sudah punya akun? <a href="login.php">Login</a></p>
    </form>
</body>
</html>
