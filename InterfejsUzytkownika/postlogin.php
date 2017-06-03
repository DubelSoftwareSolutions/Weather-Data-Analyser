<?php

	session_start();
	
	if(!isset($_POST['login']) || !isset($_POST['password']))
	{
		header('Location:login.php');
		exit();		
	}
	
	require_once "connect.php";
	
	$DatabaseConnection = @new mysqli($host,$db_user,$db_password,$db_name);
	if($DatabaseConnection->connect_errno!=0)
	{
		echo "Error: ".$DatabaseConnection->connect_errno."Note: ".$DatabaseConnection->connect_error;
	}
	else
	{
		$login = $_POST['login'];
		$password = $_POST['password'];
		
		$AdminQuery= "call GetAdminInfo(\"$login\",\"$password\")";
		if($QueryResult = @$DatabaseConnection->query($AdminQuery))
		{
			$RecordCount = $QueryResult->num_rows;
			if($RecordCount>0)
			{
				$Row = $QueryResult->fetch_assoc();
				$_SESSION['AdminFirstName'] = $Row['imie'];
				$_SESSION['AdminLastName'] = $Row['nazwisko'];
				$_SESSION['AdminEmail'] = $Row['e_mail'];
				$_SESSION['AdminID'] = $Row['AdminID'];
				
				unset($_SESSION['error']);
				$_SESSION['UserType']='Admin';
				header('Location:index.php');
			}
			$QueryResult->close();
			$DatabaseConnection->next_result();
		}
		
		if($RecordCount==0)
		{
			$AnalystQuery= "call GetAnalystInfo(\"$login\",\"$password\")";
			if($QueryResult = @$DatabaseConnection->query($AnalystQuery))
			{
				$RecordCount = $QueryResult->num_rows;
				if($RecordCount>0)
				{
					$Row = $QueryResult->fetch_assoc();
					$_SESSION['AnalystFirstName'] = $Row['imie'];
					$_SESSION['AnalystLastName'] = $Row['nazwisko'];
					$_SESSION['AnalystEmail'] = $Row['e_mail'];
					$_SESSION['AnalystID'] = $Row['AnalystID'];
					
					unset($_SESSION['error']);
					$_SESSION['UserType']='Analyst';
					header('Location:index.php');
				}
				else
				{
					$_SESSION['error'] = '<span style="color:red">Nieprawidłowy login lub hasło</span>';
					header('Location: login.php');
				}
				$QueryResult->close();
				$DatabaseConnection->next_result();
			}
			else
				echo $DatabaseConnection->error;
		}
		$DatabaseConnection->close();
	}
?>