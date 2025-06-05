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

$sql = "SELECT * FROM donasi";
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
  <title>Manajemen Donasi</title>
  <link rel="stylesheet" href="../../assets/css/pengguna.css"> <!-- Gunakan CSS yang sama jika belum ada CSS khusus -->
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
        <h2>Manajemen Donasi</h2>
      </header>

      <section class="content">
        <h3>Riwayat Donasi</h3>

        <?php if (isset($_GET['status']) && $_GET['status'] === 'deleted'): ?>
          <p class="status success">✅ Data donasi berhasil dihapus.</p>
        <?php endif; ?>

        <a href="proses/tambah_donasi.php" class="add-btn">+ Tambah Data</a>

        <table>
          <thead>
            <tr>
              <th>ID Donasi</th>
              <th>ID User</th>
              <th>Nama</th>
              <th>Email</th>
              <th>Nominal</th>
              <th>Bukti</th>
              <th>Tanggal</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr>
                <td><?= htmlspecialchars($row['id_donasi']) ?></td>
                <td><?= htmlspecialchars($row['id_user']) ?></td>
                <td><?= htmlspecialchars($row['nama']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td>Rp <?= number_format($row['nominal'], 2, ',', '.') ?></td>
                <td> <img style="width: 100px;" src="../../pages/upload/<?= $row['bukti_transfer'] ?>" alt=""></td>
                <td><?= htmlspecialchars($row['tanggal']) ?></td>
                <td>
                  <a href="proses/delete_donasi.php?id_donasi=<?= $row['id_donasi'] ?>" class="delete-btn" onclick="return confirm('Yakin ingin menghapus data donasi ini?')">🗑</a>
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
