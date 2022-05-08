<?php 
    session_start();
    include 'db.php';
    if ($_SESSION['status_login'] != true) {
        echo '<script>window.location="login.php"</script>';
    }
    $query = mysqli_query($conn, "SELECT * FROM login_user WHERE id_username = '".$_SESSION['id']."' ");
    $data = mysqli_fetch_object($query);

    $produk = mysqli_query($conn, "SELECT * FROM product WHERE product_id = '".$_GET['id']."' ");
    if (mysqli_num_rows($produk) == 0) {
        echo "cek";
        echo '<script>window.location="produk.php"</script>';
    }
    $data = mysqli_fetch_object($produk);
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
    <title>Edit Data</title>
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
            <h3>Edit Data</h3>
            <div class="box">
                <form action="" method="POST" enctype="multipart/form-data">
                    <select  name="kategori" class="input-control">
                        <option value="">--Pilih--</option>
                        <option value="Game" <?php echo ("Game" == $data->category_product)?'selected':'' ?> >Game</option>
                        <option value="Laptop" <?php echo ("Laptop" == $data->category_product)?'selected':'' ?> >Laptop</option>
                        <option value="ElectronicTools" <?php echo ("ElectronicTools" == $data->category_product)?'selected':'' ?>>Peralatan Elektronik</option>
                        <option value="Sparepart" <?php echo ("Sparepart" == $data->category_product)?'selected':'' ?>>SparePart Computer</option>
                    </select>
                    <input type="text" name="p_name" placeholder="Nama Produk" class="input-control" value="<?php echo $data->product_name ?>" required>
                    <input type="text" name="p_price" placeholder="Harga Produk" class="input-control" value="<?php echo $data->product_price ?>"required>
                    
                    <img src="pict-product/<?php echo $data->product_pict ?>" width="200px" style="margin: 0 0 20px 10px; " alt="">
                    <input type="hidden" name="photo" value="<?php echo $data->product_pict ?>">
                    <input type="file" name="p_pict" class="input-control"  >
                    <textarea name="p_desc" cols="30" class="input-control" rows="10" placeholder="Deskripsi Produk"><?php echo $data->product_desc ?></textarea>
                    <select name="status" class="input-control">
                        <option>--Status--</option>
                        <option value="0" <?php echo (0 == $data->product_status)?'selected':'' ?> >Tidak Aktif</option>
                        <option value="1" <?php echo (1 == $data->product_status)?'selected':'' ?> >Aktif</option>
                    </select>
                    
                    <input type="submit" id="submit" name="submit" value="Submit" class="btn">
                </form>
                <?php 
                    if (isset($_POST['submit'])) {
                            // menampung data inputan dari form
                            $kategori   = $_POST['kategori'];
                            $p_name     = $_POST['p_name'];
                            $p_price    = $_POST['p_price'];
                            $p_desc     = $_POST['p_desc'];
                            $status     = $_POST['status'];
                            $photo      = $_POST['photo'];

                        
                            // file gambar yang baru
                            $filename   = $_FILES['p_pict']['name'];
                            $tmp_name   = $_FILES['p_pict']['tmp_name'];
                            $type1      = explode('.', $filename);
                            $type2      = $type1[1];
                            $newname    = 'Produk '.time().'.'.$type2;
                            $izin_tipe  = array('jpg','jpeg','png');
                        

                            // jika admin mengganti gambarnya
                            if ($filename != '') {
                                // validasi format file
                                if (!in_array($type2,$izin_tipe)) {
                                    echo '<script>alert("Format file tidak diizinkan!")</script>';
                                }else{
                                    // proses upload dan insert ke db jika berhasil melewati validasi dan menghapus data dari file directory
                                    move_uploaded_file($tmp_name, './pict-product/'.$newname);
                                    $namagambar = $newname;
                                    unlink('./pict-product/'.$photo);
                                }
                            }else{
                                // jika admin tidak mengganti gambarnya
                                $namagambar = $photo;
                            }

                            // query update data
                            $update = mysqli_query($conn, "UPDATE product SET 
                                                        category_product = '".$kategori."',
                                                        product_price = '".$p_price."',
                                                        product_desc = '".$p_desc."',
                                                        product_pict = '".$namagambar."',
                                                        product_name = '".$p_name."'
                                                        WHERE product_id = '".$_GET['id']."'
                                                        ");
                                if ($update) {
                                    echo '<script>alert("Data Produk Berhasi di Update")</script>';
                                    echo '<script>window.location=("produk.php")</script>';
                                    echo $filename;
                                }else{
                                    echo '<script>alert("Data gagal di upload!".mysqli_error($conn))</script>';
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