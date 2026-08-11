<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$error = "";

// Database connection
$conn = new mysqli("sql106.hstn.me", "mseet_41388470", "Foodshare1234", "mseet_41388470_foodshare");

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT id, fullname, email, city, activity, availability, message FROM volunteers WHERE email=? AND password=?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $_SESSION['member_id'] = $row['id'];
        $_SESSION['member_name'] = $row['fullname'];
        $_SESSION['member_email'] = $row['email'];
        $_SESSION['member_city'] = $row['city'];
        $_SESSION['member_activity'] = $row['activity'];
        $_SESSION['member_availability'] = $row['availability'];
        $_SESSION['member_message'] = $row['message'];

        header("Location: member-dashboard.php");
        exit();
    } else {
        $error = "Invalid email or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Member Login | ShareTheMeal</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        *{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif;}
        body{
            min-height:100vh;
            background:linear-gradient(rgba(15,23,42,0.65), rgba(15,23,42,0.65)), url("../images/volunteerhero.jpg") center/cover no-repeat;
            display:flex;
            align-items:center;
            justify-content:center;
            padding:20px;
        }

        .login-card{
            width:100%;
            max-width:500px;
            background:rgba(255,255,255,0.95);
            backdrop-filter:blur(14px);
            border-radius:32px;
            padding:40px 32px;
            box-shadow:0 25px 60px rgba(0,0,0,0.18);
            animation:fadeUp 0.8s ease;
        }

        .badge{
            display:inline-block;
            background:#ccfbf1;
            color:#0f766e;
            padding:8px 16px;
            border-radius:999px;
            font-size:13px;
            font-weight:700;
            margin-bottom:18px;
        }

        .login-card h1{
            font-size:38px;
            color:#0f172a;
            margin-bottom:10px;
        }

        .login-card p{
            color:#64748b;
            line-height:1.8;
            margin-bottom:28px;
            font-size:15px;
        }

        .form-group{
            margin-bottom:20px;
        }

        .form-group label{
            display:block;
            font-weight:600;
            margin-bottom:8px;
            color:#0f172a;
        }

        .form-group input{
            width:100%;
            padding:15px 16px;
            border:1px solid #e2e8f0;
            border-radius:16px;
            background:#f8fafc;
            font-size:15px;
            outline:none;
            transition:0.3s ease;
        }

        .form-group input:focus{
            border-color:#0f766e;
            box-shadow:0 0 0 4px rgba(15,118,110,0.10);
            background:white;
        }

        .btn{
            width:100%;
            border:none;
            background:#f59e0b;
            color:#111827;
            padding:15px;
            border-radius:16px;
            font-size:16px;
            font-weight:700;
            cursor:pointer;
            transition:0.3s ease;
            box-shadow:0 12px 24px rgba(245,158,11,0.25);
        }

        .btn:hover{
            transform:translateY(-3px);
        }

        .error{
            background:#fee2e2;
            color:#991b1b;
            padding:14px 16px;
            border-radius:14px;
            margin-bottom:20px;
            font-weight:600;
            font-size:14px;
        }

        .links{
            margin-top:22px;
            text-align:center;
        }

        .links a{
            color:#0f766e;
            text-decoration:none;
            font-weight:600;
        }

        .links a:hover{
            text-decoration:underline;
        }

        @keyframes fadeUp{
            from{opacity:0; transform:translateY(40px);}
            to{opacity:1; transform:translateY(0);}
        }
    </style>
</head>
<body>

    <div class="login-card">
        <span class="badge">Volunteer / Member Access</span>
        <h1>Member Login</h1>
        <p>Login using the same email and password you used while filling the volunteer registration form.</p>

        <?php if(!empty($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>

            <button type="submit" class="btn">Login to Member Dashboard</button>
        </form>

        <div class="links">
            <p style="margin-top:18px;">New volunteer? <a href="volunteer.php">Register here</a></p>
            <p style="margin-top:8px;"><a href="../index.php">← Back to Website</a></p>
        </div>
    </div>

</body>
</html>