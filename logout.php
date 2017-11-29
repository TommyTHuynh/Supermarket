<?php

// include function files for this application
require_once('assets/PHPfunctions/bookmark_fns.php'); 
session_start();
@$old_user = $_SESSION['valid_user'];  
// store  to test if they *were* logged in
unset($_SESSION['valid_user']);
unset($_SESSION['priviledge']);
$result_dest = session_destroy();

// start output html
do_html_header_universal('form');

if (!empty($old_user))
{
  if ($result_dest)
  {
    // if they were logged in and are now logged out
	user_message('Logged Out.');
    do_html_url('index.html', 'Login');
  }
  else
  {
   // they were logged in and could not be logged out
	user_message('Could not log you out.<br />');
  }
}
else
{
  // if they weren't logged in but came to this page somehow
  user_message('You were not logged in, and so have not been logged out.<br />');
  do_html_url('index.html', 'Login');
}

do_html_footer_universal(false, 'form')

?>
