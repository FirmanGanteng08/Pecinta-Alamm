<?php
include '../../../config/db.php';

// Jika ada pengiriman form POST (update data)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_user = $_POST['id_user'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $current_password = $_POST['current_password'];
    $peran = $_POST['peran'];
    $status_akun = $_POST['status_akun'];
    $no_telepon = $_POST['no_telepon'];

    // Gunakan password lama jika tidak ingin mengubah
    if (empty($password)) {
        $password_to_save = $current_password;
    } else {
        $password_to_save = password_hash($password, PASSWORD_DEFAULT);
    }

    // Update data menggunakan prepared statement
    $stmt = $conn->prepare("UPDATE pengguna SET nama = ?, email = ?, password = ?, peran = ?, status_akun = ?, no_telepon = ? WHERE id_user = ?");
    $stmt->bind_param("ssssssi", $nama, $email, $password_to_save, $peran, $status_akun, $no_telepon, $id_user);
    
    if ($stmt->execute()) {
        echo "<script>alert('Data berhasil diperbarui'); window.location.href = '../pengguna.php';</script>";
        exit;
    } else {
        echo "<div class='error'>Terjadi kesalahan saat memperbarui data!</div>";
    }

    $stmt->close();
}

// Ambil data pengguna jika ID diberikan
if (isset($_GET['id_user'])) {
    $id_user = $_GET['id_user'];

    $stmt = $conn->prepare("SELECT * FROM pengguna WHERE id_user = ?");
    $stmt->bind_param("i", $id_user);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "<div class='error'>Pengguna tidak ditemukan!</div>";
        exit;
    }

    $stmt->close();
} else {
    echo "<div class='error'>ID pengguna tidak ditemukan!</div>";
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Update Profil Pengguna</title>
    <link rel="stylesheet" href="../../../assets/css/create.css">
</head>
<body>
    <h1>Update Profil Pengguna</h1>
    <form method="POST">
        <input type="hidden" name="id_user" value="<?= htmlspecialchars($user['id_user']) ?>">
        <input type="hidden" name="current_password" value="<?= htmlspecialchars($user['password']) ?>">

        <label for="nama">Nama:</label>
        <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($user['nama']) ?>" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

        <label for="password">Password (kosongkan jika tidak ingin diubah):</label>
        <input type="password" id="password" name="password">

        <label for="peran">Peran:</label>
        <select id="peran" name="peran" required>
            <option value="pengguna" <?= $user['peran'] === 'pengguna' ? 'selected' : '' ?>>Pengguna</option>
            <option value="kolaborator" <?= $user['peran'] === 'kolaborator' ? 'selected' : '' ?>>Kolaborator</option>
            <option value="admin" <?= $user['peran'] === 'admin' ? 'selected' : '' ?>>Admin</option>
        </select>

        <label for="status_akun">Status Akun:</label>
        <select name="status_akun" required>
            <option value="aktif" <?= $user['status_akun'] === 'aktif' ? 'selected' : '' ?>>Aktif</option>
            <option value="nonaktif" <?= $user['status_akun'] === 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
            <option value="suspend" <?= $user['status_akun'] === 'suspend' ? 'selected' : '' ?>>Suspend</option>
        </select>

        <label for="no_telepon">No Telepon:</label>
        <input type="text" id="no_telepon" name="no_telepon" value="<?= htmlspecialchars($user['no_telepon']) ?>">

        <button type="submit">Perbarui Pengguna</button>
    </form>
</body>
</html>
