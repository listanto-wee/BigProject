<?php
include('konfigurasi/koneksi.php');
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - LaporAja!</title>
    <link rel="stylesheet" href="style.css">
    
</head>
<body>
     <header>
        <img>
        <nav>
            <ol>
                <li><a href="#alur" id="aheader">Beranda</a></li>
                <li><a href="#statistik" id="aheader">Laporanku</a></li>
                <li><a href="" id="aheader">Feed</a></li>
                <li><a href="#" id="aheader">Peta Laporan</a></li>
            </ol>
        </nav>
        <button></button>
    </header>
    <main>
        <section id="section1">
            <div class="title">
                <div id="titletext">
                    <h1>Lapor Masalah Disekitar Anda,<br> Dengan Mudah & Cepat</h1>
                    <h2>Platform Laporan Masyarakat Mandiri</h2>
                    <button>Lapor Sekarang!</button>
                </div>
                <div id="alur"><br><br>
                    <label>Alur Laporan</label>
                    <div>
                        <table>
                            <tr class="jalur">
                                <th><label>1</label></th>
                                <td rowspan="3"><img class="arrow"></td>
                                <th><label>2</label></th>
                                <td rowspan="3"><img class="arrow"></td>
                                <th><label>3</label></th>
                            </tr>
                            <tr>
                                <th>ISI LAPORAN</th>
                                <th>KIRIM OTOMATIS</th>
                                <th>PANTAU STATUS</th>
                            </tr>
                            <tr>
                                <td>Isi formulir & tambahkan foto.</td>
                                <td>Sistem mengirim laporan ke instansi tujuan.</td>
                                <td>Gunakan kode tracking untuk memantau.</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg">
            <img style="position: absolute; opacity: 0.2;" src="Gambar/idn.png" alt="None">
            <img src="Gambar/Bg.png" alt="None">
        </section>

        <section id="section2">
            <div id="statistik">
                   <table>
                       <tr id="stastistik-head">
                           <th>200</th>
                           <th>Infrastruktur</th>
                           <th>70%</th>
                       </tr>
                       <tr>
                           <td>Laporan Hari Ini</td>
                           <td>Kategori Laporan Terbanyak</td>
                           <td>Laporan Ditindaklanjuti</td>
                       </tr>
                   </table>
                   <h3><label>Selasa,2 November 2025</label></h3>
               </div>
        </section>
        <section id="section3">
            <div id="feed">
                    <h3><label>Feed</label></h3>
                    <div class="postfeed">

                        <?php
                $result = mysqli_query($con,"SELECT * FROM laporan ORDER BY id_laporan DESC LIMIT 6");
                while($row = mysqli_fetch_assoc($result)){
                 $laporan = 'laporan.php?id=' . htmlspecialchars($row['id_laporan']);
                ?>
                        <a href="<?php echo $laporan;?>"><div class="posts">
                            <div class="image" style="background-image: url('Gambar/<?php echo $row['file']; ?>');"></div>
                                <article>
                                    <h4><?php echo $row['judul']; ?></h4>
                                    <p><label>Kecamatan Pituruh</label><label> - </label><label><?php echo $row['tanggal']; ?></label><label> - </label><label><?php echo $row['kategori']; ?></label></p>
                                    <label><p>Status : <button><?php echo $row['status']; ?></button></p></label>
                                </article>
                            </div></a>
                            <?php } ?>
                        </div>

        </section>
        
    </main>
    <footer>
        <section>
            <div>
                ulalau
            </div>
        </section>
        <div>
            <label>© 2025 Universitas Muhammadiyah Purworejo</label>
            <label>Tugas - Pemrograman - web</label>
        </div>
    </footer>
</body>
</html>