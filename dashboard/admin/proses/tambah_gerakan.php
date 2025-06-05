<?php
session_start();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Gerakan</title>
    <link rel="stylesheet" href="../../../assets/css/create.css"> 
</head>
<body>

    <h1>Tambah Gerakan</h1>

    <form action="tambah_gerakan_proses.php" method="post">
        <label for="judul_gerakan">Nama Gerakan</label>
        <input type="text" id="nama_gerakan" name="judul_gerakan" required>

        <label for="deskripsi">Deskripsi</label>
        <input type="text" id="deskripsi" name="deskripsi" required>

        <label for="lokasi">Lokasi</label>
        <input type="text" id="lokasi" name="lokasi">

        <label for="tanggal_mulai">Tanggal Mulai</label>
        <input type="date" id="tanggal_mulai" name="tanggal_mulai" required>

        <label for="tanggal_selesai">Tanggal Selesai</label>
        <input type="date" id="tanggal_selesai" name="tanggal_selesai" required>



        <button type="submit">Tambah Gerakan</button>
    </form>

</body>
</html>
