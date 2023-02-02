<?php
    
	try 
	{
                $pdo= new PDO('mysql:host=67.220.183.250;dbname=vetmecom_iknow_db','vetmecom_root','fearlessness');
                //$pdo= new PDO('mysql:host=127.0.0.1;dbname=iknow_db','root','');
		$pdo->setAttribute(PDO:: ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$pdo->exec('SET NAMES "utf8"');	
		//$output="Established database connection.";
		//include 'output.html.php';
		
	} 
	catch (PDOException $e)
	{
		$output="Unable to establish database connection. ";
		include'output.html.php';
		exit();
	}

?>