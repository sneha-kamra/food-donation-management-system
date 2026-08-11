<?php
session_start();
if (!isset($_SESSION['member_id'])) {
    header("Location: volunteer_login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Member Dashboard | ShareTheMeal</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif;}
        body{
            background:linear-gradient(135deg,#f8fafc,#eef6f5);
            color:#0f172a;
            min-height:100vh;
        }

        .dashboard{
            width:min(1100px,92%);
            margin:auto;
            padding:50px 0 70px;
        }

        .topbar{
            display:flex;
            justify-content:space-between;
            align-items:center;
            flex-wrap:wrap;
            gap:20px;
            margin-bottom:35px;
        }

        .topbar h1{
            font-size:42px;
            color:#115e59;
            font-weight:800;
        }

        .topbar p{
            color:#64748b;
            margin-top:8px;
            font-size:16px;
        }

        .btn{
            display:inline-block;
            text-decoration:none;
            padding:13px 20px;
            border-radius:14px;
            font-weight:700;
            transition:0.3s ease;
        }

        .back-btn{
            background:#f59e0b;
            color:#111827;
            box-shadow:0 12px 24px rgba(245,158,11,0.25);
        }

        .logout-btn{
            background:#dc2626;
            color:white;
        }

        .btn:hover{
            transform:translateY(-2px);
        }

        .card-grid{
            display:grid;
            grid-template-columns:repeat(2,1fr);
            gap:24px;
        }

        .card{
            background:white;
            border-radius:28px;
            padding:30px 24px;
            box-shadow:0 15px 40px rgba(0,0,0,0.08);
        }

        .card h3{
            font-size:24px;
            margin-bottom:18px;
            color:#115e59;
        }

        .info{
            margin-bottom:14px;
            font-size:15px;
            color:#334155;
            line-height:1.8;
        }

        .info strong{
            color:#0f172a;
        }

        .welcome-box{
            margin-bottom:30px;
            background:linear-gradient(135deg,#0f766e,#115e59);
            color:white;
            padding:28px;
            border-radius:28px;
            box-shadow:0 15px 40px rgba(0,0,0,0.08);
        }

        .welcome-box h2{
            font-size:30px;
            margin-bottom:10px;
        }

        .welcome-box p{
            line-height:1.9;
            color:#dffaf4;
        }

        @media(max-width:800px){
            .card-grid{grid-template-columns:1fr;}
            .topbar h1{font-size:32px;}
        }
    </style>
</head>
<body>

<div class="dashboard">

    <div class="topbar">
        <div>
            <h1>Member Dashboard</h1>
            <p>Welcome to your volunteer profile area.</p>
        </div>
        <div style="display:flex; gap:10px;">
            <a href="../index.php" class="btn back-btn">← Back to Website</a>
            <a href="volunteer_logout.php" class="btn logout-btn">Logout</a>
        </div>
    </div>

    <div class="welcome-box">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['member_name']); ?> 👋</h2>
        <p>Thank you for being part of ShareTheMeal. Your support helps create real community impact.</p>
    </div>

    <div class="card-grid">
        <div class="card">
            <h3>Your Profile</h3>
            <div class="info"><strong>Full Name:</strong> <?php echo htmlspecialchars($_SESSION['member_name']); ?></div>
            <div class="info"><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['member_email']); ?></div>
            <div class="info"><strong>City:</strong> <?php echo htmlspecialchars($_SESSION['member_city']); ?></div>
        </div>

        <div class="card">
            <h3>Your Volunteer Details</h3>
            <div class="info"><strong>Selected Activity:</strong> <?php echo htmlspecialchars($_SESSION['member_activity']); ?></div>
            <div class="info"><strong>Availability:</strong> <?php echo htmlspecialchars($_SESSION['member_availability']); ?></div>
            <div class="info"><strong>Motivation:</strong> <?php echo htmlspecialchars($_SESSION['member_message']); ?></div>
        </div>
    </div>

</div>

</body>
</html>