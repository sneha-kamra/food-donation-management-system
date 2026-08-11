<?php
session_start();
if(!isset($_SESSION['admin_id'])){
    header("Location: admin_login.php");
    exit();
}
?>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$conn = new mysqli("sql106.hstn.me", "mseet_41388470", "Foodshare1234", "mseet_41388470_foodshare");

// Check connection
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Function to safely count rows
function getCount($conn, $table) {
    $check = $conn->query("SHOW TABLES LIKE '$table'");
    if ($check && $check->num_rows > 0) {
        $result = $conn->query("SELECT COUNT(*) AS total FROM `$table`");
        if ($result && $row = $result->fetch_assoc()) {
            return $row['total'];
        }
    }
    return 0;
}

// Correct table names
$totalDonations = getCount($conn, "donations");       // food donations
$totalRequests = getCount($conn, "help_requests");    // help requests
$totalVolunteers = getCount($conn, "volunteers");
$totalMessages = getCount($conn, "contact_feedback");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Dashboard | ShareTheMeal</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        *{margin:0; padding:0; box-sizing:border-box; font-family:'Poppins',sans-serif;}
        :root{
            --primary:#0f766e;
            --primary-dark:#115e59;
            --accent:#f59e0b;
            --text:#0f172a;
            --muted:#64748b;
            --white:#ffffff;
            --bg:#f8fafc;
            --card:#ffffff;
            --shadow:0 15px 40px rgba(0,0,0,0.08);
            --shadow-hover:0 20px 45px rgba(0,0,0,0.12);
        }
        body{background:linear-gradient(135deg,#f8fafc,#eef6f5); color:var(--text); min-height:100vh;}
        .dashboard{width:min(1200px,92%); margin:auto; padding:50px 0 70px;}
        .topbar{display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:20px; margin-bottom:35px;}
        .topbar h1{font-size:42px; color:var(--primary-dark); font-weight:800;}
        .topbar p{color:var(--muted); margin-top:8px; font-size:16px;}
        .back-btn{display:inline-block; background:var(--accent); color:#111827; text-decoration:none; padding:13px 20px; border-radius:14px; font-weight:700; box-shadow:0 12px 24px rgba(245,158,11,0.25); transition:0.3s ease;}
        .back-btn:hover{transform:translateY(-2px);}
        .stats-grid{display:grid; grid-template-columns:repeat(4,1fr); gap:24px; margin-bottom:45px;}
        .stat-card{background:var(--card); border-radius:28px; padding:30px 24px; box-shadow:var(--shadow); transition:0.35s ease; position:relative; overflow:hidden; cursor:pointer; text-decoration:none; color:inherit;}
        .stat-card:hover{transform:translateY(-6px); box-shadow:var(--shadow-hover);}
        .stat-card::before{content:""; position:absolute; top:0; left:0; width:100%; height:6px; background:linear-gradient(90deg,var(--primary),var(--accent));}
        .stat-label{font-size:15px; color:var(--muted); margin-bottom:14px; font-weight:600;}
        .stat-number{font-size:44px; font-weight:800; color:var(--primary-dark); margin-bottom:8px;}
        .stat-note{font-size:14px; color:#94a3b8;}
        .section-title{font-size:28px; font-weight:800; margin-bottom:22px; color:#0f172a;}
        .actions-grid{display:grid; grid-template-columns:repeat(2,1fr); gap:24px;}
        .action-card{background:#ffffff; border-radius:28px; padding:28px 26px; box-shadow:var(--shadow); transition:0.35s ease; border:1px solid #eef2f7;}
        .action-card:hover{transform:translateY(-5px); box-shadow:var(--shadow-hover);}
        .action-card h3{font-size:24px; margin-bottom:10px; color:var(--primary-dark);}
        .action-card p{color:var(--muted); line-height:1.8; font-size:15px; margin-bottom:20px;}
        .action-btn{display:inline-block; background:var(--primary); color:white; text-decoration:none; padding:12px 18px; border-radius:14px; font-weight:700; transition:0.3s ease;}
        .action-btn:hover{background:var(--primary-dark);}
        .note-box{margin-top:45px; background:linear-gradient(135deg,#0f766e,#115e59); color:white; padding:28px; border-radius:28px; box-shadow:var(--shadow);}
        .note-box h3{font-size:24px; margin-bottom:10px;}
        .note-box p{line-height:1.9; color:#dffaf4;}
        @media(max-width:1100px){.stats-grid{grid-template-columns:repeat(2,1fr);}.actions-grid{grid-template-columns:1fr;}}
        @media(max-width:650px){.stats-grid{grid-template-columns:1fr;}.topbar h1{font-size:32px;}}
    </style>
</head>
<body>

<div class="dashboard">

   <div class="topbar" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:20px; margin-bottom:35px;">
    <div>
        <h1>Admin Dashboard</h1>
        <p>Manage your NGO website records from one place.</p>
    </div>
    <div style="display:flex; gap:10px;">
        <!-- Fixed Back to Website button -->
        <a href="../index.php" class="back-btn" style="background:#f59e0b;">← Back to Website</a>
        <a href="admin_logout.php" class="back-btn" style="background:#dc2626;">Logout</a>
    </div>
</div>

    <!-- STATS -->
    <h2 class="section-title">Quick Stats</h2>
    <div class="stats-grid">
        <a href="admin-donations.php" class="stat-card">
            <div class="stat-label">Food Donations</div>
            <div class="stat-number"><?php echo $totalDonations; ?></div>
            <div class="stat-note">Total donation entries received</div>
        </a>

        <a href="admin-requests.php" class="stat-card">
            <div class="stat-label">Help Requests</div>
            <div class="stat-number"><?php echo $totalRequests; ?></div>
            <div class="stat-note">People requesting support</div>
        </a>

        <a href="admin-volunteers.php" class="stat-card">
            <div class="stat-label">Volunteers</div>
            <div class="stat-number"><?php echo $totalVolunteers; ?></div>
            <div class="stat-note">Join Us form submissions</div>
        </a>

        <a href="admin-contact-messages.php" class="stat-card">
            <div class="stat-label">Contact Messages</div>
            <div class="stat-number"><?php echo $totalMessages; ?></div>
            <div class="stat-note">Feedback / complaints / inquiries</div>
        </a>
    </div>

    <!-- ACTIONS -->
    <h2 class="section-title">Quick Admin Access</h2>
    <div class="actions-grid">
        <div class="action-card">
            <h3>View Food Donations</h3>
            <p>Open and manage all food donation submissions received from donors.</p>
            <a href="admin-donations.php" class="action-btn">Open Donations</a>
        </div>

        <div class="action-card">
            <h3>View Help Requests</h3>
            <p>See all requests submitted by individuals or families seeking food support.</p>
            <a href="admin-requests.php" class="action-btn">Open Requests</a>
        </div>

        <div class="action-card">
            <h3>View Volunteers</h3>
            <p>Check all people who want to join and support your NGO activities.</p>
            <a href="admin-volunteers.php" class="action-btn">Open Volunteers</a>
        </div>

        <div class="action-card">
            <h3>View Contact Messages</h3>
            <p>Read feedback, complaints, general inquiries, and donation-related messages.</p>
            <a href="admin-contact-messages.php" class="action-btn">Open Messages</a>
        </div>
    </div>

    <!-- NOTE -->
    <div class="note-box">
        <h3>Important Admin Note</h3>
        <p>
            This dashboard should remain private and should not be shown in the website navbar or footer.
            Use this page only for managing internal website submissions and NGO operations.
        </p>
    </div>

</div>

</body>
</html>