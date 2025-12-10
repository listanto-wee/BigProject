<?php
    include('konfigurasi/koneksi.php');
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $idlaporan = mysqli_real_escape_string($con, $_GET['id']);
        $query = "SELECT * FROM laporan WHERE id_laporan = $idlaporan";
        $result = mysqli_query($con, $query);}

    if (mysqli_num_rows($result) > 0) {
        $post = mysqli_fetch_assoc($result);
        $judul = htmlspecialchars($post ['judul']);
    }


       
        
    ?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
    <header>
        <img>
        <nav>
            <ol>
                <li><a href="#alur">Beranda</a></li>
                <li><a href="#statistik">Laporanku</a></li>
                <li><a href="">Feed</a></li>
                <li><a href="#">Peta Laporan</a></li>
            </ol>
        </nav>
        <button></button>
    </header>
    <div class="posts">
        <h1><?php echo $judul; ?></h1>
    </div>
</body>
</html>