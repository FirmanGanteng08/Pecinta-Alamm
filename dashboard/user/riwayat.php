<?php
session_start();
include '../../config/db.php';

if (!isset($_SESSION['id_user'])) {
    header('Location: ../auth/login.php');
    exit();
}

$id_user = $_SESSION['id_user'];

// Ambil data donasi
$query_donasi = "SELECT nominal, tanggal FROM donasi WHERE id_user = ? ORDER BY tanggal DESC";
$stmt_donasi = $conn->prepare($query_donasi);
$stmt_donasi->bind_param("i", $id_user);
$stmt_donasi->execute();
$result_donasi = $stmt_donasi->get_result();

// Ambil data gerakan dan tanggal ikut
$query_gerakan = "
    SELECT g.judul_gerakan, pg.tanggal_ikut 
    FROM pengguna_gerakan pg
    JOIN gerakan g ON pg.id_gerakan = g.id_gerakan
    WHERE pg.id_user = ?
    ORDER BY pg.tanggal_ikut DESC
";

$stmt_gerakan = $conn->prepare($query_gerakan);
$stmt_gerakan->bind_param("i", $id_user);
$stmt_gerakan->execute();
$result_gerakan = $stmt_gerakan->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Aktivitas</title>
    <link rel="stylesheet" href="../../assets/css/riwayat.css">
    <link rel="icon" type="image/png" href="../assets/images/logo2.png">
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
            <h2>Riwayat Aktivitas Anda</h2>
            <button id="toggleBtn" onclick="toggleSidebar()">☰</button>
        </header>

        <section class="profile-info">
            <h3>Riwayat Donasi</h3>
            <?php if ($result_donasi->num_rows > 0): ?>
                <?php while ($donasi = $result_donasi->fetch_assoc()): ?>
                    <p>
                        <strong>Tanggal Donasi:</strong>
                        <span><?= date('d M Y', strtotime($donasi['tanggal'])); ?></span>

                        <strong>Jumlah Donasi:</strong>
                        <span>Rp<?= number_format($donasi['nominal'], 0, ',', '.'); ?></span>
                    </p>
                <?php endwhile; ?>
            <?php else: ?>
                <p><span>Belum ada riwayat donasi.</span></p>
            <?php endif; ?>
        </section>

        <section class="profile-info">
            <h3>Gerakan yang Diikuti</h3>
            <?php if ($result_gerakan->num_rows > 0): ?>
                <?php while ($gerakan = $result_gerakan->fetch_assoc()): ?>
                    <p>
                        <strong>Judul Gerakan:</strong>
                        <span><?= htmlspecialchars($gerakan['judul_gerakan']); ?></span>

                        <strong>Tanggal Bergabung:</strong>
                        <span><?= date('d M Y', strtotime($gerakan['tanggal_ikut'])); ?></span>
                    </p>
                <?php endwhile; ?>
            <?php else: ?>
                <p><span>Belum mengikuti gerakan apapun.</span></p>
            <?php endif; ?>
        </section>

        <a href="../../index.php" class="back-button">← Kembali ke Beranda</a>
    </main>
</div>

<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('closed');
        document.querySelector('.container').classList.toggle('sidebar-closed');
    }
</script>

</body>
</html>
