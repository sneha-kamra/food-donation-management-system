<?php
include("../includes/dbconnect.php");
?>

<h2>All Food Donations</h2>

<table border="1" cellpadding="10">
<tr>
<th>Name</th>
<th>Food</th>
<th>Quantity</th>
<th>Location</th>
<th>Pickup Time</th>
<th>Contact</th>
<th>Status</th>
<th>Claimed By</th>
</tr>

<?php
$query="SELECT * FROM donors";
$result=mysqli_query($conn,$query);

while($row=mysqli_fetch_assoc($result)){
?>
<tr>
<td><?php echo $row['name']; ?></td>
<td><?php echo $row['food_type']; ?></td>
<td><?php echo $row['quantity']; ?></td>
<td><?php echo $row['location']; ?></td>
<td><?php echo $row['pickup_time']; ?></td>
<td><?php echo $row['contact']; ?></td>
<td><?php echo $row['status']; ?></td>
<td><?php echo $row['claimed_by']; ?></td>
</tr>
<?php } ?>
</table>