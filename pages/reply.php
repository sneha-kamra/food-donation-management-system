<?php
include("../includes/dbconnect.php");

$id = $_GET['id'];

if(isset($_POST['send'])){
$reply = $_POST['reply'];

mysqli_query($conn,"UPDATE contact_messages 
SET reply='$reply', status='Replied' WHERE id='$id'");

header("Location: admin_messages.php");
}
?>

<form method="POST">
<textarea name="reply" placeholder="Write reply" required></textarea>
<br><br>
<button name="send">Send Reply</button>
</form>