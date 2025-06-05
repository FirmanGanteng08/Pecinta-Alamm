<?php
session_start();

// Cek apakah sudah login
if (!isset($_SESSION['id_user'])) {
    header("Location: ../login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Pengguna</title>
    <link rel="stylesheet" href="../../assets/css/dashboard.css">
</head>
<body>
    <div class="container">
        <aside>
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
                <button id="toggleBtn">☰</button>
                <h2>Profil Pengguna - <?= htmlspecialchars($_SESSION['nama']); ?> 👋</h2>
            </header>
            <div class="content">
                <div class="profile-info">
                    <h3>Informasi Profil</h3>
                        <p><strong>Nama:</strong> <?= htmlspecialchars($_SESSION['nama']); ?></p>
                        <p><strong>No Telepon:</strong> <?= isset($_SESSION['no_telepon']) ? htmlspecialchars($_SESSION['no_telepon']) : 'Tidak tersedia'; ?></p>
                        <p><strong>Email:</strong> <?= isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : 'Tidak tersedia'; ?></p>
                </div>

            </div>


                <a class="back-button" href="../../auth/logout.php">Logout</a>
            </div>
        </main>

    <script>
        // Toggle sidebar functionality
        document.getElementById('toggleBtn').addEventListener('click', function() {
            document.querySelector('aside').classList.toggle('closed');
            document.querySelector('.container').classList.toggle('sidebar-closed');
        });
    </script>
</body>
</html>
