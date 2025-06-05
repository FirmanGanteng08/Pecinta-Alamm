<?php
session_start();

require '../../config/db.php'; // Pastikan file ini ada dan koneksi benar

$id_user = $_SESSION['id_user'];
$nama = $_SESSION['nama'] ?? 'Pengguna';
$email = $_SESSION['email'] ?? '';
$no_telepon = $_SESSION['no_telepon'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_baru = trim($_POST['nama']);
    $email_baru = trim($_POST['email']);
    $no_telepon_baru = trim($_POST['no_telepon']);
    $password_lama = $_POST['password_lama'];
    $password_baru = $_POST['password_baru'];

    // Ambil password lama dari database
    $query = mysqli_query($conn, "SELECT password FROM pengguna WHERE id_user = '$id_user'");
    $data = mysqli_fetch_assoc($query);
    $password_saat_ini = $data['password'];

    // Inisialisasi query update
    $update_query = "UPDATE pengguna SET nama='$nama_baru', email='$email_baru', no_telepon='$no_telepon_baru'";

    if (!empty($password_lama) && !empty($password_baru)) {
        if (password_verify($password_lama, $password_saat_ini)) {
            $hashed_password_baru = password_hash($password_baru, PASSWORD_DEFAULT);
            $update_query .= ", password='$hashed_password_baru'";
        } else {
            $error_message = "Password lama tidak sesuai!";
        }
    }

    $update_query .= " WHERE id_user='$id_user'";

    if (!isset($error_message)) {
        if (mysqli_query($conn, $update_query)) {
            // Update session
            $_SESSION['nama'] = $nama_baru;
            $_SESSION['email'] = $email_baru;
            $_SESSION['no_telepon'] = $no_telepon_baru;
            $success_message = "Perubahan berhasil disimpan.";
        } else {
            $error_message = "Gagal menyimpan perubahan: " . mysqli_error($conn);
        }
    }
}

$nama = $_SESSION['nama'] ?? $nama;
$email = $_SESSION['email'] ?? $email;
$no_telepon = $_SESSION['no_telepon'] ?? $no_telepon;
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Pengaturan Akun - SIFIRMAN</title>
  <link rel="stylesheet" href="../../assets/css/pengaturan.css">
  <script>
    function togglePassword(id) {
      const field = document.getElementById(id);
      field.type = field.type === "password" ? "text" : "password";
    }
  </script>
</head>
<body>
  <div class="container">
    <aside id="sidebar">
      <div class="logo">
        <img width="80%" src="../../assets/images/logo1.png" alt="Logo Komunitas Pecinta Alam">
      </div>
      <ul class="menu">
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="riwayat.php">Riwayat</a></li>
        <li><a href="pengaturan.php">Pengaturan</a></li>
      </ul>
    </aside>

    <main>
      <header>
        <h2>Pengaturan Akun</h2>
        <button id="toggleBtn" onclick="document.getElementById('sidebar').classList.toggle('closed')">☰</button>
      </header>

      <div class="form-container">
        <h3>Selamat datang, <?= htmlspecialchars($nama) ?></h3>

        <?php if (isset($success_message)) echo "<p class='status success'>$success_message</p>"; ?>
        <?php if (isset($error_message)) echo "<p class='status error'>$error_message</p>"; ?>

        <form method="POST" action="pengaturan.php" class="settings-form">
          <p><strong>Username:</strong> <?= htmlspecialchars($nama) ?></p>

          <label for="nama">Nama:</label>
          <input type="text" name="nama" value="<?= htmlspecialchars($nama) ?>" required>

          <label for="email">Email:</label>
          <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>" required>

          <label for="password_lama">Password Lama:</label>
          <input type="password" name="password_lama" id="password_lama" placeholder="Masukkan password lama">
          <label><input type="checkbox" onclick="togglePassword('password_lama')"> Tampilkan Password Lama</label>

          <label for="password_baru">Password Baru:</label>
          <input type="password" name="password_baru" id="password_baru" placeholder="Masukkan password baru">
          <label><input type="checkbox" onclick="togglePassword('password_baru')"> Tampilkan Password Baru</label>

          <label for="no_telepon">Nomor Telepon:</label>
          <input type="text" id="no_telepon" name="no_telepon" value="<?= htmlspecialchars($no_telepon) ?>" required>

          <button type="submit">Simpan Perubahan</button>
        </form>

        <a href="../../index.php" class="back-button">← Kembali ke Dashboard</a>
      </div>
    </main>
  </div>
</body>
</html>
