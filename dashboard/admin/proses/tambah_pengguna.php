<?php
session_start();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pengguna</title>
    <link rel="stylesheet" href="../../../assets/css/create.css">
</head>
<body>
    <h1>Tambah Pengguna</h1>

    <?php
    if (isset($_GET['status'])) {
        if ($_GET['status'] === 'success') {
            echo "<p class='success'>Pengguna berhasil ditambahkan!</p>";
        } elseif ($_GET['status'] === 'error') {
            echo "<p class='error'>Terjadi kesalahan, coba lagi.</p>";
        } elseif ($_GET['status'] === 'duplicate') {
            echo "<p class='error'>Email sudah terdaftar.</p>";
        }
    }
    ?>

    <form action="tambah_pengguna_process.php" method="POST">
        <label for="nama">Nama:</label>
        <input type="text" id="nama" name="nama" required minlength="3" maxlength="50" autocomplete="off">

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required minlength="6">

        <label for="peran">Peran:</label>
        <select id="peran" name="peran" required>
            <option value="pengguna">Pengguna</option>
            <option value="kolaborator">Kolaborator</option>
            <option value="admin">Admin</option>
        </select>

        <label for="no_telepon">No Telepon:</label>
        <input type="text" id="no_telepon" name="no_telepon" required maxlength="15">

        <label for="status_akun">Status Akun:</label>
        <select name="status_akun" required>
            <option value="aktif">Aktif</option>
            <option value="nonaktif">Nonaktif</option>
            <option value="suspend">Suspend</option>
        </select>
        
        <button type="submit">Tambah Pengguna</button>
    </form>
</body>
</html>
