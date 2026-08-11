<?php
session_start();
include("../includes/dbconnect.php");

if(!isset($_SESSION['volunteer'])){
    echo "Please login first";
    exit();
}

if(isset($_GET['id'])){
    $id = intval($_GET['id']);
} else {
    echo "Invalid request";
    exit();
}

$volunteer = $_SESSION['volunteer'];

// ✅ CHECK IF ALREADY CLAIMED
$check = mysqli_query($conn, "SELECT status FROM donors WHERE id='$id'");
$data = mysqli_fetch_assoc($check);

if($data['status'] == 'Claimed'){
    echo "<h3 style='text-align:center;color:red;margin-top:50px;'>❌ This food is already claimed!</h3>";
    echo "<p style='text-align:center;'><a href='viewfood.php'>Go Back</a></p>";
    exit();
}

// ✅ UPDATE WITH EMAIL
$query = "UPDATE donors 
          SET status='Claimed', claimed_by='$volunteer' 
          WHERE id='$id'";

$result = mysqli_query($conn, $query);

if($result){
?>
<!DOCTYPE html>
<html>
<head>
<style>
body{
    font-family:Arial;
    background:#ecfdf5;
}

.success-box{
    background:#d1fae5;
    color:#065f46;
    padding:20px;
    margin:100px auto;
    width:320px;
    text-align:center;
    border-radius:10px;
    font-weight:bold;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}
.email{
    margin-top:10px;
    font-size:14px;
    color:#065f46;
}
</style>
</head>
<body>

<div class="success-box">
    ✅ Food Claimed Successfully!
    <div class="email">
        Claimed by: <?php echo $volunteer; ?>
    </div>
    <br>
    Redirecting...
</div>

<script>
setTimeout(function(){
    window.location = "viewfood.php";
}, 2000);
</script>

</body>
</html>

<?php
} else {
    echo "Error in claiming food";
}
?>