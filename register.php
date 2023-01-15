<?php

$user = 'phpmyadmin';
$password = 'eduard17';
$database = 'Nyaa';
$servername='localhost:3306';
$mysqli = new mysqli($servername, $user,
				$password, $database);
if ($mysqli->connect_error) {
	die('Connect Error (' .
	$mysqli->connect_errno . ') '.
	$mysqli->connect_error);
}

if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['password_re']))
{
	if($_POST['password'] == $_POST['password_re'])
			{
				$hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
				$username = mysqli_real_escape_string($mysqli, $_POST['username']);
				$password = mysqli_real_escape_string($mysqli, $hash);
				$sql = " INSERT INTO user VALUES ('$username', '$password') ";
				$mysqli->query($sql);
				header("Location: ./login.php");
			}
			
}
$mysqli->close();

?>
<!DOCTYPE html>
<html lang="en">
	<header>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>
			Register
		</title>
	</header>

	<body>
			<h1>	
				<a href="./index.php">Go home</a>
			</h1>
			<form method="post">
				<label>Username</label>
				<input type="text" name="username">
				<label>Password</label>
				<input type="password" name="password">
				<label>Re-type password</label>
				<input type="password" name="password_re">
				<input type="submit" name="submit" value="Submit">
			</form>
	</body>

</html>