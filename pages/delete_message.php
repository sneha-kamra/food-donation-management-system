<?php
include("../includes/dbconnect.php");

$id = $_GET['id'];

mysqli_query($conn,"DELETE FROM contact_messages WHERE id='$id'");

header("Location: admin_messages.php");
?>