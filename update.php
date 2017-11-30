<?php
  require_once('assets/PHPfunctions/bookmark_fns.php');
  session_start();
 
  //create short variable names
  @$edit = $_POST['edit'];
  @$delete = $_POST['delete'];
  @$search = $_POST['search'];
  @$valid_user = $_SESSION['valid_user'];
  @$old = $_POST['old'];
  @$new = $_POST['new'];
  @$search_term = $_POST['search_term'];
  @$table_name = $_POST['table_name'];

 
  do_html_header_universal('form');

  try{
	active_session();
  }
  catch (Exception $e)
  {
	  user_message($e->getMessage());
  }
  if (!filled_out($_POST))
  {
	  user_message('You have not chosen either option to be here');
    user_mess_footer(tnrue); 
    exit;
  }
  else 
  {
	  	$temp_name = get_names($table_name);
		$col_names = array();
		foreach($temp_name as $temp){
			$col_names[] = $temp;
		}
    if(isset($edit)){
		user_message('Edit');
		user_message($old[1]);
		user_message($new[1]);
	}
	else if(isset($delete)){
		user_message('Delete');
		print_r($old);
		try{
			//searchAndDestroy($table_name, $col_names, $old);
		}
		catch(Exception $e){
			echo "<b>Error thrown</b>";
		}
	}
	else if(isset($search)){
		user_message('Search Results');
		$query = search($table_name, $col_names, $search_term);
		
		try{
			if ($query->num_rows > 0)
				display_table_new($table_name, $query);
			else
				user_message("None found");
		}
		catch(Exception $e)
		{
			echo "<b>Error thrown</b>";
		}
	}
	else
		user_message('You should not be here');
  	do_html_URL("$table_name.php", "Go Back");
  }


  do_html_footer_universal(true, 'form');
?>