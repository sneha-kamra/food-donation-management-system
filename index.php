<!DOCTYPE html>
<html lang="en">
<head>
    <title>ShareTheMeal | Feeding The Hungry</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="icon" type="image/png" href="images/logo.png?v=5">
<link rel="shortcut icon" href="images/logo.png?v=5">
<link rel="apple-touch-icon" href="images/logo.png?v=5">

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

        /* HERO */
        .hero{
            min-height:100vh;
            position:relative;
            display:flex;
            align-items:center;
            justify-content:center;
            padding:140px 20px 100px;
            overflow:hidden;
            text-align:center;
        }

        .hero-bg{
            position:absolute;
            inset:0;
            background:
                linear-gradient(rgba(15,23,42,0.22), rgba(15,23,42,0.22)),
                url("images/foodbg.jpg?v=2") center center / cover no-repeat;            transform:scale(1.02);
            filter:brightness(1.22);
        }

        .hero::after{
            content:"";
            position:absolute;
            inset:0;
            background:linear-gradient(to top, rgba(15,23,42,0.14), rgba(15,23,42,0.05));
        }

        .hero-content{
            position:relative;
            z-index:2;
            max-width:1000px;
            animation:fadeUp 1.2s ease;
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
            background:rgba(255,255,255,0.18);
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
            font-size:74px;
            line-height:1.08;
            color:var(--white);
            font-weight:800;
            margin-bottom:18px;
            letter-spacing:-1px;
        }

        .hero p{
            font-size:22px;
            color:#f1f5f9;
            line-height:1.8;
            max-width:800px;
            margin:0 auto;
        }

        .hero-buttons{
            margin-top:38px;
            display:flex;
            justify-content:center;
            gap:18px;
            flex-wrap:wrap;
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
            background:rgba(255,255,255,0.10);
            border:1px solid rgba(255,255,255,0.28);
            color:var(--white);
            backdrop-filter:blur(10px);
        }

        .btn-outline:hover{
            transform:translateY(-4px);
            background:rgba(255,255,255,0.16);
        }

        .hero-stats{
            margin-top:60px;
            display:flex;
            justify-content:center;
            gap:22px;
            flex-wrap:wrap;
        }

        .hero-stat{
            min-width:200px;
            background:rgba(255,255,255,0.12);
            border:1px solid rgba(255,255,255,0.16);
            border-radius:22px;
            padding:24px 28px;
            color:white;
            backdrop-filter:blur(12px);
            box-shadow:0 12px 30px rgba(0,0,0,0.18);
        }

        .hero-stat h3{
            font-size:34px;
            margin-bottom:6px;
        }

        .hero-stat p{
            font-size:15px;
            color:#e2e8f0;
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
            font-size:58px;
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

        /* TRUST STRIP */
        .trust-strip{
            background:#ffffff;
            margin-top:-60px;
            position:relative;
            z-index:10;
        }

        .trust-grid{
            display:grid;
            grid-template-columns:repeat(4,1fr);
            gap:20px;
        }

        .trust-box{
            background:var(--card);
            border-radius:24px;
            padding:30px 28px;
            box-shadow:var(--shadow);
            text-align:center;
            transition:0.35s ease;
        }

        .trust-box:hover{
            transform:translateY(-6px);
            box-shadow:var(--shadow-hover);
        }

        .trust-box h3{
            font-size:20px;
            margin:14px 0 8px;
        }

        .trust-box p{
            color:var(--muted);
            font-size:15px;
            line-height:1.8;
        }

        .trust-icon{
            font-size:38px;
        }

        /* CARDS */
        .cards{
            display:grid;
            grid-template-columns:repeat(3,1fr);
            gap:28px;
        }

        .card{
            background:var(--card);
            border-radius:28px;
            overflow:hidden;
            box-shadow:var(--shadow);
            transition:0.35s ease;
        }

        .card:hover{
            transform:translateY(-8px);
            box-shadow:var(--shadow-hover);
        }

        .card img{
            width:100%;
            height:240px;
            object-fit:cover;
            object-position:center;
        }

        .card-content{
            padding:28px;
        }

        .step{
            display:inline-block;
            background:#ecfeff;
            color:var(--primary);
            font-size:13px;
            font-weight:700;
            padding:7px 14px;
            border-radius:999px;
            margin-bottom:14px;
        }

        .card h3{
            font-size:28px;
            margin-bottom:12px;
        }

        .card p{
            color:var(--muted);
            line-height:1.9;
            font-size:15px;
        }

        /* ABOUT SPLIT */
        .split{
            display:grid;
            grid-template-columns:1.1fr 1fr;
            gap:55px;
            align-items:center;
        }

        .split-image{
            border-radius:30px;
            overflow:hidden;
            box-shadow:0 18px 45px rgba(0,0,0,0.12);
        }

        .split-image img{
            width:100%;
            height:100%;
            object-fit:cover;
            min-height:520px;
        }

        .split-content .tag{
            display:inline-block;
            color:var(--primary);
            background:#ccfbf1;
            padding:8px 16px;
            border-radius:999px;
            font-size:13px;
            font-weight:700;
            margin-bottom:18px;
        }

        .split-content h2{
            font-size:60px;
            margin-bottom:20px;
            line-height:1.14;
            font-weight:800;
        }

        .split-content p{
            color:var(--muted);
            font-size:16px;
            line-height:1.95;
            margin-bottom:18px;
        }

        .feature-list{
            display:grid;
            gap:16px;
            margin-top:24px;
        }

        .feature-item{
            background:#ffffff;
            border-radius:18px;
            padding:18px 20px;
            box-shadow:var(--shadow);
        }

        .feature-item strong{
            display:block;
            margin-bottom:6px;
            color:var(--text);
            font-size:17px;
        }

        .feature-item span{
            color:var(--muted);
            font-size:15px;
            line-height:1.8;
        }

        /* IMPACT */
        .impact-wrap{
            background:linear-gradient(135deg, #0f172a, #1e293b);
            border-radius:36px;
            padding:75px 40px;
            color:white;
            box-shadow:0 20px 50px rgba(15,23,42,0.18);
        }

        .impact-wrap .section-head h2,
        .impact-wrap .section-head p{
            color:white;
        }

        .impact-wrap .section-head p{
            color:#cbd5e1;
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
            padding:32px 24px;
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

        /* INFO GRID */
        .info-grid{
            display:grid;
            grid-template-columns:repeat(3,1fr);
            gap:28px;
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
            font-size:26px;
            margin-bottom:12px;
        }

        .info-box p{
            color:var(--muted);
            font-size:15px;
            line-height:1.9;
        }

        /* FAQ */
        .faq-wrap{
            max-width:900px;
            margin:auto;
            display:grid;
            gap:18px;
        }

        .faq-item{
            background:#ffffff;
            border-radius:20px;
            box-shadow:var(--shadow);
            padding:24px 26px;
            transition:0.3s ease;
        }

        .faq-item:hover{
            transform:translateY(-4px);
        }

        .faq-item h3{
            font-size:22px;
            margin-bottom:10px;
        }

        .faq-item p{
            color:var(--muted);
            line-height:1.9;
            font-size:15px;
        }

        /* CTA */
        .cta{
            background:
                linear-gradient(rgba(15,23,42,0.48), rgba(15,23,42,0.48)),
                url("images/contactbg.jpg?v=3") center center / cover no-repeat;            padding:110px 20px;
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
            .trust-grid,
            .impact-grid,
            .info-grid,
            .footer-grid{
                grid-template-columns:repeat(2,1fr);
            }

            .split{
                grid-template-columns:1fr;
            }

            .split-image img{
                min-height:420px;
            }

            .hero h1{
                font-size:56px;
            }

            .section-head h2,
            .split-content h2,
            .cta h2{
                font-size:44px;
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
            }

            .hero h1{
                font-size:40px;
            }

            .hero p{
                font-size:17px;
            }

            .hero-stat{
                min-width:160px;
                padding:20px;
            }

            .section{
                padding:80px 18px;
            }

            .section-head h2,
            .split-content h2,
            .cta h2{
                font-size:36px;
            }

            .cards,
            .trust-grid,
            .impact-grid,
            .info-grid,
            .footer-grid{
                grid-template-columns:1fr;
            }

            .card img{
                height:220px;
            }
        }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <div class="navbar" id="navbar">
        <a href="index.php" class="logo">
    <img src="images/logo.png"alt="ShareTheMeal Logo">
    <span>ShareTheMeal</span>
        </a>

        <div class="nav-links">
            <a href="index.php">Home</a>
            <a href="pages/about.php">About</a>
            <a href="pages/donate.php">Donate Food</a>
            <a href="pages/viewfood.php">Available Meals</a>                           
            <a href="pages/volunteer.php">Join Us</a>
            <a href="pages/contact.php">Contact</a>
            <a href="pages/donate.php" class="nav-btn">Donate Now</a>
        </div>
    </div>

    <!-- HERO -->
    <section class="hero">
        <div class="hero-bg"></div>

        <div class="hero-content">
            <div class="hero-badge">A community-driven food support initiative</div>

            <h1>Feeding The Hungry</h1>
            <p>We serve surplus food to people in need with dignity, care, and compassion — helping reduce hunger while preventing good food from going to waste.</p>

            <div class="hero-buttons">
                <a href="pages/donate.php" class="btn btn-primary">Donate Food</a>
                <a href="pages/about.php" class="btn btn-outline">Learn More</a>
            </div>

            <div class="hero-stats">
                <div class="hero-stat">
                    <h3>120+</h3>
                    <p>Meals Shared</p>
                </div>

                <div class="hero-stat">
                    <h3>45+</h3>
                    <p>Community Helpers</p>
                </div>

                <div class="hero-stat">
                    <h3>30+</h3>
                    <p>Food Donors</p>
                </div>
            </div>
        </div>
    </section>

    <!-- TRUST STRIP -->
    <section class="section trust-strip">
        <div class="container">
            <div class="trust-grid">
                <div class="trust-box hidden">
                    <div class="trust-icon">🍱</div>
                    <h3>Surplus Food Collection</h3>
                    <p>Collecting usable extra food from homes, events, and local food providers.</p>
                </div>

                <div class="trust-box hidden">
                    <div class="trust-icon">🤝</div>
                    <h3>Community Support</h3>
                    <p>Connecting donated food with people and communities who need timely support.</p>
                </div>

                <div class="trust-box hidden">
                    <div class="trust-icon">🚚</div>
                    <h3>Safe Food Movement</h3>
                    <p>Helping coordinate collection and delivery in a simple and responsible way.</p>
                </div>

                <div class="trust-box hidden">
                    <div class="trust-icon">🌍</div>
                    <h3>Waste Reduction</h3>
                    <p>Reducing food wastage while encouraging responsible and compassionate giving.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- HOW IT WORKS -->
    <section class="section">
        <div class="container">
            <div class="section-head hidden">
                <span class="tag">How It Works</span>
                <h2>A simple way to turn extra food into meaningful support</h2>
                <p>ShareTheMeal helps connect available food with people in need through a structured and community-based process.</p>
            </div>

            <div class="cards">
                <div class="card hidden">
                <img src="images/donate.jpg?v=2" alt="Donate Food">                    
                        <div class="card-content">
                        <span class="step">Step 01</span>
                        <h3>Donate Food</h3>
                        <p>Individuals, families, restaurants, and event organizers can list surplus food instead of letting it go to waste.</p>
                    </div>
                </div>

                <div class="card hidden">
                <img src="images/volunteer.jpg?v=2" alt="Food Collection Support">                    
                        <div class="card-content">
                        <span class="step">Step 02</span>
                        <h3>Community Collection</h3>
                        <p>Registered support members can help coordinate collection and movement of food from the donor location.</p>
                    </div>
                </div>

                <div class="card hidden">
                <img src="images/distribute.jpg?v=2" alt="Food Distribution">                    
                        <div class="card-content">
                        <span class="step">Step 03</span>
                        <h3>Serve With Dignity</h3>
                        <p>The food is directed toward people who need it, helping ensure it reaches the right hands at the right time.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ABOUT / WHY -->
    <section class="section" style="background:#f1f5f9;">
        <div class="container split">
            <div class="split-image hidden">
                <img src="images/aboutbg.jpg" alt="Helping Communities">
            </div>

            <div class="split-content hidden">
                <span class="tag">Why ShareTheMeal</span>
                <h2>Built with purpose, compassion, and community impact</h2>
                <p>ShareTheMeal is designed to support a simple but powerful mission — ensuring that good food reaches people instead of being wasted.</p>
                <p>Our platform encourages responsible food donation and creates a bridge between food donors and community support networks.</p>

                <div class="feature-list">
                    <div class="feature-item">
                        <strong>Human-Centered Mission</strong>
                        <span>Focused on hunger support, food dignity, and meaningful community service.</span>
                    </div>

                    <div class="feature-item">
                        <strong>Simple Food Donation Flow</strong>
                        <span>Easy donation listing and smooth food visibility for faster support action.</span>
                    </div>

                    <div class="feature-item">
                        <strong>Purpose-Led Digital Initiative</strong>
                        <span>Built to combine technology with social impact in a practical way.</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- OUR PROGRAMS -->
    <section class="section">
        <div class="container">
            <div class="section-head hidden">
                <span class="tag">Our Programs</span>
                <h2>Meaningful initiatives that support hunger relief</h2>
                <p>Our work is centered around responsible food sharing, volunteer action, and community support for those in need.</p>
            </div>

            <div class="cards">
                <div class="card hidden">
                    <img src="images/program1.jpg" alt="Meal Rescue Program">
                    <div class="card-content">
                        <h3>Meal Rescue</h3>
                        <p>Collecting extra meals from homes, gatherings, and food providers before they go to waste.</p>
                    </div>
                </div>

                <div class="card hidden">
                    <img src="images/program2.jpg" alt="Community Outreach">
                    <div class="card-content">
                        <h3>Community Outreach</h3>
                        <p>Helping connect food support efforts with communities and individuals facing food insecurity.</p>
                    </div>
                </div>

                <div class="card hidden">
                    <img src="images/program3.jpg" alt="Volunteer Action">
                    <div class="card-content">
                        <h3>Volunteer Action</h3>
                        <p>Encouraging people to take part in local support work through collection and distribution assistance.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- IMPACT -->
    <section class="section">
        <div class="container">
            <div class="impact-wrap hidden">
                <div class="section-head">
                    <span class="tag" style="background:rgba(255,255,255,0.12); color:#fbbf24;">Our Impact</span>
                    <h2>Every meal shared can create hope</h2>
                    <p>Even small acts of giving can create meaningful change for people and communities.</p>
                </div>

                <div class="impact-grid">
                    <div class="impact-card">
                        <h3>120+</h3>
                        <p>Meals listed and shared through the platform</p>
                    </div>

                    <div class="impact-card">
                        <h3>45+</h3>
                        <p>Community helpers supporting the mission</p>
                    </div>

                    <div class="impact-card">
                        <h3>30+</h3>
                        <p>Food donors participating in support efforts</p>
                    </div>

                    <div class="impact-card">
                        <h3>100%</h3>
                        <p>Purpose-driven effort to reduce hunger and waste</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- HOW YOU CAN HELP -->
    <section class="section" style="background:#f8fafc;">
        <div class="container">
            <div class="section-head hidden">
                <span class="tag">How You Can Help</span>
                <h2>There are many ways to support the mission</h2>
                <p>Whether you have food to share, time to contribute, or simply want to spread awareness, your support matters.</p>
            </div>

            <div class="info-grid">
                <div class="info-box hidden">
                    <div class="icon">🍛</div>
                    <h3>Donate Surplus Food</h3>
                    <p>Share safe and usable extra food from your home, event, or food outlet instead of letting it go to waste.</p>
                </div>

                <div class="info-box hidden">
                    <div class="icon">🙋</div>
                    <h3>Join as a Volunteer</h3>
                    <p>Help support food collection, coordination, and delivery efforts in your local area.</p>
                </div>

                <div class="info-box hidden">
                    <div class="icon">📢</div>
                    <h3>Spread Awareness</h3>
                    <p>Encourage others to donate food responsibly and become part of a more caring community.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- TESTIMONIALS -->
    <section class="section">
        <div class="container">
            <div class="section-head hidden">
                <span class="tag">Voices of Support</span>
                <h2>What people feel about this mission</h2>
                <p>Food support is not just about meals — it is about dignity, kindness, and community action.</p>
            </div>

            <div class="info-grid">
                <div class="info-box hidden">
                    <div class="icon">💬</div>
                    <h3>Food Donor</h3>
                    <p>“This initiative gives a meaningful way to share extra food instead of wasting it. It feels responsible and human.”</p>
                </div>

                <div class="info-box hidden">
                    <div class="icon">💬</div>
                    <h3>Volunteer Member</h3>
                    <p>“Being part of food support work makes me feel like even small efforts can create real social impact.”</p>
                </div>

                <div class="info-box hidden">
                    <div class="icon">💬</div>
                    <h3>Community Voice</h3>
                    <p>“A platform like this can help reduce hunger while also making people more aware about food wastage.”</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section class="section" style="background:#f1f5f9;">
        <div class="container">
            <div class="section-head hidden">
                <span class="tag">FAQ</span>
                <h2>Frequently Asked Questions</h2>
                <p>Some common questions people may have before getting involved with ShareTheMeal.</p>
            </div>

            <div class="faq-wrap">
                <div class="faq-item hidden">
                    <h3>Who can donate food?</h3>
                    <p>Anyone with safe and usable surplus food — including households, event organizers, and food businesses — can contribute through the platform.</p>
                </div>

                <div class="faq-item hidden">
                    <h3>Can I volunteer without prior experience?</h3>
                    <p>Yes. Volunteers can support in simple ways such as helping with coordination, collection, or awareness activities.</p>
                </div>

                <div class="faq-item hidden">
                    <h3>What type of food can be donated?</h3>
                    <p>Fresh, safe, and consumable surplus food that is suitable for sharing should be donated responsibly.</p>
                </div>

                <div class="faq-item hidden">
                    <h3>Is this a real social impact initiative?</h3>
                    <p>Yes. ShareTheMeal is designed as a purpose-led food support platform focused on reducing waste and supporting people in need.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="cta">
        <div class="container">
            <h2>Join The Mission Against Hunger</h2>
            <p>Whether you want to donate food, support the effort, or connect with the initiative — your contribution can help serve meals where they are needed most.</p>
            <a href="pages/donate.php" class="btn btn-primary">Start Donating</a>
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
                <a href="index.php">Home</a>
                <a href="pages/about.php">About</a>
                <a href="pages/donate.php">Donate Food</a>
                <a href="pages/contact.php">Contact</a>
            </div>

            <div class="footer-links">
                <h4>Get Involved</h4>
                <a href="pages/volunteer.php">Join Our Mission</a>
                <a href="pages/viewfood.php">Available Meals</a>
                <a href="pages/privacy.php">Privacy Policy</a>
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
