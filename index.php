<?php
include('Mobile_Detect.php');

$detect = new Mobile_Detect;

//redirect to mobile version of site if using mobile device
if($detect->isMobile()){
	//javascript to redirect to mobile version
	echo '<script type="text/javascript">';
	echo 'window.location = "http:.....com"';
	echo "</script>";	
}

session_start();

if(isset($_SESSION['login_user'])){
	#echo $_SESSION['login_user'];
	header("location: home.php");
}
else {
	//echo "not logged in";
	//header("location: noLogin.php");
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link rel="shortcut icon" href="images/favicon.ico">
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<center>
	<div class="frontContainer">
		<img src="images/front.jpg" alt="headlight" class="login">
	</div>

	<?php
	if(isset($_GET['error']) === true)
		echo "<center>Error: Wrong Username or Password</center>";	
	
	if(isset($_GET['noLogin']) === true)
		echo "<center>Error: Must be Logged in to Access That Page</center>";		
	?>

	<form action=loginCheck.php method="POST">
		<p> <input type="text" name="username" placeholder="Username"/>
		<p> <input type="password" name="password" placeholder="Password"/>
		<p> <input type="submit" value="Log In"/>
	</form>
	</center>
</body>
</html>