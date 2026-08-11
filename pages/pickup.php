<?php
include("../includes/dbconnect.php");

$id=$_GET['id'];

mysqli_query($conn,"UPDATE donors SET status='Picked Up' WHERE id='$id'");

header("Location:viewfood.php");
?>