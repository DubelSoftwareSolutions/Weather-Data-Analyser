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
	<h1>Logowanie</h1><br/><br/>
	<form action="postlogin.php" method="post">
		Login: <input type="text" name="login" /> <br/>
		Hasło: <input type="password" name="password" /> <br/>
		<input type="submit" value="Zaloguj"/>
	</form>
	<?php
		if(isset($_SESSION['error']))
		{
			echo $_SESSION['error'];
			unset($_SESSION['error']);
		}
	?>
	<br><a href="index.php">Powrót do strony głównej</a>
</body>
</html>