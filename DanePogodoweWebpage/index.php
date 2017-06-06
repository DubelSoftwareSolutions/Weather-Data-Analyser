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
	<h1>Strona główna</h1><br/><br/>
	<?php
	if(!isset($_SESSION['UserType']))
		header('Location:user_index.php');
	else
		if($_SESSION['UserType'] == 'Admin')
			header('Location:admin_index.php');
		else
			if($_SESSION['UserType'] == 'Analyst')
				header('Location:analyst_index.php');
	?>
</body>
</html>