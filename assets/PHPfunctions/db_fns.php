<?php
	//post-condition: when called on, this function will connect to the mySQL database.
	function db_connect(){
		$result = new mysqli('localhost', 'root', '021696', 'market');
		if(!$result)
			throw new Exception('Could not connect to database server');
		else
			return $result;
	}
	function pdo_connection() {
//		$pdo = new PDO('mysql:host=localhost;dbname=market', 'root', '');
		$pdo = new PDO('mysql:host=localhost;dbname=market', 'root', '021696');
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		return $pdo;
	}
?>