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
		$Query= "UPDATE `StacjePogodowe` SET `KomentarzAnalityka`=\"".$_POST['Comment']."\" WHERE `StationID`=".$_POST['StationID'];
		if($QueryResult = @$DatabaseConnection->query($Query))
		{
		}
		if($_SESSION['UserType'] == "Analyst")
		{
			$Query= "UPDATE `StacjePogodowe` SET `AnalystID`=".$_SESSION['AnalystID']." WHERE `StationID`=".$_POST['StationID'];
			if($QueryResult = @$DatabaseConnection->query($Query))
			{
			}
		}
		$DatabaseConnection->close();
	}
	
	header('Location:meteo_data.php');
?>

