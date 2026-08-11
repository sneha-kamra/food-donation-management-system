<?php
session_start();
if(!isset($_SESSION['volunteer'])){
    header("Location: volunteers_login.php");
    exit();
}
$volunteer = $_SESSION['volunteer'];
?>

<h2>Welcome, <?php echo $volunteer; ?></h2>

<p>Follow the steps below to use FoodShare:</p>

<ul>
<li><a href="donate.php">1️⃣ Donate Food</a></li>
<li><a href="volunteer.php">2️⃣ Volunteer Registration</a></li>
<li><a href="viewfood.php">3️⃣ View Your Donations</a></li>
</ul>