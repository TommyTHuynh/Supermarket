<?php
  // include function files for this application
  require_once('assets/PHPfunctions/bookmark_fns.php');

  //create short variable names
  @$username=$_POST['username'];
  @$passwd=$_POST['passwd'];
  @$passwd2=$_POST['passwd2'];
  @$pnumber=$_POST['pnumber'];
  @$address=$_POST['address'];
  // start session which may be needed later
  // start it now because it must go before headers
  session_start();
  try
  {
    // check forms filled in
    if (!filled_out($_POST))
    {
      throw new Exception('You have not filled the form out correctly - please go back'
          .' and try again.');    
    }

    // passwords not the same 
    if ($passwd != $passwd2)
    {
      throw new Exception('The passwords you entered do not match - please go back'
                           .' and try again.');
    }

    // check password length is ok
    // ok if username truncates, but passwords will get
    // munged if they are too long.
    if (strlen($passwd)<6 || strlen($passwd) >16)
    {
      throw new Exception('Your password must be between 6 and 16 characters.'
                           .'Please go back and try again.');
    }
    if (is_numeric($pnumber) == false){
      throw new Exception('Your phone number contains non-numeric characters');
    }
   
    // attempt to register
    // this function can also throw an exception
    register($username, $passwd, $pnumber, $address);
    // register session variable 
    $_SESSION['valid_user'] = $username;
    $_SESSION['priviledge'] = priviledge_level($username);
    // provide link to members page
    do_html_header_universal('form');
	user_message('Your registration was successful.  Go to the members page '.'to start looking through our database!');
    do_html_url('member.php', 'Go to members page');
   
   // end page
   do_html_footer_universal(false, 'form');
  }
  catch (Exception $e)
  {
	 do_html_header_universal('form');
	 user_message($e->getMessage());
     do_html_footer_universal(false, 'form');
     exit;
  } 
?>

