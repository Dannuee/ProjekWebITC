<?php 
	include 'db.php';
	if (isset($_GET['id'])) {
		$produk = mysqli_query($conn, "SELECT product_pict FROM product WHERE product_id = '".$_GET['id']."' ");
		$d = mysqli_fetch_object($produk);

		unlink('./pict-product/'.$d->product_pict);

		$delete = mysqli_query($conn, "DELETE FROM product WHERE product_id = '".$_GET['id']."' ");
		echo '<script>window.location=("produk.php")</script>';
	}

 ?>