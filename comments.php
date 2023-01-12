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

$sql = "SELECT * FROM comment INNER JOIN nyaa ON nyaa.title = comment.title ORDER BY date DESC";
$result = $mysqli->query($sql);

$sql_title = "SELECT * FROM nyaa";
$result_title = $mysqli->query($sql_title);

if(isset($_SESSION['user']) && !empty($_POST['comment']) && isset($_POST['title']))
			{
				$add_comment = mysqli_real_escape_string($mysqli, $_POST['comment']);
				$add_user = mysqli_real_escape_string($mysqli, $_SESSION['user']);
				$add_title = mysqli_real_escape_string($mysqli, $_POST['title']);
				$add_query = "INSERT INTO comment VALUES ('$add_user', '$add_comment', '$add_title', now())";
				$mysqli->query($add_query);
				header("Location: ./comments.php");

			}

if(isset($_SESSION['user']) && isset($_GET['l']))
			{
				$add_user_history = mysqli_real_escape_string($mysqli, $_SESSION['user']);
				$add_link_history = mysqli_real_escape_string($mysqli, $_GET['l']);
				$add_query_history = 
							"INSERT INTO list VALUES ('$add_user_history', '$add_link_history', now())";
				$mysqli->query($add_query_history);
				header("Location: ./comments.php");
			}
if(isset($_GET['ru']) && isset($_GET['rd']))
			{
						
				if($_SESSION['user'] == $_GET['ru'])
				{
						$rm_user = mysqli_real_escape_string($mysqli, $_GET['ru']);
						$rm_date = mysqli_real_escape_string($mysqli, $_GET['rd']);
						$sql_rm = "DELETE FROM comment WHERE username = '$rm_user' AND date = '$rm_date'";
						$mysqli->query($sql_rm);
						header("Location: ./comments.php");
				}
				else
					header("Location: ./comments.php");
			}			

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
	
	<head>

			<meta charset="utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<title>Comments</title>
	</head>

	<body>

		<h1>Currently: <a href="./comments.php">Comments</a></h1>
		<h2><a href="./index.php">Go home</a></h2>
		<p><?php 
		if(isset($_SESSION['user']))
				{
					$user=$_SESSION['user'];
					echo "Hello, $user!";
				}
		else
				echo "Not logged in";
			?>
		</p>

		<form method="post">
					
				<label>Select a title: </label>
			<br>	
				<select name="title">
					<option value=""></option>
				<?php 
					while($rows_title=$result_title->fetch_assoc())
					{
				?>		
					<option value="<?php echo $rows_title['title'];?>"> 
							<?php echo $rows_title['title'];?>
					</option>
				<?php
					}
				?>	
				</select>	
			</br>
				<label>Make the comment here:</label>
					
				<input type="text" name="comment">
			
				<input type="submit" name="submit" value="Submit">
		</form>
			
			<table border=1>
				<tr>
					<th>User</th>
					<th>Title</th>
					<th>Comment</th>
					<th>Date</th>
					<th></th>
				</tr>
					<?php
						while($rows=$result->fetch_assoc())
						{
					?>
				<tr>
					<td><?php echo $rows['username'];?></td>
					<td>
						<a href="./comments.php?l=<?php echo $rows['title'];?>"  onclick="window.open('<?php echo $rows['link'];?>')"> 
							<?php
								echo $rows['title'];
							?>
						</a>
					</td>
					<td><?php echo $rows['comment'];?></td>
					<td><?php echo $rows['date'];?></td>
					<td> 
						<?php
							$user = $_SESSION['user'];
							$user_check = $rows['username'];
							if($user == $user_check)
								{
									echo '<a href="./comments.php?ru='.$rows['username'].'&rd='.$rows['date'].'">Remove</a';
								}
						?>
					</td>
				</tr>
					<?php
						}
					?>
			</table>

	</body>

</html>