<?php
session_start();  
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="icon" type="image/png" href="../assets/images/logo2.png">
    <link rel="stylesheet" href="../assets/css/about.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <!-- Bagian Header -->
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

    <main>
        <!-- Section Hero -->
        <section class="hero">
            <div class="overlay"></div>
            <h1>“Pecinta Alam adalah pusat transfer informasi dan pengetahuan digital mengenai aliran limbah”</h1>
        </section>

        <!-- Section Content -->
        <section class="vision-section">
            <div class="video-container">
                <!-- Video Section -->
                <video autoplay muted loop>
                    <source src="../assets/video/1127.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
            <div class="content">
                <h2>Our Vision</h2>
                <p>
                    Kami percaya pada permintaan besar untuk perubahan lingkungan di Asia Tenggara. 
                    Kami menyadari bahwa generasi muda Asia yang sebagian besar aktif di media sosial mulai menyadari ancaman perubahan iklim 
                    dan dampak negatif dari pencemaran lingkungan.
                </p>
                <p>
                    Kami yakin bahwa pada tahun 2020-an kesadaran akan semakin meningkat seiring dengan berkembangnya ekonomi sirkular.
                    Misi kami adalah menyediakan pengetahuan, informasi faktual, dan pemahaman bersama lintas sektor
                    dan populasi di Asia Tenggara.
                </p>
            </div>
        </section>

        <section class="about-us">
            <div class="title">
              <h1>About Us</h1>
              <p>Pecinta Alam adalah organisasi yang peduli terhadap lingkungan dan beraksi untuk menjaga kelestarian alam</p>
            </div>
            <div class="image-gallery">
              <img src="../assets/images/gambar1.jpg" alt="Activity 1">
              <img src="../assets/images/gambar2.jpg" alt="Activity 2">
              <img src="../assets/images/gambar3.jpg" alt="Activity 3">
              <img src="../assets/images/gambar4.jpg" alt="Activity 4">
              <img src="../assets/images/gambar5.jpg" alt="Activity 5">
            </div>
            <div class="description">
              <p>Danftz memiliki pengalaman dalam ekonomi sirkular plastik selama bertahun-tahun. Ia meneliti dan menyelidiki rantai pasokan plastik dan telah menerbitkan beberapa artikel, dokumenter, dan sebuah buku.</p>
              <a href="https://www.instagram.com/danftz_08/profilecard/?igsh=dWIwa2ZldzVhdDBs"><button>Visit @Danftz</button></a>
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
                        <li><a href="about.php">About</a></li>
                        <li><a href="donasi.php">Donasi</a></li>
                        <li><a href="gerakan.php">Gerakan</a></li>
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
