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
    <title>Profile Admin</title>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container">
            <h1><a href="dashboard.php">CyberStation</a></h1>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="produk.php">Tambah Produk</a></li>
                <li><a href="logout.php">Log Out</a></li>
            </ul>
        </div>
    </header>

    <!-- Content -->
    <div class="content">
        <div class="container">
            <h3>Profile</h3>
            <div class="box">
                <form action="" method="POST">
                    <input type="text" name="user" placeholder="Username" class="input-control" value="<?php echo $data->username ?>" required>
                    <input type="text" name="full-name" placeholder="Nama Lengkap" class="input-control" value="<?php echo $data->full_name ?>" required>
                    <input type="text" name="phone" placeholder="Nomor Handphone" class="input-control" value="<?php echo $data->phone ?>" >
                    <input type="text" name="address" placeholder="Alamat" class="input-control" value="<?php echo $data->address ?>">
                    <input type="text" name="email" placeholder="E-Mail" class="input-control" value="<?php echo $data->email ?>">
                    <input type="submit" name="submit" value="Submit" class="btn">
                    <input type="reset" id="reset" name="reset" value="Reset" class="btn">
                </form>
                <?php 
                    if (isset($_POST['submit'])) {
                        $user       = $_POST['user'];
                        $fullname   = ucwords($_POST['full-name']);
                        $phone      = $_POST['phone'];
                        $address    = ucwords($_POST['address']);
                        $email      = $_POST['email'];

                        $update = mysqli_query($conn,  "UPDATE login_user SET
                            username = '".$user."',
                            full_name = '".$fullname."',
                            phone = '".$phone."',
                            address = '".$address."',
                            email = '".$email."' 
                            WHERE id_username = '".$data->id_username."' ");
                        if ($update == true) {
                            echo '<script>alert("Update Profile Success!")</script>';
                            echo '<script>window.location = "profile.php"</script>';
                        }else{
                            echo "gagal".mysqli_error($conn);
                        }
                    }
                 ?>
            </div>
            <br><br>
            <h3>Ubah Password</h3>
            <div class="box">
                <form action="" method="POST">
                    <input type="password" name="new_pass" placeholder="Password Baru" class="input-control" value="" required>
                    <input type="password" name="confirm_pass" placeholder="Konfirmasi Password" class="input-control" value="" required>
                    <input type="submit" name="submit_pass" value="Submit" class="btn">
                </form>
                <?php 
                    if (isset($_POST['submit_pass'])) {
                        $new_pass  = $_POST['new_pass'];
                        $confirm_pass  = $_POST['confirm_pass'];
                        if ($new_pass == $confirm_pass) {
                            $u_pass = mysqli_query($conn,  "UPDATE login_user SET
                            password = '".$new_pass."' 
                            WHERE id_username = '".$data->id_username."' ");
                            if ($u_pass) {
                                echo '<script>alert("Update Password Success!")</script>';
                                echo '<script>window.location = "profile.php"</script>';
                            }else{
                                echo "gagal".mysqli_error($conn);
                            }
                        }else{  
                            echo '<script>alert("Konfirmasi Password Tidak Sesuai!")</script>';
                        }
                    }
                 ?>
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