<?php


	session_start();
	 
	$_SESSION['logged_in'] = false;
	 
	session_destroy();
	 
	header('Location: ../Telas/login.php');

?>