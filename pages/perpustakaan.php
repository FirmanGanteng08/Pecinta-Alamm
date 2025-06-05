<?php
// Mulai session
session_start();

// Menghubungkan ke database
include '../config/db.php';

// Ambil data informasi alam
$sql = "SELECT id_perpustakaan, judul, kategori, tahun_terbit FROM perpustakaan";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Informasi Alam</title>
    <link rel="stylesheet" href="../assets/css/perpustakaan.css">
    <link rel="icon" type="image/png" href="../assets/images/logo2.png">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>

    <!-- Bagian Header -->
    <header>
        <div class="navbar-container">
            <div class="logo">
                <img src="../assets/images/logo1.png" alt="Logo Komunitas Pecinta Alam">
            </div>
            <nav id="nav-menu" role="navigation" aria-label="Main Navigation">
                <ul>
                    <li><a href="../index.php">Beranda</a></li>
                    <li><a href="about.php">About</a></li>
                    <li><a href="donasi.php">Donasi</a></li>
                    <li><a href="gerakan.php">Gerakan</a></li>
                    <li><a href="perpustakaan.php">Perpustakaan</a></li>
                    <?php if (isset($_SESSION['nama'])): ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle">
                                <?php echo $_SESSION['nama']; ?> <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <?php if ($_SESSION['peran'] === 'admin' || $_SESSION['peran'] === 'kolaborator'): ?>
                                    <li><a href="../dashboard/admin/dashboard.php">Dashboard</a></li>
                                <?php else: ?>
                                    <li><a href="../dashboard/user/dashboard.php">Dashboard</a></li>
                                <?php endif; ?>
                                <li><a href="../auth/logout.php">Logout</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li><a href="../auth/login.php">Login</a></li>
                        <li><a href="../auth/register.php">Register</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

<div class="container">
    <h2>Daftar Buku Alam</h2>
    <table>
        <tr>
            <th>Judul</th>
            <th>Kategori</th>
            <th>Tahun Terbit</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?= htmlspecialchars($row['judul']) ?></td>
            <td><?= htmlspecialchars($row['kategori']) ?></td>
            <td><?= htmlspecialchars($row['tahun_terbit']) ?></td>
            <td><a href="proses/detail_alam.php?id=<?= $row['id_perpustakaan'] ?>">Lihat Detail</a></td>
        </tr>
        <?php } ?>
    </table>
</div>

<!-- Footer -->
<footer>
    <div class="containers">
        <div class="footer-content">
            <div class="footer-section about">
                <h2>Tentang Kami</h2>
                <p>Kami adalah komunitas yang peduli terhadap lingkungan dan alam.</p>
            </div>
            <div class="footer-section links">
                <h2>Menu</h2>
                <ul>
                    <li><a href="../index.php">Beranda</a></li>
                    <li><a href="about.php">About</a></li>
                    <li><a href="donasi.php">Donasi</a></li>
                    <li><a href="gerakan.php">Gerakan</a></li>
                    <li><a href="informasi.php">Informasi</a></li>
                </ul>
            </div>
            <div class="footer-section contact">
                <h2>Kontak Kami</h2>
                <p>Email: firmandn8@gmail.com</p>
                <p>Telepon: +62 856-4396-6568</p>
                <div class="socials">
                    <a href="#"><i class='bx bxl-facebook-circle'></i></a>
                    <a href="#"><i class='bx bxl-twitter' ></i></a>
                    <a href="https://www.instagram.com/danftz_08/profilecard/?igsh=dWIwa2ZldzVhdDBs"><i class='bx bxl-instagram' ></i></a>
                    <a href="#"><i class='bx bxl-linkedin' ></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy;2025 Website Anda. Semua Hak Dilindungi.</p>
    </div>
</footer>

</body>
</html>
