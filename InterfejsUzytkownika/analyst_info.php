<!DOCTYPE HTML>
<html lang="pl>
<head>
	<meta charset="utf-8" />
	<http-equiv="X-UA-Compatible"content="IE=edge,chrome=1"/>
	<title>Analiza Danych Pogodowych</title>
</head>

<body>
	<?php
		require_once "connect.php";
		$DatabaseConnection = @new mysqli($host,$db_user,$db_password,$db_name);
		if($DatabaseConnection->connect_errno!=0)
		{
			echo "Error: ".$DatabaseConnection->connect_errno."Note: ".$DatabaseConnection->connect_error;
		}
		else
		{
			$Query= "CALL GetAnalystInfoID(".$_POST['AnalystID'].")";
			if($QueryResult = @$DatabaseConnection->query($Query))
			{
				$Row = $QueryResult->fetch_assoc();
				echo "Analityk wystawiajacy komentarz";
				echo "<br/><br/>";
				echo "<b>Imię:</b> ".$Row['imie']."<br>";
				echo "<b>Nazwisko:</b> ".$Row['nazwisko']."<br>";
				echo "<b>Email:</b> ".$Row['e_mail']."<br>";	
				$QueryResult->close();
				$DatabaseConnection->next_result();
			}
		}
		$DatabaseConnection->close();
	?>
	<br><a href="meteo_data.php">Powrót do poprzedniej strony</a>
</body>
</html>