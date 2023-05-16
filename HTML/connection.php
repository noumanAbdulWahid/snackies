<?php 
    $server = "localhost";
	$username = "root";
	$password = "";
	$database = "snakies";
    
    $conn = mysqli_connect($server, $username,$password,$database) or die("can not connect to the database sorry" .mysqli_connect_error());
?>