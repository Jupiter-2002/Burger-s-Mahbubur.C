<?php
$timestamp = time();
$date_time = date("d-m-Y (D) H:i:s", $timestamp);
echo "Current date and local time on this server is ".$date_time;
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
	<title><?php echo $page_title;	?></title>
	<link href="<?php echo asset_url(); ?>dist/css/main.css" rel="stylesheet" type="text/css" />
</head>

<body class="nobg loginPage">


<!-- Main content wrapper -->
<div class="loginWrapper">
	<div class="loginLogo"><img style="width: 236px; height: 80px;" src="<?php echo asset_url(); ?>dist/upload/loginLogo.jpg" alt="" /></div>
	<div class="widget">
		<div class="title"><img src="<?php echo asset_url(); ?>dist/images/icons/dark/files.png" alt="" class="titleIcon" /><h6>Login panel</h6></div>
		<form action="<?php echo base_url() ?>admin" id="validate" class="form" method="post">
			<fieldset>
				<div class="formRow">
					<div class="clear">
						<?php
						echo validation_errors();
						if( isset($log_in_error_message) && $log_in_error_message!= "" ) {
							echo '<div class="form-group">'.$log_in_error_message.'</div>';
						}
						?>
					</div>
				</div>

				<div class="formRow">
					<label for="login">Username:</label>
					<div class="loginInput"><input type="text" class="validate[required]" name="username" id="username" /></div>
					<div class="clear"></div>
				</div>

				<div class="formRow">
					<label for="pass">Password:</label>
					<div class="loginInput"><input type="password" class="validate[required]" name="password" id="password" /></div>
					<div class="clear"></div>
				</div>

				<div class="loginControl">
					<div class="rememberMe"><a href="<?php echo base_url()."admin/forgot_password";	?>"><label for="remMe">Forgot Password?</label></div>

					<input type="submit" name="submit" id="submit" value="submit" class="dredB logMeIn" />
					<div class="clear"></div>
				</div>
			</fieldset>
		</form>
	</div>
</div>

<!-- Footer line -->
<div id="footer">
    <div class="wrapper">&copy; 2020 Multi Restaurant. Design and Developed by <a href="#" title="">iSoftware Limited</a></div>
</div>


</body>
</html>
