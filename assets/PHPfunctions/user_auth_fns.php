<?php
	require_once('db_fns.php');
	
	//pre-condition: takes in the $username, $email, and $password that the user entered when registering for an account
	//post-condition: will throw an exception if database could not be reached, if the username entered is already in the database, and if the user was not allowed to enter their username into the database. Will return true if no exception is reached.
	function register($username, $password, $pnumber, $address){		
		$conn = db_connect();
		
		//search for username in database
		$result = $conn->query("select * from login_information where username='$username'");
		if(!$result)
			throw new Exception('Could not execute query');
		if($result->num_rows > 0)
			throw new Exception('That username is taken - go back and choose another');
		
		//insert user into Person table
		$result = $conn->query("INSERT INTO person VALUES ('$username', '$pnumber', '$address')");
		
		if(!$result)
			throw new Exception('Could not add you to our Person Table');
		//insert user into Customer table
		$result = $conn->query("INSERT INTO customer VALUES('$username', '$pnumber', '0', '102')");
		
		if(!$result)
			throw new Exception('Could not add you to our Customer Table');
		
		//insert user into Login Table
		$result = $conn->query("insert into login_information values 
        ('$username', sha1('$password'))");
		
		if(!$result)
			throw new Exception('Could not register you in database - please try again later');
		
		return true;
	}
	
	//pre-condition: takes in username and password when the user is in the login page. 
	//post-condition: Throws an exception when the query could not go through and when the query goes through but the username was not found in the database. Returns true when the username was found.
	function login($username, $password){
		
		$conn = db_connect();
		
		//searches for username AND password in database
		$result = $conn->query("select * from login_information where
		username = '$username'
		and passwd = sha1('$password')");
		
		if(!$result)
			throw new Exception('Could not connect to database');
		if($result->num_rows > 0)
			return true;
		else
			throw new Exception('An error has occured');
	}
	
	function priviledge_level($username){
		$conn = db_connect();
		
		$customer = $conn->query("SELECT * from market.customer where Cname = '$username'");
		$employee = $conn->query("SELECT * from market.employee where Ename = '$username'");
		if(!$customer || !$employee)
			throw new Exception('Could not connect to database.');
		else if($employee->num_rows > 0)
			return "employee";
		else if($customer->num_rows > 0)
			return "customer";
		else
			throw new Exception('An error has occured');
	}
	
	function active_session(){
		if(!(isset($_SESSION['valid_user']))){
			user_message('You are not logged in');
			do_html_url('index.html', 'Login');
			//do_html_footer();
			do_html_footer_universal(false, 'form');
			exit;
		}
	}
?>