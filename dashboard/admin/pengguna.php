<?php
session_start();

if (!isset($_SESSION['id_user']) || !isset($_SESSION['peran'])) {
    header("Location: ../../auth/login.php");
    exit;
}

$peran = strtolower($_SESSION['peran']);
if ($peran !== 'kolaborator' && $peran !== 'admin') {
    header("Location: ../php/login.php");
    exit;
}

$current_user_id = $_SESSION['id_user'];
include '../../config/db.php';

$sql = "SELECT * FROM pengguna";
$result = $conn->query($sql);

if (!$result) {
    die("Error dalam query: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manajemen Pengguna</title>
  <link rel="stylesheet" href="../../assets/css/pengguna.css">
</head>
<body>
  <div class="container">
    <aside id="sidebar">
      <div class="logo">
        <img width="80%" src="../../assets/images/logo1.png" alt="Logo Komunitas Pecinta Alam">
      </div>
      <ul class="menu">
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="pengguna.php" class="active">Pengguna</a></li>
        <li><a href="gerakan.php">Gerakan</a></li>
        <li><a href="donasi.php">Donasi</a></li>
        <li><a href="perpustakaan.php">Perpustakaan</a></li>
        <li><a href="pengaturan.php">Pengaturan</a></li>
      </ul>
    </aside>

    <main>
      <header>
        <button id="toggleBtn">☰</button>
        <h2>Manajemen Pengguna</h2>
      </header>

      <section class="content">
        <h3>Daftar Pengguna</h3>

        <?php if (isset($_GET['status']) && $_GET['status'] === 'deleted'): ?>
          <p class="status success">✅ Pengguna berhasil dihapus.</p>
        <?php endif; ?>

        <a href="proses/tambah_pengguna.php" class="add-btn">+ Tambah Pengguna</a>

        <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>Nama</th>
              <th>Email</th>
              <th>Peran</th>
              <th>No Telepon</th>
              <th>Status</th>
              <th>Bergabung</th>
              <th>Password</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr>
                <td><?= htmlspecialchars($row['id_user']) ?></td>
                <td><?= htmlspecialchars($row['nama']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['peran']) ?></td>
                <td><?= htmlspecialchars($row['no_telepon']) ?></td>
                <td><?= htmlspecialchars($row['status_akun']) ?></td>
                <td><?= date("d-m-Y", strtotime($row['tanggal_bergabung'])) ?></td>
                <td><?= strlen($row['password']) > 0 ? "Tersimpan" : "Belum Ada" ?></td>
                <td>
                  <a href="proses/update_pengguna.php?id_user=<?= $row['id_user'] ?>" class="edit-btn">✏️</a>
                  <a href="proses/delete_process.php?id_user=<?= $row['id_user'] ?>" class="delete-btn" onclick="return confirm('Yakin ingin menghapus pengguna ini?')">🗑</a>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </section>

      <a href="../../index.php" class="back-button">← Kembali ke Dashboard</a>
    </main>
  </div>

  <script>
    const toggleBtn = document.getElementById("toggleBtn");
    const sidebar = document.getElementById("sidebar");

    toggleBtn.addEventListener("click", () => {
      sidebar.classList.toggle("closed");
    });
  </script>
</body>
</html>
