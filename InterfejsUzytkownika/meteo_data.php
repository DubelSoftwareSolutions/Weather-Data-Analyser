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
	<h1>Analiza Danych </h1>
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
		echo	 "<h2>Stacje pogodowe (komentarze)</h2>";
		echo "<table border='1' cellpadding='10' cellspacing='0'>";
		$Query= "CALL GetAllStations()";
			if($QueryResult = @$DatabaseConnection->query($Query))
			{
			if(isset($_SESSION['UserType']))
				if ($_SESSION['UserType']=='Admin')
				{
					echo "<form action='add_station.php'>";
					echo "<input type='submit', value='Add Station'/>";
					echo "</form>";
				}
				echo "<tr><td>Nazwa</td><td>Komentarz automatyczny</td><td>Komentarz analityka</td><td>Akcje</td></tr>";
				while($Row = $QueryResult->fetch_assoc())
				{
					echo "<tr><td>";
					echo "<form action='meteo_data_station.php' method='post'>";
					echo "<input type='hidden' name='StationID' value=".$Row['StationID'].">";
					echo "<button>".$Row['NazwaStacjiPogodowej']."</button>";
					echo "</form></td>";
					echo "<td>".$Row['AutomatycznyKomentarz']."</td>";
					if(!isset($_SESSION['UserType']))
					{
						echo "<td>".$Row['KomentarzAnalityka']."</td>";
						echo "<td>";
						echo "<form action='meteo_analysis_station.php' method='post'>";
						echo "<input type='hidden' name='StationName' value=".$Row['NazwaStacjiPogodowej'].">";
						echo "<button><b>Analiza Danych</b></button>";
						echo "</form>";
					}
					else if ($_SESSION['UserType']=='Admin')
					{
						echo "<td>".$Row['KomentarzAnalityka']."</td>";
						echo "<td>";
						echo "<form action='meteo_analysis_station.php' method='post'>";
						echo "<input type='hidden' name='StationName' value=".$Row['NazwaStacjiPogodowej'].">";
						echo "<button><b>Analiza Danych</b></button>";
						echo "</form>";
						echo "<form action='update_comment.php' method='post'>";
						echo "<input type='hidden' name='StationID' value=".$Row['StationID'].">";
						echo "<button>Update Auto Comment</button>";
						echo "</form>";
						echo "<form action='analyst_info.php' method='post'>";
						echo "<input type='hidden' name='AnalystID' value=".$Row['AnalystID'].">";
						echo "<button>Analyst Info</button>";
						echo "</form>";
						echo "<form action='edit_comment.php' method='post'>";
						echo "<input type='hidden' name='StationID' value=".$Row['StationID'].">";
						echo "<input type='submit', value='Edit Comment'/>";
						echo "</form>";
						echo "<form action='delete_station.php' method='post'>";
						echo "<input type='hidden' name='StationID' value=".$Row['StationID'].">";
						echo "<input type='submit', value='Delete Station'/>";
						echo "</form></td>";
					}
					else if ($_SESSION['UserType']=='Analyst')
					{
						echo "<td>".$Row['KomentarzAnalityka']."</td>";
						echo "<td>";
						echo "<form action='meteo_analysis_station.php' method='post'>";
						echo "<input type='hidden' name='StationName' value=".$Row['NazwaStacjiPogodowej'].">";
						echo "<button><b>Analiza Danych</b></button>";
						echo "</form>";
						echo "<form action='update_comment.php' method='post'>";
						echo "<input type='hidden' name='StationID' value=".$Row['StationID'].">";
						echo "<button>Update Auto Comment</button>";
						echo "</form>";
						echo "<form action='edit_comment.php' method='post'>";
						echo "<input type='hidden' name='StationID' value=".$Row['StationID'].">";
						echo "<button>Edit Comment</button>";
						echo "</form></td>";
					}
					echo"</tr>";
				}	
				$QueryResult->close();
				$DatabaseConnection->next_result();
			}
		echo "</table>";
		$DatabaseConnection->close();
		Header("Refresh:3600");
		}
	?>
	
	<br><a href="index.php">Powrót do strony głównej</a>
</body>
</html>