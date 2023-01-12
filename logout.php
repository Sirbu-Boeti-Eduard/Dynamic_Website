<?php
session_start();
session_destroy();
header("Location: ./index.php");
?>
<!DOCTYPE html>
<html lang="en">
	<header>
		 <meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
			<title>
				Logout
			</title>
	</header>
</html>