<?php
	//This function creates a default HTML style for a page that has returned an error. This includes the header, and possibly an error message that we want the user to see. In the case that there is an error message, we'll need the section after the header to be a 'form'
	function do_html_header_universal($section = 'default'){
?>
		<!DOCTYPE html>
		<html lang="en">
	
		<head>
			<meta charset="utf-8">
			<title>Supermarket</title>
			<link rel="stylesheet" href="assets/stylesheets/supermarket_design.css">
			<link href='https://fonts.googleapis.com/css?family=Lato:400,300,100' rel='stylesheet' type='text/css'>
		</head>
	
		<body>
			<header class="primary-header container group">
			
				<h1 class="logo">
					<a href="member.php">Supermarket</a>
				</h1>
				
				<div class="tagline">
					<h3>Shop with us</h3>
					<a class ="btn btn-alt" href="register_form.html">Sign Up</a>
				</div>
			</header>
<?php		
		
		if($section == 'form'){
?>
		<section class="row">
			<div class="column container form-style">
				<form>
<?php
		}
	}
	
	//In the case we want to print something to the user, in an exception-style, we send a string to this function an return the message in HTML
	function user_message($mess)
	{
?>
	<h2 class="exception-message"><?php echo $mess; ?></h2>
<?php
	}
	
	//Function that has two strings as parameters, the first being a link and the second being the name of the page the link is attached to
	function do_html_URL($url, $name)
	{
	  // output URL as link and br
?>
			<br /><a class = "exception-message" href="<?php echo $url;?>"><?php echo $name;?></a><br />
<?php
	}
	
	//To finish the page, we may need to close the <form> tag and may also want to show the user the different links he/she can go to. However, there are two cases, when the user has logged in and we want to show the user the links (inner is set to true because we are 'in' the website) or we had an error before logging in and don't have the right to access those links (inner set to false).
	function do_html_footer_universal($inner = false, $section = false){
		
		if ($section == 'form')
		{
?>	
				</form>
			</div>
		</section>
		<?php 
	
		}
	}
	
	function display_user_menu()
	{
	  // display the menu options on this page 
?>
<nav class="user-menu">
	<ul>
	<li><a href="person.php">Person</a></li><!-- 
	--><li><a href="product.php">Products</a></li><!-- 
	--><li><a href="sale.php">Sale</a></li><!-- 
	--><li><a href="store.php">Store</a></li><!-- 
	--><li><a href="suppliedby.php">SuppliedBy</a></li><!-- 
	--><li><a href="supplier.php">Supplier</a></li><!-- 
	--><li><a href="customer.php">Customer</a></li><!-- 
	--><li><a href="employee.php">Employee</a></li>
	</ul>
</nav>

<?php
	}	
		
		
	function display_table($var, $every_row)
	{
		$col_names = get_names($var);
		
		error_reporting(E_ALL & ~E_NOTICE);
		
		$editables =array("product", "supplier", "employee");
		if($_SESSION['priviledge'] == 'employee' && in_array($var, $editables))
			$edit = true;
		
?>
					<form class="book-table" action="update.php" method="post">
						<table id="supermarket_info">
							<?php 
							echo "<tr>";
							foreach($col_names as $col)
							{
								echo "<th scope='row'>
								$col
								</th>";
							}
							if($edit){
	?>
							<th scope="row">
								Update
							</th>
<?php						}
							echo "</tr>";
							?>
<?php
	
		
	if (is_array($col_names) && count($col_names)>0)
	{
		$conn = db_connect();
		
		$col_names = $conn->query("select column_name
								from information_schema.columns
								where table_schema='market'
								and table_name='$var'");
		try{
			if ($every_row->num_rows > 0) {
					$test_array = array();
					
				
				for($count = 0; $rows = $col_names->fetch_row(); ++$count)
				{	
					$final = lcfirst($rows[0]);
					$test_array[$count] = $final;
				}
				while($row = $every_row->fetch_row()){
					$count = 0;
					echo "<tr>";
					$test = array();
					echo '<form action="update.php" method="post">';
					foreach($test_array as $testing){
							echo "<td>";
							$table_entry = $row["$count"];
							$test[] = $table_entry;
							$count++;
							//EDITABLE PAGES
							if($edit){
								
								echo '<input type="hidden" name="old[]" value="'.$table_entry.'"></input>';
								echo '<input type="hidden" name="table_name" value="'.$var.'"></input>';
								//echo "<input type='text' name='new' value='$table_entry' onkeypress=\"this.style.width = ((this.value.length + 1) * 8) + \" px\";\" ></input>";

								//echo '<input id="txt" type="text" onkeypress="this.style.width = ((this.value.length + 1) * 8) + "px";">';
								
								echo "<input type='text' name='new[]' value='$table_entry' style='width: 100px;'></input>";
							}
							//END EDITABLE
							else
								echo $table_entry;
							
							echo "</td>";
					}
					if($edit){
						echo "<td>
						<button class='btn' type='submit' name='edit' value='test'>Edit
						</button>";
						echo "<button class='btn' type='submit' name='delete' value='delete'>Delete</button>
						</td>";
					}
					echo "</tr>";
					echo '</form>';
				}		
			}
		}
		catch(Exception $e)
		{
			echo "<b>Error thrown</b>";
		}
				// TEST FOR ALL TABLES
		
	}
	else
		echo "<tr><td>No Contents on record</td></tr>";
?>
						</table> 
					</form>
<?php
	}
	
	function generateForm( $tableName, $columns, array $errors = array(), $oldData = array() ) {


		$dropDownOption = $dropDown = '';
		$dropDownOption2 = $dropDown2 = '';

		if ( $tableName == 'product' ) {

			$stores = getStore();
			foreach ( $stores as $store ) {
				
				$dropDownOption .= '<option value="'.$store['StoreID'].'">'.$store['StoreID'].' - ' . $store['Address_city'] . ',' . $store['Address_state']. ', ' . $store['Addess_zip'] .'</option>';
			}

			$index = array_search('SoldAt', $columns);
			if ( $index !== false ) {
				unset($columns[$index]);
				$dropDown = '<div class="search_feature">
				<label>SoldAt: </label>
				<select name="SoldAt" id="SoldAt">'.$dropDownOption.'</select>
</div>';
			}
		}

		if ( $tableName == 'employee' ) {
			$stores = getStore();
			foreach ( $stores as $store ) {
				$dropDownOption .= '<option value="'.$store['StoreID'].'">'.$store['StoreID'].' - ' . $store['Address_city'] . ',' . $store['Address_state']. ', ' . $store['Addess_zip'] .'</option>';
			}

			$index = array_search('WorksAt', $columns);
			//$index2 = array_search('EPhone', $columns);
			//$index3 = array_search('EName', $columns);
			$index4 = array_search('StartDate', $columns);
			//unset($columns[$index2]);
			unset($columns[$index4]);

			if ( $index !== false ) {
				unset($columns[$index]);
				$dropDown = '<div class="search_feature">
				<label>WorksAt: </label>
				<select name="WorksAt" id="WorksAt">'.$dropDownOption.'</select>
			</div>';
			}

			/*if ( $index3 !== false ) {*/

				/*foreach ( getPerson() as $person ) {*/
					/*$dropDownOption2 .= '<option value="'.$person['Name'].'">'.$person['Name'].' - ' . $person['Phone'] .'</option>';*/
				/*}*/

				/*unset($columns[$index3]);*/
				/*$dropDown2 = '<div>*/
				/*<label>EName: </label>*/
				/*<select name="EName" id="EName">'.$dropDownOption2.'</select>*/
/*</div>';*/
			/*}*/
		}

		/*Creates the body of the user prompt section. First it will take all the comlumns from $columns. It will then print out the Column name in a label and do so by string manipulation. The user input section will be empty when the $oldData is empty (so first try) and will be filled when there is either an error or there is something in $oldData. Finally, in the case of errors, we want to print a span that tells the user what the error is. Notice that this only prints up to the final box where we have the Works at section*/
		$columnsHtml = '';
		foreach ( $columns as $type => $columnName ) {

			$columnsHtml .= '<div class="search_feature">';
			$columnsHtml .= '<label for="'.$columnName.'">'.ucwords(str_replace('_',' ', $columnName)).'</label>';
			$columnsHtml .= '<input type="text" name="'.$columnName.'" value="'.(!empty($oldData[$columnName]) ? $oldData[$columnName] : '').'" id="'.$columnName.'"">';
			if ( isset($errors[$columnName]) ) {
				$columnsHtml .= '<span class="help-block">'.$errors[$columnName].'</span>';
			}
			$columnsHtml .= '</div>';
		}
		
		/*Now that we've created the strings for the input boxes, here is where we print it out to the user. We use <<< to signigy a string that ends with HTML finside we have the form with us sending through POST tableName and keywork insertion*/
		$html = <<<HTML
			<form class="search_feature" action="" method="post">
			<label>Add Entry:</label>
			<input type="hidden" name="table" value="{$tableName}">
			<input type="hidden" name="operation" value="insertion">
			{$dropDown2} {$columnsHtml} {$dropDown}
			<button type="submit">Save</button>
</form>
HTML;

		if ( $tableName == 'employee' && ! $dropDownOption2 ) {
			//return '<form>All your persons are associated with employee. Please add a new <a href="/person.php"">Person</a> before create an employee.</form>';
		}
		
		//In the end we return the HTML code that we have constructed 
		return $html;
	}	
?>
