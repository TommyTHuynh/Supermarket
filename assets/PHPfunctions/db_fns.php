<?php
	//post-condition: when called on, this function will connect to the mySQL database.
	function db_connect(){
		$result = new mysqli('team4supermarket-dbs.mysql.database.azure.com', 'smadmin@team4supermarket-dbs', 'cosC3380!', 'market');
//		$result = new mysqli('localhost', 'root', '07Loganoliver', 'market');
		if(!$result)
			throw new Exception('Could not connect to database server');
		else
			return $result;
	}

	function pdo_connection() {
//		$pdo = new PDO('mysql:host=localhost;dbname=market', 'root', '07Loganoliver');
		$pdo = new PDO('mysql:host=team4supermarket-dbs.mysql.database.azure.com;dbname=market', 'smadmin@team4supermarket-dbs', 'cosC3380!');
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		return $pdo;
	}
?>