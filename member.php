<?php

// include function files for this application
require_once('assets/PHPfunctions/bookmark_fns.php');
session_start();

//create short variable names
@$username = $_POST['username'];
@$passwd = $_POST['passwd'];



if ($username && $passwd)
// they have just tried logging in
{
  try
  {
    login($username, $passwd);
    // if they are in the database register the user id
    $_SESSION['valid_user'] = $username;
	$_SESSION['priviledge'] = priviledge_level($username);
  }
  catch(Exception $e)
  {
    // unsuccessful login
    do_html_header_universal('form');
	user_message('You could not be logged in. 
          You must be logged in to view this page');
    do_html_url('index.html', 'Login');
    do_html_footer_universal(false, 'form');
    exit;
  }      
}

if(!(isset($_SESSION['valid_user']))){
	do_html_header_universal('form');
	user_message('You are not logged in');
    do_html_url('index.html', 'Login');
    do_html_footer_universal(false, 'form');
	exit;
}	

$var = "first";

$conn = db_connect();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>SuperMarket</title>
		<link rel="stylesheet" href="assets/stylesheets/supermarket_design.css">
		<link href='https://fonts.googleapis.com/css?family=Lato:400,300,100' rel='stylesheet' type='text/css'>
	</head>
	
	<body>
		<header class="primary-header container group">
		
			<h1 class="logo">
				<a href="member.php">SuperMarket</a>
			</h1>
			
			<div class="tagline">
				<h3>Become a Member</h3>
				<a class ="btn btn-alt" href="register_form.html">Sign Up</a>
			</div>
		</header>
	
		<section class="row">
			<div class="column container">
				<section class="home-block col-2-4">
	<?php
				echo '<img class="home-img" src="assets/images/John46.JPG" alt="temp-image">';
				$name = $_SESSION['valid_user'];
				echo "<h2 class='user-valid' >Logged in as $name </h2>";
	?>
					<nav class="home-menu">
						<ul>
<?php
							if($_SESSION['priviledge'] == "customer"){
?>
							<li><a href="member.php">User Setting</a></li>
							<?php						
}
?>							
							<!--Editable only in Employee--><li><a href="product.php">Products</a></li>
							<!--Not Editable--><li><a href="store.php">Store</a></li>
							<!-- CUSTOMER SHOULD VIEW HIS/HER OWN ENTRY-->
							
<?php
							if($_SESSION['priviledge'] == "employee"){
?>
							<!--Editable--><li><a href="supplier.php">Supplier</a></li>	
							<!--Not Editable--><li><a href="sale.php">Sale</a></li>
							<!--Not Editable--><li><a href="suppliedby.php">SuppliedBy</a></li>
							<!--Not Editable--><li><a href="customer.php">Customer</a></li>
							<!--Editable--><li><a href="employee.php">Employee</a></li>
<?php
							}
?>
							<li><a href="logout.php">Logout</a></li>
						</ul>
					</nav>
					
					<div class="member-info">
						<h3>SuperMarket Simple Steps</h3>
						<ul>
							<li>List of all contents</li>
							<li>Just select your Table and view the contents</li>
						</ul>
					
					</div>
				</section><!--
				--><section class="col-2-4">
<?php if(!$_SESSION['priviledge'] == "customer" || $_SESSION['priviledge'] == "employee"){?>
<form class="book-table" action="update.php" method="post">
<?php
				echo "<input type='text' name='search_term[]' style='width: 100px;'></input>";
				echo "<input type='text' name='search_term[]' style='width: 100px;'></input>";
				echo "<input type='text' name='search_term[]' style='width: 100px;'></input>";
				echo "<input type='text' name='search_term[]' style='width: 100px;'></input>";
				echo '<input type="hidden" name="table_name" value="'.$var.'"></input>';
				echo "
						<button class='btn' type='submit' name='search' value='search'>Search</button>
					";
			}
	?>
				</form>
<?php				
				if($_SESSION['priviledge'] == "employee")
					$var = "product";
				else
					$var = "customer";
				if ($col_names=get_names($var)){ 
				$user = $_SESSION['valid_user'];
				$cname_string_query = "select ";
				$col_names = $conn->query("select column_name
								from information_schema.columns
								where table_schema='market'
								and table_name='$var'");				
				for($count = 0; $rows = $col_names->fetch_row(); ++$count)
				{	
					if($count == 0)
						$cname_string_query .= lcfirst($rows[0]);
					else
						$cname_string_query .= ", ".lcfirst($rows[0]);
				}
				if($_SESSION['priviledge'] == "customer")
					$cname_string_query .= " from $var where Cname = '$user'";
				else
					$cname_string_query .= " from $var";
				$every_row = $conn->query($cname_string_query);
				
						$url_array = get_all_table($var);
						$number = get_col($var);
						if($number != 0)
							display_table_new($var, $every_row);
				}
?>	
				</section>
			</div>
		</section>
<?php		

// give menu of options
 do_html_footer_universal();
?>


