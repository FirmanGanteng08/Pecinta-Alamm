<?php
session_start();
include_once '../config/db.php';

$row = [
    'nama' => '',
    'email' => ''
];

if (isset($_SESSION['id_user'])) {
    $query = "SELECT * FROM `pengguna` WHERE id_user = " . $_SESSION['id_user'];
    $result = $conn->query($query);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Donasi</title>
    <link rel="icon" type="image/png" href="../assets/images/logo2.png">
    <link rel="stylesheet" href="../assets/css/donasi.css">
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

    <!-- Konten Utama -->
    <div class="container">
        <div class="content">
            <!-- Gambar -->
            <div class="image-section">
                <img src="../assets/images/donasi.jpg" alt="Gambar Donasi">
            </div>
            <!-- Form Donasi -->
            <!-- Array ( [id_user] => 1 [nama] => FirmanDN [email] => firman@gmail.com [password] => $2y$10$xRM3eeZHe8f8TszjD9k.e.M4qeyT7Wn5GcypS82wA.MUaw8NM5/3e [peran] => kolaborator [id_gerakan] => [no_telepon] => 08782657980785 [status_akun] => aktif [tanggal_bergabung] => 2025-02-10 11:18:46 ) -->
            <div class="form-section">
                <h1>Donasi Sekarang</h1>
                <form action="proses/proses_donasi.php" method="POST" enctype="multipart/form-data">
                    <div class="input-group">
                        <label for="nama">Nama Lengkap</label>
                        <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($row['nama']); ?>" required>
                    </div>
                    <div class="input-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="<?= htmlspecialchars($row['email']); ?>" required>
                    </div>
                    <div class="input-group">
                        <label for="nominal">Nominal Donasi</label>
                        <input type="number" id="nominal" name="nominal" min="1000" placeholder="Masukkan nominal donasi (min Rp1.000)" required>
                    </div>
                    <div class="input-group">
                        <label for="bukti">Bukti Transfer <small>(gambar atau pdf, maks. 2MB)</small></label>
                        <input type="file" id="bukti" name="bukti" accept=".jpg,.jpeg,.png,.pdf" required>
                    </div>
                    <button type="submit">Donasi Sekarang</button>
                </form>

                <p class="note">* Semua donasi akan digunakan untuk tujuan kemanusiaan.</p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section about">
                    <h2>Tentang Kami</h2>
                    <p>Kami adalah perusahaan yang bergerak di bidang lingkungan Alam.</p>
                </div>
                <div class="footer-section links">
                    <h2>Menu</h2>
                    <ul>
                        <li><a href="index.php">Beranda</a></li>
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
                        <a href="#"><i class='bx bxl-twitter'></i></a>
                        <a href="https://www.instagram.com/danftz_08/profilecard/?igsh=dWIwa2ZldzVhdDBs"><i
                                class='bx bxl-instagram'></i></a>
                        <a href="#"><i class='bx bxl-linkedin'></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy;2025 Website Anda. Semua Hak Dilindungi.</p>
        </div>
    </footer>

    <script src="../assets/js/href.js"></script>

    <!-- Script untuk Hamburger Menu -->
    <script>
        const hamburger = document.querySelector('.hamburger');
        const navMenu = document.querySelector('nav ul');

        hamburger.addEventListener('click', () => {
            navMenu.classList.toggle('active');
        });
    </script>
</body>

</html>