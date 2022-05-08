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
    <title>Daftar Produk</title>
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
            <h3>Data Produk</h3>
            <div class="box">
               <p style="margin: 20px 0 30px 0;"><a href="tambah-produk.php" class="btn">Tambah Produk</a></p>
               <table border="1" cellspacing="0" class="table">
                   <thead>
                       <tr>
                           <th width="50px">NO</th>
                           <th>Kategori</th>
                           <th>Nama Produk</th>
                           <th>Harga</th>
                           <th>Deskripsi</th>
                           <th>Gambar</th>
                           <th>Status</th>
                           <th width="150px">Aksi</th>
                       </tr>
                   </thead>
                   <tbody>   
                        <?php 
                            $a = 1 ; 
                            $data = mysqli_query($conn, "SELECT * FROM product ORDER BY product_id DESC");
                            if (mysqli_num_rows($data) > 0) {
                                while($row = mysqli_fetch_array($data)){
                                ?>
                               <tr>
                                   <td> <?php echo $a++; ?> </td> 
                                   <td> <?php echo $row['category_product'] ?> </td> 
                                   <td> <?php echo $row['product_name'] ?> </td> 
                                   <td> <?php echo 'Rp. '.number_format($row['product_price'])  ?> </td> 
                                   <td> <?php echo $row['product_desc'] ?> </td> 
                                   <td><a href="pict-product/<?php echo $row['product_pict']?>" target="_blank"><img src="pict-product/<?php echo $row['product_pict']?>" width="80px" ></a></td>  
                                   <td> <?php echo ($row['product_status'] == 0 )?'Tidak Aktif':'Aktif' ?> </td> 
                                   <td>
                                       <a href="edit.php?id=<?php echo $row['product_id'] ?>" class="btn" >Edit</a> | <a href="delete.php?id=<?php echo $row['product_id'] ?>" class="btn" onclick="return confirm('Yakin Ingin Hapus?')" >Delete</a>
                                   </td>
                               </tr>
                                <?php }
                            }else{ ?>
                            <td colspan="8">Tidak Ada Data</td>
                            <?php }; ?>
                   </tbody>
               </table>
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