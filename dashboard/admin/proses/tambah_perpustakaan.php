<?php
session_start();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Buku</title>
    <link rel="stylesheet" href="../../../assets/css/create.css">
</head>
<body>

    <h1>Tambah Buku ke Perpustakaan</h1>

    <?php
    $conn = new mysqli("localhost", "root", "", "pecinta_allam");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $judul = $_POST["judul"];
        $penulis = $_POST["penulis"];
        $kategori = $_POST["kategori"];
        $tahun = $_POST["tahun_terbit"];
        $deskripsi = $_POST["deskripsi"];
        $id_user = $_POST["id_user"];

        $query = "INSERT INTO perpustakaan (judul, penulis, kategori, tahun_terbit, deskripsi, id_user) 
                  VALUES ('$judul', '$penulis', '$kategori', '$tahun', '$deskripsi', '$id_user')";

        if ($conn->query($query) === TRUE) {
            echo '<div class="success">Data buku berhasil ditambahkan ke perpustakaan.</div>';
        } else {
            echo '<div class="error">Gagal menambahkan data: ' . $conn->error . '</div>';
        }
    }
    ?>

    <form method="post">
        <label>Judul</label>
        <input type="text" name="judul" required>

        <label>Penulis</label>
        <input type="text" name="penulis" required>

        <label>Kategori</label>
        <input type="text" name="kategori" required>

        <label>Tahun Terbit</label>
        <input type="text" name="tahun_terbit" required>

        <label>Deskripsi</label>
        <input type="text" name="deskripsi" required>

        <label>ID User</label>
        <input type="text" name="id_user" required>

        <button type="submit">Tambah Buku</button>
    </form>

</body>
</html>
