<?php
	session_start();
?>

<!DOCTYPE HTML>
<html lang="pl>
<head>
	<meta charset="utf-8" />
	<http-equiv="X-UA-Compatible"content="IE=edge,chrome=1"/>
	<title>Analiza Danych Pogodowych</title>
</head>

<body>
	<h1>Analiza Danych</h1>
	<?php
		require_once "user_info.php";
		require_once "connect.php";

		$DatabaseConnection = @new mysqli($host,$db_user,$db_password,$db_name);
		if($DatabaseConnection->connect_errno!=0)
		{
			echo "Error: ".$DatabaseConnection->connect_errno."Note: ".$DatabaseConnection->connect_error;
		}
		else
		{
		$Query= "CALL GetStationLocation(".$_POST['StationID'].")";
			if($QueryResult = @$DatabaseConnection->query($Query))
			{
				if($Row = $QueryResult->fetch_assoc())
				{
					echo "<b>Szerokość Geograficzna =</b>".$Row['SzerokoscGeograficzna'];
					echo "<br><b>Długość Geograficzna =</b>".$Row['DlugoscGeograficzna'];
					echo "<br><b>Wysokość =</b>".$Row['Wysokosc']."m n.p.m";
				}	
				$QueryResult->close();
				$DatabaseConnection->next_result();
			}
		
			$Query= "CALL GetStationName(".$_POST['StationID'].")";
			if($QueryResult = @$DatabaseConnection->query($Query))
			{
				if($Row = $QueryResult->fetch_assoc())
				{
					$StationName = $Row['NazwaStacjiPogodowej'];
					$QueryResult->free_result();
				}
				$DatabaseConnection->next_result();
			}
			echo	 "<h2>Pomiary dla stacji: ".$StationName."</h2>";
			echo "<table border='1' cellpadding='10' cellspacing='0'>";
			echo "<tr><td>Data Pomiaru</td><td>Godzina Pomiaru</td><td>Kod Pomiaru</td><td>Wartość Pomiaru</td><td>Akcje</td></tr>";
			$Query= "CALL GetStationMeteoData(".$_POST['StationID'].")";
			if($QueryResult = @$DatabaseConnection->query($Query))
			{
				while($Row = $QueryResult->fetch_assoc())
				{
					echo "<tr>";
					echo "<td>".$Row['DataPomiaru']."</td>";
					echo "<td>".$Row['GodzinaPomiaru']."</td>";
					echo "<td>".$Row['KodPomiaru']."</td>";
					echo "<td>".$Row['WartoscPomiaru']."</td>";
					echo "</tr>";
				}	
				$QueryResult->close();
				$DatabaseConnection->next_result();
			}
			echo "</table>";
		
		$DatabaseConnection->close();
		Header("Refresh:3600");
		}
	?>
	<br><a href="meteo_data.php">Powrót do poprzedniej strony</a>
</body>
</html>