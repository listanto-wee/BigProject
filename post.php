<?php
    // koneksi.php harus sudah ter-include di sini
    include('konfigurasi/koneksi.php');

    if(isset($_POST['submit'])){

        // Pengecekan dasar apakah ada file yang diunggah dan tidak ada error
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            
            $file_name = $_FILES['image']['name'];
            $tempname = $_FILES['image']['tmp_name'];
            // Direktori tujuan harus konsisten. 
            $folder = 'Gambar/'.$file_name; 

            // Ambil data POST
            $judul = $_POST['judul'];
            $isi = $_POST['isi'];
            $status = $_POST['status'];
            // Pastikan Anda mendapatkan nilai 'tanggal' dari POST jika diperlukan
            $tanggal = $_POST['tanggal']; 
            $pengirim = $_POST['pengirim'];

            $kategori = $_POST['kategori'];
            // Perbaikan: Pastikan kategoriCustom memiliki atribut name="kategoriCustom" di HTML
            if($kategori == 'custom' && isset($_POST['kategoriCustom'])) {
                $kategori = $_POST['kategoriCustom'];
            }

            // PENTING: Pindahkan file
            if (move_uploaded_file($tempname, $folder)) {
                // File berhasil dipindahkan, lanjutkan simpan ke database
                
                // PERHATIAN: Ini adalah SQL query yang rentan SQL Injection!
                // Harap gunakan prepared statements untuk produksi.
                $query = mysqli_query($con, "INSERT INTO laporan (file, judul, isi, tanggal, kategori, status, pengirim) VALUES ('$file_name', '$judul','$isi','$tanggal', '$kategori', '$status','$pengirim')");

                if($query){
                    header("Location: post.php");
                    exit();
                } else {
                    echo "<h2>Gagal menyimpan data ke database: " . mysqli_error($con) . "</h2>";
                    // Opsional: Hapus file yang sudah terunggah jika gagal simpan ke DB
                    // unlink($folder); 
                }
            } else {
                // KASUS 1: move_uploaded_file gagal (kemungkinan besar karena izin folder)
                echo "<h2>Gagal memindahkan file yang diunggah. Cek izin tulis untuk folder 'Gambar/'.</h2>";
            }
        } else {
             // KASUS 2: Tidak ada file yang diunggah atau terjadi error unggah PHP
            echo "<h2>Gagal mengunggah file. Pastikan Anda memilih file dan ukuran file tidak melebihi batas.</h2>";
            // Untuk debugging, Anda bisa menampilkan kode error: $_FILES['image']['error']
        }
    } 
    // Hapus blok 'else' di sini, karena akan dieksekusi setiap kali halaman dimuat pertama kali
    /* else {
        echo "<h2>Gagal memindahkan file yang diunggah. Cek izin folder 'Gambar/database/'.</h2>";
    } */

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>


    <style>
        *{
            font-family: Arial, Helvetica, sans-serif;
        }
        a{
            text-decoration: none;
        }

        .posts{
            display: flex;
            padding: 15px 0px 15px 0px;
            margin: 5px;
            background-color: white; 
            border-radius: 15px; 
            width: 28%;
            box-shadow: 0px 10px 15px -3px rgba(0, 0, 0, 0.1);
            position: relative;
            display: inline-block;
         }

        .posts h4{
            overflow-wrap: break-word;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            line-height: 1.4em; /* Tinggi satu baris */
            height: 2.8em;
            overflow: hidden;
            text-align: left;
            font-size: larger;
            margin: 10px 0px 10px 0px;
         }
        .posts .image{
            position: relative;
            left: 50%;
            transform: translate(-50%);
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            background-color: #33a3d8;
            width: 100%;
            height: 250px;
            background-color: aliceblue;
         }
        .posts article{
            margin: 0px 20px 0px 20px;
         }

        .posts label{
            font-size: medium;
            font-weight: bolder;
            text-align: left;
            
         }
        .posts p{
            margin: 0;
            font-size: medium;
            text-align: left;
            border-radius: 5px;
            margin: 5px 0px 5px 0px;
         }
        .posts p button{
            position: relative;
            z-index: 2;
            width: 80px;
            height: 25px;
            border: 0px;
            background-color: rgb(234, 255, 234);
            color: green;
            border: 1px solid green;
            border-radius: 20px;
            font-size: small;
            font-weight: normal;
         }
        .posts p button:hover{
            cursor: default;
         }
    </style>
</head>
<body>
    <form method="POST" enctype="multipart/form-data" name="image">
        <input type="file" name="image"><br>
        
        <div id="customInput" style="display:none;">
            <input type="text" id="kategoriCustom" placeholder="Tulis kategori sendiri">
        </div>
        
        <input type="text" name="judul" placeholder="judul" required>
        <input type="text" name="isi" placeholder="isi" required>
        <input type="text" name="status" placeholder="status" required>
        <input type="text" hidden name="tanggal" id="tanggal">
        <input type="text" name="pengirim" placeholder="pengirim" required>

        <select name="kategori" id="kategori" onchange="cekCustom()">
            <option value="infrastruktur">Infrastruktur</option>
            <option value="pemerintahan">Pemerintahan</option>
            <option value="becanaalam">Bencana Alam</option>
            <option value="custom">Custom...</option>
        </select>
        <br>
        <br><br>
        <button type="submit" name="submit">Submit</button>
    </form>


    <div>
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
                            </article></a>
                    </div>
        <?php } ?>
    </div>

    <script>
                function cekCustom(){
                    let pilih = document.getElementById("kategori").value;
                    let customBox = document.getElementById("customInput");
                    console.log(pilih)

                    if(pilih === "custom"){
                        customBox.style.display = "block";
                    } else {
                        customBox.style.display = "none";
                    }
                }
                    function formatTanggalNamaBulan(tanggal) {
                        
                        const options = {
                            day: '2-digit',     
                            month: 'long',       
                            year: 'numeric'     
                        };
                        const tanggalTerformat = tanggal.toLocaleDateString('id-ID', options);
                        
                        return tanggalTerformat;
                    }

                  
                    const tanggalSaatIni = new Date();
                    const hasilFormat = formatTanggalNamaBulan(tanggalSaatIni);

                    console.log(hasilFormat); // Output: "05 Desember 2025"

                    const d = tanggalTerformat;
                    document.getElementById("tanggal").value = d;
    </script>

</body>
</html>