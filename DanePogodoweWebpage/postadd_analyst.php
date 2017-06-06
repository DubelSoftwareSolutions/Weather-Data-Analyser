<?php

	session_start();
	require_once "connect.php";
	
	$DatabaseConnection = @new mysqli($host,$db_user,$db_password,$db_name);
	if($DatabaseConnection->connect_errno!=0)
	{
		echo "Error: ".$DatabaseConnection->connect_errno."Note: ".$DatabaseConnection->connect_error;
	}
	else
	{
		$Query= "CALL AddAnalyst(\"".$_POST['login']."\",\"".$_POST['password']."\",\"".$_POST['firstname']."\",\"".$_POST['lastname']."\",\"".$_POST['email']."\")";
		echo $Query;
		if($QueryResult = @$DatabaseConnection->query($Query))
		{
			$DatabaseConnection->next_result();
		}
		$DatabaseConnection->close();
	}
	
	header('Location:index.php');
?>

