<?php
	function search($table, $columns, $values){
		$conn = db_connect();
		foreach ($values as &$data){
			if (is_null($data)){
				$data = "%";
			}
			else {
				$data .= "%";
			}
		}
		unset($data);
		if ($table = 'customer'){
			$result = $conn->query("SELECT * FROM $table WHERE $columns[0] LIKE '$values[0]' AND $columns[1] LIKE '$values[1]' AND $columns[2] LIKE '$values[2]' AND $columns[3] LIKE '$values[3]'");
		}
		if ($table = 'employee'){
			$result = $conn->query("SELECT * FROM $table WHERE $columns[0] LIKE '$values[0]' AND $columns[1] LIKE '$values[1]' AND $columns[2] LIKE '$values[2]' AND $columns[3] LIKE '$values[3]' AND $columns[4] LIKE '$values[4]' AND $columns[5] LIKE '$values[5]'");
		}
		if ($table = 'product'){
			$result = $conn->query("SELECT * FROM $table WHERE $columns[0] LIKE '$values[0]' AND $columns[1] LIKE '$values[1]' AND $columns[2] LIKE '$values[2]' AND $columns[3] LIKE '$values[3]' AND $columns[4] LIKE '$values[4]'");
		}
		if ($table = 'sale'){
			$result = $conn->query("SELECT * FROM $table WHERE $columns[0] LIKE '$values[0]' AND $columns[1] LIKE '$values[1]' AND $columns[2] LIKE '$values[2]' AND $columns[3] LIKE '$values[3]'");
		}
		if ($table = 'store'){
			$result = $conn->query("SELECT * FROM $table where $columns[0] like '$values[0]' and $columns[1] like '$values[1]' and $columns[2] like '$values[2]' and $columns[3] like '$values[3]'");
		}
		if ($table = 'suppliedby'){
			$result = $conn->query("select * from $table where $columns[0] like '$values[0]' and $columns[1] like '$values[1]'");
		}
		if ($table = 'supplier'){
			$result = $conn->query("select * from $table where $columns[0] like '$values[0]' and $columns[1] like '$values[1]' and $columns[2] like '$values[2]' and $columns[3] like '$values[3]'");
		}
		return $result;
	}
?>