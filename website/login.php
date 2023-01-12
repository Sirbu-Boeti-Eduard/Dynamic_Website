<?php

session_start();

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

if (isset($_SESSION['user']))
	{
		header("Location: ./index.php");
		exit;
	}


if (isset($_POST['submit']))
{
	$username=trim($_POST['username']);
	$password=trim($_POST['password']);
}

$error='';
if(empty($username))
		$error .= '1';
if (empty($password))
		$error .= '1';

if(empty($error))
{
	$sql = "SELECT username, password FROM user";
	$result= $mysqli->query($sql);
	while($row=$result->fetch_assoc()){	
		
		if (password_verify($password, $row['password']) && $username == $row['username'])
				{
					header("Location: ./index.php");
					$_SESSION['user'] = $username;
					exit;
				}
	}
}


$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
	<head>
			<meta charset="utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<title>Login</title>
	</head>

	<body>
			<h1>	
				<a href="./index.php">Go back</a>
			</h1>
			<p>Enter your login credentials</p>
			<form method="post">
				<label>Username</label>
				<input type="text" name="username">
				<label>Password</label>
				<input type="password" name="password">

				<input type="submit" name="submit" value="Submit">
			</form>
			<a href="./register.php">Register here</a>
	</body>

</html>