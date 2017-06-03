<!DOCTYPE HTML>
<html lang="pl>
<head>
	<meta charset="utf-8" />
	<http-equiv="X-UA-Compatible"content="IE=edge,chrome=1"/>
	<title>Analiza Danych Pogodowych</title>
</head>

<body>
	Dodawanie stacji pogodowej<br/><br/>
	<form action="postadd_station.php" method="post">
		Nazwa: <input type="text" name="name" /> <br/>
		Szerokość Geograficzna: <input type="text" name="latitude" /> <br/>
		Długość Geograficzna: <input type="text" name="longitude" /> <br/>
		Wysokość: <input type="text" name="altitude" /> <br/>
		<input type="submit" value="Wyślij"/>
	</form>

	<br><a href="meteo_data.php">Powrót poprzedniej strony</a>
</body>
</html>
