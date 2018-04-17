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

//$ID == CarID
$ID = mysqli_real_escape_string($conn, $_GET['ID']);
$query = "SELECT * FROM Car WHERE CarID = '$ID'";
$result = mysqli_query($conn, $query);

$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Vehicle Details</title>
	<link rel="shortcut icon" href="images/favicon.ico">
	
	<!--
		tableStyle.css code from https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css	
	
		table sorter from https://datatables.net/
	-->
	
	<link rel="stylesheet" href="tableStyle.css">	
	<link rel="stylesheet" href = "style.css">	
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
	<script>
	$(document).ready(function(){
    $('#repairTable').DataTable();
	});
	</script>
	
	<!-- http://www.textfixer.com/html/create-jquery-popups.php -->
<script type="text/javascript">
	//initialize the 3 popup css class names - create more if needed
	var matchClass=['popup1','popup2','popup3'];
	//Set your 3 basic sizes and other options for the class names above - create more if needed
	var popup1 = 'width=400,height=300,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=20,top=20';
	var popup2 = 'width=700,height=600,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=20,top=20';
	var popup3 = 'width=1000,height=750,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=20,top=20';
	
	//The pop-up function
	function tfpop(){
			var x = 0;
			var popClass;
			//Cycle through the class names
			while(x < matchClass.length){
					popClass = "'."+matchClass[x]+"'";
					//Attach the clicks to the popup classes
					$(eval(popClass)).click(function() {
							//Get the destination URL and the class popup specs
							var popurl = $(this).attr('href');
							var popupSpecs = $(this).attr('class');
							//Create a "unique" name for the window using a random number
							var popupName = Math.floor(Math.random()*10000001);
							//Opens the pop-up window according to the specified specs
							newwindow=window.open(popurl,popupName,eval(popupSpecs));
							return false;
					});							
			x++;
			} 
	}
	
	//Wait until the page loads to call the function
	$(function() {
		tfpop();
	});
</script>


<!-- test script for multiple images in same place
<script language="javascript">
<!--

var state = 'none';

function showhide(layer_ref) {

if (state == 'block') {
state = 'none';
}
else {
state = 'block';
}
/*
if (document.all) { //IS IE 4 or 5 (or 6 beta)
eval( "document.all." + layer_ref + ".style.display = state");
}
if (document.layers) { //IS NETSCAPE 4 or below
document.layers[layer_ref].display = state;
}*/
if (document.getElementById &&!document.all) {
hza = document.getElementById(layer_ref);
hza.style.display = state;

}
}
//
</script> 
-->

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
		<a href="archive.php">Archive</a> |
		<a href="buyers.php">Buyers</a>
	</div>
	</center>

	<!--<div class="leftFormat">-->
