<?php
	if(!isset($_SESSION['UserType']))
	{
		echo "(użytkownik)";
		echo "<br/><br/>";
		echo "<form action='login.php' method='post'>";
		echo "<input type='submit' value='Logowanie'/>";
		echo "</form>";
	}
	else if ($_SESSION['UserType']=='Admin')
	{
		echo "(administrator)";
		echo "<br/><br/>";
		echo "Zalogowano na konto Administratora<br>";
		echo "<b>Imię:</b> ".$_SESSION['AdminFirstName']."<br>";
		echo "<b>Nazwisko:</b> ".$_SESSION['AdminLastName']."<br>";
		echo "<b>Email:</b> ".$_SESSION['AdminEmail']."<br>";
		echo "<form action='logout.php' method='post'>";
		echo "<input type='submit' value='Wyloguj'/>";
		echo "</form>";
	}
	else if ($_SESSION['UserType']=='Analyst')
	{
		echo "(analityk)";
		echo "<br/><br/>";
		echo "Zalogowano na konto Analityka<br>";
		echo "<b>Imię:</b> ".$_SESSION['AnalystFirstName']."<br>";
		echo "<b>Nazwisko:</b> ".$_SESSION['AnalystLastName']."<br>";
		echo "<b>Email:</b> ".$_SESSION['AnalystEmail']."<br>";
		echo "<form action='logout.php' method='post'>";
		echo "<input type='submit' value='Wyloguj'/>";
		echo "</form>";
	}
?>