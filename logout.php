<?php 
	session_start();
	session_destroy();
	echo '<script>window.location="loginUser.php"</script>';
 ?>