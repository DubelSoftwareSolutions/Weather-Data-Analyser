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
		$Query= "CALL UpdateAutoComment()"; //TODO
		if($QueryResult = @$DatabaseConnection->query($Query))
		{
			$QueryResult->close();
			$DatabaseConnection->next_result();
		}
		$DatabaseConnection->close();
	}
	
	header('Location:meteo_data.php');
?>

