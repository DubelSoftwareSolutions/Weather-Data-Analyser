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
		echo	 "<h2>Wykresy autokorelacji dla stacji: ".$_POST['StationName']."</h2>";
		?>
		
		<form action="postmeteo_autokorelacja_station.php" method="post">
			<input type="hidden" name="TMAX" value="0">
			<input type="checkbox" name="TMAX" value="1"> T maksymalna
			
			<input type="hidden" name="TMIN" value="0">
			<input type="checkbox" name="TMIN" value="1"> T minimalna
			
			<input type="hidden" name="TMID" value="0">
			<input type="checkbox" name="TMID" value="1"> T średnia
			
			<input type="hidden" name="TAVG" value="0">
			<input type="checkbox" name="TAVG" value="1"> T średnia dzienna
			
			<input type="hidden" name="HAVG" value="0">
			<input type="checkbox" name="HAVG" value="1"> Wilgotność średnia
			
			<input type="hidden" name="WINT" value="0">
			<input type="checkbox" name="WINT" value="1"> Prędkość wiatru
			
			<input type="hidden" name="WGUS" value="0">
			<input type="checkbox" name="WGUS" value="1"> Porywy wiatru
			
			<input type="hidden" name="PRES" value="0">
			<input type="checkbox" name="PRES" value="1"> Ciśnienie
			
			<input type="hidden" name="PREC" value="0">
			<input type="checkbox" name="PREC" value="1"> Opady
			
			<input type="hidden" name="TCLD" value="0">
			<input type="checkbox" name="TCLD" value="1"> Zachmurzenie całkowite
			
			<input type="hidden" name="LCLD" value="0">
			<input type="checkbox" name="LCLD" value="1"> Zachmurzenie dolne
			
			<input type="hidden" name="SUNH" value="0">
			<input type="checkbox" name="SUNH" value="1"> Czas słońca
			
			<input type="hidden" name="SVIS" value="0">
			<input type="checkbox" name="SVIS" value="1"> Widoczność
			
			<?php
			echo "<input type='hidden' name='StationName' value=".$_POST['StationName'].">";
			?>
			<br><input type='submit' value='Pokaż'/>
		</form><br>
		<?php
		require_once "user_info.php";
		?>
	<br><a href="meteo_data.php">Powrót do poprzedniej strony</a>
</body>
</html>