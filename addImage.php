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

$ID = mysqli_real_escape_string($conn, $_GET['ID']);
?>

<html>
	<head>
	<title>Adding Image</title>
	<link rel="shortcut icon" href="images/favicon.ico">
	
	<link rel="stylesheet" href = "style.css">			
</head>
<body>
<br><br>
<form method="POST" enctype="multipart/form-data">
	<center>
	<table class="addInfo">
		<thead>
			<tr>
				<th>New Image</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><center><input type="file" name="image"></center></td>
			</tr>

		</tbody>
		<tfoot>
			<tr>
				<th>
					<center><input type="submit" value="Add Image" name = "submitImage"></center>
				</th>			
			</tr>
		</tfoot>	
	</table>
	</center>
</form>

<?php
	if(isset($_POST['submitImage'])){
		if(getimagesize($_FILES['image']['tmp_name']) == FALSE){
			echo "Select an image";
		}
		else{
			$image = addslashes($_FILES['image']['tmp_name']);
			$name = addslashes($_FILES['image']['name']);
			$image = file_get_contents($image);
			$image = base64_encode($image);
			
			$query = "INSERT INTO Image (CarID, Name, Image) VALUES ('$ID', '$name', '$image')";
			$result = mysqli_query($conn, $query);
			
			if(mysqli_query($conn, $query)){
				//closes the window once image is uploaded
				echo "<script>window.close();</script>";
			}
			else{
				mysqli_error();
			}
		}
	}
?>
</body>
</html>