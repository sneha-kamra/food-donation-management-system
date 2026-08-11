<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$conn = new mysqli("sql106.hstn.me", "mseet_41388470", "Foodshare1234", "mseet_41388470_foodshare");

// Check connection
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Check if volunteers table exists
$checkTable = $conn->query("SHOW TABLES LIKE 'volunteers'");

$volunteerData = null;
$tableExists = false;

if ($checkTable && $checkTable->num_rows > 0) {
    $tableExists = true;

    // Safe query without forcing missing columns
    $volunteerData = $conn->query("SELECT * FROM volunteers");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Volunteers | ShareTheMeal</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:'Poppins',sans-serif;
        }

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
        }

        body{
            background:linear-gradient(135deg,#f8fafc,#eef6f5);
            color:var(--text);
            min-height:100vh;
            padding:40px 20px;
        }

        .container{
            width:min(1250px, 95%);
            margin:auto;
        }

        .topbar{
            display:flex;
            justify-content:space-between;
            align-items:center;
            flex-wrap:wrap;
            gap:20px;
            margin-bottom:30px;
        }

        .topbar h1{
            font-size:40px;
            color:var(--primary-dark);
            font-weight:800;
        }

        .topbar p{
            color:var(--muted);
            margin-top:8px;
            font-size:16px;
        }

        .back-btn{
            display:inline-block;
            background:var(--accent);
            color:#111827;
            text-decoration:none;
            padding:13px 20px;
            border-radius:14px;
            font-weight:700;
            box-shadow:0 12px 24px rgba(245,158,11,0.25);
            transition:0.3s ease;
        }

        .back-btn:hover{
            transform:translateY(-2px);
        }

        .table-wrap{
            background:var(--card);
            border-radius:28px;
            box-shadow:var(--shadow);
            overflow:auto;
            padding:10px;
        }

        table{
            width:100%;
            border-collapse:collapse;
            min-width:1100px;
        }

        th, td{
            padding:18px 16px;
            text-align:left;
            border-bottom:1px solid #e2e8f0;
            vertical-align:top;
            font-size:14px;
        }

        th{
            background:#f1f5f9;
            color:#0f172a;
            font-weight:700;
        }

        tr:hover{
            background:#f8fafc;
        }

        .badge{
            display:inline-block;
            background:#ecfeff;
            color:var(--primary-dark);
            padding:6px 12px;
            border-radius:999px;
            font-size:12px;
            font-weight:700;
        }

        .empty-box{
            background:white;
            border-radius:28px;
            box-shadow:var(--shadow);
            padding:45px 30px;
            text-align:center;
        }

        .empty-box h2{
            font-size:28px;
            margin-bottom:12px;
            color:var(--primary-dark);
        }

        .empty-box p{
            color:var(--muted);
            line-height:1.8;
        }

        .warning-box{
            margin-top:30px;
            background:linear-gradient(135deg,#0f766e,#115e59);
            color:white;
            padding:26px;
            border-radius:24px;
            box-shadow:var(--shadow);
        }

        .warning-box h3{
            font-size:22px;
            margin-bottom:10px;
        }

        .warning-box p{
            color:#dffaf4;
            line-height:1.8;
        }

        @media(max-width:700px){
            .topbar h1{
                font-size:30px;
            }
        }
    </style>
</head>
<body>

<div class="container">

    <div class="topbar">
        <div>
            <h1>Volunteer Submissions</h1>
            <p>Manage all people who submitted the Join Us / Volunteer form.</p>
        </div>
        <a href="admin-dashboard.php" class="back-btn">← Back to Dashboard</a>
    </div>

    <?php if(!$tableExists): ?>
        <div class="empty-box">
            <h2>Volunteers Table Not Found</h2>
            <p>
                Your database does not currently contain a <strong>volunteers</strong> table.
                Once your volunteer form is connected to the database, entries will appear here.
            </p>
        </div>
    <?php else: ?>

        <?php if($volunteerData && $volunteerData->num_rows > 0): ?>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>City</th>
                            <th>Age</th>
                            <th>Activity</th>
                            <th>Availability</th>
                            <th>Why do you want to volunteer?</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $volunteerData->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['id'] ?? '-'; ?></td>
                                <td><?php echo htmlspecialchars($row['fullname'] ?? '-'); ?></td>
                                <td><?php echo htmlspecialchars($row['email'] ?? '-'); ?></td>
                                <td><?php echo htmlspecialchars($row['phone'] ?? '-'); ?></td>
                                <td><?php echo htmlspecialchars($row['city'] ?? '-'); ?></td>
                                <td><?php echo htmlspecialchars($row['age'] ?? '-'); ?></td>
                                <td><span class="badge"><?php echo htmlspecialchars($row['activity'] ?? '-'); ?></span></td>
                                <td><?php echo htmlspecialchars($row['availability'] ?? '-'); ?></td>
                                <td><?php echo nl2br(htmlspecialchars($row['reason'] ?? '-')); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="empty-box">
                <h2>No Volunteer Entries Yet</h2>
                <p>
                    Your volunteers table exists, but no one has submitted the Join Us form yet.
                    Once someone fills the volunteer form, their details will appear here.
                </p>
            </div>
        <?php endif; ?>

    <?php endif; ?>

    <div class="warning-box">
        <h3>Private Admin Area</h3>
        <p>
            This page should remain private and should not be added to your public website navigation.
            Use it only for managing volunteer form submissions.
        </p>
    </div>

</div>

</body>
</html>