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
					$DatabaseConnection->next_result();
				}
			}
			echo	 "<h2>Edycja komentarza dla stacji: ".$StationName."</h2>";
		}
		echo "<form action='postedit.php' method='post'>";
		echo "Nowy Komentarz: <input type='text' name='Comment' /> <br/>";
		echo "<input type='hidden' name='StationID' value=".$_POST['StationID'].">";
		echo "<input type='submit' value='Wyślij'/>";
		echo "</form>";
	?>
<br><a href="meteo_data.php">Powrót poprzedniej strony</a>
</body>
</html>