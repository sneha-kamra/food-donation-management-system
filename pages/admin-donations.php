<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$conn = new mysqli("sql106.hstn.me", "mseet_41388470", "Foodshare1234", "mseet_41388470_foodshare");

// Check connection
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Update status
if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = intval($_GET['id']);
    $status = $conn->real_escape_string($_GET['status']);

    $allowed_status = ['Pending', 'Approved', 'Picked Up', 'Delivered', 'Rejected'];

    if (in_array($status, $allowed_status)) {
        $conn->query("UPDATE donations SET status='$status' WHERE id=$id");
        header("Location: admin-donations.php");
        exit();
    }
}

// Fetch donations
$result = $conn->query("SELECT * FROM donations ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Food Donations</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #f8fafc;
            color: #0f172a;
            padding: 30px;
        }

        .container {
            max-width: 1400px;
            margin: auto;
        }

        .page-header {
            background: linear-gradient(135deg, #0f766e, #14b8a6);
            color: white;
            padding: 28px;
            border-radius: 22px;
            margin-bottom: 28px;
            box-shadow: 0 12px 35px rgba(20, 184, 166, 0.18);
        }

        .page-header h1 {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 8px;
        }

        .page-header p {
            font-size: 0.98rem;
            opacity: 0.95;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 14px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            background: #0f172a;
            color: white;
            padding: 12px 18px;
            border-radius: 12px;
            font-size: 0.95rem;
            font-weight: 600;
            transition: 0.3s ease;
        }

        .back-btn:hover {
            background: #1e293b;
            transform: translateY(-2px);
        }

        .count-box {
            background: white;
            border-radius: 16px;
            padding: 14px 18px;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
            font-weight: 600;
            color: #0f172a;
        }

        .table-wrapper {
            background: white;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 14px 38px rgba(15, 23, 42, 0.08);
        }

        .table-scroll {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1600px;
        }

        thead {
            background: #0f172a;
            color: white;
        }

        thead th {
            padding: 16px 14px;
            text-align: left;
            font-size: 0.92rem;
            font-weight: 600;
            white-space: nowrap;
        }

        tbody tr {
            border-bottom: 1px solid #e2e8f0;
            transition: 0.2s ease;
        }

        tbody tr:hover {
            background: #f8fafc;
        }

        tbody td {
            padding: 16px 14px;
            font-size: 0.92rem;
            vertical-align: top;
            color: #334155;
        }

        .name {
            font-weight: 700;
            color: #0f172a;
        }

        .small-text {
            font-size: 0.84rem;
            color: #64748b;
            margin-top: 4px;
        }

        .status-badge {
            display: inline-block;
            padding: 8px 14px;
            border-radius: 999px;
            font-size: 0.82rem;
            font-weight: 700;
            white-space: nowrap;
        }

        .pending {
            background: #fef3c7;
            color: #92400e;
        }

        .approved {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .picked {
            background: #e0f2fe;
            color: #0369a1;
        }

        .delivered {
            background: #dcfce7;
            color: #166534;
        }

        .rejected {
            background: #fee2e2;
            color: #b91c1c;
        }

        .action-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .action-buttons a {
            text-decoration: none;
            padding: 8px 12px;
            border-radius: 10px;
            font-size: 0.82rem;
            font-weight: 600;
            transition: 0.2s ease;
            display: inline-block;
        }

        .btn-approve {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .btn-picked {
            background: #e0f2fe;
            color: #0369a1;
        }

        .btn-delivered {
            background: #dcfce7;
            color: #166534;
        }

        .btn-reject {
            background: #fee2e2;
            color: #b91c1c;
        }

        .action-buttons a:hover {
            transform: translateY(-2px);
            opacity: 0.92;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #64748b;
        }

        .empty-state i {
            font-size: 3rem;
            color: #cbd5e1;
            margin-bottom: 16px;
        }

        .empty-state h3 {
            color: #0f172a;
            margin-bottom: 8px;
            font-size: 1.4rem;
        }

        .details-box {
            max-width: 260px;
            line-height: 1.6;
            word-wrap: break-word;
        }

        @media (max-width: 768px) {
            body {
                padding: 16px;
            }

            .page-header {
                padding: 22px 18px;
            }

            .page-header h1 {
                font-size: 1.6rem;
            }

            .top-bar {
                flex-direction: column;
                align-items: stretch;
            }

            .back-btn,
            .count-box {
                width: 100%;
                justify-content: center;
                text-align: center;
            }
        }
    </style>
</head>
<body>

<div class="container">

    <div class="page-header">
        <h1><i class="fas fa-utensils"></i> Food Donations Dashboard</h1>
        <p>Manage all food donation submissions, track their progress, and update delivery status.</p>
    </div>

    <div class="top-bar">
        <a href="admin-dashboard.php" class="back-btn">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>

        <div class="count-box">
            <i class="fas fa-list"></i>
            Total Donations:
            <?php echo $result ? $result->num_rows : 0; ?>
        </div>
    </div>

    <div class="table-wrapper">
        <div class="table-scroll">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Donor Details</th>
                        <th>Contribution Type</th>
                        <th>City</th>
                        <th>Pickup Date</th>
                        <th>Pickup Time</th>
                        <th>Quantity</th>
                        <th>Address</th>
                        <th>Details</th>
                        <th>Submitted On</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>

                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <?php
                            $status = $row['status'] ?? 'Pending';
                            $statusClass = 'pending';

                            if ($status == 'Approved') $statusClass = 'approved';
                            elseif ($status == 'Picked Up') $statusClass = 'picked';
                            elseif ($status == 'Delivered') $statusClass = 'delivered';
                            elseif ($status == 'Rejected') $statusClass = 'rejected';
                        ?>
                        <tr>
                            <td><strong>#<?php echo htmlspecialchars($row['id']); ?></strong></td>

                            <td>
                                <div class="name"><?php echo htmlspecialchars($row['fullname']); ?></div>
                                <div class="small-text"><?php echo htmlspecialchars($row['email']); ?></div>
                                <div class="small-text"><?php echo htmlspecialchars($row['phone']); ?></div>
                            </td>

                            <td><?php echo htmlspecialchars($row['contribution_type']); ?></td>
                            <td><?php echo htmlspecialchars($row['city']); ?></td>
                            <td><?php echo htmlspecialchars($row['pickup_date']); ?></td>
                            <td><?php echo htmlspecialchars($row['pickup_time']); ?></td>
                            <td><?php echo htmlspecialchars($row['quantity']); ?></td>

                            <td>
                                <div class="details-box">
                                    <?php echo nl2br(htmlspecialchars($row['address'])); ?>
                                </div>
                            </td>

                            <td>
                                <div class="details-box">
                                    <?php echo !empty($row['details']) ? nl2br(htmlspecialchars($row['details'])) : '<span style="color:#94a3b8;">No extra details</span>'; ?>
                                </div>
                            </td>

                            <td><?php echo htmlspecialchars($row['created_at']); ?></td>

                            <td>
                                <span class="status-badge <?php echo $statusClass; ?>">
                                    <?php echo htmlspecialchars($status); ?>
                                </span>
                            </td>

                            <td>
                                <div class="action-buttons">
                                    <a class="btn-approve" href="?id=<?php echo $row['id']; ?>&status=Approved">Approve</a>
                                    <a class="btn-picked" href="?id=<?php echo $row['id']; ?>&status=Picked Up">Picked Up</a>
                                    <a class="btn-delivered" href="?id=<?php echo $row['id']; ?>&status=Delivered">Delivered</a>
                                    <a class="btn-reject" href="?id=<?php echo $row['id']; ?>&status=Rejected" onclick="return confirm('Are you sure you want to reject this donation?')">Reject</a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="12">
                            <div class="empty-state">
                                <i class="fas fa-box-open"></i>
                                <h3>No Donations Found</h3>
                                <p>No food donation submissions have been received yet.</p>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>

                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>

<?php $conn->close(); ?>