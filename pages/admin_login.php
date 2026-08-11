<?php
session_start();
$conn = new mysqli("sql106.hstn.me", "mseet_41388470", "Foodshare1234", "mseet_41388470_foodshare");
$error = "";

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $sql = "SELECT id FROM admins WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $_SESSION['admin_id'] = $row['id'];
        header("Location: admin-dashboard.php");
        exit();
    } else {
        $error = "Invalid username or password.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | ShareTheMeal</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; font-family:'Poppins',sans-serif; }
        body { display:flex; justify-content:center; align-items:center; min-height:100vh; background:linear-gradient(135deg,#0f766e,#f59e0b); }
        .login-box { background:#fff; padding:40px; border-radius:20px; box-shadow:0 15px 40px rgba(0,0,0,0.2); width:350px; text-align:center; }
        .login-box h2 { margin-bottom:30px; color:#0f766e; }
        .login-box input { width:100%; padding:12px 15px; margin:10px 0; border-radius:10px; border:1px solid #ccc; font-size:16px; }
        .login-box button { width:100%; padding:12px; margin-top:15px; border:none; border-radius:10px; background:#0f766e; color:#fff; font-size:18px; cursor:pointer; transition:0.3s; }
        .login-box button:hover { background:#115e59; }
        .error { color:red; margin-top:10px; font-size:14px; }
        .login-footer { margin-top:20px; font-size:14px; color:#64748b; }
    </style>
</head>
<body>

<div class="login-box">
    <h2>Admin Login</h2>
    <?php if($error!="") echo "<div class='error'>$error</div>"; ?>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
    <div class="login-footer">ShareTheMeal NGO Admin Panel</div>
</div>

</body>
</html>