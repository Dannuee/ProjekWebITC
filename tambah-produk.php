<?php 
    session_start();
    include 'db.php';
    if ($_SESSION['status_login'] != true) {
        echo '<script>window.location="login.php"</script>';
    }
    $query = mysqli_query($conn, "SELECT * FROM login_user WHERE id_username = '".$_SESSION['id']."' ");
    $data = mysqli_fetch_object($query);
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <title>Tambah Produk</title>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container">
            <h1><a href="dashboard.php">CyberStation</a></h1>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="produk.php">Data Produk</a></li>
                <li><a href="logout.php">Log Out</a></li>
            </ul>
        </div>
    </header>

    <!-- Content -->
    <div class="content">
        <div class="container">
            <h3>Tambah Data</h3>
            <div class="box">
                <form action="" method="POST" enctype="multipart/form-data">
                    <select name="kategori" class="input-control">
                        <option value="">--Pilih--</option>
                        <option value="Game">Game</option>
                        <option value="Laptop">Laptop</option>
                        <option value="Electronic Tools">Peralatan Elektronik</option>
                        <option value="Sparepart">SparePart Computer</option>
                    </select>
                    <input type="text" name="p_name" placeholder="Nama Produk" class="input-control" required>
                    <input type="text" name="p_price" placeholder="Harga Produk" class="input-control" required>
                    <input type="file" name="p_pict" class="input-control" required>
                    <textarea name="p_desc" cols="30" class="input-control" rows="10" placeholder="Deskripsi Produk"></textarea>
                    <select name="status" class="input-control">
                        <option>--Status--</option>
                        <option value="0">Tidak Aktif</option>
                        <option value="1">Aktif</option>
                    </select>
                    
                    <input type="submit" id="submit" name="submit" value="Submit" class="btn">
                </form>
                <?php 
                    if (isset($_POST['submit'])) {
                        // Menampung isi dari form
                        $kategori   = $_POST['kategori'];
                        $p_name     = $_POST['p_name'];
                        $p_price    = $_POST['p_price'];
                        $p_desc     = $_POST['p_desc'];
                        $status     = $_POST['status'];

                        // menampung data file yang diupload
                        $filename   = $_FILES['p_pict']['name'];
                        $tmp_name   = $_FILES['p_pict']['tmp_name'];
                        $type1      = explode('.', $filename);
                        $type2      = $type1[1];
                        $newname    = 'Produk '.time().'.'.$type2;

                        // menampung format file yang diizinkan untuk upload
                        $izin_tipe  = array('jpg','jpeg','png');

                        // validasi format file
                        if (!in_array($type2,$izin_tipe)) {
                            echo '<script>alert("Format file tidak diizinkan!")</script>';
                        }else{
                            // proses upload dan insert ke db jika berhasil melewati validasi
                            move_uploaded_file($tmp_name, './pict-product/'.$newname);

                            $insert = mysqli_query($conn, "INSERT INTO product VALUES (
                                null,
                                '".$kategori."',
                                '".$p_price."',
                                '".$p_desc."',
                                '".$newname."',
                                '".$status."',
                                null,
                                '".$p_name."' )");

                            if ($insert) {
                                echo '<script>alert("Data Produk Berhasi di Upload")</script>';
                                echo '<script>window.location=("produk.php")</script>';
                            }else{
                                echo '<script>alert("Data gagal di upload!".mysqli_error($conn))</script>';
                            }
                        }
                    }
                 ?>
            </div>
            <br><br>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <small>Copyright &copy; 2022 CyberStation</small>
        </div>
    </footer>
</body>
</html>