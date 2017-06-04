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
			$Query= "SELECT `LocationID` FROM `polozenie` WHERE `StationID`=".$_POST['StationID'];
			if($QueryResult = @$DatabaseConnection->query($Query))
			{
				if($Row = $QueryResult->fetch_assoc())
				{
					$LocationID = $Row['LocationID'];
					$QueryResult->close();
					$DatabaseConnection->next_result();
					$Query= "DELETE FROM `polozenie` WHERE `LocationID`=".$LocationID;
					$QueryResult = @$DatabaseConnection->query($Query);
				}	
				else
				{
					$Query= "SELECT `LocationID` from `polozenie` ORDER BY `LocationID` DESC LIMIT 1";
					if($QueryResult = @$DatabaseConnection->query($Query))
					{
						if($Row = $QueryResult->fetch_assoc())
						{
							$LocationID = $Row['LocationID'] +1;
							$QueryResult->free_result();
						}
						else
							$LocationID=0;
						$DatabaseConnection->next_result();
					}
				}
				$DatabaseConnection->next_result();
			}
			$Query= "SELECT `MeasurementID` from `pomiary` ORDER BY `MeasurementID` DESC LIMIT 1";
			if($QueryResult = @$DatabaseConnection->query($Query))
			{
				if($Row = $QueryResult->fetch_assoc())
				{
					$BiggestMeasurementID = $Row['MeasurementID'];
					$QueryResult->free_result();
				}
				else
					$BiggestMeasurementID=0;
				$DatabaseConnection->next_result();
			}
			$Query= "SELECT `DataPomiaru` from `pomiary` WHERE `StationID`=".$_POST['StationID']." ORDER BY `DataPomiaru` DESC LIMIT 1";
			if($QueryResult = @$DatabaseConnection->query($Query))
			{
				if($Row = $QueryResult->fetch_assoc())
				{
					$LastMeasuremetDate = $Row['DataPomiaru'];
					$QueryResult->free_result();
				}
				else
					$LastMeasuremetDate= "2017-05-01";
				$DatabaseConnection->next_result();
			}
			$pyscript = 'E:\\programs\\xampp\\htdocs\\DanePogodoweWebpage\\OgimetHtmlParser\\OgimetHtmlParser\\OgimetHtmlParser.py';
			$pyargs = $LocationID.' '.$BiggestMeasurementID.' '.$_POST['StationID'].' '.$StationName.' '.$LastMeasuremetDate;
			$python = 'E:\\programs\\Python\\Anaconda3\\python.exe';
			$cmd = "$python $pyscript $pyargs";
			$output=shell_exec("$cmd");
			$Query= "LOAD DATA LOCAL INFILE \"E:/programs/xampp/htdocs/DanePogodoweWebpage/".$StationName."Data.txt\" INTO TABLE `pomiary` FIELDS TERMINATED BY ' ' LINES TERMINATED BY '\\r\\n'";
			if($QueryResult = @$DatabaseConnection->query($Query))
			{
				$DatabaseConnection->next_result();
			}
			$Query= "LOAD DATA LOCAL INFILE \"E:/programs/xampp/htdocs/DanePogodoweWebpage/".$StationName."Location.txt\" INTO TABLE `polozenie` FIELDS TERMINATED BY ' ' LINES TERMINATED BY '\\r\\n'";
			if($QueryResult = @$DatabaseConnection->query($Query))
			{
				$DatabaseConnection->next_result();
			}
			
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
			echo	 "<h2>Pomiary dla stacji: ".$StationName."</h2>";
			echo "<table border='1' cellpadding='10' cellspacing='0'>";
			echo "<tr>
				<td>Data Pomiaru</td>
				<td>T maksymalna</td>
				<td>T minimalna</td>
				<td>T średnia</td>
				<td>T średnia dzienna</td>
				<td>Wilgotność średnia</td>
				<td>Prędkość wiatru</td>
				<td>Porywy wiatru</td>
				<td>Ciśnienie</td>
				<td>Opady</td>
				<td>Zachmurzenie całkowite</td>
				<td>Zachmurzenie dolne</td>
				<td>Czas słońca</td>
				<td>Widoczność</td>
				<td>Akcje</td></tr>";
			$Query= "CALL GetStationMeteoData(".$_POST['StationID'].")";
			if($QueryResult = @$DatabaseConnection->query($Query))
			{
				while($Row = $QueryResult->fetch_assoc())
				{
					echo "<tr>";
					echo "<td>".$Row['DataPomiaru']."</td>";
					echo "<td>".$Row['TMAX']."</td>";
					echo "<td>".$Row['TMIN']."</td>";
					echo "<td>".$Row['TMID']."</td>";
					echo "<td>".$Row['TAVG']."</td>";
					echo "<td>".$Row['HAVG']."</td>";
					echo "<td>".$Row['WINT']."</td>";
					echo "<td>".$Row['WGUS']."</td>";
					echo "<td>".$Row['PRES']."</td>";
					echo "<td>".$Row['PREC']."</td>";
					echo "<td>".$Row['TCLD']."</td>";
					echo "<td>".$Row['LCLD']."</td>";
					echo "<td>".$Row['SUNH']."</td>";
					echo "<td>".$Row['SVIS']."</td>";
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