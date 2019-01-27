<?php
session_start();
IF(ISSET($_SESSION['name'])){
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />
<title>Bootstrap Login</title>
<!-- bootstrap-3.3.7 -->
<link rel="stylesheet" href="bootstrap-3.3.7/css/bootstrap.min.css">
<script src="bootstrap-3.3.7/js/bootstrap.min.js"></script>

<!-- JQUERY -->
<script type="text/javascript" language="javascript" src="jquery/jquery.js"></script>

</head>

<body>

<div class="navbar navbar-default navbar-static-top" role="navigation">
	<div class="container">
            <div class="navbar-header">
                <a class="admin.php" href="index.php">Home </a>
				<a class="navbar-brand" href="#">Navbar 2</a>
				<a class="navbar-brand" href="#">Navbar 3</a>
				<a class="navbar-brand" href="#">Navbar 4</a>
				<a class="navbar-brand pull-right" href="logout.php?destroy"> <span class="glyphicon glyphicon-off"></span> Logout </a>
				<a class="navbar-brand pull-right"><span class="glyphicon glyphicon-user"></span> <?=$_SESSION['name'];?> </a>
            </div>
	</div>

</div>

<div class="container">

<h2>Hallo </h2>
<br>
<p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque dapibus, tortor sit amet rhoncus lobortis,
leo libero suscipit justo, ac tincidunt ligula eros sit amet sem. <br>
Sed lobortis nisl sed diam porttitor, quis lacinia felis lacinia. In urna nulla, consectetur nec nisi vitae,
laoreet pellentesque augue. Donec feugiat, velit eu imperdiet semper,
ante sem suscipit nulla, congue suscipit ipsum tellus commodo ipsum. Sed pharetra orci a volutpat faucibus.
</p>
<br>
</div>
</body>
</html>

<?php
}else{
	echo "<script language=\"javascript\">alert(\"Please login\");document.location.href='login.php';</script>";
}
?>
