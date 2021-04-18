<?php
	session_start();
	require('new-connection.php');

	if(isset($_POST['action']) && $_POST['action'] == 'post_it'){

		$sql = "INSERT INTO messages(user_id, message, created_at, updated_at) 
				VALUES ('{$_SESSION['user_id']}','{$_POST['message']}', now(), now())"; 	
		// echo $sql;
		// var_dump($_SESSION['user_id']);
		run_mysql_query($sql);
		header("location: wall.php");
		die();
	}	else if(isset($_POST['action']) && $_POST['action'] == 'comment_it'){
		$sql = "INSERT INTO comments (user_id, comment, message_id, created_at, updated_at) 
				VALUES ('{$_SESSION['user_id']}','{$_POST['comment']}','{$_POST['message_id']}', now(), now())"; 	
		// echo $sql;
		// var_dump($sql);
		run_mysql_query($sql);
		header("location: wall.php");
		die();
	}
	if(isset($_POST['action']) && $_POST['action'] == 'register'){

		register_user($post);
		
	}
	else if(isset($_POST['action']) && $_POST['action'] == 'login'){

		login_user($post);
	
	} else {
		session_destroy();
		header('location: index.php');
		die();
	}

	function register_user($post){
		$_SESSION['errors'] = array();

		if(empty($_POST['first_name'])){
			$_SESSION['errors'][] = "First name required";
		}
		if(empty($_POST['last_name'])){
			$_SESSION['errors'][] = "Last name required";
		}
		if($_POST['first_name']){
			if(strlen($_POST['first_name']) < 2){
				$_SESSION['errors'][] = "First name should not be less than 2 characters";
			}	
		}
		if($_POST['last_name']){
			if(strlen($_POST['last_name']) < 2){
				$_SESSION['errors'][] = "Last name should not be less than 2 characters";
			}
		}
		if(preg_match('([a-zA-Z].*[0-9]|[0-9].*[a-zA-Z])', $_POST['first_name'])){
			$_SESSION['errors'][] = "first_name field should not contain numbers";
		}
		if(preg_match('([a-zA-Z].*[0-9]|[0-9].*[a-zA-Z])', $_POST['last_name'])){
			$_SESSION['errors'][] = "last_name field should not contain numbers";
		}
		if(empty($_POST['password'])){
			$_SESSION['errors'][] = "Password required!";
		}
		if(empty($_POST['confirm_pass'])){
			$_SESSION['errors'][] = "Confirm password required!";
		}
		if($_POST['password'] !== $_POST['confirm_pass']){
			$_SESSION['errors'][] = "Password and confirmation must match!";
		}
		if($_POST['password']){
			if(strlen($_POST['password']) < 1){//8
				$_SESSION['errors'][] = "Password length should be greater than 8 characters";
			}
		}
		if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
			$_SESSION['errors'][] = "Please use a valid email address!";
		}
		// end validation
		
		if(count($_SESSION['errors']) > 0){

			header('location: index.php');
			die();

		} else {
			$password = md5($_POST['password']);
			$email = escape_this_string($_POST['email']);
			$sql = "INSERT INTO users (first_name, last_name, email, password, created_at, updated_at) 
			VALUES ('{$_POST['first_name']}','{$_POST['last_name']}','$email','$password', now(), now())";
			
			run_mysql_query($sql);
			$_SESSION['success_message'] = "New user added!";
			header('location: index.php');
			// echo $sql;
			die();
		}
	}

	function login_user($post){
		$password = md5($_POST['password']);
		$email = escape_this_string($_POST['email']);
		$sql = "SELECT * FROM users WHERE users.email = '{$email}'
		AND users.password = '{$password}'";
		
		$user = fetch_all($sql);
		if(count($user) > 0){
			$_SESSION['user_id'] = $user[0]['id'];
			$_SESSION['first_name'] = $user[0]['first_name'];
			$_SESSION['logged_in'] = TRUE;
			header('location: wall.php');
		} else {
			$_SESSION['errors'][] = "User not found";
			header('location: index.php');
			die();
		}
	}
?>