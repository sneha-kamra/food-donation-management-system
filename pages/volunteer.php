<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$success = false;
$error = "";

$conn = new mysqli("sql106.hstn.me", "mseet_41388470", "Foodshare1234", "mseet_41388470_foodshare");

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $fullname     = isset($_POST['fullname']) ? trim($_POST['fullname']) : '';
    $email        = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password     = isset($_POST['password']) ? trim($_POST['password']) : '';
    $phone        = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $city         = isset($_POST['city']) ? trim($_POST['city']) : '';
    $age          = isset($_POST['age']) ? (int)$_POST['age'] : 0;
    $activity     = isset($_POST['activity']) ? trim($_POST['activity']) : '';
    $availability = isset($_POST['availability']) ? trim($_POST['availability']) : '';
    $message      = isset($_POST['message']) ? trim($_POST['message']) : '';

    $checkMember = $conn->prepare("SELECT id FROM members WHERE email = ?");
    if (!$checkMember) {
        die("Check query failed: " . $conn->error);
    }

    $checkMember->bind_param("s", $email);
    $checkMember->execute();
    $checkMember->store_result();

    if ($checkMember->num_rows > 0) {
        $error = "This email is already registered. Please use another email or login.";
    } else {
        $stmt = $conn->prepare("INSERT INTO volunteers (fullname, email, password, phone, city, age, activity, availability, message) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

        if (!$stmt) {
            die("Volunteer insert prepare failed: " . $conn->error);
        }

        $stmt->bind_param("sssssisss", $fullname, $email, $password, $phone, $city, $age, $activity, $availability, $message);

        if ($stmt->execute()) {
            $memberStmt = $conn->prepare("INSERT INTO members (name, email, password, role) VALUES (?, ?, ?, 'volunteer')");

            if (!$memberStmt) {
                die("Member insert prepare failed: " . $conn->error);
            }

            $memberStmt->bind_param("sss", $fullname, $email, $password);

            if ($memberStmt->execute()) {
                $success = true;
            } else {
                $error = "Member insert failed: " . $memberStmt->error;
            }

            $memberStmt->close();
        } else {
            $error = "Volunteer insert failed: " . $stmt->error;
        }

        $stmt->close();
    }

    $checkMember->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Join Us | ShareTheMeal</title>
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
            --primary:#0f766e;
            --primary-dark:#115e59;
            --accent:#f59e0b;
            --accent-soft:#fbbf24;
            --text:#0f172a;
            --muted:#64748b;
            --white:#ffffff;
            --bg:#f8fafc;
            --card:#ffffff;
            --soft:#f1f5f9;
            --shadow:0 12px 35px rgba(0,0,0,0.08);
            --shadow-hover:0 18px 40px rgba(0,0,0,0.12);
        }

        body{
            font-family:'Poppins',sans-serif;
            background:var(--bg);
            color:var(--text);
            overflow-x:hidden;
        }

        a{
            text-decoration:none;
        }

        img{
            max-width:100%;
            display:block;
        }

        /* NAVBAR */
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
            background:rgba(15, 23, 42, 0.35);
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
            color:var(--primary-dark);
        }

        .nav-links{
            display:flex;
            align-items:center;
            gap:28px;
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

        .nav-links a:hover::after,
        .nav-links a.active::after{
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

        /* HERO */
        .page-hero{
            min-height:82vh;
            position:relative;
            display:flex;
            align-items:center;
            justify-content:center;
            padding:150px 20px 90px;
            text-align:center;
            overflow:hidden;
        }

        .page-hero-bg{
            position:absolute;
            inset:0;
            background:
                linear-gradient(rgba(15,23,42,0.55), rgba(15,23,42,0.48)),
                url("../images/volunteerhero.jpg") center center / cover no-repeat;
            transform:scale(1.03);
        }

        .page-hero-content{
            position:relative;
            z-index:2;
            max-width:920px;
            animation:fadeUp 1.1s ease;
        }

        .hero-badge{
            display:inline-block;
            background:rgba(255,255,255,0.16);
            color:#f8fafc;
            padding:10px 18px;
            border:1px solid rgba(255,255,255,0.24);
            border-radius:999px;
            font-size:14px;
            font-weight:500;
            backdrop-filter:blur(10px);
            margin-bottom:22px;
        }

        .page-hero h1{
            font-size:68px;
            line-height:1.08;
            color:var(--white);
            font-weight:800;
            margin-bottom:18px;
            letter-spacing:-1px;
        }

        .page-hero p{
            font-size:21px;
            color:#e2e8f0;
            line-height:1.85;
            max-width:820px;
            margin:0 auto 28px;
        }

        .hero-btns{
            display:flex;
            justify-content:center;
            gap:16px;
            flex-wrap:wrap;
            margin-top:24px;
        }

        .btn{
            display:inline-block;
            padding:16px 30px;
            border-radius:14px;
            font-weight:700;
            font-size:16px;
            transition:0.3s ease;
        }

        .btn-primary{
            background:var(--accent);
            color:#111827;
            box-shadow:0 14px 30px rgba(245,158,11,0.30);
        }

        .btn-primary:hover{
            transform:translateY(-4px);
        }

        .btn-outline{
            border:1px solid rgba(255,255,255,0.28);
            color:white;
            background:rgba(255,255,255,0.08);
            backdrop-filter:blur(8px);
        }

        .btn-outline:hover{
            transform:translateY(-4px);
            background:rgba(255,255,255,0.14);
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

        /* SECTION */
        .section{
            padding:105px 20px;
        }

        .container{
            width:min(1180px, 92%);
            margin:auto;
        }

        .section-head{
            text-align:center;
            max-width:860px;
            margin:0 auto 60px;
        }

        .section-head .tag{
            display:inline-block;
            color:var(--primary);
            background:#ccfbf1;
            padding:9px 17px;
            border-radius:999px;
            font-size:13px;
            font-weight:700;
            margin-bottom:18px;
        }

        .section-head h2{
            font-size:56px;
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

        /* CARDS */
        .cards{
            display:grid;
            grid-template-columns:repeat(4,1fr);
            gap:28px;
        }

        .card{
            background:var(--card);
            border-radius:28px;
            padding:34px 28px;
            box-shadow:var(--shadow);
            transition:0.35s ease;
        }

        .card:hover{
            transform:translateY(-8px);
            box-shadow:var(--shadow-hover);
        }

        .card .icon{
            font-size:40px;
            margin-bottom:16px;
        }

        .card h3{
            font-size:26px;
            margin-bottom:12px;
        }

        .card p{
            color:var(--muted);
            line-height:1.9;
            font-size:15px;
        }

        /* ROLE CARDS */
        .role-grid{
            display:grid;
            grid-template-columns:repeat(2,1fr);
            gap:28px;
        }

        .role-card{
            border-radius:30px;
            padding:34px 30px;
            box-shadow:var(--shadow);
            transition:0.35s ease;
            border:1px solid rgba(15, 23, 42, 0.04);
        }

        .role-card:hover{
            transform:translateY(-8px);
            box-shadow:var(--shadow-hover);
        }

        .role-card:nth-child(1){
            background:linear-gradient(135deg, #fff7ed, #ffedd5);
        }

        .role-card:nth-child(2){
            background:linear-gradient(135deg, #ecfdf5, #d1fae5);
        }

        .role-card:nth-child(3){
            background:linear-gradient(135deg, #f5f3ff, #ede9fe);
        }

        .role-card:nth-child(4){
            background:linear-gradient(135deg, #eff6ff, #dbeafe);
        }

        .role-card h3{
            font-size:28px;
            margin-bottom:12px;
            color:var(--text);
        }

        .role-card p{
            color:var(--muted);
            font-size:15px;
            line-height:1.9;
            margin-bottom:18px;
        }

        .role-card ul{
            padding-left:18px;
            color:var(--muted);
            line-height:1.9;
            font-size:15px;
        }

        /* STORIES */
        .stories{
            display:grid;
            grid-template-columns:repeat(3,1fr);
            gap:28px;
        }

        .story-card{
            background:#ffffff;
            border-radius:30px;
            padding:34px 28px;
            box-shadow:var(--shadow);
            transition:0.35s ease;
            position:relative;
        }

        .story-card:hover{
            transform:translateY(-8px);
            box-shadow:var(--shadow-hover);
        }

        .story-card .quote{
            font-size:42px;
            color:var(--accent);
            margin-bottom:12px;
        }

        .story-card p{
            color:var(--muted);
            font-size:15px;
            line-height:1.95;
            margin-bottom:18px;
        }

        .story-card h4{
            font-size:20px;
            color:var(--text);
            margin-bottom:5px;
        }

        .story-card span{
            color:var(--primary);
            font-weight:600;
            font-size:14px;
        }

        /* FORM */
        .form-wrap{
            display:grid;
            grid-template-columns:0.95fr 1.05fr;
            gap:35px;
            align-items:stretch;
        }

        .form-info{
            background:linear-gradient(135deg, #0f172a, #1e293b);
            color:white;
            border-radius:32px;
            padding:42px 34px;
            box-shadow:0 20px 50px rgba(15,23,42,0.18);
        }

        .form-info h3{
            font-size:38px;
            margin-bottom:18px;
            line-height:1.2;
        }

        .form-info p{
            color:#cbd5e1;
            font-size:16px;
            line-height:1.95;
            margin-bottom:24px;
        }

        .info-list{
            display:grid;
            gap:18px;
        }

        .info-item{
            background:rgba(255,255,255,0.08);
            border:1px solid rgba(255,255,255,0.10);
            border-radius:20px;
            padding:18px 18px;
        }

        .info-item strong{
            display:block;
            color:#ffffff;
            margin-bottom:6px;
            font-size:17px;
        }

        .info-item span{
            color:#cbd5e1;
            font-size:15px;
            line-height:1.8;
        }

        .form-card{
            background:#ffffff;
            border-radius:32px;
            padding:40px 34px;
            box-shadow:var(--shadow);
        }

        .alert{
            padding:15px 18px;
            border-radius:14px;
            margin-bottom:22px;
            font-weight:600;
            font-size:15px;
        }

        .success{
            background:#dcfce7;
            color:#166534;
        }

        .error{
            background:#fee2e2;
            color:#991b1b;
        }

        .form-grid{
            display:grid;
            grid-template-columns:repeat(2,1fr);
            gap:20px;
        }

        .form-group{
            margin-bottom:20px;
        }

        .form-group label{
            display:block;
            font-weight:600;
            margin-bottom:8px;
            color:var(--text);
            font-size:15px;
        }

        .form-group input,
        .form-group select,
        .form-group textarea{
            width:100%;
            padding:15px 16px;
            border:1px solid #e2e8f0;
            border-radius:16px;
            background:#f8fafc;
            font-size:15px;
            font-family:'Poppins',sans-serif;
            outline:none;
            transition:0.3s ease;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus{
            border-color:var(--primary);
            box-shadow:0 0 0 4px rgba(15,118,110,0.10);
            background:white;
        }

        .form-group textarea{
            min-height:140px;
            resize:vertical;
        }

        .submit-btn{
            width:100%;
            border:none;
            cursor:pointer;
        }

        /* IMPACT BAR */
        .impact-strip{
            background:linear-gradient(135deg, #0f172a, #1e293b);
            border-radius:36px;
            padding:70px 35px;
            color:white;
            box-shadow:0 20px 50px rgba(15,23,42,0.18);
        }

        .impact-grid{
            display:grid;
            grid-template-columns:repeat(4,1fr);
            gap:22px;
            margin-top:20px;
        }

        .impact-card{
            background:rgba(255,255,255,0.08);
            border:1px solid rgba(255,255,255,0.10);
            border-radius:24px;
            padding:30px 24px;
            text-align:center;
            backdrop-filter:blur(10px);
            transition:0.35s ease;
        }

        .impact-card:hover{
            transform:translateY(-6px);
        }

        .impact-card h3{
            font-size:42px;
            margin-bottom:10px;
            color:#fbbf24;
        }

        .impact-card p{
            color:#e2e8f0;
            font-size:15px;
            line-height:1.8;
        }

        /* CTA */
        .cta{
            background:
                linear-gradient(rgba(15,23,42,0.52), rgba(15,23,42,0.48)),
                url("../images/contactbg.jpg") center center / cover no-repeat;
            padding:110px 20px;
            text-align:center;
            color:white;
        }

        .cta h2{
            font-size:56px;
            margin-bottom:14px;
            font-weight:800;
        }

        .cta p{
            max-width:760px;
            margin:0 auto 28px;
            font-size:18px;
            color:#e2e8f0;
            line-height:1.9;
        }

        /* FOOTER */
        footer{
            background:#0f172a;
            color:#e2e8f0;
            padding:80px 20px 30px;
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

        /* ANIMATION */
        .hidden{
            opacity:0;
            transform:translateY(45px);
            transition:all 0.8s ease;
        }

        .show{
            opacity:1;
            transform:translateY(0);
        }

        /* RESPONSIVE */
        @media(max-width:1100px){
            .cards,
            .stories,
            .impact-grid,
            .footer-grid,
            .form-grid,
            .role-grid{
                grid-template-columns:repeat(2,1fr);
            }

            .form-wrap{
                grid-template-columns:1fr;
            }

            .page-hero h1{
                font-size:54px;
            }

            .section-head h2,
            .cta h2{
                font-size:42px;
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

            .page-hero{
                padding-top:180px;
                min-height:72vh;
            }

            .page-hero h1{
                font-size:38px;
            }

            .page-hero p{
                font-size:17px;
            }

            .section{
                padding:80px 18px;
            }

            .section-head h2,
            .cta h2,
            .form-info h3{
                font-size:34px;
            }

            .cards,
            .stories,
            .impact-grid,
            .footer-grid,
            .form-grid,
            .role-grid{
                grid-template-columns:1fr;
            }

            .form-card,
            .form-info{
                padding:28px 22px;
            }
        }
    </style>
</head>
<body>

    <!-- NAVBAR -->
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
            <a href="request-help.php">Request Help</a>
            <a href="volunteer.php" class="active">Join Us</a>
            <a href="contact.php">Contact</a>
            <a href="donate.php" class="nav-btn">Donate Now</a>
        </div>
    </div>

    <!-- HERO -->
    <section class="page-hero">
        <div class="page-hero-bg"></div>

        <div class="page-hero-content">
            <div class="hero-badge">Join Our Volunteer Network & Make Real Community Impact</div>
            <h1>Give your time to a cause that truly matters</h1>
            <p>Become part of ShareTheMeal’s volunteer community and help support food collection, meal delivery, awareness campaigns, and compassionate local action.</p>

            <div class="hero-btns">
                <a href="#join-form" class="btn btn-primary">Become a Volunteer</a>
                <a href="#roles" class="btn btn-outline">Explore Roles</a>
            </div>
        </div>
    </section>

    <!-- WHY JOIN -->
    <section class="section">
        <div class="container">
            <div class="section-head hidden">
                <span class="tag">Why Join Us</span>
                <h2>Volunteering here is more than helping — it is meaningful action</h2>
                <p>Every volunteer contributes to a larger mission of reducing food waste, supporting dignity, and strengthening community care.</p>
            </div>

            <div class="cards">
                <div class="card hidden">
                    <div class="icon">🤝</div>
                    <h3>Serve With Purpose</h3>
                    <p>Use your time and effort to support a mission that creates visible and practical community impact.</p>
                </div>

                <div class="card hidden">
                    <div class="icon">🍱</div>
                    <h3>Support Food Sharing</h3>
                    <p>Help ensure usable food reaches people who need support instead of being wasted.</p>
                </div>

                <div class="card hidden">
                    <div class="icon">🌍</div>
                    <h3>Build Social Awareness</h3>
                    <p>Become part of awareness efforts that inspire responsibility, empathy, and local participation.</p>
                </div>

                <div class="card hidden">
                    <div class="icon">❤️</div>
                    <h3>Create Human Impact</h3>
                    <p>Even a few hours of contribution can bring relief, hope, and care to others.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- VOLUNTEER ROLES -->
    <section class="section" id="roles" style="background:#f1f5f9;">
        <div class="container">
            <div class="section-head hidden">
                <span class="tag">Volunteer Opportunities</span>
                <h2>Choose how you want to contribute</h2>
                <p>Different roles allow volunteers to support the mission in ways that match their time, energy, and strengths.</p>
            </div>

            <div class="role-grid">
                <div class="role-card hidden">
                    <h3>Food Collection</h3>
                    <p>Support collection efforts from homes, events, food providers, and community contributors.</p>
                    <ul>
                        <li>Coordinate food pickup support</li>
                        <li>Assist with packaging and sorting</li>
                        <li>Help donors connect with the initiative</li>
                    </ul>
                </div>

                <div class="role-card hidden">
                    <h3>Meal Delivery</h3>
                    <p>Help ensure food reaches individuals and families who need support in a timely and respectful way.</p>
                    <ul>
                        <li>Assist with local delivery coordination</li>
                        <li>Support distribution drives</li>
                        <li>Help during community outreach efforts</li>
                    </ul>
                </div>

                <div class="role-card hidden">
                    <h3>Awareness Campaigns</h3>
                    <p>Take part in creating awareness around food waste, social support, and community participation.</p>
                    <ul>
                        <li>College and school awareness activities</li>
                        <li>Local campaign participation</li>
                        <li>Helping spread the mission online/offline</li>
                    </ul>
                </div>

                <div class="role-card hidden">
                    <h3>Community Drives</h3>
                    <p>Work alongside the team during special drives, events, and support initiatives.</p>
                    <ul>
                        <li>Volunteer during food support events</li>
                        <li>Assist with on-ground coordination</li>
                        <li>Support local engagement activities</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- STORIES -->
    <section class="section">
        <div class="container">
            <div class="section-head hidden">
                <span class="tag">Volunteer Stories</span>
                <h2>Real people. Real service. Real meaning.</h2>
                <p>Behind every food support effort are volunteers who choose to show up with compassion and commitment.</p>
            </div>

            <div class="stories">
                <div class="story-card hidden">
                    <div class="story-icon" style="font-size:50px;">🍱</div> 
                    <div class="quote">“</div>
                    <p>Helping with food collection made me realize how much impact simple local action can create when people work together.</p>
                    <h4>Aarti</h4>
                    <span>Volunteer Support Member</span>
                </div>

                <div class="story-card hidden">
                    <div class="story-icon" style="font-size:50px;">🚚</div> 
                    <div class="quote">“</div>
                    <p>Joining meal delivery activities gave me a deeper understanding of dignity, service, and how meaningful even small efforts can be.</p>
                    <h4>Rohit</h4>
                    <span>Weekend Volunteer</span>
                </div>

                <div class="story-card hidden">
                    <div class="story-icon" style="font-size:50px;">📢</div>
                    <div class="quote">“</div>
                    <p>Through awareness campaigns, I was able to encourage more students to think about food waste and community responsibility.</p>
                    <h4>Neha</h4>
                    <span>Student Volunteer</span>
                </div>
            </div>
        </div>
    </section>

    <!-- FORM -->
    <section class="section" id="join-form" style="background:#f1f5f9;">
        <div class="container">
            <div class="section-head hidden">
                <span class="tag">Volunteer Registration</span>
                <h2>Take the first step toward meaningful contribution</h2>
                <p>Fill out the form below and become part of a mission focused on food support, compassion, and responsible action.</p>
            </div>

            <div class="form-wrap">
                <div class="form-info hidden">
                    <h3>Become part of a compassionate volunteer movement</h3>
                    <p>Whether you are a student, working professional, or community supporter, your time and effort can help make real impact through practical service.</p>

                    <div class="info-list">
                        <div class="info-item">
                            <strong>Flexible Participation</strong>
                            <span>Choose roles and availability that suit your schedule and comfort.</span>
                        </div>

                        <div class="info-item">
                            <strong>Student Friendly</strong>
                            <span>College and school students are welcome to contribute through awareness and support activities.</span>
                        </div>

                        <div class="info-item">
                            <strong>Purpose-Driven Work</strong>
                            <span>Every volunteer effort directly supports the mission of reducing waste and helping people.</span>
                        </div>
                    </div>
                </div>

                <div class="form-card hidden">
                    <?php if ($success): ?>
                        <div class="alert success">Thank you for joining our volunteer network. Your member login account has also been created successfully.</div>
                    <?php endif; ?>

                    <?php if (!empty($error)): ?>
                        <div class="alert error"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <form method="POST" action="">
                        <div class="form-grid">
                            <div class="form-group">
                                <label>Full Name</label>
                                <input type="text" name="fullname" required>
                            </div>

                            <div class="form-group">
                                <label>Email Address</label>
                                <input type="email" name="email" required>
                            </div>

                            <div class="form-group">
                                <label>Create Password</label>
                                <input type="text" name="password" required>
                            </div>

                            <div class="form-group">
                                <label>Phone Number</label>
                                <input type="text" name="phone" required>
                            </div>

                            <div class="form-group">
                                <label>City</label>
                                <input type="text" name="city" required>
                            </div>

                            <div class="form-group">
                                <label>Age</label>
                                <input type="number" name="age" required>
                            </div>

                            <div class="form-group">
                                <label>Select Activity</label>
                                <select name="activity" required>
                                    <option value="">Choose an activity</option>
                                    <option>Food Collection</option>
                                    <option>Meal Delivery</option>
                                    <option>Awareness Campaigns</option>
                                    <option>Community Drives</option>
                                    <option>General Volunteering</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Availability</label>
                                <select name="availability" required>
                                    <option value="">Choose your availability</option>
                                    <option>Weekdays</option>
                                    <option>Weekends</option>
                                    <option>Occasionally</option>
                                    <option>Flexible</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Why do you want to volunteer?</label>
                            <textarea name="message" required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary submit-btn">Submit Volunteer Registration</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- IMPACT -->
    <section class="section">
        <div class="container">
            <div class="impact-strip hidden">
                <div class="section-head">
                    <span class="tag" style="background:rgba(255,255,255,0.12); color:#fbbf24;">Volunteer Impact</span>
                    <h2 style="color:white;">People-powered support creates meaningful change</h2>
                    <p style="color:#cbd5e1;">Every volunteer adds energy, compassion, and practical help to our growing mission.</p>
                </div>

                <div class="impact-grid">
                    <div class="impact-card">
                        <h3>45+</h3>
                        <p>Volunteers engaged in support activities</p>
                    </div>

                    <div class="impact-card">
                        <h3>20+</h3>
                        <p>Community awareness efforts supported</p>
                    </div>

                    <div class="impact-card">
                        <h3>120+</h3>
                        <p>Meals supported through volunteer efforts</p>
                    </div>

                    <div class="impact-card">
                        <h3>100%</h3>
                        <p>Mission-led effort focused on care and dignity</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="cta">
        <div class="container">
            <h2>Even a few hours of your time can create real impact</h2>
            <p>Join our volunteer mission and help turn compassion into action through food support, awareness, and community care.</p>
            <a href="#join-form" class="btn btn-primary">Join the Mission</a>
        </div>
    </section>

    <!-- FOOTER -->
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
                <a href="volunteer_login.php">Member Login</a>            
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
        // Navbar scroll effect
        window.addEventListener("scroll", function(){
            const navbar = document.getElementById("navbar");
            if(window.scrollY > 50){
                navbar.classList.add("scrolled");
            } else {
                navbar.classList.remove("scrolled");
            }
        });

        // Scroll animation
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