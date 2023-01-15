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
$sort=pubDate;
$order=desc;
if(isset($_GET['s']))
		$sort=$_GET['s'];
if(isset($_GET['o']))
		$order=$_GET['o'];

$search = strtoupper($_GET['q']);

if(isset($_GET['q']) == false)	
		$sql = " SELECT * FROM nyaa ORDER BY $sort $order";
else
		$sql = " SELECT * FROM nyaa WHERE UPPER(title) LIKE '%{$search}%' ORDER By $sort $order ";
		

if(isset($_GET['l']) && isset($_SESSION['user']))
		{
				$user = mysqli_real_escape_string($mysqli ,$_SESSION['user']);
				$title = mysqli_real_escape_string($mysqli ,$_GET['l']);
				$insert = "INSERT INTO list (username, title, date_added)
					VALUES( '$user', '$title' ,now())";
				$mysqli->query($insert);
				header("Location: ./index.php");

		}

$result = $mysqli->query($sql);
$mysqli->close();
?>
<!-- HTML code to display data in tabular format -->
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Nyaa Feed</title>
</head>

<body>
	<section>
		<h1>Currently: <a href="./index.php">Nyaa Raw Feed</a></h1>
		<h2><a href="./official.php">Official Releases Feed</a>
			|
			<a href="./scanlated.php">Scanlated Releases Feed</a>
			|
			<a href="./comments.php">Comments</a>
		</h2>
		<h3>
				<?php
					if(isset($_SESSION['user']))
					{
						$user = $_SESSION['user'];
						echo "Hello, $user!";
					}
					else
						echo '<a href = "./login.php"> Login </a>'
				?>
				|
				<?php
					if(isset($_SESSION['user']))
					{
						echo '<a href = "./history.php">Downloaded</a>
						|';
					}
				?>
				<a href="./logout.php">Logout</a>
		</h3>
		<form id="search"> 
		  <input type="search" id="query" name="q" placeholder="Search for a title">
		  <button>Search</button>
		</form>
		<!-- TABLE CONSTRUCTION -->
		<table border=1>
			<tr>
				<th>Title
					<a href="./index.php?q=<?php echo $_GET['q'];?>&s=title&o=asc" style="text-decoration:none; color:black">&#708</a>
					<a href="./index.php?q=<?php echo $_GET['q'];?>&s=title&o=desc" style="text-decoration:none; color:black">&#709</a>
				</th>
				<th>Link</th>
				<th>Size
					<a href="./index.php?q=<?php echo $_GET['q'];?>&s=size&o=asc" style="text-decoration:none; color:black">&#708</a>
					<a href="./index.php?q=<?php echo $_GET['q'];?>&s=size&o=desc" style="text-decoration:none; color:black">&#709</a>
				</th>
				<th>Date of Upload
					<a href="./index.php?q=<?php echo $_GET['q'];?>&s=pubDate&o=asc" style="text-decoration:none; color:black">&#708</a>
					<a href="./index.php?q=<?php echo $_GET['q'];?>&s=pubDate&o=desc" style="text-decoration:none; color:black">&#709</a>
				</th>
				<th>Trusted
					<a href="./index.php?q=<?php echo $_GET['q'];?>&s=trusted&o=asc" style="text-decoration:none; color:black">&#708</a>
					<a href="./index.php?q=<?php echo $_GET['q'];?>&s=trusted&o=desc" style="text-decoration:none; color:black">&#709</a>
				</th>
			</tr>
			<?php
				while($rows=$result->fetch_assoc())
				{
			?>
			<tr>
				<td><?php echo $rows['title'];?></td>
				<td>
					<a href="./index.php?l=<?php echo $rows['title'];?>" onclick="window.open('<?php echo $rows['link'];?>')" >Here

					</a>
				</td>
				<td><?php 
				 if($rows['size']>=1000)	
				 	{ echo ($rows['size']/1000); echo " GB";}
				else
					{echo $rows['size']; echo " MB";}
				?></td>
				<td><?php echo $rows['pubDate'];?></td>
				<td><?php echo $rows['trusted'];?></td>
			</tr>
			<?php
				}
			?>
		</table>
	</section>
</body>

</html>
