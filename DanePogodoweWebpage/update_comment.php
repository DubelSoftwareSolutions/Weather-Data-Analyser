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
		$Comment="";
		$Query= "SELECT `DataPomiaru`, `WartoscPomiaru` FROM `pomiary` WHERE `StationID`=".$_POST['StationID']." AND `KodPomiaru`=\"TMID\" ORDER BY `DataPomiaru` DESC";
		if($QueryResult = @$DatabaseConnection->query($Query))
		{
			if($Row = $QueryResult->fetch_assoc())
				{
					$CurrentValue = $Row['WartoscPomiaru'];
				}
			if($Row = $QueryResult->fetch_assoc())
				{
					$PrevValue = $Row['WartoscPomiaru'];
				}
			$QueryResult->close();
			$DatabaseConnection->next_result();
			if($CurrentValue>15 && $CurrentValue<25) $Comment=$Comment."ciepło, ";
			else if($CurrentValue>25) $Comment=$Comment."gorąco, ";
			else if(5>$CurrentValue) $Comment=$Comment."zimno, ";
			if($CurrentValue < $PrevValue) $Comment=$Comment."temperatura spada, ";
			else if ($CurrentValue > $PrevValue) $Comment=$Comment."temperatura rośnie, ";
		}
		$Query= "SELECT `DataPomiaru`, `WartoscPomiaru` FROM `pomiary` WHERE `StationID`=".$_POST['StationID']." AND `KodPomiaru`=\"PRES\" ORDER BY `DataPomiaru` DESC";
		if($QueryResult = @$DatabaseConnection->query($Query))
		{
			if($Row = $QueryResult->fetch_assoc())
				{
					$CurrentValue = $Row['WartoscPomiaru'];
				}
			if($Row = $QueryResult->fetch_assoc())
				{
					$PrevValue = $Row['WartoscPomiaru'];
				}
			$QueryResult->close();
			$DatabaseConnection->next_result();
			if($CurrentValue>1100) $Comment=$Comment."wysokie ciśnienie, ";
			else if ($CurrentValue<=1050) $Comment=$Comment."niskie ciśnienie, ";
			else $Comment=$Comment."ciśnienie w normie, ";
			if($CurrentValue < $PrevValue) $Comment=$Comment."ciśnienie spada, ";
			else if ($CurrentValue > $PrevValue) $Comment=$Comment."ciśnienie rośnie, ";
		}
		$Query= "SELECT `DataPomiaru`, `WartoscPomiaru` FROM `pomiary` WHERE `StationID`=".$_POST['StationID']." AND `KodPomiaru`=\"WINT\" ORDER BY `DataPomiaru` DESC";
		if($QueryResult = @$DatabaseConnection->query($Query))
		{
			if($Row = $QueryResult->fetch_assoc())
				{
					$CurrentValue = $Row['WartoscPomiaru'];
				}
			$QueryResult->close();
			$DatabaseConnection->next_result();
			if($CurrentValue>20) $Comment=$Comment."dobre warunki windsurfingowe, ";
			else $Comment=$Comment."słabe warunki windsurfingowe, ";
		}
		$Query= "SELECT `DataPomiaru`, `WartoscPomiaru` FROM `pomiary` WHERE `StationID`=".$_POST['StationID']." AND `KodPomiaru`=\"LCLD\" ORDER BY `DataPomiaru` DESC";
		if($QueryResult = @$DatabaseConnection->query($Query))
		{
			if($Row = $QueryResult->fetch_assoc())
				{
					$CurrentValue = $Row['WartoscPomiaru'];
				}
			$QueryResult->close();
			$DatabaseConnection->next_result();
			if($CurrentValue>5) $Comment=$Comment."pochmurno, ";
			else $Comment=$Comment."słonecznie, ";
		}
		$Query= "SELECT `DataPomiaru`, `WartoscPomiaru` FROM `pomiary` WHERE `StationID`=".$_POST['StationID']." AND `KodPomiaru`=\"PREC\" ORDER BY `DataPomiaru` DESC";
		if($QueryResult = @$DatabaseConnection->query($Query))
		{
			if($Row = $QueryResult->fetch_assoc())
				{
					$CurrentValue = $Row['WartoscPomiaru'];
				}
			$QueryResult->close();
			$DatabaseConnection->next_result();
			if($CurrentValue>10) $Comment=$Comment."przewidywane opady, weź parasol ";
		}
		$Query= "SELECT `DataPomiaru`, `WartoscPomiaru` FROM `pomiary` WHERE `StationID`=".$_POST['StationID']." AND `KodPomiaru`=\"SVIS\" ORDER BY `DataPomiaru` DESC";
		if($QueryResult = @$DatabaseConnection->query($Query))
		{
			if($Row = $QueryResult->fetch_assoc())
				{
					$CurrentValue = $Row['WartoscPomiaru'];
				}
			$QueryResult->close();
			$DatabaseConnection->next_result();
			if($CurrentValue>50) $Comment=$Comment."dobra widoczność, ";
			else $Comment=$Comment."słaba widoczność, uwaga na drodze, ";
		}
		$Query= "UPDATE `StacjePogodowe` SET `AutomatycznyKomentarz`=\"".$Comment."\" WHERE `StationID`=".$_POST['StationID'];
		if($QueryResult = @$DatabaseConnection->query($Query))
		{
			$DatabaseConnection->next_result();
		}
		$DatabaseConnection->close();
	}
	header("Location:meteo_data.php");
?>