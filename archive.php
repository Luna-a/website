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

//$name = $_SESSION['login_user'];
$query = "SELECT * FROM Car WHERE User = 'User1' AND Status = 'Archive'";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
	<head>
	<title>Archive</title>
	<link rel="shortcut icon" href="images/favicon.ico">
	
	<!--
		tableStyle.css code from https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css	
	
		table sorter from https://datatables.net/
	-->
	
	<link rel="stylesheet" href="tableStyle.css">
	<link rel="stylesheet" href = "style.css">	
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
	
	<!--
	adds:
		sortable tables
		search
		multiple pages
	-->
	
	<script>
	$(document).ready(function(){
    $('#mainTable').DataTable();
	});
	</script>
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
		<a href="archive.php"><b>Archive</b></a> |
		<a href="buyers.php">Buyers</a>
	</div>
	</center>
	

	<center>
	<table id="mainTable" class="display" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th><a href="addVehicle.php">Add</a></th>
				<th>Year</th>
				<th>Make</th>
				<th>Model</th>
				<th>Vin</th>
				<th>Date Purchased</th>
				<th>Cost</th>
				<th>Fees</th>
				<th>Sold For</th>
				<th>Miles</th>				
			</tr>
		</thead>
		
		<tbody class="test">
<?php
		while($row = mysqli_fetch_array($result)){
			echo "<tr>";
				echo "<td> <a href=\"details.php?ID={$row['CarID']}\" class = \"classTable\">Details</a></td>";
				echo "<td> {$row["Year"]} </td>";
				echo "<td>". $row["Make"]. "</td>";
				echo "<td>". $row["Model"]. "</td>";
				echo "<td>". $row["Vin"]. "</td>";
				echo "<td>". $row["DatePurchased"]. "</td>";
				echo "<td>$ ". $row["Cost"]. "</td>";
				echo "<td>$ ". $row["Fees"]. "</td>";
				echo "<td>$ ". $row["SoldFor"]. "</td>";
				echo "<td>". $row["Miles"]. "</td>";
				
			echo "</tr>";
		}
?>	
		</tbody>
			<tfoot>
			<tr>
				<th><a href="addVehicle.php">Add</a></th>
				<th>Year</th>
				<th>Make</th>
				<th>Model</th>
				<th>Vin</th>
				<th>Date Purchased</th>
				<th>Cost</th>
				<th>Fees</th>
				<th>Sold For</th>
				<th>Miles</th>				
			</tr>
		</tfoot>
	</table>
	</center>
</body>
</html>