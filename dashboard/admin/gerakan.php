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

include '../../config/db.php';

$sql = "SELECT * FROM gerakan";
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
  <title>Manajemen Gerakan</title>
  <link rel="stylesheet" href="../../assets/css/pengguna.css"> <!-- Gaya bawaan -->
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
        <h2>Manajemen Gerakan</h2>
      </header>

      <section class="content">
        <h3>Daftar Gerakan</h3>

        <?php if (isset($_GET['status']) && $_GET['status'] === 'deleted'): ?>
          <p class="status success">✅ Data gerakan berhasil dihapus.</p>
        <?php endif; ?>

        <a href="proses/tambah_gerakan.php" class="add-btn">+ Tambah Data</a>

        <table>
          <thead>
            <tr>
              <th>ID Gerakan</th>
              <th>Judul</th>
              <th>Deskripsi</th>
              <th>Tanggal Mulai</th>
              <th>Tanggal Selesai</th>
              <th>ID Kolaborator</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr>
                <td><?= htmlspecialchars($row['id_gerakan']) ?></td>
                <td><?= htmlspecialchars($row['judul_gerakan']) ?></td>
                <td><?= htmlspecialchars($row['deskripsi']) ?></td>
                <td><?= htmlspecialchars($row['tanggal_mulai']) ?></td>
                <td><?= htmlspecialchars($row['tanggal_selesai']) ?></td>
                <td><?= htmlspecialchars($row['id_kolaborator']) ?></td>
                <td>
                  <a href="proses/delete_gerakan.php?id_gerakan=<?= $row['id_gerakan'] ?>" class="delete-btn" onclick="return confirm('Yakin ingin menghapus gerakan ini?')">🗑</a>
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
