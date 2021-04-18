<?php
session_start();
	require('new-connection.php');

    if(isset($_SESSION['logged_in'])){ // log off to end session
        header('location: wall.php');
        die();
    }
?>
<html>
<head>
	<title>Login with session</title>
    <link rel="stylesheet" href="wall_style.css">
	<style type="text/css">
		
	</style>
</head>
<body>
	<?php
	if(isset($_SESSION['success_message'])){
		echo "<p class='success'>{$_SESSION['success_message']} </p>";
		unset($_SESSION['success_message']);
	}
		if(isset($_SESSION['errors'])){
			foreach($_SESSION['errors'] as $error){
				echo "<p class='error'>{$error}</p>";
			}
			unset($_SESSION['errors']);
		}
	?>
	<div class="reg">
		<h1>Wall Registration</h1>
		<form action="process.php" method="POST">
			<input type="text" name="first_name" id="tbx" placeholder="First Name">
			<input type="text" name="last_name" id="tbx" placeholder="Last Name">
			<input type="text" name="email" id="tbx" placeholder="Email">
			<input type="password" name="password" id="tbx" placeholder="Password">
			<input type="password" name="confirm_pass" id="tbx" placeholder="Confirm Password">
			<input type="hidden" name="action" value="register">
			<input type="submit" name="Register" value="register">
		</form>
	</div>
	<div class="logins">
	<h1>Wall Login</h1>
		<form action="process.php" method="POST">
			<!-- <input type="text" name="email" value="python@django.com" id="user" placeholder="Email or username">
			<input type="password" name="password" value="\\" id="pass" placeholder="Password"> -->
            <input type="text" name="email"  id="user" placeholder="Email or username">
			<input type="password" name="password" id="pass" placeholder="Password">
			<input type="hidden" name="action" value="login">
			<input type="submit" value="Log In" name="login">
		</form>
	</div>
    <!-- 
     -->
</body>
</html>