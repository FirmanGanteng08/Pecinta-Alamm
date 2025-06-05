<?php
session_start();  
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Komunitas Pecinta Alam adalah organisasi yang peduli terhadap lingkungan dan beraksi untuk menjaga kelestarian alam.">
    <title>Pecinta Alam</title>
    <link rel="icon" type="image/png" href="assets/images/logo2.png">
    <link rel="stylesheet" href="assets/css/index.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <!-- Bagian Header -->
    <header>
        <div class="navbar-container">
            <div class="logo">
                <img src="assets/images/logo1.png" alt="Logo Komunitas Pecinta Alam">
            </div>
            <nav id="nav-menu" role="navigation" aria-label="Main Navigation">
                <ul>
                    <li><a href="index.php">Beranda</a></li>
                    <li><a href="pages/about.php">About</a></li>
                    <li><a href="pages/donasi.php">Donasi</a></li>
                    <li><a href="pages/gerakan.php">Gerakan</a></li>
                    <li><a href="pages/perpustakaan.php">Perpustakaan</a></li>
                    <?php if (isset($_SESSION['nama'])): ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle">
                                <?php echo $_SESSION['nama']; ?> <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <?php if ($_SESSION['peran'] === 'admin' || $_SESSION['peran'] === 'kolaborator'): ?>
                                    <li><a href="dashboard/admin/dashboard.php">Dashboard</a></li>
                                <?php else: ?>
                                    <li><a href="dashboard/user/dashboard.php">Dashboard</a></li>
                                <?php endif; ?>
                                <li><a href="auth/logout.php">Logout</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li><a href="auth/login.php">Login</a></li>
                        <li><a href="auth/register.php">Register</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Konten Utama -->
    <main class="hero">
        <section>
            <div class="overlay"></div>
            <div class="video-background-container">
                <video autoplay muted loop class="background-video">
                    <source src="assets/video/1127.mp4" type="video/mp4">
                    Browser Anda tidak mendukung video.
                </video>
                <div class="overlay"></div>
                <div class="content">
                    <h1>Selamat Datang di Komunitas Pecinta Alam</h1>
                    <p>Kami peduli dan beraksi untuk lingkungan yang lebih baik.</p>
                    <a href="about.php" class="btn">Pelajari Lebih Lanjut</a>
                </div>
            </div>
        </section>
        
        <section>
            <div class="conteiners">
                <p>"Kami berupaya meningkatkan pola pikir dan pemahaman masyarakat tentang bumi tempat kita tinggal. Kami percaya bahwa masyarakat dan lembaga akan mengubah perilaku mereka dalam kondisi pengetahuan lingkungan yang berubah."</p>
            </div>
        </section>
    </main>

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
                        <li><a href="pages/about.php">About</a></li>
                        <li><a href="pages/donasi.php">Donasi</a></li>
                        <li><a href="pages/gerakan.php">Gerakan</a></li>
                        <li><a href="pages/perpustakaan.php">Perpustakaan</a></li>
                        <li><a href="pages/informasi.php">Informasi</a></li>
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
