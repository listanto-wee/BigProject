<?php
    include('dbconnection.php');

    if(isset($_POST['submit'])){
        $file_name = $_FILES['image']['name'];
        $tempname = $_FILES['image']['tmp_name'];
        $folder = 'Gambar/database/' .$file_name;

        $caption = $_POST['caption'];

        $kategori = $_POST['kategori'];
        if($kategori == 'custom')
            $kategori =$_POST['kategoriCustom'];

        $query = mysqli_query($con,"INSERT INTO images (file, caption, kategori) VALUES ('$file_name', '$caption', '$kategori')");
        

            header("Location: Upload.php");
        exit();
    } else {
        echo "<h2>Upload file gagal</h2>";
    }



?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>


    <style>

        .posts{
            display: flex;
            padding: 30px;
            background-color: aquamarine; 
            border-radius: 15px; 
            width: 15%;

            position: relative;
            display: inline-block;
        }
    </style>
</head>
<body>
    <form method="POST" enctype="multipart/form-data" name="image">
        <input type="file" name="image"><br>
        <select name="kategori" id="kategori" onchange="cekCustom()">
            <option value="infrastruktur">Infrastruktur</option>
            <option value="pemerintahan">Pemerintahan</option>
            <option value="becanaalam">Bencana Alam</option>
            <option value="custom">Custom...</option>
        </select>
        <br>

        <div id="customInput" style="display:none;">
            <input type="text" id="kategoriCustom" placeholder="Tulis kategori sendiri">
        </div>

        <input type="text" name="caption" required>
        <br><br>
        <button type="submit" name="submit">Submit</button>
    </form>


    <div>
            <?php
            $res = mysqli_query($con,"select * from images");
            while($row = mysqli_fetch_assoc($res)){
            ?>

            <div style="
                display: flex;
                margin: 20px;
                float: left;
                position: relative;
                background-color: aquamarine; 
                border-radius: 15px; 
                width: 25%;
            ">

            <article style="
                margin: 10px 10px 0px 10px;
                text-align: left;
                width: 100%;
            ">
                <div  style="
                width: 100%;
                height: 200px;
                background-image: url('Gambar/database/<?php echo $row['file']; ?>');
                background-size: cover;
                background-position: center;
                border-radius: 10px;
                margin-bottom: 10px;
            "></div>
            
            <p style="
                position: relative;
                display: inline-block;
                "><?php echo $row['kategori']; ?>
            </p> <br>

            <p style="
                position: relative;
                display: inline-block;
                "><?php echo $row['caption']; ?>
            </p>

            </article>
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
    </script>

</body>
</html>