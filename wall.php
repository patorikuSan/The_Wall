<?php
	session_start();
	require('new-connection.php');
	echo "Logged in: Hi " .  $_SESSION['first_name'];
	echo "<a href='process.php'>LOG OFF!</a>";

?>
<html>
	<head>
	<link rel="stylesheet" href="wall_style.css">
		<style>

		</style>
	</head>
	<body>
	<h1>The Wall</h1>
	<h3>Post a message</h3> 
	<form class="message_form" action="process.php" method="post">
		<textarea name="message" id="" cols="30" rows="10"></textarea>
		<input type="hidden" name="action" value="post_it">
		<input type="submit" value="post a message!">
	</form>

<?php //messages
		$messages = fetch_all("SELECT messages.*, users.first_name, users.last_name
								FROM messages 
								LEFT JOIN users 
								ON users.id = messages.user_id
								ORDER BY id DESC"); // reverse order of messages
									// var_dump($messages);
?>

<?php	foreach( $messages as $message){	?>
		<h2>Message from <?= $message['first_name']?> <?= $message['last_name']?> <?= $message['created_at']?></h2>
		<p><?= $message['message'] ?></p>

		<?php  //comments
		$comments = fetch_all("SELECT comments.*, users.first_name, users.last_name 
								FROM comments 
								LEFT JOIN users 
								ON users.id = comments.user_id 
								WHERE comments.message_id =".$message['id']);	
?>	

<?php   foreach( $comments as $comment){    ?>
		<h3>Comment from <?= $comment['first_name']?> <?= $comment['last_name']?> <?= $comment['created_at']?></h3>
		<p><?= $comment['comment'] ?></p>
<?php   } ?>

			<h3>Post a comment</h3> 
			<form class="comment_form" action="process.php" method="post">
				<textarea name="comment" id="" cols="30" rows="10"></textarea>
				<input type="hidden" name="action" value="comment_it">
				<input type="hidden" name="message_id" value="<?= $message['id'] ?>">
				<input type="submit" value="post a comment!">
			</form>
<?php 	} ?>

	</body>
</html>