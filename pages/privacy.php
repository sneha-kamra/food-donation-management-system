<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Privacy Policy | ShareTheMeal</title>
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
            min-height:75vh;
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
                radial-gradient(circle at 20% 20%, rgba(245,158,11,0.22), transparent 25%),
                radial-gradient(circle at 80% 30%, rgba(20,184,166,0.20), transparent 28%),
                radial-gradient(circle at 50% 80%, rgba(59,130,246,0.18), transparent 30%),
                linear-gradient(135deg, #0f172a 0%, #134e4a 45%, #1e293b 100%);
            transform:scale(1.03);
        }

        .page-hero::before,
        .page-hero::after{
            content:"";
            position:absolute;
            border-radius:50%;
            filter:blur(80px);
            opacity:0.35;
            z-index:1;
        }

        .page-hero::before{
            width:260px;
            height:260px;
            background:rgba(245,158,11,0.35);
            top:80px;
            left:8%;
        }

        .page-hero::after{
            width:300px;
            height:300px;
            background:rgba(20,184,166,0.28);
            bottom:60px;
            right:8%;
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
            font-size:66px;
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

        .hero-meta{
            display:flex;
            justify-content:center;
            gap:14px;
            flex-wrap:wrap;
            margin-top:20px;
        }

        .meta-pill{
            background:rgba(255,255,255,0.10);
            color:#f8fafc;
            padding:10px 16px;
            border-radius:999px;
            font-size:14px;
            border:1px solid rgba(255,255,255,0.15);
            backdrop-filter:blur(10px);
        }

        .hero-btns{
            display:flex;
            justify-content:center;
            gap:16px;
            flex-wrap:wrap;
            margin-top:28px;
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
            padding:100px 20px;
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

        /* OVERVIEW CARDS */
        .policy-grid{
            display:grid;
            grid-template-columns:repeat(2,1fr);
            gap:28px;
        }

        .policy-card{
            background:var(--card);
            border-radius:30px;
            padding:34px 30px;
            box-shadow:var(--shadow);
            transition:0.35s ease;
            border:1px solid rgba(15,23,42,0.04);
        }

        .policy-card:hover{
            transform:translateY(-8px);
            box-shadow:var(--shadow-hover);
        }

        .policy-card:nth-child(1){
            background:linear-gradient(135deg, #fff7ed, #ffedd5);
        }

        .policy-card:nth-child(2){
            background:linear-gradient(135deg, #ecfdf5, #d1fae5);
        }

        .policy-card:nth-child(3){
            background:linear-gradient(135deg, #f5f3ff, #ede9fe);
        }

        .policy-card:nth-child(4){
            background:linear-gradient(135deg, #eff6ff, #dbeafe);
        }

        .policy-card .icon{
            font-size:42px;
            margin-bottom:16px;
        }

        .policy-card h3{
            font-size:28px;
            margin-bottom:12px;
            color:var(--text);
        }

        .policy-card p{
            color:var(--muted);
            font-size:15px;
            line-height:1.9;
        }

        /* PROFESSIONAL POLICY BLOCKS */
        .policy-detail-grid{
            display:grid;
            grid-template-columns:repeat(2,1fr);
            gap:28px;
        }

        .policy-block{
            background:#ffffff;
            border-radius:30px;
            padding:34px 30px;
            box-shadow:var(--shadow);
            border:1px solid rgba(15,23,42,0.04);
            transition:0.35s ease;
        }

        .policy-block:hover{
            transform:translateY(-6px);
            box-shadow:var(--shadow-hover);
        }

        .policy-block h3{
            font-size:28px;
            color:var(--primary-dark);
            margin-bottom:14px;
        }

        .policy-block p{
            color:var(--muted);
            font-size:15px;
            line-height:1.95;
            margin-bottom:14px;
        }

        .policy-block ul{
            padding-left:20px;
            color:var(--muted);
            line-height:2;
            font-size:15px;
        }

        .highlight-box{
            background:linear-gradient(135deg,#0f172a,#1e293b);
            color:white;
            border-radius:32px;
            padding:42px 34px;
            box-shadow:0 20px 50px rgba(15,23,42,0.18);
        }

        .highlight-box h3{
            font-size:34px;
            margin-bottom:18px;
            line-height:1.2;
        }

        .highlight-box p{
            color:#cbd5e1;
            font-size:16px;
            line-height:1.95;
            margin-bottom:18px;
        }

        .highlight-list{
            display:grid;
            gap:16px;
            margin-top:18px;
        }

        .highlight-item{
            background:rgba(255,255,255,0.08);
            border:1px solid rgba(255,255,255,0.10);
            border-radius:20px;
            padding:18px 18px;
        }

        .highlight-item strong{
            display:block;
            color:#ffffff;
            margin-bottom:6px;
            font-size:17px;
        }

        .highlight-item span{
            color:#cbd5e1;
            font-size:15px;
            line-height:1.8;
        }

        /* CTA */
        .cta{
            background:
                radial-gradient(circle at top left, rgba(245,158,11,0.18), transparent 25%),
                radial-gradient(circle at bottom right, rgba(20,184,166,0.18), transparent 30%),
                linear-gradient(135deg, #0f172a 0%, #1e293b 55%, #134e4a 100%);
            padding:110px 20px;
            text-align:center;
            color:white;
            position:relative;
            overflow:hidden;
        }

        .cta::before,
        .cta::after{
            content:"";
            position:absolute;
            border-radius:50%;
            filter:blur(80px);
            opacity:0.25;
        }

        .cta::before{
            width:220px;
            height:220px;
            background:rgba(245,158,11,0.28);
            top:20px;
            left:10%;
        }

        .cta::after{
            width:260px;
            height:260px;
            background:rgba(20,184,166,0.25);
            bottom:20px;
            right:10%;
        }

        .cta .container{
            position:relative;
            z-index:2;
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
            .policy-grid,
            .footer-grid,
            .policy-detail-grid{
                grid-template-columns:repeat(2,1fr);
            }

            .page-hero h1{
                font-size:52px;
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
                min-height:68vh;
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
            .highlight-box h3,
            .policy-block h3{
                font-size:32px;
            }

            .policy-grid,
            .footer-grid,
            .policy-detail-grid{
                grid-template-columns:1fr;
            }

            .policy-card,
            .policy-block,
            .highlight-box{
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
            <a href="request-help.php">Request Help</a>
            <a href="volunteer.php">Join Us</a>
            <a href="contact.php">Contact</a>
            <a href="donate.php" class="nav-btn">Donate Now</a>
        </div>
    </div>

    <!-- HERO -->
    <section class="page-hero">
        <div class="page-hero-bg"></div>

        <div class="page-hero-content">
            <div class="hero-badge">Your Information Matters • Transparency • Trust • Respect</div>
            <h1>Privacy Policy</h1>
            <p>At ShareTheMeal, we value the trust of our donors, volunteers, supporters, and individuals seeking help. This page explains how information may be collected, used, and protected through our platform.</p>

            <div class="hero-meta">
                <div class="meta-pill">Transparency First</div>
                <div class="meta-pill">Community Support Platform</div>
            </div>

            <div class="hero-btns">
                <a href="#policy-details" class="btn btn-primary">Read Policy</a>
                <a href="contact.php" class="btn btn-outline">Contact Us</a>
            </div>
        </div>
    </section>

    <!-- OVERVIEW -->
    <section class="section">
        <div class="container">
            <div class="section-head hidden">
                <span class="tag">Privacy Overview</span>
                <h2>We collect only what helps us serve better</h2>
                <p>This privacy policy explains what information may be collected through our website and how it is used responsibly for food support, volunteer coordination, and communication purposes.</p>
            </div>

            <div class="policy-grid">
                <div class="policy-card hidden">
                    <div class="icon">🔐</div>
                    <h3>Data Protection</h3>
                    <p>We aim to keep submitted information secure and use it responsibly for support coordination, communication, and platform-related activities only.</p>
                </div>

                <div class="policy-card hidden">
                    <div class="icon">📋</div>
                    <h3>Information Collection</h3>
                    <p>We may collect basic details such as name, email, phone number, city, address, and information shared through our forms.</p>
                </div>

                <div class="policy-card hidden">
                    <div class="icon">🤝</div>
                    <h3>Purpose of Use</h3>
                    <p>Your information helps us manage food donations, volunteer participation, support requests, follow-ups, and website communication.</p>
                </div>

                <div class="policy-card hidden">
                    <div class="icon">🌍</div>
                    <h3>Trust & Respect</h3>
                    <p>We aim to maintain a trustworthy, respectful, and transparent experience for every person using our platform.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- PROFESSIONAL POLICY DETAILS -->
    <section class="section" id="policy-details" style="background:#f1f5f9;">
        <div class="container">
            <div class="section-head hidden">
                <span class="tag">Detailed Policy</span>
                <h2>How your information is handled on our platform</h2>
                <p>Below is a clear and structured explanation of how ShareTheMeal may collect, use, and protect information submitted through the website.</p>
            </div>

            <div class="policy-detail-grid">
                <div class="policy-block hidden">
                    <h3>1. Information We May Collect</h3>
                    <p>When users interact with ShareTheMeal, we may collect information submitted through forms, pages, and direct communication.</p>
                    <ul>
                        <li>Full name</li>
                        <li>Email address</li>
                        <li>Phone number</li>
                        <li>City or location details</li>
                        <li>Address or pickup/delivery details</li>
                        <li>Volunteer information</li>
                        <li>Donation-related details</li>
                        <li>Help request information</li>
                        <li>Feedback, complaints, or messages</li>
                    </ul>
                </div>

                <div class="policy-block hidden">
                    <h3>2. How We Use Your Information</h3>
                    <p>The information shared through this platform is used only for website-related and support-focused purposes.</p>
                    <ul>
                        <li>To respond to food donation submissions</li>
                        <li>To manage food support requests</li>
                        <li>To connect with volunteers and supporters</li>
                        <li>To improve communication and coordination</li>
                        <li>To follow up on submitted forms</li>
                        <li>To handle inquiries, complaints, or feedback</li>
                    </ul>
                </div>

                <div class="policy-block hidden">
                    <h3>3. Data Protection & Security</h3>
                    <p>We aim to take reasonable care in handling the information submitted through this website. While no online platform can guarantee absolute security, we value responsible handling of data.</p>
                    <ul>
                        <li>Submitted information is intended for platform-related use only</li>
                        <li>We aim to avoid unnecessary misuse of user data</li>
                        <li>Access to submitted information should remain limited to relevant website handling purposes</li>
                    </ul>
                </div>

                <div class="policy-block hidden">
                    <h3>4. Sharing of Information</h3>
                    <p>We do not intend to sell personal information or use it for unrelated promotional misuse. Information is expected to remain limited to website operation and support coordination.</p>
                    <ul>
                        <li>No intentional sale of personal information</li>
                        <li>No unrelated commercial misuse of submitted data</li>
                        <li>Information may only be used where necessary for platform support and communication</li>
                    </ul>
                </div>

                <div class="policy-block hidden">
                    <h3>5. Cookies & Website Usage</h3>
                    <p>Our website may use basic browser/session-related functionality to improve user experience and website performance. This may include standard technical data such as browser behavior or session handling.</p>
                    <ul>
                        <li>To improve website usability</li>
                        <li>To support page functionality</li>
                        <li>To enhance general browsing experience</li>
                    </ul>
                </div>

                <div class="policy-block hidden">
                    <h3>6. User Responsibility</h3>
                    <p>Users are encouraged to provide only necessary, accurate, and respectful information while using the platform.</p>
                    <ul>
                        <li>Submit correct and relevant details</li>
                        <li>Avoid sharing unnecessary sensitive information</li>
                        <li>Use the website respectfully and responsibly</li>
                    </ul>
                </div>

                <div class="policy-block hidden">
                    <h3>7. Your Rights</h3>
                    <p>If you have concerns regarding the information you submitted through this platform, you may contact us for clarification.</p>
                    <ul>
                        <li>You may ask questions related to your submitted information</li>
                        <li>You may request clarification about privacy-related concerns</li>
                        <li>You may contact us regarding website communication or form submissions</li>
                    </ul>
                </div>

                <div class="policy-block hidden">
                    <h3>8. Policy Updates</h3>
                    <p>This privacy policy may be updated in the future if website features expand or if improvements are made to the platform.</p>
                    <ul>
                        <li>Policy content may evolve with website growth</li>
                        <li>Users are encouraged to review this page periodically</li>
                        <li>Updated versions will reflect the latest website practices</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- TRUST SECTION -->
    <section class="section">
        <div class="container">
            <div class="policy-detail-grid">
                <div class="highlight-box hidden">
                    <h3>Your trust matters to us</h3>
                    <p>ShareTheMeal is designed as a socially responsible platform focused on food support and community care. We value the trust of every donor, volunteer, and visitor.</p>
                    <p>We do not intend to use personal information for unrelated or harmful purposes, and we aim to handle submitted information respectfully and responsibly.</p>

                    <div class="highlight-list">
                        <div class="highlight-item">
                            <strong>No unnecessary misuse</strong>
                            <span>We aim to use submitted details only for website-related communication and support coordination.</span>
                        </div>

                        <div class="highlight-item">
                            <strong>Support-focused use</strong>
                            <span>Information is collected to help manage food donations, volunteer participation, and assistance requests.</span>
                        </div>

                        <div class="highlight-item">
                            <strong>Trust-first approach</strong>
                            <span>We believe transparency and user trust are essential for any social impact platform.</span>
                        </div>
                    </div>
                </div>

                <div class="policy-block hidden">
                    <h3>Contact for Privacy Concerns</h3>
                    <p>If you have any concerns related to your personal information, website submissions, or communication through the platform, you are welcome to contact us.</p>
                    <p>We value feedback and aim to maintain a respectful, transparent, and support-focused digital experience for all users.</p>

                    <ul>
                        <li>Questions about submitted information</li>
                        <li>Clarification regarding privacy concerns</li>
                        <li>Feedback related to website communication</li>
                        <li>General privacy or support-related inquiries</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="cta">
        <div class="container">
            <h2>Questions about privacy or your submitted information?</h2>
            <p>If you have any concerns related to your personal information, form submissions, or website communication, feel free to contact us directly.</p>
            <a href="contact.php" class="btn btn-primary">Contact Our Team</a>
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