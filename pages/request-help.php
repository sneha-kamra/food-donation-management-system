<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$success = false;
$error = "";
$isClaimMode = false;
$claimDonation = null;

// Database connection
$conn = new mysqli("sql106.hstn.me", "mseet_41388470", "Foodshare1234", "mseet_41388470_foodshare");

// Check connection
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Default form values
$fullname = "";
$email = "";
$phone = "";
$request_type = "";
$city = "";
$people_count = "";
$needed_date = "";
$needed_time = "";
$address = "";
$details = "";
$donation_id = null;

// Check if user came from viewfood.php to claim a specific donation
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $donation_id = intval($_GET['id']);

    $claimStmt = $conn->prepare("SELECT id, fullname, contribution_type, city, pickup_date, pickup_time, quantity, details, status 
                                 FROM donations 
                                 WHERE id = ? LIMIT 1");
    $claimStmt->bind_param("i", $donation_id);
    $claimStmt->execute();
    $claimResult = $claimStmt->get_result();

    if ($claimResult && $claimResult->num_rows > 0) {
        $claimDonation = $claimResult->fetch_assoc();

        if (strtolower(trim($claimDonation['status'])) === "available") {
            $isClaimMode = true;
            $city = $claimDonation['city'];
            $request_type = $claimDonation['contribution_type'];
        } else {
            $error = "This food listing is no longer available for claim.";
        }
    } else {
        $error = "Requested food listing not found.";
    }

    $claimStmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $donation_id = !empty($_POST['donation_id']) ? intval($_POST['donation_id']) : null;

    // Get form data
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $request_type = trim($_POST['request_type']);
    $city = trim($_POST['city']);
    $people_count = trim($_POST['people_count']);
    $needed_date = trim($_POST['needed_date']);
    $needed_time = trim($_POST['needed_time']);
    $address = trim($_POST['address']);
    $details = trim($_POST['details']);

    // Basic validation
    if (
        !empty($fullname) &&
        !empty($email) &&
        !empty($phone) &&
        !empty($request_type) &&
        !empty($city) &&
        !empty($people_count) &&
        !empty($needed_date) &&
        !empty($needed_time) &&
        !empty($address)
    ) {

        // If donation is being claimed, verify still available
        if (!empty($donation_id)) {
            $checkStmt = $conn->prepare("SELECT status FROM donations WHERE id = ? LIMIT 1");
            $checkStmt->bind_param("i", $donation_id);
            $checkStmt->execute();
            $checkResult = $checkStmt->get_result();

            if ($checkResult && $checkResult->num_rows > 0) {
                $checkRow = $checkResult->fetch_assoc();
                if (strtolower(trim($checkRow['status'])) !== "available") {
                    $error = "Sorry, this food listing has already been claimed or delivered.";
                }
            } else {
                $error = "Donation record not found.";
            }

            $checkStmt->close();
        }

        if (empty($error)) {
            // Insert into help_requests table
            $stmt = $conn->prepare("INSERT INTO help_requests 
                (donation_id, fullname, email, phone, request_type, city, people_count, needed_date, needed_time, address, details) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            $stmt->bind_param(
                "isssssissss",
                $donation_id,
                $fullname,
                $email,
                $phone,
                $request_type,
                $city,
                $people_count,
                $needed_date,
                $needed_time,
                $address,
                $details
            );

            if ($stmt->execute()) {

                // If claiming specific donation, update status to Claimed
                if (!empty($donation_id)) {
                    $updateStmt = $conn->prepare("UPDATE donations SET status = 'Claimed' WHERE id = ?");
                    $updateStmt->bind_param("i", $donation_id);
                    $updateStmt->execute();
                    $updateStmt->close();
                }

                $success = true;

                // Clear form after success
                $fullname = "";
                $email = "";
                $phone = "";
                $request_type = "";
                $city = "";
                $people_count = "";
                $needed_date = "";
                $needed_time = "";
                $address = "";
                $details = "";
                $donation_id = null;
                $isClaimMode = false;
                $claimDonation = null;

            } else {
                $error = "Something went wrong while submitting your request.";
            }

            $stmt->close();
        }

    } else {
        $error = "Please fill all required fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Request Help | ShareTheMeal</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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
            --help-blue:#1d4ed8;
            --help-soft:#dbeafe;
            --accent:#f59e0b;
            --text:#0f172a;
            --muted:#64748b;
            --white:#ffffff;
            --bg:#f8fafc;
            --card:#ffffff;
            --soft:#eef6ff;
            --shadow:0 12px 35px rgba(0,0,0,0.08);
            --shadow-hover:0 18px 40px rgba(0,0,0,0.12);
            --success:#16a34a;
            --success-bg:#dcfce7;
            --claim:#f59e0b;
            --claim-bg:#fef3c7;
        }

        body{
            font-family:'Poppins',sans-serif;
            background:var(--bg);
            color:var(--text);
            overflow-x:hidden;
        }

        a{ text-decoration:none; }
        img{ max-width:100%; display:block; }

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

        .nav-btn::after{ display:none; }

        .hero{
            min-height:82vh;
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
            linear-gradient(rgba(15,23,42,0.55), rgba(15,23,42,0.52)),
            url("../images/requesthelpbg.jpg") center center / 100% no-repeat;
        }

        .hero-content{
            position:relative;
            z-index:2;
            max-width:950px;
            animation:fadeUp 1.1s ease;
        }

        @keyframes fadeUp{
            from{ opacity:0; transform:translateY(40px); }
            to{ opacity:1; transform:translateY(0); }
        }

        .hero-badge{
            display:inline-block;
            background:rgba(255,255,255,0.15);
            color:#f8fafc;
            padding:10px 18px;
            border:1px solid rgba(255,255,255,0.25);
            border-radius:999px;
            font-size:14px;
            font-weight:500;
            backdrop-filter:blur(10px);
            margin-bottom:22px;
        }

        .hero h1{
            font-size:68px;
            line-height:1.08;
            color:var(--white);
            font-weight:800;
            margin-bottom:18px;
            letter-spacing:-1px;
        }

        .hero p{
            font-size:21px;
            color:#e2e8f0;
            line-height:1.9;
            max-width:800px;
            margin:0 auto;
        }

        .section{ padding:100px 20px; }
        .container{ width:min(1180px, 92%); margin:auto; }

        .section-head{
            text-align:center;
            max-width:850px;
            margin:0 auto 60px;
        }

        .section-head .tag{
            display:inline-block;
            color:var(--help-blue);
            background:var(--help-soft);
            padding:9px 17px;
            border-radius:999px;
            font-size:13px;
            font-weight:700;
            margin-bottom:18px;
        }

        .section-head h2{
            font-size:54px;
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

        .cards{
            display:grid;
            grid-template-columns:repeat(3,1fr);
            gap:28px;
        }

        .card{
            background:linear-gradient(180deg,#ffffff,#f8fbff);
            border:1px solid #e2e8f0;
            border-radius:28px;
            padding:34px 28px;
            box-shadow:var(--shadow);
            transition:0.35s ease;
            text-align:center;
        }

        .card:hover{
            transform:translateY(-8px);
            box-shadow:var(--shadow-hover);
        }

        .card .icon{
            font-size:44px;
            margin-bottom:18px;
        }

        .card h3{
            font-size:28px;
            margin-bottom:14px;
        }

        .card p{
            color:var(--muted);
            line-height:1.9;
            font-size:15px;
        }

        .claim-banner{
            background:linear-gradient(135deg,#fff7ed,#fffbeb);
            border:1px solid #fde68a;
            border-radius:24px;
            padding:28px;
            margin-bottom:30px;
            box-shadow:var(--shadow);
        }

        .claim-banner h3{
            font-size:30px;
            margin-bottom:14px;
            color:#92400e;
        }

        .claim-banner p{
            color:#78350f;
            line-height:1.9;
            font-size:15px;
            margin-bottom:16px;
        }

        .claim-grid{
            display:grid;
            grid-template-columns:repeat(2,1fr);
            gap:16px;
        }

        .claim-item{
            background:#ffffff;
            border-radius:18px;
            padding:16px 18px;
            border:1px solid #fde68a;
        }

        .claim-item span{
            display:block;
            font-size:13px;
            color:#92400e;
            margin-bottom:6px;
            font-weight:600;
        }

        .claim-item strong{
            font-size:15px;
            color:#111827;
        }

        .form-section{
            background:linear-gradient(180deg,#eef6ff,#f8fafc);
        }

        .form-wrap{
            display:grid;
            grid-template-columns:1fr 1.1fr;
            gap:40px;
            align-items:start;
        }

        .form-side{
            background:linear-gradient(135deg,#1e3a8a,#1d4ed8);
            color:white;
            border-radius:30px;
            padding:45px 35px;
            box-shadow:0 18px 45px rgba(29,78,216,0.18);
        }

        .form-side h2{
            font-size:42px;
            margin-bottom:18px;
            line-height:1.2;
        }

        .form-side p{
            color:#dbeafe;
            line-height:1.9;
            font-size:16px;
            margin-bottom:20px;
        }

        .form-points{
            display:grid;
            gap:16px;
            margin-top:20px;
        }

        .form-point{
            background:rgba(255,255,255,0.10);
            border:1px solid rgba(255,255,255,0.14);
            padding:18px 20px;
            border-radius:18px;
        }

        .form-point strong{
            display:block;
            margin-bottom:6px;
            font-size:17px;
        }

        .form-point span{
            color:#dbeafe;
            font-size:15px;
            line-height:1.8;
        }

        .form-card{
            background:linear-gradient(180deg,#ffffff,#f8fbff);
            border:1px solid #dbeafe;
            border-radius:30px;
            box-shadow:0 18px 45px rgba(15,23,42,0.06);
            padding:40px 32px;
        }

        .form-card h3{
            font-size:34px;
            margin-bottom:10px;
            color:#0f172a;
        }

        .form-card p{
            color:var(--muted);
            margin-bottom:26px;
            line-height:1.8;
        }

        .success-message{
            background:#dcfce7;
            color:#166534;
            padding:16px 18px;
            border-radius:16px;
            font-weight:600;
            margin-bottom:24px;
            border:1px solid #bbf7d0;
        }

        .error-message{
            background:#fee2e2;
            color:#991b1b;
            padding:16px 18px;
            border-radius:16px;
            font-weight:600;
            margin-bottom:24px;
            border:1px solid #fecaca;
        }

        .form-grid{
            display:grid;
            grid-template-columns:repeat(2,1fr);
            gap:20px;
        }

        .form-group{
            display:flex;
            flex-direction:column;
        }

        .form-group.full{
            grid-column:1 / -1;
        }

        label{
            font-size:14px;
            font-weight:600;
            margin-bottom:10px;
            color:#0f172a;
        }

        input, select, textarea{
            padding:15px 16px;
            border-radius:14px;
            border:1px solid #dbeafe;
            font-family:'Poppins',sans-serif;
            font-size:15px;
            background:#ffffff;
            transition:0.3s ease;
            outline:none;
        }

        input:focus, select:focus, textarea:focus{
            border-color:var(--help-blue);
            box-shadow:0 0 0 4px rgba(29,78,216,0.08);
        }

        textarea{
            min-height:130px;
            resize:vertical;
        }

        .submit-btn{
            margin-top:26px;
            display:inline-block;
            width:100%;
            padding:16px;
            border:none;
            border-radius:16px;
            background:linear-gradient(135deg,#1d4ed8,#2563eb);
            color:#ffffff;
            font-weight:700;
            font-size:16px;
            cursor:pointer;
            transition:0.3s ease;
            box-shadow:0 14px 30px rgba(37,99,235,0.22);
        }

        .submit-btn:hover{
            transform:translateY(-3px);
        }

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
            position:relative;
            width:fit-content;
        }

        .footer-links a:hover{
            color:#fbbf24;
            text-shadow:0 0 8px rgba(251,191,36,0.55);
            transform:translateX(4px);
        }

        .footer-credit strong{ color:#ffffff; }

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
            .cards,
            .footer-grid{
                grid-template-columns:repeat(2,1fr);
            }

            .form-wrap{
                grid-template-columns:1fr;
            }

            .hero h1{ font-size:54px; }
            .section-head h2,
            .form-side h2{ font-size:42px; }
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
                padding-top:180px;
                min-height:65vh;
            }

            .hero h1{ font-size:38px; }
            .hero p{ font-size:17px; }

            .section{ padding:80px 18px; }

            .section-head h2,
            .form-side h2{ font-size:34px; }

            .cards,
            .footer-grid,
            .form-grid,
            .claim-grid{
                grid-template-columns:1fr;
            }

            .form-card{
                padding:32px 22px;
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
            <a href="request-help.php" class="active">Request Help</a>
            <a href="volunteer.php">Join Us</a>
            <a href="contact.php">Contact</a>
            <a href="#help-form" class="nav-btn">Request Now</a>
        </div>
    </div>

    <section class="hero">
        <div class="hero-bg"></div>

        <div class="hero-content">
            <div class="hero-badge">Respectful food support for individuals, families, and community groups</div>
            <h1>Request Food Support</h1>
            <p>If you or your organization need food assistance, you can request support here. Our goal is to connect available meals with people who need them most — simply, safely, and respectfully.</p>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="section-head hidden">
                <span class="tag">Who Can Request</span>
                <h2>Designed for real needs and real communities</h2>
                <p>This support page is created for individuals, families, shelters, and verified support groups who may need food assistance.</p>
            </div>

            <div class="cards">
                <div class="card hidden">
                    <div class="icon">👨‍👩‍👧</div>
                    <h3>Families</h3>
                    <p>Families facing temporary food shortage can request meal support for urgent daily needs.</p>
                </div>

                <div class="card hidden">
                    <div class="icon">🏠</div>
                    <h3>Shelters & Homes</h3>
                    <p>Community shelters, care homes, and support centers can request available food assistance.</p>
                </div>

                <div class="card hidden">
                    <div class="icon">🤝</div>
                    <h3>NGOs & Kitchens</h3>
                    <p>Verified groups working at ground level can request meals or packaged food for meaningful distribution.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="section form-section" id="help-form">
        <div class="container form-wrap">
            <div class="form-side hidden">
                <h2>Why this form matters</h2>
                <p>This form helps ShareTheMeal understand who needs help, what type of food support is required, and how support can be coordinated better.</p>

                <div class="form-points">
                    <div class="form-point">
                        <strong>Request Assistance</strong>
                        <span>People or organizations can share their food support needs in one simple and respectful place.</span>
                    </div>

                    <div class="form-point">
                        <strong>Better Coordination</strong>
                        <span>Details like people count, timing, and location help organize food support more clearly.</span>
                    </div>

                    <div class="form-point">
                        <strong>Claim Real Donations</strong>
                        <span>If you came from Available Meals, this form can also claim a specific donation automatically.</span>
                    </div>
                </div>
            </div>

            <div class="form-card hidden">
                <h3><?php echo $isClaimMode ? "Claim This Food Support" : "Food Support Request Form"; ?></h3>
                <p><?php echo $isClaimMode ? "You are requesting a specific available donation listed on ShareTheMeal." : "Fill in your details below so we can understand your support needs properly."; ?></p>

                <?php if($isClaimMode && $claimDonation): ?>
                    <div class="claim-banner">
                        <h3>Selected Food Listing</h3>
                        <p>You are about to request support for this available food donation. Once submitted, this listing will be marked as <strong>Claimed</strong>.</p>

                        <div class="claim-grid">
                            <div class="claim-item">
                                <span>Food Type</span>
                                <strong><?php echo htmlspecialchars($claimDonation['contribution_type']); ?></strong>
                            </div>

                            <div class="claim-item">
                                <span>Location</span>
                                <strong><?php echo htmlspecialchars($claimDonation['city']); ?></strong>
                            </div>

                            <div class="claim-item">
                                <span>Pickup Date</span>
                                <strong><?php echo htmlspecialchars($claimDonation['pickup_date']); ?></strong>
                            </div>

                            <div class="claim-item">
                                <span>Pickup Time</span>
                                <strong><?php echo htmlspecialchars($claimDonation['pickup_time']); ?></strong>
                            </div>

                            <div class="claim-item">
                                <span>Quantity</span>
                                <strong><?php echo htmlspecialchars($claimDonation['quantity']); ?></strong>
                            </div>

                            <div class="claim-item">
                                <span>Donor</span>
                                <strong><?php echo htmlspecialchars($claimDonation['fullname']); ?></strong>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if($success): ?>
                    <div class="success-message">
                        ✅ Your request has been submitted successfully.
                        <?php echo !empty($donation_id) ? " The selected donation has now been marked as Claimed." : " Thank you for reaching out to ShareTheMeal."; ?>
                    </div>
                <?php endif; ?>

                <?php if(!empty($error)): ?>
                    <div class="error-message">
                        ❌ <?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="#help-form">
                    <input type="hidden" name="donation_id" value="<?php echo htmlspecialchars($donation_id); ?>">

                    <div class="form-grid">
                        <div class="form-group">
                            <label>Full Name / Organization Name</label>
                            <input type="text" name="fullname" placeholder="Enter name" required value="<?php echo htmlspecialchars($fullname); ?>">
                        </div>

                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="email" name="email" placeholder="Enter your email" required value="<?php echo htmlspecialchars($email); ?>">
                        </div>

                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="tel" name="phone" placeholder="Enter your phone number" required value="<?php echo htmlspecialchars($phone); ?>">
                        </div>

                        <div class="form-group">
                            <label>Request Type</label>
                            <select name="request_type" required>
                                <option value="">Select request type</option>
                                <option value="Cooked Food" <?php if($request_type=="Cooked Food") echo "selected"; ?>>Cooked Food</option>
                                <option value="Packaged Food" <?php if($request_type=="Packaged Food") echo "selected"; ?>>Packaged Food</option>
                                <option value="Emergency Food Support" <?php if($request_type=="Emergency Food Support") echo "selected"; ?>>Emergency Food Support</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>City / Location</label>
                            <select name="city" required>
                                <option value="">Select your city</option>
                                <option value="Delhi" <?php if($city=="Delhi") echo "selected"; ?>>Delhi</option>
                                <option value="Mumbai" <?php if($city=="Mumbai") echo "selected"; ?>>Mumbai</option>
                                <option value="Chandigarh" <?php if($city=="Chandigarh") echo "selected"; ?>>Chandigarh</option>
                                <option value="Mohali" <?php if($city=="Mohali") echo "selected"; ?>>Mohali</option>
                                <option value="Amritsar" <?php if($city=="Amritsar") echo "selected"; ?>>Amritsar</option>
                                <option value="Ludhiana" <?php if($city=="Ludhiana") echo "selected"; ?>>Ludhiana</option>
                                <option value="Patiala" <?php if($city=="Patiala") echo "selected"; ?>>Patiala</option>
                                <option value="Jalandhar" <?php if($city=="Jalandhar") echo "selected"; ?>>Jalandhar</option>
                                <option value="Jaipur" <?php if($city=="Jaipur") echo "selected"; ?>>Jaipur</option>
                                <option value="Ahmedabad" <?php if($city=="Ahmedabad") echo "selected"; ?>>Ahmedabad</option>
                                <option value="Pune" <?php if($city=="Pune") echo "selected"; ?>>Pune</option>
                                <option value="Bangalore" <?php if($city=="Bangalore") echo "selected"; ?>>Bangalore</option>
                                <option value="Hyderabad" <?php if($city=="Hyderabad") echo "selected"; ?>>Hyderabad</option>
                                <option value="Kolkata" <?php if($city=="Kolkata") echo "selected"; ?>>Kolkata</option>
                                <option value="Chennai" <?php if($city=="Chennai") echo "selected"; ?>>Chennai</option>
                                <option value="Panipat" <?php if($city=="Panipat") echo "selected"; ?>>Panipat</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Number of People</label>
                            <input type="number" name="people_count" placeholder="Example: 25" required value="<?php echo htmlspecialchars($people_count); ?>">
                        </div>

                        <div class="form-group">
                            <label>Needed Date</label>
                            <input type="date" name="needed_date" required value="<?php echo htmlspecialchars($needed_date); ?>">
                        </div>

                        <div class="form-group">
                            <label>Preferred Time</label>
                            <input type="time" name="needed_time" required value="<?php echo htmlspecialchars($needed_time); ?>">
                        </div>

                        <div class="form-group full">
                            <label>Address / Pickup or Delivery Location</label>
                            <textarea name="address" placeholder="Enter full location details" required><?php echo htmlspecialchars($address); ?></textarea>
                        </div>

                        <div class="form-group full">
                            <label>Additional Details</label>
                            <textarea name="details" placeholder="Mention urgency, special needs, organization details, or any important information"><?php echo htmlspecialchars($details); ?></textarea>
                        </div>
                    </div>

                    <button type="submit" class="submit-btn">
                        <?php echo $isClaimMode ? "Claim This Food Support" : "Submit Help Request"; ?>
                    </button>
                </form>
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