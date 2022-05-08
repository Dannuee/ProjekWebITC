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
    <title>Login User</title>
</head>
<body id="bg-login">
    <div class="box-login">
        <h2>Login User</h2>

        <form action="" method="POST">
            <input type="text" name="user" placeholder="Username" class="input-control">
            <input type="password" name="pass" placeholder="Password" class="input-control">
            <input type="submit" name="login" value="Login" class="btn" >
        </form>

        <?php
            if(isset($_POST['user'])){
                session_start();
                include 'db.php';
                $user = $_POST['user'];
                $pass = $_POST['pass'];

                $login = mysqli_query($conn, "SELECT * FROM login_user WHERE username = '".$user."' AND password = '".$pass."' ");
                if (mysqli_num_rows($login) > 0) {
                    $s = mysqli_fetch_object($login);
                    $_SESSION ['status_login'] = true;
                    $_SESSION ['admin'] = $s;
                    $_SESSION['id'] = $s -> id_username;
                    echo '<script>window.location="dashboard.php"</script>';
                }else {
                    echo "<script>alert('Username atau Password Anda Salah!')</script>";
                    $_SESSION ['status_login'] = false;
                }
            }
        ?>
    </div>
</body>
</html>