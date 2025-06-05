<?php
session_start();
session_regenerate_id(true);
include '../config/db.php';

$search_query = "";
if (isset($_POST['search'])) {
    $search_query = trim($_POST['search']);
    $query = "SELECT id_gerakan, judul_gerakan, deskripsi, tanggal_mulai, tanggal_selesai FROM gerakan 
              WHERE (judul_gerakan LIKE ? OR deskripsi LIKE ?) 
              AND (tanggal_selesai IS NULL OR tanggal_selesai >= CURDATE())";
    $stmt = $conn->prepare($query);
    $search_term = "%" . $search_query . "%";
    $stmt->bind_param("ss", $search_term, $search_term);
} else {
    $query = "SELECT id_gerakan, judul_gerakan, deskripsi, tanggal_mulai, tanggal_selesai FROM gerakan 
              WHERE tanggal_selesai IS NULL OR tanggal_selesai >= CURDATE()";
    $stmt = $conn->prepare($query);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerakan yang Bisa Diikuti</title>
    <link rel="icon" type="image/png" href="../assets/images/logo2.png">
    <link rel="stylesheet" href="../assets/css/gerakan.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <!-- Header -->
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
                                <?php echo htmlspecialchars($_SESSION['nama']); ?>
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

    <!-- Gerakan -->
    <section>
    <div class="gerakan-search">
        <h2>Cari Gerakan</h2>
        <form action="gerakan.php" method="POST">
            <input type="text" name="search" placeholder="Cari gerakan..." value="<?php echo htmlspecialchars($search_query); ?>">
            <button type="submit">Cari</button>
        </form>
    </div>

    <div class="gerakan-list">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='gerakan'>";
                echo "<h3>" . htmlspecialchars($row['judul_gerakan']) . "</h3>";
                echo "<p>" . htmlspecialchars($row['deskripsi']) . "</p>";
                echo "<p><strong>Tanggal Mulai:</strong> " . htmlspecialchars($row['tanggal_mulai']) . "</p>";
                echo "<p><strong>Tanggal Selesai:</strong> " . htmlspecialchars($row['tanggal_selesai']) . "</p>";

                // Jika pengguna sudah login, tambahkan tombol untuk mengikuti
                if (isset($_SESSION['id_user'])) {
                    $id_user = $_SESSION['id_user'];
                    $id_gerakan = $row['id_gerakan'];

                    // Cek apakah pengguna sudah mengikuti gerakan ini
                    $check_follow = "SELECT * FROM pengguna_gerakan WHERE id_user = ? AND id_gerakan = ?";
                    $stmt_check = $conn->prepare($check_follow);
                    $stmt_check->bind_param("ii", $id_user, $id_gerakan);
                    $stmt_check->execute();
                    $result_check = $stmt_check->get_result();

                    if ($result_check->num_rows > 0) {
                        echo "<button disabled>Sudah Mengikuti</button>";
                    } else {
                        echo "<a href='proses/ikuti_gerakan.php?id=" . $id_gerakan . "'><button>Ikuti Gerakan</button></a>";
                    }
                    $stmt_check->close();
                }
                echo "</div>";
            }
        } else {
            echo "<p>Tidak ada gerakan yang tersedia.</p>";
        }
        ?>
    </div>
</section>

    <!-- Tambah Gerakan -->
    <div class="tambah-gerakan">
        <a href="tambah_gerakan.php"><button>Tambah Gerakan Baru</button></a>
    </div>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h2>Tentang Kami</h2>
                <p>Komunitas peduli lingkungan yang menginisiasi gerakan untuk bumi lebih baik.</p>
            </div>
            <div class="footer-section">
                <h2>Navigasi</h2>
                <ul>
                    <li><a href="../index.php">Beranda</a></li>
                    <li><a href="about.php">About</a></li>
                    <li><a href="donasi.php">Donasi</a></li>
                </ul>
            </div>
            <div class="footer-section socials">
                <h2>Ikuti Kami</h2>
                <a href="#"><i class='bx bxl-facebook'></i></a>
                <a href="#"><i class='bx bxl-instagram'></i></a>
                <a href="#"><i class='bx bxl-twitter'></i></a>
            </div>
        </div>
        <div class="footer-bottom">
            &copy; <?= date('Y') ?> Komunitas Pecinta Alam. All rights reserved.
        </div>
    </footer>
</body>
</html>


