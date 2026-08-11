<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$conn = new mysqli("sql106.hstn.me", "mseet_41388470", "Foodshare1234", "mseet_41388470_foodshare");

// Check connection
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Fetch latest food donations with status
$sql = "SELECT id, fullname, contribution_type, city, pickup_date, pickup_time, quantity, details, status 
        FROM donations 
        WHERE contribution_type != 'Cash Donation'
        ORDER BY id DESC";

$result = $conn->query($sql);

// Count total active listings
$count_sql = "SELECT COUNT(*) AS total FROM donations WHERE contribution_type != 'Cash Donation'";
$count_result = $conn->query($count_sql);
$total_listings = 0;

if ($count_result && $count_result->num_rows > 0) {
    $count_row = $count_result->fetch_assoc();
    $total_listings = $count_row['total'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Available Meals | ShareTheMeal</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            scroll-behavior:smooth;
        }

        :root{
            --primary:#14532d;
            --primary-dark:#0f3f22;
            --accent:#f59e0b;
            --accent-soft:#fef3c7;
            --warm:#fffaf3;
            --card:#ffffff;
            --soft:#f8fafc;
            --text:#0f172a;
            --muted:#64748b;
            --white:#ffffff;
            --shadow:0 14px 35px rgba(0,0,0,0.08);
            --shadow-hover:0 20px 45px rgba(0,0,0,0.12);
            --success:#16a34a;
            --success-bg:#dcfce7;
            --blue:#2563eb;
            --blue-bg:#dbeafe;
            --claimed:#d97706;
            --claimed-bg:#fef3c7;
            --delivered:#7c3aed;
            --delivered-bg:#ede9fe;
        }

        body{
            font-family:'Poppins',sans-serif;
            background:var(--warm);
            color:var(--text);
            overflow-x:hidden;
        }

        a{
            text-decoration:none;
        }

        .navbar{
            position:fixed;
            top:0;
            left:0;
            width:100%;
            z-index:1000;
            display:flex;
            justify-content:space-between;
            align-items:center;
            padding:18px 60px;
            background:rgba(15, 23, 42, 0.45);
            backdrop-filter:blur(12px);
            transition:0.35s ease;
        }

        .navbar.scrolled{
            background:rgba(255,255,255,0.96);
            box-shadow:0 8px 25px rgba(0,0,0,0.08);
        }

       .logo{
    display:flex;
    align-items:center;
    gap:14px;
    font-size:36px;
    font-weight:800;
    letter-spacing:0.5px;
}

.logo img{
    width:60px;
    height:60px;
    object-fit:contain;
    filter:drop-shadow(0 6px 14px rgba(0,0,0,0.18));
    transition:0.3s ease;
}

.logo:hover img{
    transform:scale(1.05);
}

.logo span{
    color:var(--white);
    transition:0.3s ease;
}

.navbar.scrolled .logo span{
    color:var(--primary-dark);
}
        .navbar.scrolled .logo{
            color:var(--primary);
        }

        .nav-links{
            display:flex;
            align-items:center;
            gap:24px;
            flex-wrap:wrap;
        }

        .nav-links a{
            color:var(--white);
            font-weight:500;
            font-size:15px;
            position:relative;
            transition:0.3s;
        }

        .navbar.scrolled .nav-links a{
            color:var(--text);
        }

        .nav-links a::after{
            content:"";
            position:absolute;
            left:0;
            bottom:-6px;
            width:0%;
            height:2px;
            background:var(--accent);
            transition:0.3s;
        }

        .nav-links a:hover::after{
            width:100%;
        }

        .nav-btn{
            background:var(--accent);
            color:#111827 !important;
            padding:10px 18px;
            border-radius:999px;
            font-weight:700 !important;
            box-shadow:0 8px 20px rgba(245,158,11,0.28);
        }

        .nav-btn::after{
            display:none;
        }

        .hero{
            min-height:78vh;
            position:relative;
            display:flex;
            align-items:center;
            justify-content:center;
            padding:160px 20px 110px;
            text-align:center;
            overflow:hidden;
        }

        .hero-bg{
            position:absolute;
            inset:0;
            background:
                linear-gradient(rgba(15,23,42,0.62), rgba(15,23,42,0.55)),
                url("../images/viewfoodbg.jpg") center center / 110% auto no-repeat;
        }

        .hero-content{
            position:relative;
            z-index:2;
            max-width:950px;
            animation:fadeUp 1.1s ease;
        }

        @keyframes fadeUp{
            from{
                opacity:0;
                transform:translateY(40px);
            }
            to{
                opacity:1;
                transform:translateY(0);
            }
        }

        .hero-badge{
            display:inline-block;
            background:rgba(255,255,255,0.14);
            color:#f8fafc;
            padding:10px 18px;
            border:1px solid rgba(255,255,255,0.22);
            border-radius:999px;
            font-size:14px;
            font-weight:500;
            backdrop-filter:blur(10px);
            margin-bottom:22px;
        }

        .hero h1{
            font-size:64px;
            line-height:1.08;
            color:var(--white);
            font-weight:800;
            margin-bottom:18px;
            letter-spacing:-1px;
        }

        .hero p{
            font-size:20px;
            color:#e2e8f0;
            line-height:1.9;
            max-width:820px;
            margin:0 auto;
        }

        .section{
            padding:100px 20px;
        }

        .container{
            width:min(1180px, 92%);
            margin:auto;
        }

        .section-head{
            text-align:center;
            max-width:850px;
            margin:0 auto 60px;
        }

        .section-head .tag{
            display:inline-block;
            color:var(--primary);
            background:#dcfce7;
            padding:9px 17px;
            border-radius:999px;
            font-size:13px;
            font-weight:700;
            margin-bottom:18px;
        }

        .section-head h2{
            font-size:48px;
            line-height:1.16;
            margin-bottom:16px;
            font-weight:800;
            color:#0f172a;
        }

        .section-head p{
            font-size:18px;
            color:var(--muted);
            line-height:1.9;
        }

        .stats{
            margin-top:-70px;
            position:relative;
            z-index:5;
        }

        .stats-grid{
            display:grid;
            grid-template-columns:repeat(4,1fr);
            gap:24px;
        }

        .stat-card{
            background:rgba(255,255,255,0.92);
            backdrop-filter:blur(14px);
            border:1px solid rgba(255,255,255,0.5);
            box-shadow:var(--shadow);
            border-radius:26px;
            padding:30px 24px;
            text-align:center;
            transition:0.35s ease;
        }

        .stat-card:hover{
            transform:translateY(-8px);
            box-shadow:var(--shadow-hover);
        }

        .stat-icon{
            font-size:34px;
            margin-bottom:12px;
        }

        .stat-card h3{
            font-size:34px;
            color:var(--primary);
            margin-bottom:8px;
        }

        .stat-card p{
            color:var(--muted);
            font-size:15px;
        }

        .listing-grid{
            display:grid;
            grid-template-columns:repeat(3,1fr);
            gap:28px;
        }

        .food-card{
            background:linear-gradient(180deg,#ffffff,#fffdf8);
            border:1px solid #f1f5f9;
            border-radius:30px;
            box-shadow:var(--shadow);
            padding:28px;
            transition:0.35s ease;
            position:relative;
            overflow:hidden;
        }

        .food-card::before{
            content:"";
            position:absolute;
            top:0;
            left:0;
            width:100%;
            height:6px;
            background:linear-gradient(90deg,var(--primary),var(--accent));
        }

        .food-card:hover{
            transform:translateY(-10px);
            box-shadow:var(--shadow-hover);
        }

        .food-top{
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:18px;
            gap:12px;
        }

        .food-type{
            display:inline-flex;
            align-items:center;
            gap:10px;
            font-size:20px;
            font-weight:700;
            color:#0f172a;
        }

        .status{
            padding:8px 14px;
            border-radius:999px;
            font-size:13px;
            font-weight:700;
            white-space:nowrap;
        }

        .status.available{
            background:var(--success-bg);
            color:var(--success);
        }

        .status.claimed{
            background:var(--claimed-bg);
            color:var(--claimed);
        }

        .status.delivered{
            background:var(--delivered-bg);
            color:var(--delivered);
        }

        .donor{
            font-size:15px;
            color:var(--muted);
            margin-bottom:20px;
            line-height:1.8;
        }

        .donor strong{
            color:#0f172a;
        }

        .food-details{
            display:grid;
            gap:14px;
            margin-bottom:22px;
        }

        .detail-box{
            background:#f8fafc;
            border-radius:18px;
            padding:14px 16px;
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:10px;
        }

        .detail-box span{
            color:var(--muted);
            font-size:14px;
        }

        .detail-box strong{
            color:#0f172a;
            font-size:14px;
            text-align:right;
        }

        .food-note{
            background:var(--accent-soft);
            border-left:5px solid var(--accent);
            padding:16px 18px;
            border-radius:18px;
            font-size:14px;
            color:#92400e;
            line-height:1.8;
            margin-bottom:20px;
        }

        .food-footer{
            display:flex;
            justify-content:space-between;
            align-items:center;
            gap:14px;
            flex-wrap:wrap;
        }

        .meal-badge{
            background:var(--blue-bg);
            color:var(--blue);
            padding:10px 14px;
            border-radius:999px;
            font-size:13px;
            font-weight:700;
        }

        .request-link{
            background:linear-gradient(135deg,var(--primary),#15803d);
            color:white;
            padding:12px 18px;
            border-radius:999px;
            font-size:14px;
            font-weight:700;
            transition:0.3s ease;
            box-shadow:0 10px 24px rgba(21,128,61,0.18);
            display:inline-block;
        }

        .request-link:hover{
            transform:translateY(-2px);
        }

        .disabled-btn{
            background:#cbd5e1;
            color:#475569;
            padding:12px 18px;
            border-radius:999px;
            font-size:14px;
            font-weight:700;
            cursor:not-allowed;
        }

        .empty-box{
            grid-column:1 / -1;
            background:#ffffff;
            border-radius:30px;
            box-shadow:var(--shadow);
            padding:45px 30px;
            text-align:center;
        }

        .empty-box h3{
            font-size:32px;
            margin-bottom:12px;
        }

        .empty-box p{
            color:var(--muted);
            font-size:16px;
            line-height:1.9;
            max-width:700px;
            margin:auto;
        }

        .steps-grid{
            display:grid;
            grid-template-columns:repeat(4,1fr);
            gap:24px;
        }

        .step-card{
            background:#ffffff;
            border-radius:28px;
            padding:34px 24px;
            box-shadow:var(--shadow);
            text-align:center;
            transition:0.35s ease;
        }

        .step-card:hover{
            transform:translateY(-8px);
            box-shadow:var(--shadow-hover);
        }

        .step-number{
            width:56px;
            height:56px;
            margin:0 auto 18px;
            background:linear-gradient(135deg,var(--accent),#fbbf24);
            color:#111827;
            border-radius:50%;
            display:flex;
            align-items:center;
            justify-content:center;
            font-weight:800;
            font-size:20px;
            box-shadow:0 10px 22px rgba(245,158,11,0.24);
        }

        .step-icon{
            font-size:38px;
            margin-bottom:14px;
        }

        .step-card h3{
            font-size:24px;
            margin-bottom:12px;
        }

        .step-card p{
            color:var(--muted);
            font-size:15px;
            line-height:1.9;
        }

        .impact-wrap{
            display:grid;
            grid-template-columns:1fr;
            gap:30px;
            align-items:stretch;
        }

        .impact-box{
            background:#ffffff;
            border-radius:30px;
            padding:38px 32px;
            box-shadow:var(--shadow);
        }

        .impact-box h3{
            font-size:34px;
            margin-bottom:16px;
        }

        .impact-box p{
            color:var(--muted);
            line-height:1.9;
            font-size:16px;
            margin-bottom:18px;
        }

        .impact-list{
            display:grid;
            gap:16px;
            margin-top:18px;
        }

        .impact-item{
            background:#f8fafc;
            border-radius:18px;
            padding:16px 18px;
            font-size:15px;
            color:#0f172a;
            line-height:1.8;
        }

        .cta{
            background:linear-gradient(135deg,#14532d,#166534);
            border-radius:36px;
            padding:60px 35px;
            text-align:center;
            color:white;
            box-shadow:0 22px 50px rgba(20,83,45,0.22);
        }

        .cta h2{
            font-size:48px;
            margin-bottom:16px;
        }

        .cta p{
            color:#dcfce7;
            max-width:800px;
            margin:0 auto 28px;
            font-size:18px;
            line-height:1.9;
        }

        .cta-buttons{
            display:flex;
            justify-content:center;
            gap:18px;
            flex-wrap:wrap;
        }

        .cta-buttons a{
            padding:14px 24px;
            border-radius:999px;
            font-weight:700;
            font-size:15px;
            transition:0.3s ease;
        }

        .btn-primary{
            background:var(--accent);
            color:#111827;
            box-shadow:0 12px 26px rgba(245,158,11,0.28);
        }

        .btn-secondary{
            background:rgba(255,255,255,0.12);
            color:white;
            border:1px solid rgba(255,255,255,0.18);
        }

        .cta-buttons a:hover{
            transform:translateY(-3px);
        }

        footer{
            background:#0f172a;
            color:#e2e8f0;
            padding:80px 20px 30px;
            margin-top:100px;
        }

        .footer-grid{
            width:min(1180px, 92%);
            margin:auto;
            display:grid;
            grid-template-columns:2fr 1fr 1fr 1.3fr;
            gap:30px;
            margin-bottom:35px;
        }

        .footer-brand h3{
            color:white;
            font-size:30px;
            margin-bottom:14px;
        }

        .footer-brand p,
        .footer-links a,
        .footer-credit p{
            color:#cbd5e1;
            font-size:15px;
            line-height:1.9;
        }

        .footer-links h4,
        .footer-credit h4{
            color:white;
            margin-bottom:16px;
            font-size:20px;
        }

        .footer-links a{
            display:block;
            margin-bottom:12px;
            transition:0.3s ease;
            position:relative;
            width:fit-content;
        }

        .footer-links a:hover{
            color:#fbbf24;
            text-shadow:0 0 8px rgba(251,191,36,0.55);
            transform:translateX(4px);
        }

        .footer-credit strong{
            color:#ffffff;
        }

        .footer-bottom{
            width:min(1180px, 92%);
            margin:auto;
            border-top:1px solid rgba(255,255,255,0.08);
            padding-top:20px;
            text-align:center;
            color:#94a3b8;
            font-size:14px;
        }

        .hidden{
            opacity:0;
            transform:translateY(45px);
            transition:all 0.8s ease;
        }

        .show{
            opacity:1;
            transform:translateY(0);
        }

        @media(max-width:1100px){
            .stats-grid,
            .listing-grid,
            .steps-grid,
            .footer-grid{
                grid-template-columns:repeat(2,1fr);
            }

            .hero h1{
                font-size:52px;
            }

            .section-head h2,
            .cta h2{
                font-size:40px;
            }
        }

        @media(max-width:768px){
            .navbar{
                padding:16px 20px;
                flex-direction:column;
                gap:12px;
            }

            .nav-links{
                justify-content:center;
                gap:16px;
            }

            .hero{
                padding-top:190px;
                min-height:70vh;
            }

            .hero h1{
                font-size:36px;
            }

            .hero p{
                font-size:17px;
            }

            .section{
                padding:80px 18px;
            }

            .section-head h2,
            .cta h2{
                font-size:32px;
            }

            .stats-grid,
            .listing-grid,
            .steps-grid,
            .footer-grid{
                grid-template-columns:1fr;
            }

            .food-card{
                padding:24px;
            }

            .cta{
                padding:46px 22px;
            }
        }
    </style>
</head>
<body>

    <div class="navbar" id="navbar">
        <a href="../index.php" class="logo">
    <img src="../images/logo.png" alt="ShareTheMeal Logo">
    <span>ShareTheMeal</span>
</a>

        <div class="nav-links">
            <a href="../index.php">Home</a>
            <a href="about.php">About</a>
            <a href="donate.php">Donate Food</a>
            <a href="viewfood.php">Available Meals</a>
            <a href="request-help.php">Request Support</a>
            <a href="volunteer.php">Join Us</a>
            <a href="contact.php">Contact</a>
            <a href="#food-listings" class="nav-btn">Browse Meals</a>
        </div>
    </div>

    <section class="hero">
        <div class="hero-bg"></div>

        <div class="hero-content">
            <div class="hero-badge">Real-time food support listings for community impact</div>
            <h1>Food Available Near Communities</h1>
            <p>Explore available meal donations shared through ShareTheMeal and see what food support is currently ready for responsible pickup, coordination, or distribution.</p>
        </div>
    </section>

    <section class="stats">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-card hidden">
                    <div class="stat-icon">🍱</div>
                    <h3><?php echo $total_listings; ?>+</h3>
                    <p>Active Food Listings</p>
                </div>

                <div class="stat-card hidden">
                    <div class="stat-icon">🤝</div>
                    <h3>100%</h3>
                    <p>Community Shared Support</p>
                </div>

                <div class="stat-card hidden">
                    <div class="stat-icon">📍</div>
                    <h3>Multi-City</h3>
                    <p>Location-Based Availability</p>
                </div>

                <div class="stat-card hidden">
                    <div class="stat-icon">🚚</div>
                    <h3>Tracked</h3>
                    <p>Status-Based Distribution</p>
                </div>
            </div>
        </div>
    </section>

    <section class="section" id="food-listings">
        <div class="container">
            <div class="section-head hidden">
                <span class="tag">Available Meal Board</span>
                <h2>Current food donations ready to support people in need</h2>
                <p>This section displays food support entries shared by donors through the platform. These listings help make support visible, organized, and easier to coordinate.</p>
            </div>

            <div class="listing-grid">
                <?php if($result && $result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <div class="food-card hidden">
                            <div class="food-top">
                                <div class="food-type">
                                    <?php
                                        if($row['contribution_type'] == "Cooked Food"){
                                            echo "🍛 Cooked Food";
                                        } elseif($row['contribution_type'] == "Packaged Food"){
                                            echo "📦 Packaged Food";
                                        } else {
                                            echo "🍱 Food Support";
                                        }
                                    ?>
                                </div>

                                <?php
                                    $status = strtolower(trim($row['status']));
                                    $statusClass = "available";

                                    if($status == "claimed"){
                                        $statusClass = "claimed";
                                    } elseif($status == "delivered"){
                                        $statusClass = "delivered";
                                    }
                                ?>

                                <div class="status <?php echo $statusClass; ?>">
                                    <?php echo htmlspecialchars($row['status']); ?>
                                </div>
                            </div>

                            <div class="donor">
                                Donated by <strong><?php echo htmlspecialchars($row['fullname']); ?></strong>
                            </div>

                            <div class="food-details">
                                <div class="detail-box">
                                    <span>📍 Location</span>
                                    <strong><?php echo htmlspecialchars($row['city']); ?></strong>
                                </div>

                                <div class="detail-box">
                                    <span>📅 Pickup Date</span>
                                    <strong><?php echo htmlspecialchars($row['pickup_date']); ?></strong>
                                </div>

                                <div class="detail-box">
                                    <span>⏰ Pickup Time</span>
                                    <strong><?php echo htmlspecialchars($row['pickup_time']); ?></strong>
                                </div>

                                <div class="detail-box">
                                    <span>🍽 Quantity</span>
                                    <strong><?php echo htmlspecialchars($row['quantity']); ?></strong>
                                </div>
                            </div>

                            <div class="food-note">
                                <?php echo !empty($row['details']) ? htmlspecialchars($row['details']) : "Freshly shared support item listed through ShareTheMeal for responsible food distribution."; ?>
                            </div>

                            <div class="food-footer">
                                <?php if(strtolower(trim($row['status'])) == "available"): ?>
                                    <div class="meal-badge">Ready for Claim</div>
                                    <a href="request-help.php?id=<?php echo $row['id']; ?>" class="request-link">Request Support</a>
                                <?php elseif(strtolower(trim($row['status'])) == "claimed"): ?>
                                    <div class="meal-badge">Already Claimed</div>
                                    <div class="disabled-btn">Unavailable</div>
                                <?php else: ?>
                                    <div class="meal-badge">Successfully Delivered</div>
                                    <div class="disabled-btn">Completed</div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="empty-box hidden">
                        <h3>No food listings available yet</h3>
                        <p>There are currently no active meal donations visible on the platform. Once donors submit food support through the Donate Food page, they will appear here as available community listings.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section class="section" style="background:#fffdf8;">
        <div class="container">
            <div class="section-head hidden">
                <span class="tag">How It Works</span>
                <h2>Simple steps behind the food support process</h2>
                <p>ShareTheMeal is designed to create a simple bridge between food donors, support seekers, and coordinated community action.</p>
            </div>

            <div class="steps-grid">
                <div class="step-card hidden">
                    <div class="step-number">1</div>
                    <div class="step-icon">📝</div>
                    <h3>Register</h3>
                    <p>Users join the platform as donors, volunteers, or support seekers through simple website forms.</p>
                </div>

                <div class="step-card hidden">
                    <div class="step-number">2</div>
                    <div class="step-icon">🍱</div>
                    <h3>Donate or Request</h3>
                    <p>Food can be donated through the Donate Food page, while those in need can request support respectfully.</p>
                </div>

                <div class="step-card hidden">
                    <div class="step-number">3</div>
                    <div class="step-icon">✔️</div>
                    <h3>Verification</h3>
                    <p>Basic details like quantity, type, location, and timing help make the food support process more organized.</p>
                </div>

                <div class="step-card hidden">
                    <div class="step-number">4</div>
                    <div class="step-icon">🚚</div>
                    <h3>Pickup / Delivery</h3>
                    <p>Available food can then be coordinated for pickup or support delivery depending on the situation.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container impact-wrap">
            <div class="impact-box hidden">
                <h3>Why this page matters</h3>
                <p>This page is more than a listing board — it represents how food support becomes visible, usable, and meaningful in a real community-based platform.</p>

                <div class="impact-list">
                    <div class="impact-item">🍽 It shows what food is currently available for support.</div>
                    <div class="impact-item">♻️ It helps reduce unnecessary food waste responsibly.</div>
                    <div class="impact-item">🤝 It encourages trust, transparency, and local participation.</div>
                    <div class="impact-item">📍 It makes food support easier to coordinate by location and timing.</div>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="cta hidden">
                <h2>Want to support or receive help?</h2>
                <p>You can either contribute available food or submit a respectful support request through ShareTheMeal. Every action helps build a more caring and responsible community system.</p>

                <div class="cta-buttons">
                    <a href="donate.php" class="btn-primary">Donate Food</a>
                    <a href="request-help.php" class="btn-secondary">Request Help</a>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="footer-grid">
            <div class="footer-brand">
                <h3>ShareTheMeal</h3>
                <p>ShareTheMeal is a food support initiative focused on reducing food waste and helping connect surplus meals with people in need.</p>
            </div>

            <div class="footer-links">
                <h4>Quick Links</h4>
                <a href="../index.php">Home</a>
                <a href="about.php">About</a>
                <a href="donate.php">Donate Food</a>
                <a href="contact.php">Contact</a>
            </div>

            <div class="footer-links">
                <h4>Get Involved</h4>
                <a href="volunteer.php">Join Our Mission</a>
                <a href="viewfood.php">Available Meals</a>
                <a href="privacy.php">Privacy Policy</a>
                <a href="pages/volunteer_login.php">Member Login</a>            
            </div>

            <div class="footer-credit">
                <h4>Project Credit</h4>
                <p><strong>Concept, Design & Development by Sneha</strong></p>
                <p>This website is developed as a social impact-based web platform project.</p>
            </div>
        </div>

        <div class="footer-bottom">
            © 2026 ShareTheMeal. All rights reserved.
        </div>
    </footer>

    <script>
        window.addEventListener("scroll", function(){
            const navbar = document.getElementById("navbar");
            if(window.scrollY > 50){
                navbar.classList.add("scrolled");
            } else {
                navbar.classList.remove("scrolled");
            }
        });

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if(entry.isIntersecting){
                    entry.target.classList.add("show");
                }
            });
        }, { threshold: 0.15 });

        document.querySelectorAll(".hidden").forEach((el) => observer.observe(el));
    </script>

</body>
</html>