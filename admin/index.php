<!DOCTYPE html>
<html lang = "en">
	<head>
		<title>Admin::DATA CENTER::File Management System</title>
		<meta charset = "utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel = "stylesheet" type="text/css" href="css/bootstrap.css" />
		<link rel = "stylesheet" type="text/css" href="css/style.css" />
	</head>
<body>
	<nav class="navbar navbar-light bg-light navbar-fixed-top">
	<!-- <nav class="navbar navbar-default navbar-fixed-top" style="background-color:blue;"> -->
		<div class="container-fluid">
		<img src="barbar.png" alt="" width="50px" height="70px">
		<label class="navbar-brand" id="title">DATA CENTER SMAM1TA</label>

		</div>
	</nav>
	<?php include 'login.php'?>
	<div id = "footer">
		<label class = "footer-title">&copy; Copyright ICT_SMAM1TA <?php echo date("Y", strtotime("+6 HOURS")) ?></label>
	</div>
</body>
</html>