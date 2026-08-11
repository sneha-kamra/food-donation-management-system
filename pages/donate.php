<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$success = false;
$error = "";

// Database connection
$conn = new mysqli("sql106.hstn.me", "mseet_41388470", "Foodshare1234", "mseet_41388470_foodshare");

// Check connection
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get form data safely
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $contribution_type = trim($_POST['contribution_type']);
    $city = trim($_POST['city']);
    $pickup_date = trim($_POST['pickup_date']);
    $pickup_time = trim($_POST['pickup_time']);
    $quantity = trim($_POST['quantity']);
    $address = trim($_POST['address']);
    $details = trim($_POST['details']);

    // Insert into donations table
    $stmt = $conn->prepare("INSERT INTO donations (fullname, email, phone, contribution_type, city, pickup_date, pickup_time, quantity, address, details) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if ($stmt) {
        $stmt->bind_param("ssssssssss", $fullname, $email, $phone, $contribution_type, $city, $pickup_date, $pickup_time, $quantity, $address, $details);

        if ($stmt->execute()) {
            $success = true;
        } else {
            $error = "Something went wrong while saving data: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $error = "Database query preparation failed: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Donate Food | ShareTheMeal</title>
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
                linear-gradient(rgba(15,23,42,0.50), rgba(15,23,42,0.48)),
                url("../images/donatebg.jpg?v=2") center center / 100% auto no-repeat;
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

        /* SECTION */
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
            background:#ccfbf1;
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

        /* DONATION TYPES */
        .cards{
            display:grid;
            grid-template-columns:repeat(3,1fr);
            gap:28px;
        }

        .card{
            background:var(--card);
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

        /* WHY DONATE */
        .info-grid{
            display:grid;
            grid-template-columns:repeat(3,1fr);
            gap:28px;
            margin-top:30px;
        }

        .info-box{
            background:#ffffff;
            border-radius:26px;
            box-shadow:var(--shadow);
            padding:30px 26px;
            transition:0.35s ease;
        }

        .info-box:hover{
            transform:translateY(-6px);
            box-shadow:var(--shadow-hover);
        }

        .info-box .icon{
            font-size:36px;
            margin-bottom:16px;
        }

        .info-box h3{
            font-size:24px;
            margin-bottom:12px;
        }

        .info-box p{
            color:var(--muted);
            font-size:15px;
            line-height:1.9;
        }

        /* FORM */
        .form-section{
            background:#f1f5f9;
        }

        .form-wrap{
            display:grid;
            grid-template-columns:1fr 1.1fr;
            gap:40px;
            align-items:start;
        }

        .form-side{
            background:linear-gradient(135deg,#0f172a,#1e293b);
            color:white;
            border-radius:30px;
            padding:45px 35px;
            box-shadow:0 18px 45px rgba(0,0,0,0.12);
        }

        .form-side h2{
            font-size:42px;
            margin-bottom:18px;
            line-height:1.2;
        }

        .form-side p{
            color:#cbd5e1;
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
            background:rgba(255,255,255,0.08);
            border:1px solid rgba(255,255,255,0.08);
            padding:18px 20px;
            border-radius:18px;
        }

        .form-point strong{
            display:block;
            margin-bottom:6px;
            font-size:17px;
        }

        .form-point span{
            color:#cbd5e1;
            font-size:15px;
            line-height:1.8;
        }

        .form-card{
            background:#ffffff;
            border-radius:30px;
            box-shadow:var(--shadow);
            padding:40px 32px;
        }

        .form-card h3{
            font-size:34px;
            margin-bottom:10px;
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

        input,
        select,
        textarea{
            padding:15px 16px;
            border-radius:14px;
            border:1px solid #dbe4ee;
            font-family:'Poppins',sans-serif;
            font-size:15px;
            background:#ffffff;
            transition:0.3s ease;
            outline:none;
        }

        input:focus,
        select:focus,
        textarea:focus{
            border-color:var(--primary);
            box-shadow:0 0 0 4px rgba(15,118,110,0.08);
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
            background:var(--accent);
            color:#111827;
            font-weight:700;
            font-size:16px;
            cursor:pointer;
            transition:0.3s ease;
            box-shadow:0 14px 30px rgba(245,158,11,0.28);
        }

        .submit-btn:hover{
            transform:translateY(-3px);
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

        /* SCROLL ANIMATION */
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
            .info-grid,
            .footer-grid{
                grid-template-columns:repeat(2,1fr);
            }

            .form-wrap{
                grid-template-columns:1fr;
            }

            .hero h1{
                font-size:54px;
            }

            .section-head h2,
            .form-side h2{
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

            .hero{
                padding-top:180px;
                min-height:65vh;
            }

            .hero h1{
                font-size:38px;
            }

            .hero p{
                font-size:17px;
            }

            .section{
                padding:80px 18px;
            }

            .section-head h2,
            .form-side h2{
                font-size:34px;
            }

            .cards,
            .info-grid,
            .footer-grid,
            .form-grid{
                grid-template-columns:1fr;
            }

            .form-card{
                padding:32px 22px;
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
            <a href="donate.php" class="active">Donate Food</a>
            <a href="viewfood.php">Available Meals</a>
            <a href="request-help.php">Request Help</a>
            <a href="volunteer.php">Join Us</a>
            <a href="contact.php">Contact</a>
            <a href="#contribution-form" class="nav-btn">Donate Now</a>
        </div>
    </div>

    <!-- HERO -->
    <section class="hero">
        <div class="hero-bg"></div>

        <div class="hero-content">
            <div class="hero-badge">Support meals, reduce waste, create impact</div>
            <h1>Donate Food</h1>
            <p>Your food donation can help connect meals, care, and support with people who need it most. Every donation matters.</p>
        </div>
    </section>

    <!-- DONATION TYPES -->
    <section class="section">
        <div class="container">
            <div class="section-head hidden">
                <span class="tag">Ways To Donate</span>
                <h2>Choose the kind of food support you want to offer</h2>
                <p>We have designed this page to make food donation simple, meaningful, and practical for individuals, families, and local supporters.</p>
            </div>

            <div class="cards">
                <div class="card hidden">
                    <div class="icon">🍲</div>
                    <h3>Cooked Food</h3>
                    <p>Share freshly prepared surplus meals from your home, event, or gathering so they can be directed toward people in need.</p>
                </div>

                <div class="card hidden">
                    <div class="icon">📦</div>
                    <h3>Packaged Food</h3>
                    <p>Donate sealed and usable packaged food items that are safe for sharing and easy to distribute responsibly.</p>
                </div>

                <div class="card hidden">
                    <div class="icon">💰</div>
                    <h3>Cash Donation</h3>
                    <p>Support outreach, transport, and hunger relief efforts by contributing financially to strengthen the mission.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- WHY DONATE -->
    <section class="section" style="background:#f1f5f9;">
        <div class="container">
            <div class="section-head hidden">
                <span class="tag">Why It Matters</span>
                <h2>Your support can create real local impact</h2>
                <p>Donating is not only about giving — it is about helping food reach people with dignity, care, and responsibility.</p>
            </div>

            <div class="info-grid">
                <div class="info-box hidden">
                    <div class="icon">🍽️</div>
                    <h3>Feed More People</h3>
                    <p>Usable food can become a meaningful source of support for individuals and communities facing food insecurity.</p>
                </div>

                <div class="info-box hidden">
                    <div class="icon">♻️</div>
                    <h3>Reduce Food Waste</h3>
                    <p>Responsible food donation helps reduce the amount of good food that would otherwise be unnecessarily wasted.</p>
                </div>

                <div class="info-box hidden">
                    <div class="icon">🤝</div>
                    <h3>Strengthen Community</h3>
                    <p>Every donation encourages compassion, participation, and stronger support networks in local communities.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FORM SECTION -->
    <section class="section form-section" id="contribution-form">
        <div class="container form-wrap">
            <div class="form-side hidden">
                <h2>Donate with care and purpose</h2>
                <p>Fill out the form with your donation details and our support system can help make the process smoother and more organized.</p>

                <div class="form-points">
                    <div class="form-point">
                        <strong>Safe & Responsible Sharing</strong>
                        <span>Please donate only fresh, usable, and responsibly handled food items.</span>
                    </div>

                    <div class="form-point">
                        <strong>Location-Based Support</strong>
                        <span>Select your city and pickup timing so food support can be coordinated more efficiently.</span>
                    </div>

                    <div class="form-point">
                        <strong>Confirmation After Submission</strong>
                        <span>Once submitted, you will receive a confirmation-style message on the screen.</span>
                    </div>
                </div>
            </div>

            <div class="form-card hidden">
                <h3>Donate Food Form</h3>
                <p>Submit your food donation details below.</p>

                <?php if($success): ?>
                    <div class="success-message">
                        ✅ Thank you for your food donation! Your submission has been received successfully. We appreciate your support for ShareTheMeal.
                    </div>
                <?php endif; ?>

                <?php if(!empty($error)): ?>
                    <div class="error-message">
                        ❌ <?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="#contribution-form">
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" name="fullname" placeholder="Enter your full name" required>
                        </div>

                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="email" name="email" placeholder="Enter your email" required>
                        </div>

                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="tel" name="phone" placeholder="Enter your phone number" required>
                        </div>

                        <div class="form-group">
                            <label>Contribution Type</label>
                            <select name="contribution_type" required>
                                <option value="">Select contribution type</option>
                                <option value="Cooked Food">Cooked Food</option>
                                <option value="Packaged Food">Packaged Food</option>
                                <option value="Cash Donation">Cash Donation</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>City / Location</label>
                            <select name="city" required>
                                <option value="">Select your city</option>
                                <option>Delhi</option>
                                <option>Mumbai</option>
                                <option>Chandigarh</option>
                                <option>Mohali</option>
                                <option>Amritsar</option>
                                <option>Ludhiana</option>
                                <option>Patiala</option>
                                <option>Jalandhar</option>
                                <option>Jaipur</option>
                                <option>Ahmedabad</option>
                                <option>Pune</option>
                                <option>Bangalore</option>
                                <option>Hyderabad</option>
                                <option>Kolkata</option>
                                <option>Chennai</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Pickup Date</label>
                            <input type="date" name="pickup_date" required>
                        </div>

                        <div class="form-group">
                            <label>Pickup Time</label>
                            <input type="time" name="pickup_time" required>
                        </div>

                        <div class="form-group">
                            <label>Estimated Quantity</label>
                            <input type="text" name="quantity" placeholder="Example: 20 meals / 5 boxes / ₹5000">
                        </div>

                        <div class="form-group full">
                            <label>Pickup Address</label>
                            <textarea name="address" placeholder="Enter full pickup address" required></textarea>
                        </div>

                        <div class="form-group full">
                            <label>Additional Details</label>
                            <textarea name="details" placeholder="Mention food type, packaging, serving count, donation note, or any important instructions"></textarea>
                        </div>
                    </div>

                    <button type="submit" class="submit-btn">Submit Donation</button>
                </form>
            </div>
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