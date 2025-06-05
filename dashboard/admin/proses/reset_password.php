<?php
session_start();

// Cek apakah pengguna sudah login dan memiliki akses admin/kolaborator
if (!isset($_SESSION['id_user']) || !isset($_SESSION['peran'])) {
    header("Location: ../../../auth/login.php");
    exit;
}

// Konversi peran ke lowercase agar case-insensitive
$peran = strtolower($_SESSION['peran']);
if ($peran !== 'kolaborator' && $peran !== 'admin') {
    header("Location: ../../../auth/login.php");
    exit;
}

// Mendapatkan ID pengguna yang akan direset passwordnya
if (isset($_GET['id_user'])) {
    $id_user = $_GET['id_user'];
    
    // Menghubungkan ke database
    include '../../../config/db.php';

    // Query untuk mengambil data pengguna
    $sql = "SELECT * FROM pengguna WHERE id_user = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_user);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        header("Location: ../pengguna.php");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $password_baru = $_POST['password_baru'];

        if (strlen($password_baru) >= 6) {
            // Hash password baru dan update di database
            $hashed_password = password_hash($password_baru, PASSWORD_DEFAULT);
            $update_query = "UPDATE pengguna SET password = ? WHERE id_user = ?";
            $stmt_update = $conn->prepare($update_query);
            $stmt_update->bind_param("si", $hashed_password, $id_user);

            if ($stmt_update->execute()) {
                header("Location: ../pengguna.php?status=reset");
                exit;
            } else {
                $error_message = "Gagal mereset password.";
            }
        } else {
            $error_message = "Password baru harus minimal 6 karakter.";
        }
    }
} else {
    header("Location: ../pengguna.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="../public/style.css">
</head>
<body>
    <h1>Reset Password Pengguna</h1>

    <!-- Tampilkan pesan error jika ada -->
    <?php if (isset($error_message)) echo "<p class='error'>$error_message</p>"; ?>

    <form method="POST" action="">
        <label for="password_baru">Password Baru:</label>
        <input type="password" name="password_baru" id="password_baru" required>

        <button type="submit">Reset Password</button>
    </form>

    <a href="../pengguna.php" class="btn">Kembali</a>
</body>
</html>
