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
		$Query= "CALL AddMeteoStation(\"".$_POST['name']."\",\"".$_POST['latitude']."\",\"".$_POST['longitude']."\",\"".$_POST['altitude']."\")";
		echo $Query;
		if($QueryResult = @$DatabaseConnection->query($Query))
		{
			$DatabaseConnection->next_result();
		}
		$DatabaseConnection->close();
	}
	
	header('Location:meteo_data.php');
?>

