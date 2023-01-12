<!-- PHP code to establish connection with the localserver -->
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

if(empty($_SESSION['user']))
	header("Location: ./login.php");

$user = $_SESSION['user'];

$sql = " SELECT * FROM list WHERE username = '".$user."' ORDER BY date_added DESC";
$count_sql = "SELECT COUNT(username) AS Row_count FROM list WHERE username = '".$user."' ";

$result = $mysqli->query($sql);
$result_count = $mysqli->query($count_sql);

if(isset($_GET['l']))
{
	$rm_title = mysqli_real_escape_string($mysqli, $_GET['l']);
	$user = $_SESSION['user'];
	$rm_query = "DELETE FROM list WHERE username = '$user' AND title = '$rm_title' ";

	$mysqli->query($rm_query);

	header("Location: ./history.php");

}


$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Downloaded</title>
</head>

<body>
	<section>
		<h1>Currently: Download history</h1>
		<h2><a href="./index.php">Go home</a>
		</h2>
		<h3>
				<?php
					$user = $_SESSION['user'];
					echo "Hello, $user!";
				?>
				|
				<a href="./logout.php">Logout</a>
		</h3>

		<?php
		$row_count = $result_count->fetch_assoc();

			if($row_count['Row_count'] == 0)
					echo 'You currently have no downloads';

			else if ($row_count['Row_count'] != 0){

		?>
		<table border=1>
			<tr>
				<th>Title</th>
				<th>Date Added</th>
				<th></th>
			</tr>
			<?php
				while($rows=$result->fetch_assoc())
				{
			?>
			<tr>
				<td><?php echo $rows['title'];?></td>
				<td><?php echo $rows['date_added'];?></td>
				<td><a href="./history.php?l=
						<?php
							echo $rows['title'];
						?>
					">Remove</a></td>
			</tr>
			<?php
				}
			}
			?>
		</table>
	</section>
</body>

</html>
