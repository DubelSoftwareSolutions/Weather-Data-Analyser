<?php
	session_start();

	unset($_SESSION['AdminFirstName']);
	unset($_SESSION['AdminLastName']);
	unset($_SESSION['AdminEmail']);
	
	unset($_SESSION['AnalystFirstName']);
	unset($_SESSION['AnalystLastName']);
	unset($_SESSION['AnalystEmail']);
	
	unset($_SESSION['UserType']);
	header('Location:index.php');
?>