<?php
	
	if($row['Status'] == "Available"){	
	
		/****************
		images
		*****************/
		
		/* retrieve images from database */
		$query = "SELECT * FROM Image WHERE CarID = '$ID'";
		$result = mysqli_query($conn, $query);
		$rowCount = mysqli_num_rows($result);

		/* displays all images retrieved from database */
		while ($row2 = mysqli_fetch_assoc($result)){
			echo '<div class="imgContainer">';
			echo "<a href=\"image.php?ID={$row2['ImageID']}\">";
			echo '<img src = "data:image;base64,'.$row2["Image"].' " class="p1">';
			echo '</a>';
			echo '</div> ';
		}

		/***************
		info table
		****************/
		
		/* displays top row in info table */
		echo '<table class="infoTableHead">';
			echo '<thead>';
				echo '<tr>';
					echo '<th>';
						echo '<a href="edit.php?edit=Year&CarID='.$ID.'" class = "popup1">'.$row["Year"].'</a> '.
						     '<a href="edit.php?edit=Make&CarID='.$ID.'" class = "popup1">'.$row["Make"].'</a> '.
							 '<a href="edit.php?edit=Model&CarID='.$ID.'" class = "popup1">'.$row["Model"].'</a> ';
					echo '</th>';
				echo '</tr>';
			echo '</thead>';
		echo '</table>';


		/* displays main info in table */
		echo "<table class=\"infoTableBody\">";
			echo "<tbody>";
				echo "<tr>";
					echo "<td>";
						echo '<a href="edit.php?edit=Miles&CarID='.$ID.'" class = "popup1" id="blackLink">Miles</a>';
					echo "</td>";
					echo "<td>";
						echo $row["Miles"];
					echo "</td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td>";
						echo '<a href="edit.php?edit=Vin&CarID='.$ID.'" class = "popup1" id="blackLink">Vin</a>';
					echo "</td>";
					echo "<td>";
						echo $row["Vin"];
					echo "</td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td>";
						echo '<a href="edit.php?edit=Cost&CarID='.$ID.'" class = "popup1" id="blackLink">Cost</a>';
					echo "</td>";
					echo "<td>";
						echo "$ {$row["Cost"]}";
					echo "</td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td>";
						echo '<a href="edit.php?edit=Fees&CarID='.$ID.'" class = "popup1" id="blackLink">Fees</a>';
					echo "</td>";
					echo "<td>";
						echo "$ {$row["Fees"]}";
					echo "</td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td>";
						echo '<a href="edit.php?edit=AskingPrice&CarID='.$ID.'" class = "popup1" id="blackLink">Asking Price</a>';
					echo "</td>";
					echo "<td>";
						echo "$ {$row["AskingPrice"]}";
					echo "</td>";
				echo "</tr>	";
				echo "<tr>";
					echo "<td>";
						echo '<a href="edit.php?edit=DatePurchased&CarID='.$ID.'" class = "popup1" id="blackLink">Date Purchased</a>';
					echo "</td>";
					echo "<td>";
						echo $row["DatePurchased"];
					echo "</td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td>";
						echo "Status";
					echo "</td>";
					echo "<td>";
						echo $row["Status"];
				echo "</td>";
				echo "</tr>	";		
		echo '</tbody>';
		echo '</table>';

		/* displays bottom row of table ie sell, add image, remove, add repair */
		echo '<table class="infoTableFoot">';
			echo '<tfoot class="shadow">';
				echo '<tr>';
					echo '<th>';
						echo "<a href=\"addBuyer.php?ID={$row['CarID']}\">Sell</a> | 
							<a href=\"addImage.php?ID={$row['CarID']}\" class=\"popup1\">Add Image</a> | 
							<a href = \"removeVehicle.php?ID={$row['CarID']}\">Remove<a/> | 
							<a href = \"addRepair.php?ID={$row['CarID']}\">Add Repair<a/>";				
					echo '</th>'; 
				echo '</tr>';
			echo '</tfoot>';	
		echo '</table>';
	
		/***************
		repair table
		****************/
			
		/* displays "Repair List" header */
		echo "<div class=detailsTableTitle>";
				echo "Repair List and Information";
		echo "</div>";
		
		/* retrieves info from Repair table */
		$query2 = "SELECT * FROM Repair WHERE CarID = '$ID'";
		$result2 = mysqli_query($conn, $query2);
		
		/* displays info from Repair table */
		echo '<div class="detailsTableBox">';
			echo '<table id="repairTable" class="display" cellspacing="0" width="100%">';
				echo '<thead>';
					echo '<tr>';
						echo '<th>Part Name</th>';
						echo '<th>Part Cost</th>';
						echo '<th>Labor</th>';
						echo '<th>Comments</th>';
					echo '</tr>';
				echo '</thead>	';	
				
				echo '<tbody>';
						while($row2 = mysqli_fetch_array($result2)){
							echo "<tr>";
							echo "<td> <a href=\"edit.php?edit=PartName&RepairID=".$row2['RepairID']."\" class=\"popup1\" id=\"blackLink\">".$row2["PartName"]. "</a></td>";
							echo "<td>$ <a href=\"edit.php?edit=PartCost&RepairID=".$row2['RepairID']."\" class=\"popup1\" id=\"blackLink\">". $row2["PartCost"]. "</a></td>";
							echo "<td>$ <a href=\"edit.php?edit=LaborCost&RepairID=".$row2['RepairID']."\" class=\"popup1\" id=\"blackLink\">". $row2["LaborCost"]. "</a></td>";
							echo "<td> <a href=\"edit.php?edit=Comments&RepairID=".$row2['RepairID']."\" class=\"popup1\" id=\"blackLink\">". $row2["Comments"]. "</a></td>";
							echo "</tr>";
						}
				echo '</tbody>';
		echo '</table>';			
		echo '</div>';
	
	}
	
	else if($row['Status'] == "Sold"){

		/****************
		images
		*****************/
		
		/* retrieve images from database */
		$query = "SELECT * FROM Image WHERE CarID = '$ID'";
		$result = mysqli_query($conn, $query);
		$rowCount = mysqli_num_rows($result);

		/* displays all images retrieved from database */
		while ($row2 = mysqli_fetch_assoc($result)){
			echo '<div class="imgContainer">';
			echo "<a href=\"image.php?ID={$row2['ImageID']}\">";
			echo '<img src = "data:image;base64,'.$row2["Image"].' " class="p1">';
			echo '</a>';
			echo '</div> ';
		}

		/* retrieve info from Balance table */
		$balQuery = "SELECT * FROM Balance WHERE CarID = '$ID'";
		$balResult = mysqli_query($conn, $balQuery);
		$balRow = mysqli_fetch_assoc($balResult);

		/* retrieve info from Balance table */
		/*$buyerQuery = "SELECT * FROM Buyer WHERE Buyer.BuyerID = Car.BuyerID && Car.CarID = '$ID'";*/
		$buyerQuery = "SELECT * FROM Buyer NATURAL JOIN Car WHERE CarID = '$ID'";
		$buyerResult = mysqli_query($conn, $buyerQuery);
		$buyerRow = mysqli_fetch_assoc($buyerResult);
		
		/***************
		info table
		****************/
		
		/* displays top row in info table */
		echo '<table class="infoTableHead">';
			echo '<thead>';
				echo '<tr>';
					echo '<th>';
						echo $row["Year"]. " ". $row["Make"]. " ". $row["Model"];
					echo '</th>';
				echo '</tr>';
			echo '</thead>';
		echo '</table>';


		/* displays main info in table */
		echo "<table class=\"infoTableBody\">";
			echo "<tbody>";
				echo "<tr>";
					echo "<td>";
						echo '<a href="edit.php?edit=Miles&CarID='.$ID.'" class = "popup1" id="blackLink">Miles</a>';
					echo "</td>";
					echo "<td>";
						echo $row["Miles"];
					echo "</td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td>";
						echo '<a href="edit.php?edit=Vin&CarID='.$ID.'" class = "popup1" id="blackLink">Vin</a>';
					echo "</td>";
					echo "<td>";
						echo $row["Vin"];
					echo "</td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td>";
						echo '<a href="edit.php?edit=Cost&CarID='.$ID.'" class = "popup1" id="blackLink">Cost</a>';
					echo "</td>";
					echo "<td>";
						echo "$ {$row["Cost"]}";
					echo "</td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td>";
						echo '<a href="edit.php?edit=Fees&CarID='.$ID.'" class = "popup1" id="blackLink">Fees</a>';
					echo "</td>";
					echo "<td>";
						echo "$ {$row["Fees"]}";
					echo "</td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td>";
						echo '<a href="edit.php?edit=AskingPrice&CarID='.$ID.'" class = "popup1" id="blackLink">Asking Price</a>';
					echo "</td>";
					echo "<td>";
						echo "$ {$row["AskingPrice"]}";
					echo "</td>";
				echo "</tr>	";
				echo "<tr>";
					echo "<td>";
						echo '<a href="edit.php?edit=SoldFor&CarID='.$ID.'&BalanceID='.$balRow['BalanceID'].'" class = "popup1" id="blackLink">Sold For</a>';
					echo "</td>";
					echo "<td>";
						echo "$ {$row["SoldFor"]}";
					echo "</td>";
				echo "</tr>	";
				echo "<tr>";
					echo "<td>";
						echo '<a href="edit.php?edit=DatePurchased&CarID='.$ID.'" class = "popup1" id="blackLink">Date Purchased</a>';
					echo "</td>";
					echo "<td>";
						echo $row["DatePurchased"];
					echo "</td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td>";
						echo '<a href="edit.php?edit=Day&CarID='.$ID.'" class = "popup1" id="blackLink">Message Day</a>';
					echo "</td>";
					echo "<td>";
						echo $row["Day"];
					echo "</td>";
				echo "</tr>	";				
				echo "<tr>";
					echo "<td>";
						echo "Status";
					echo "</td>";
					echo "<td>";
						echo $row["Status"];
					echo "</td>";
				echo "</tr>	";									
		echo '</tbody>';
		echo '</table>';

		/* displays "Price Information" header */
		echo '<table class="infoTableFoot">';
			echo '<tfoot>';
				echo '<tr>';
					echo '<th>';
						echo "Pricing Information";				
					echo '</th>'; 
				echo '</tr>';
			echo '</tfoot>';	
		echo '</table>';						

		
		/* displays total price, payed, owed, and down payment */
		echo "<table class=\"infoTableBody\">";
			echo "<tbody>";
				echo "<tr>";
					echo "<td width = 44%>";
						//uses same link as SoldFor since that link changes both SoldFor and Total
						echo '<a href="edit.php?edit=SoldFor&CarID='.$ID.'&BalanceID='.$balRow['BalanceID'].'" class = "popup1" id="blackLink">Total Price</a>';
					echo "</td>";
					echo "<td width = 56%>";
						echo "$ {$balRow["Total"]}                ";
					echo "</td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td>";
						echo "Paid";
					echo "</td>";
					echo "<td>";
						echo "$ {$balRow["Paid"]}";
					echo "</td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td>";
						echo "Owed";
					echo "</td>";
					echo "<td>";
						echo "$ {$balRow["Owed"]}";
					echo "</td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td>";
						echo "Down Payment";
					echo "</td>";
					echo "<td>";
						echo "$ {$balRow["DownPayment"]}";
					echo "</td>";
				echo "</tr>";										
		echo '</tbody>';
		echo '</table>';
		
		/* displays "Buyer Information" header */
		echo '<table class="infoTableFoot">';
			echo '<tfoot>';
				echo '<tr>';
					echo '<th>';
						echo "Buyer Information";				
					echo '</th>'; 
				echo '</tr>';
			echo '</tfoot>';	
		echo '</table>';

		/* displays buyer name, phone, and additional comments */
		echo "<table class=\"infoTableBody\">";
			echo "<tbody>";
				echo "<tr>";
					echo "<td width = 44%>";
						echo '<a href="edit.php?edit=BuyerName&BuyerID='.$row["BuyerID"].'"class = "popup1" id="blackLink">Name</a>';
					echo "</td>";
					echo "<td>";
						echo $buyerRow["Name"];
					echo "</td width = 56%>";
				echo "</tr>";
				echo "<tr>";
					echo "<td>";
						echo '<a href="edit.php?edit=Phone&BuyerID='.$row["BuyerID"].'"class = "popup1" id="blackLink">Phone</a>';
					echo "</td>";
					echo "<td>";
						echo $buyerRow["Phone"];
					echo "</td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td>";
						echo '<a href="edit.php?edit=BuyerComments&BuyerID='.$row["BuyerID"].'"class = "popup1" id="blackLink">Comments</a>';
					echo "</td>";
					echo "<td>";
						echo $buyerRow["Comments"];
					echo "</td>";
				echo "</tr>";
		echo '</tbody>';
		echo '</table>';	

		
		/* displays bottom row of table ie sell, add image, remove, add repair */
		echo '<table class="infoTableFoot">';
			echo '<tfoot class="shadow">';
				echo '<tr>';
					echo '<th>';
						echo "<a href=\"addImage.php?ID={$row['CarID']}\" class=\"popup1\">Add Image</a> | 
							<a href = \"removeVehicle.php?ID={$row['CarID']}\">Remove<a/> | 
							<a href = \"addRepair.php?ID={$row['CarID']}\">Add Repair<a/> |
							<a href = \"payments.php?ID={$row['CarID']}&BuyerID={$buyerRow['BuyerID']}\" class=\"popup2\">Payments</a>";				
					echo '</th>'; 
				echo '</tr>';
			echo '</tfoot>';	
		echo '</table>';
	
	
		/***************
		Repair Table
		****************/	
	
		/* displays "Repair List" header */
		echo "<div class=detailsTableTitle>";
				echo "Repair List and Information";
		echo "</div>";
	
	
		/* retrieves info from Repair table */
		$query4 = "SELECT * FROM Repair WHERE CarID = '$ID'";
		$result4 = mysqli_query($conn, $query4);
		
		/* displays info from Repair table */
		echo '<div class="detailsTableBox">';
			echo '<table id="repairTable" class="display" cellspacing="0" width="100%">';
				echo '<thead>';
					echo '<tr>';
						echo '<th>Part Name</th>';
						echo '<th>Part Cost</th>';
						echo '<th>Labor</th>';
						echo '<th>Comments</th>';
					echo '</tr>';
				echo '</thead>	';	
				
				echo '<tbody>';
						while($row4 = mysqli_fetch_array($result4)){
							echo "<tr>";
							echo "<td> <a href=\"edit.php?edit=PartName&RepairID=".$row4['RepairID']."\" class=\"popup1\" id=\"blackLink\">".$row4["PartName"]. "</a></td>";
							echo "<td>$ <a href=\"edit.php?edit=PartCost&RepairID=".$row4['RepairID']."\" class=\"popup1\" id=\"blackLink\">". $row4["PartCost"]. "</a></td>";
							echo "<td>$ <a href=\"edit.php?edit=LaborCost&RepairID=".$row4['RepairID']."\" class=\"popup1\" id=\"blackLink\">". $row4["LaborCost"]. "</a></td>";
							echo "<td> <a href=\"edit.php?edit=Comments&RepairID=".$row4['RepairID']."\" class=\"popup1\" id=\"blackLink\">". $row4["Comments"]. "</a></td>";
							echo "</tr>";
						}
				echo '</tbody>';
		echo '</table>';				
		echo '</div>';
	
	/***************
	Repair Table
	****************/				
	}
	else{

		/****************
		images
		*****************/
		
		/* retrieve images from database */
		$query = "SELECT * FROM Image WHERE CarID = '$ID'";
		$result = mysqli_query($conn, $query);
		$rowCount = mysqli_num_rows($result);

		/* displays all images retrieved from database */
		while ($row2 = mysqli_fetch_assoc($result)){
			echo '<div class="imgContainer">';
			echo "<a href=\"image.php?ID={$row2['ImageID']}\">";
			echo '<img src = "data:image;base64,'.$row2["Image"].' " class="p1">';
			echo '</a>';
			echo '</div> ';
		}

		/* retrieve info from Balance table */
		$balQuery = "SELECT * FROM Balance WHERE CarID = '$ID'";
		$balResult = mysqli_query($conn, $balQuery);
		$balRow = mysqli_fetch_assoc($balResult);

		/* retrieve info from Balance table */
		/*$buyerQuery = "SELECT * FROM Buyer WHERE Buyer.BuyerID = Car.BuyerID && Car.CarID = '$ID'";*/
		$buyerQuery = "SELECT * FROM Buyer NATURAL JOIN Car WHERE CarID = '$ID'";
		$buyerResult = mysqli_query($conn, $buyerQuery);
		$buyerRow = mysqli_fetch_assoc($buyerResult);
		
		/***************
		info table
		****************/
		
		/* displays top row in info table */
		echo '<table class="infoTableHead">';
			echo '<thead>';
				echo '<tr>';
					echo '<th>';
						echo $row["Year"]. " ". $row["Make"]. " ". $row["Model"];
					echo '</th>';
				echo '</tr>';
			echo '</thead>';
		echo '</table>';


		/* displays main info in table */
		echo "<table class=\"infoTableBody\">";
			echo "<tbody>";
				echo "<tr>";
					echo "<td>";
						echo '<a href="edit.php?edit=Miles&CarID='.$ID.'" class = "popup1" id="blackLink">Miles</a>';
					echo "</td>";
					echo "<td>";
						echo $row["Miles"];
					echo "</td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td>";
						echo '<a href="edit.php?edit=Vin&CarID='.$ID.'" class = "popup1" id="blackLink">Vin</a>';
					echo "</td>";
					echo "<td>";
						echo $row["Vin"];
					echo "</td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td>";
						echo '<a href="edit.php?edit=Cost&CarID='.$ID.'" class = "popup1" id="blackLink">Cost</a>';
					echo "</td>";
					echo "<td>";
						echo "$ {$row["Cost"]}";
					echo "</td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td>";
						echo '<a href="edit.php?edit=Fees&CarID='.$ID.'" class = "popup1" id="blackLink">Fees</a>';
					echo "</td>";
					echo "<td>";
						echo "$ {$row["Fees"]}";
					echo "</td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td>";
						echo '<a href="edit.php?edit=AskingPrice&CarID='.$ID.'" class = "popup1" id="blackLink">Asking Price</a>';
					echo "</td>";
					echo "<td>";
						echo "$ {$row["AskingPrice"]}";
					echo "</td>";
				echo "</tr>	";
				echo "<tr>";
					echo "<td>";
						echo "Sold For";
					echo "</td>";
					echo "<td>";
						echo "$ {$row["SoldFor"]}";
					echo "</td>";
				echo "</tr>	";
				echo "<tr>";
					echo "<td>";
						echo '<a href="edit.php?edit=DatePurchased&CarID='.$ID.'" class = "popup1" id="blackLink">Date Purchased</a>';
					echo "</td>";
					echo "<td>";
						echo $row["DatePurchased"];
					echo "</td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td>";
						echo "Status";
					echo "</td>";
					echo "<td>";
						echo $row["Status"];
					echo "</td>";
				echo "</tr>	";									
		echo '</tbody>';
		echo '</table>';

		/* displays "Price Information" header */
		echo '<table class="infoTableFoot">';
			echo '<tfoot>';
				echo '<tr>';
					echo '<th>';
						echo "Pricing Information";				
					echo '</th>'; 
				echo '</tr>';
			echo '</tfoot>';	
		echo '</table>';						

		
		/* displays total price, payed, owed, and down payment */
		echo "<table class=\"infoTableBody\">";
			echo "<tbody>";
				echo "<tr>";
					echo "<td width = 44%>";
						echo "Total Price";
					echo "</td>";
					echo "<td width = 56%>";
						echo "$ {$balRow["Total"]}";
					echo "</td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td>";
						echo "Paid";
					echo "</td>";
					echo "<td>";
						echo "$ {$balRow["Paid"]}";
					echo "</td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td>";
						echo "Owed";
					echo "</td>";
					echo "<td>";
						echo "$ {$balRow["Owed"]}";
					echo "</td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td>";
						echo "Down Payment";
					echo "</td>";
					echo "<td>";
						echo "$ {$balRow["DownPayment"]}";
					echo "</td>";
				echo "</tr>";										
		echo '</tbody>';
		echo '</table>';
		
		/* displays "Buyer Information" header */
		echo '<table class="infoTableFoot">';
			echo '<tfoot>';
				echo '<tr>';
					echo '<th>';
						echo "Buyer Information";				
					echo '</th>'; 
				echo '</tr>';
			echo '</tfoot>';	
		echo '</table>';

		/* displays buyer name, phone, and additional comments */
		echo "<table class=\"infoTableBody\">";
			echo "<tbody>";
				echo "<tr>";
					echo "<td width = 44%>";
						echo '<a href="edit.php?edit=BuyerName&BuyerID='.$row["BuyerID"].'"class = "popup1" id="blackLink">Name</a>';
					echo "</td>";
					echo "<td>";
						echo $buyerRow["Name"];
					echo "</td width = 56%>";
				echo "</tr>";
				echo "<tr>";
					echo "<td>";
						echo '<a href="edit.php?edit=Phone&BuyerID='.$row["BuyerID"].'"class = "popup1" id="blackLink">Phone</a>';
					echo "</td>";
					echo "<td>";
						echo $buyerRow["Phone"];
					echo "</td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td>";
						echo '<a href="edit.php?edit=BuyerComments&BuyerID='.$row["BuyerID"].'"class = "popup1" id="blackLink">Comments</a>';
					echo "</td>";
					echo "<td>";
						echo $buyerRow["Comments"];
					echo "</td>";
				echo "</tr>";
		echo '</tbody>';
		echo '</table>';	

		
		/* displays bottom row of table ie sell, add image, remove, add repair */
		echo '<table class="infoTableFoot">';
			echo '<tfoot class="shadow">';
				echo '<tr>';
					echo '<th>';
						echo "<a href=\"addImage.php?ID={$row['CarID']}\" class=\"popup1\">Add Image</a> | 
							<a href = \"removeVehicle.php?ID={$row['CarID']}\">Remove<a/> | 
							<a href = \"archivePayments.php?ID={$row['CarID']}&BuyerID={$buyerRow['BuyerID']}\" class=\"popup2\">Payments</a>";				
					echo '</th>'; 
				echo '</tr>';
			echo '</tfoot>';	
		echo '</table>';
	
		/***************
		Repair Table
		****************/	
	
		/* displays "Repair List" header */
		echo "<div class=detailsTableTitle>";
				echo "Repair List and Information";
		echo "</div>";
	
	
		/* retrieves info from Repair table */
		$query4 = "SELECT * FROM Repair WHERE CarID = '$ID'";
		$result4 = mysqli_query($conn, $query4);
		
		/* displays info from Repair table */
		echo '<div class="detailsTableBox">';
			echo '<table id="repairTable" class="display" cellspacing="0" width="100%">';
				echo '<thead>';
					echo '<tr>';
						echo '<th>Part Name</th>';
						echo '<th>Part Cost</th>';
						echo '<th>Labor</th>';
						echo '<th>Comments</th>';
					echo '</tr>';
				echo '</thead>	';	
				
				echo '<tbody>';
						while($row4 = mysqli_fetch_array($result4)){
							echo "<tr>";
							echo "<td> <a href=\"edit.php?edit=PartName&RepairID=".$row4['RepairID']."\" class=\"popup1\" id=\"blackLink\">".$row4["PartName"]. "</a></td>";
							echo "<td>$ <a href=\"edit.php?edit=PartCost&RepairID=".$row4['RepairID']."\" class=\"popup1\" id=\"blackLink\">". $row4["PartCost"]. "</a></td>";
							echo "<td>$ <a href=\"edit.php?edit=LaborCost&RepairID=".$row4['RepairID']."\" class=\"popup1\" id=\"blackLink\">". $row4["LaborCost"]. "</a></td>";
							echo "<td> <a href=\"edit.php?edit=Comments&RepairID=".$row4['RepairID']."\" class=\"popup1\" id=\"blackLink\">". $row4["Comments"]. "</a></td>";
							echo "</tr>";
						}
				echo '</tbody>';
		echo '</table>';				
		echo '</div>';
}
?>		
</body>
</html>