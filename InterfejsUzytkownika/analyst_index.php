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
	<h1>Strona główna (analityk)</h1><br/><br/>
	<?php
	
		if(!isset($_SESSION['UserType']))
		{
			header('Location:user_index.php');
			exit();
		}
		if($_SESSION['UserType']=='Admin')
		{
			header('Location:admin_index.php');
			exit();
		}
		echo "Zalogowano na konto Analityka<br>";
		echo "<b>Imię:</b> ".$_SESSION['AnalystFirstName']."<br>";
		echo "<b>Nazwisko:</b> ".$_SESSION['AnalystLastName']."<br>";
		echo "<b>Email:</b> ".$_SESSION['AnalystEmail']."<br>";
	?>
	<form action="logout.php" method="post">
		<input type="submit" value="Wyloguj"/>
	</form>
	<br><a href="meteo_data.php">Wyświetl dane pogodowe</a>
	<br><a href="meteo_analysis.php">Wyświetl analizę danych</a>
</body>
</html>