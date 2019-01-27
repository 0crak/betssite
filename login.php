<!DOCTYPE HTML>
<html>
<head>
<title>Bootstrap Login</title>

<!-- bootstrap-3.3.7 -->
<link rel="stylesheet" href="bootstrap-3.3.7/css/bootstrap.min.css">
<script src="bootstrap-3.3.7/js/bootstrap.min.js"></script>

<!-- JQUERY -->
<script type="text/javascript" language="javascript" src="jquery/jquery.js"></script>

<link href="style/style.css" rel="stylesheet" type="text/css" media="all"/>
<script type="text/javascript" language="javascript" src="style/style.js"></script>

</head>
<body>

<div class="container">
        <div class="card card-container">
            <img id="profile-img" class="profile-img-card" src="img/avatar_2x.png" />
            <p id="profile-name" class="profile-name-card"></p>
            <form class="form-signin" action="" method="POST">

                <input type="usernick" id="inputLogin" name="usernick" class="form-control" placeholder="usernick" required autofocus>
                <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
                <br>
                <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit"  name="login">Sign in</button>
            </form>

        </div>
</div>

</body>
</html>
<?php
include "db_con.php";

IF(ISSET($_POST['login'])){


	$usernick = $_POST['usernick'];
	$password = $_POST['password'];
  $data = mysqli_query($con,"SELECT * FROM users WHERE login='$usernick' AND password='$password'");
  $row = $data->fetch_assoc();
  echo $row['login'];
	IF($row['login']!=null)
	{
    $role = mysqli_fetch_assoc($data,"SELECT role FROM users WHERE login ='$usernick'");
    session_start();
    IF($row['role']=="admin")
    {
          $_SESSION['name'] = $_POST['usernick'];
          echo "<script language=\"javascript\">alert(\"welcome \");document.location.href='admin.php';</script>";
    }

    else if($row['role']=="moderator")
    {
            $_SESSION['name'] = $_POST['usernick'];
          echo "<script language=\"javascript\">alert(\"welcome \");document.location.href='moderator.php';</script>";
    }

    else
    {
          $_SESSION['name'] = $_POST['usernick'];
          echo "<script language=\"javascript\">alert(\"welcome \");document.location.href='gracz.php';</script>";
    }

	}
  else
    {
		echo "<script language=\"javascript\">alert(\"Invalid username or password\");document.location.href='login.php';</script>";
	  }
}
?>
