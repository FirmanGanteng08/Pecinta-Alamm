<?php
session_start();

if (!isset($_SESSION['id_user']) || !isset($_SESSION['peran'])) {
    header("Location: ../../auth/login.php");
    exit;
}

$peran = strtolower($_SESSION['peran']);
if ($peran !== 'admin' && $peran !== 'kolaborator') {
    header("Location: ../php/login.php");
    exit;
}

include '../../config/db.php';

$sql = "SELECT * FROM perpustakaan";
$result = $conn->query($sql);

if (!$result) {
    die("Query error: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Perpustakaan</title>
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
        <h2>Perpustakaan</h2>
      </header>

      <section class="content">
        <h3>Daftar Buku / Artikel</h3>

        <?php if (isset($_GET['status']) && $_GET['status'] === 'deleted'): ?>
          <p class="status success">✅ Data perpustakaan berhasil dihapus.</p>
        <?php endif; ?>

        <a href="proses/tambah_perpustakaan.php" class="add-btn">+ Tambah Data</a>

        <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>Judul</th>
              <th>Penulis</th>
              <th>Kategori</th>
              <th>Tahun Terbit</th>
              <th>Deskripsi</th>
              <th>ID User</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr>
                <td><?= htmlspecialchars($row['id_perpustakaan']) ?></td>
                <td><?= htmlspecialchars($row['judul']) ?></td>
                <td><?= htmlspecialchars($row['penulis']) ?></td>
                <td><?= htmlspecialchars($row['kategori']) ?></td>
                <td><?= htmlspecialchars($row['tahun_terbit']) ?></td>
                <td><?= htmlspecialchars($row['deskripsi']) ?></td>
                <td><?= htmlspecialchars($row['id_user']) ?></td>
                <td>
                  <a href="proses/delete_perpustakaan.php?id_perpustakaan=<?= $row['id_perpustakaan'] ?>" class="delete-btn" onclick="return confirm('Yakin ingin menghapus data ini?')">🗑</a>
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
