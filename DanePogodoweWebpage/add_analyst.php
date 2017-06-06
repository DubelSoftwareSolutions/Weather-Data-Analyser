<!DOCTYPE HTML>
<html lang="pl>
<head>
	<meta charset="utf-8" />
	<http-equiv="X-UA-Compatible"content="IE=edge,chrome=1"/>
	<title>Analiza Danych Pogodowych</title>
</head>

<body>
	Dodawanie Analityka<br/><br/>
	<form action="postadd_analyst.php" method="post">
		Login: <input type="text" name="login" /> <br/>
		Hasło: <input type="text" name="password" /> <br/>
		Imię: <input type="text" name="firstname" /> <br/>
		Nazwisko: <input type="text" name="lastname" /> <br/>
		E-mail: <input type="text" name="email" /> <br/>
		
		<input type="submit" value="Wyślij"/>
	</form>
	Usuwanie Analityka<br/><br/>
	<form action="delete_analyst.php" method="post">
		Login: <input type="text" name="login" /> <br/>
		<input type="submit" value="Wyślij"/>
	</form>
	<br><a href="index.php">Powrót poprzedniej strony</a>
</body>
</html>
