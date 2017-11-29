<?php
	function display_changing_username(){
?>
	<form method="post" action="change_user_settings.php">
			<fieldset class="setting-form">
				<h2>Change Username: </h2>
				<label>
					Old Username:
					<input type="text" name="old_username" size=16 maxlength=16 ></input>
				</label>
				<label>
					Password:
					<input type="password" name="passwd" size=16 maxlength=16 ></input>
				</label>
				<label>
					New username:
					<input type="text" name="new_username" size=16 maxlength=16 ></input>
				</label>
				
				<input class="btn btn-default" type="submit" value="Change Username"></input>
			</fieldset>
		</form>
<?php
	}
	
	function display_changing_password(){
?>
		<form method="post" action="change_user_settings.php">
			<fieldset class="setting-form">
				<h2>Change Password</h2>
				<label>
					Old password:
					<input type="password" name="old_passwd" size=16 maxlength=16 ></input>
				</label>
				<label>
					New password:
					<input type="password" name="new_passwd" size=16 maxlength=16 ></input>
				</label>
				<label id="repeat-password">
					Repeat new password:
					<input type="password" name="new_passwd2" size=16 maxlength=16 ></input>
				</label>
				<input class="btn btn-default" type="submit" value="Change Password"></input>
			</fieldset>
		</form>
<?php
	}
	
	function display_changing_image(){
?>
		<form enctype="multipart/form-data" method="post" action="change_user_settings.php">
			<fieldset class="setting-form">
				<h2>Change Profile Pic</h2>
				<label>
					<input type="hidden" name="MAX_FILE_SIZE" value="10000000">
					Upload this file: <input name="userfile" type="file">
				</label>
				<input class="btn btn-default" type="submit" value="Send File"></input>
			</fieldset>
		</form>
<?php
	}
	
	function display_current_settings(){
?>
		<ul>
			<li>
				<h4>Current Username: <?php echo $_SESSION['valid_user']; ?></h4>
			</li>
			<li>
				<h4>Current Image:
<?php
				echo '<img src="assets/images/'.get_image($_SESSION['valid_user']).'" alt="temp-image">';
?>
				</h4>
			</li>
		</ul>
<?php
	}
	
	
?>