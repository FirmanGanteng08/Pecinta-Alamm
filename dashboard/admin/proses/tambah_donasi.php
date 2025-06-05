<?php
session_start();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Donasi</title>
    <link rel="stylesheet" href="../../../assets/css/create.css"> 
</head>
<body>

    <h1>Tambah Donasi</h1>

    <?php
    $conn = new mysqli("localhost", "root", "", "pecinta_allam");

    if ($conn->connect_error) {
        die("<div class='error'>Koneksi gagal: " . $conn->connect_error . "</div>");
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nama = $_POST["nama"];
        $email = $_POST["email"];
        $nominal = $_POST["nominal"];
        $tanggal = $_POST["tanggal"];
        $id_user = $_POST["id_user"];

        $query = "INSERT INTO donasi (nama, email, nominal, tanggal, id_user) 
                  VALUES ('$nama', '$email', '$nominal', '$tanggal', '$id_user')";

        if ($conn->query($query) === TRUE) {
            header('Location: ../donasi.php?status=success');
            echo '<div class="success">Data donasi berhasil ditambahkan.</div>';
        } else {
            echo '<div class="error">Gagal menambahkan data: ' . $conn->error . '</div>'; 
        }

        
    }
    ?>

    <form method="post">
        <label for="nama">Nama</label>
        <input type="text" id="nama" name="nama" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>

        <label for="nominal">Jumlah Donasi</label>
        <input type="text" id="nominal" name="nominal" required>

        <label for="tanggal">Tanggal</label>
        <input type="date" id="tanggal" name="tanggal" required>

        <label for="id_user">ID User</label>
        <input type="text" id="id_user" name="id_user" required>

        <button type="submit">Tambah Donasi</button>
    </form>

</body>
</html>
