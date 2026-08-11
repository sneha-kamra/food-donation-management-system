<?php
session_start();
include("../includes/dbconnect.php");

if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM volunteers WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0){
        $_SESSION['volunteer'] = $email;
        header("Location: viewfood.php");
    } else {
        $error = "Invalid login details!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login</title>

<style>
body{
    font-family:Arial;
    background:#ecfdf5;
}

.container{
    width:350px;
    margin:100px auto;
    background:white;
    padding:30px;
    border-radius:10px;
}

input{
    width:100%;
    padding:10px;
    margin:10px 0;
}

button{
    width:100%;
    padding:10px;
    background:#16a34a;
    color:white;
    border:none;
}
</style>
</head>

<body>

<div class="container">
<h2>Login</h2>

<?php if(isset($error)){ echo "<p style='color:red'>$error</p>"; } ?>

<form method="post">
<input type="email" name="email" placeholder="Email" required>
<input type="password" name="password" placeholder="Password" required>

<button name="login">Login</button>
</form>

</div>

</body>
</html>