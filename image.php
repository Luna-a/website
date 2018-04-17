<?php
include('Connection.php');
include('Constants.php');

$conn = GetConnection($DBUser, $DBpass, $DBHost, $DBname);
session_start();

if(isset($_SESSION['login_user'])){
	#echo $_SESSION['login_user'];
}
else {
	//echo "not logged in";
	header("location: index.php?noLogin=1");
}

$user = $_SESSION['login_user'];
//$name = $_SESSION['login_user'];

$ID = mysqli_real_escape_string($conn, $_GET['ID']);
$query = "SELECT * FROM Image WHERE ImageID = '$ID'";
$result = mysqli_query($conn, $query);

$row = mysqli_fetch_assoc($result);
?>

<html>
	<head>
	<title>Full Size Image</title>
	<link rel="shortcut icon" href="images/favicon.ico">
	
	<link rel="stylesheet" href="style.css">	
</head>
<body>

	<div class="logout">			
		<a href="account.php">account</a> | 
		<a href="logout.php">log out</a>
	</div>
	
	<center>
	<div class="top">
		<a href="home.php">All</a> | 
		<a href="inventory.php">Inventory</a> | 
		<a href="sold.php">Sold</a> | 
		<a href="archive.php">Archive</a>
	</div>
	<br>
		</center>

<?php
	echo '<center>';
	echo '<img src = "data:image;base64,'.$row["Image"].' " >';
	echo '<br><br><br>';
	echo '<a href = "removeImage.php?ID='.$ID.'">Remove</a>';
	echo '</center>';
	
	
?>
</body>
</html>