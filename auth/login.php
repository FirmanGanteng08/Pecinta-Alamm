<?php
include '../config/db.php';
session_start();

if (isset($_SESSION['id_user'])) {
    header("Location: ../index.php");
    exit;
}

$error = '';
$input_value = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = trim($_POST['username_or_email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $input_value = htmlspecialchars($input); // untuk mengisi kembali form jika gagal

    if ($input && $password) {
        $is_email = filter_var($input, FILTER_VALIDATE_EMAIL);
        $query = $is_email 
            ? "SELECT * FROM pengguna WHERE email = ?" 
            : "SELECT * FROM pengguna WHERE nama = ?";
        
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $input);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            if ($user['status_akun'] === 'aktif') {
                $_SESSION['id_user'] = $user['id_user'];
                $_SESSION['nama'] = htmlspecialchars($user['nama']);
                $_SESSION['peran'] = strtolower($user['peran']);
                $_SESSION['no_telepon'] = $user['no_telepon'];
                $_SESSION['email'] = $user['email'];
                $redirect = "../index.php";
                header("Location: $redirect");
                exit;
            } else {
                $error = "Akun Anda sedang di blokir <strong>{$user['status_akun']}</strong>. Silakan hubungi admin.";
            }
        } else {
            $error = "Username atau password salah.";
        }
        $stmt->close();
    } else {
        $error = "Harap isi semua kolom.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Pecinta Alam</title>
    <link rel="stylesheet" href="../assets/css/login.css">
</head>
<body>
    <form method="POST" class="form-container">
        <h2>Login</h2>
        <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
        <input type="text" name="username_or_email" value="<?= $input_value ?>" placeholder="Username atau Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
        <p>Belum punya akun? <a href="register.php">Register</a></p>
        <p><a href="../index.php">Kembali ke Beranda</a></p>
    </form>
</body>
</html>
