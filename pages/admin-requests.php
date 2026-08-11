<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$conn = new mysqli("sql106.hstn.me", "mseet_41388470", "Foodshare1234", "mseet_41388470_foodshare");

// Check connection
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Fetch help requests
$result = $conn->query("SELECT * FROM help_requests ORDER BY id DESC");
$totalRequests = $result ? $result->num_rows : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Help Requests | ShareTheMeal</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

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
            --shadow-hover:0 20px 45px rgba(0,0,0,0.12);
        }

        body{
            background:linear-gradient(135deg,#f8fafc,#eef6f5);
            color:var(--text);
            min-height:100vh;
            padding:40px 0;
        }

        .container{
            width:min(1200px,90%);
            margin:auto;
        }

        .page-header{
            background:linear-gradient(135deg,var(--primary),var(--accent));
            color:white;
            padding:28px;
            border-radius:22px;
            margin-bottom:28px;
            box-shadow:0 12px 35px rgba(15, 118, 110, 0.18);
        }

        .page-header h1{
            font-size:2rem;
            font-weight:800;
            margin-bottom:8px;
        }

        .page-header p{
            font-size:0.95rem;
            opacity:0.9;
        }

        .top-bar{
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:20px;
            flex-wrap:wrap;
            gap:12px;
        }

        .back-btn{
            display:inline-block;
            background:var(--accent);
            color:#111827;
            text-decoration:none;
            padding:12px 18px;
            border-radius:14px;
            font-weight:700;
            box-shadow:0 12px 24px rgba(245,158,11,0.25);
            transition:0.3s ease;
        }

        .back-btn:hover{
            transform:translateY(-2px);
        }

        .count-box{
            background:var(--card);
            border-radius:16px;
            padding:14px 18px;
            box-shadow:var(--shadow);
            font-weight:600;
            color:var(--text);
        }

        .table-wrapper{
            background:var(--card);
            border-radius:24px;
            overflow:hidden;
            box-shadow:var(--shadow);
        }

        .table-scroll{
            overflow-x:auto;
        }

        table{
            width:100%;
            border-collapse:collapse;
            min-width:1300px;
        }

        thead{
            background:var(--primary);
            color:white;
        }

        thead th{
            padding:14px 12px;
            text-align:left;
            font-weight:600;
            font-size:0.92rem;
            white-space:nowrap;
        }

        tbody tr{
            border-bottom:1px solid #e2e8f0;
            transition:0.2s ease;
        }

        tbody tr:hover{
            background:#f0fdf4;
        }

        tbody td{
            padding:14px 12px;
            font-size:0.92rem;
            vertical-align:top;
            color:var(--text);
        }

        .name{
            font-weight:700;
        }

        .small-text{
            font-size:0.84rem;
            color:var(--muted);
            margin-top:4px;
        }

        .request-badge{
            display:inline-block;
            padding:6px 12px;
            border-radius:999px;
            font-size:0.82rem;
            font-weight:700;
            background:#f3e8ff;
            color:#7c3aed;
            white-space:nowrap;
        }

        .matched-badge{
            display:inline-block;
            padding:6px 12px;
            border-radius:999px;
            font-size:0.82rem;
            font-weight:700;
            background:#dcfce7;
            color:#166534;
        }

        .pending-badge{
            display:inline-block;
            padding:6px 12px;
            border-radius:999px;
            font-size:0.82rem;
            font-weight:700;
            background:#fef3c7;
            color:#92400e;
        }

        .details-box{
            max-width:260px;
            word-wrap:break-word;
            line-height:1.5;
        }

        .empty-state{
            text-align:center;
            padding:50px 20px;
            color:var(--muted);
        }

        .empty-state i{
            font-size:3rem;
            color:#d8b4fe;
            margin-bottom:12px;
        }

        .empty-state h3{
            color:var(--text);
            margin-bottom:6px;
            font-size:1.3rem;
        }

        @media(max-width:1100px){
            table{
                min-width:1000px;
            }
        }

        @media(max-width:768px){
            body{
                padding:20px 0;
            }

            .top-bar{
                flex-direction:column;
                align-items:stretch;
            }

            .back-btn, .count-box{
                width:100%;
                justify-content:center;
                text-align:center;
            }
        }
    </style>
</head>
<body>

<div class="container">

    <div class="page-header">
        <h1><i class="fas fa-hands-helping"></i> Help Requests Dashboard</h1>
        <p>View and manage all food assistance requests submitted by individuals and families.</p>
    </div>

    <div class="top-bar">
        <a href="admin-dashboard.php" class="back-btn"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
        <div class="count-box"><i class="fas fa-list"></i> Total Requests: <?php echo $totalRequests; ?></div>
    </div>

    <div class="table-wrapper">
        <div class="table-scroll">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Requester Details</th>
                        <th>Request Type</th>
                        <th>City</th>
                        <th>People Count</th>
                        <th>Needed Date</th>
                        <th>Needed Time</th>
                        <th>Address</th>
                        <th>Details</th>
                        <th>Submitted On</th>
                        <th>Donation Match</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                if($result && $result->num_rows>0){
                    while($row=$result->fetch_assoc()){
                        echo "<tr>";
                        echo "<td>#".htmlspecialchars($row['id'])."</td>";
                        echo "<td><div class='name'>".htmlspecialchars($row['fullname'])."</div>";
                        echo "<div class='small-text'>".htmlspecialchars($row['email'])."</div>";
                        echo "<div class='small-text'>".htmlspecialchars($row['phone'])."</div></td>";
                        echo "<td><span class='request-badge'>".htmlspecialchars($row['request_type'])."</span></td>";
                        echo "<td>".htmlspecialchars($row['city'])."</td>";
                        echo "<td>".htmlspecialchars($row['people_count'])."</td>";
                        echo "<td>".htmlspecialchars($row['needed_date'])."</td>";
                        echo "<td>".htmlspecialchars($row['needed_time'])."</td>";
                        echo "<td><div class='details-box'>".nl2br(htmlspecialchars($row['address']))."</div></td>";
                        echo "<td><div class='details-box'>".(!empty($row['details']) ? nl2br(htmlspecialchars($row['details'])) : "<span style='color:#94a3b8;'>No extra details</span>")."</div></td>";
                        echo "<td>".htmlspecialchars($row['created_at'])."</td>";
                        echo "<td>".(!empty($row['donation_id']) ? "<span class='matched-badge'>Matched with Donation #".htmlspecialchars($row['donation_id'])."</span>" : "<span class='pending-badge'>Not Matched Yet</span>")."</td>";
                        echo "</tr>";
                    }
                }else{
                    echo "<tr><td colspan='11'><div class='empty-state'><i class='fas fa-inbox'></i><h3>No Help Requests Found</h3><p>No assistance requests have been submitted yet.</p></div></td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

</body>
</html>

<?php $conn->close(); ?>