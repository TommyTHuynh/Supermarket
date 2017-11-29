<?php
	//pre-condition: uses array of the information that the user put in the form
	//post-condition: returns true if all of the boxes where filled since elements of the array are set and none have an empty char value
	function filled_out($form_vars){
		foreach($form_vars as $key => $value){
			if(!isset($key) || ($value == ''))
				return false;
		}
		return true;
	}
	
	//pre-condition: takes the email address from the form and performs a preg_match() pattern check 
	//post-condition: returns true if the String of the email address matches the corrrect pattern
	function valid_email($address){
		if(preg_match('(^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$)', $address))
			return true;
		else
			return false;
	}
?>