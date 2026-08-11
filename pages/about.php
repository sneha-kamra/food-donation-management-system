<!DOCTYPE html>
<html lang="en">
<head>
    <title>About Us | ShareTheMeal</title>
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
            min-height:78vh;
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
                linear-gradient(rgba(15,23,42,0.50), rgba(15,23,42,0.42)),
                url("../images/abouthero.jpg") center center / cover no-repeat;
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
            margin:0 auto;
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

        /* SPLIT */
        .split{
            display:grid;
            grid-template-columns:1.05fr 1fr;
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
            min-height:530px;
            object-fit:cover;
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
            font-size:56px;
            line-height:1.14;
            margin-bottom:18px;
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

        /* MISSION CARDS */
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
            font-size:28px;
            margin-bottom:12px;
        }

        .card p{
            color:var(--muted);
            line-height:1.9;
            font-size:15px;
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

        /* CREATOR SECTION */
        .creator-wrap{
            max-width:850px;
            margin:auto;
        }

        .creator-card{
            background:#ffffff;
            border-radius:30px;
            overflow:hidden;
            box-shadow:var(--shadow);
            transition:0.35s ease;
            display:grid;
            grid-template-columns:320px 1fr;
            align-items:center;
        }

        .creator-card:hover{
            transform:translateY(-8px);
            box-shadow:var(--shadow-hover);
        }

        .creator-card img{
            width:100%;
            height:100%;
            min-height:420px;
            object-fit:cover;
        }

        .creator-content{
            padding:40px 36px;
        }

        .creator-content h3{
            font-size:34px;
            margin-bottom:8px;
        }

        .creator-content span{
            display:inline-block;
            color:var(--primary);
            font-weight:700;
            margin-bottom:16px;
            font-size:16px;
        }

        .creator-content p{
            color:var(--muted);
            line-height:1.95;
            font-size:15px;
            margin-bottom:14px;
        }

        /* VALUES */
        .values-grid{
            display:grid;
            grid-template-columns:repeat(4,1fr);
            gap:24px;
        }

        .value-box{
            background:#ffffff;
            border-radius:24px;
            padding:28px 24px;
            box-shadow:var(--shadow);
            transition:0.35s ease;
            text-align:center;
        }

        .value-box:hover{
            transform:translateY(-6px);
            box-shadow:var(--shadow-hover);
        }

        .value-box .icon{
            font-size:34px;
            margin-bottom:14px;
        }

        .value-box h3{
            font-size:22px;
            margin-bottom:10px;
        }

        .value-box p{
            color:var(--muted);
            font-size:15px;
            line-height:1.85;
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
            .impact-grid,
            .values-grid,
            .footer-grid{
                grid-template-columns:repeat(2,1fr);
            }

            .split,
            .creator-card{
                grid-template-columns:1fr;
            }

            .page-hero h1{
                font-size:54px;
            }

            .section-head h2,
            .split-content h2,
            .cta h2{
                font-size:42px;
            }

            .creator-card img{
                min-height:360px;
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
                min-height:70vh;
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
            .split-content h2,
            .cta h2{
                font-size:34px;
            }

            .cards,
            .impact-grid,
            .values-grid,
            .footer-grid{
                grid-template-columns:1fr;
            }

            .split-image img{
                min-height:360px;
            }

            .creator-card img{
                min-height:300px;
            }

            .creator-content{
                padding:30px 22px;
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
            <a href="about.php" class="active">About</a>
            <a href="donate.php">Donate Food</a>
            <a href="viewfood.php">Available Meals</a>
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
            <div class="hero-badge">About Our Purpose-Led Food Support Initiative</div>
            <h1>Creating a bridge between surplus food and human need</h1>
            <p>ShareTheMeal is built with a simple but meaningful vision — to reduce food waste and help ensure that good food reaches people who need it with dignity, compassion, and care.</p>
        </div>
    </section>

    <!-- OUR STORY -->
    <section class="section">
        <div class="container split">
            <div class="split-image hidden">
                <img src="../images/aboutstory.jpg" alt="Our Story">
            </div>

            <div class="split-content hidden">
                <span class="tag">Our Story</span>
                <h2>A small idea with the power to create meaningful change</h2>
                <p>Every day, large amounts of usable food are wasted while many people continue to struggle with hunger. ShareTheMeal was created to respond to this gap in a practical and compassionate way.</p>
                <p>Our platform encourages individuals, families, food providers, and community supporters to take part in a simple mission — helping extra food reach the right people instead of being thrown away.</p>

                <div class="feature-list">
                    <div class="feature-item">
                        <strong>Food With Purpose</strong>
                        <span>Turning surplus meals into timely support for people and communities in need.</span>
                    </div>

                    <div class="feature-item">
                        <strong>Community-Led Action</strong>
                        <span>Encouraging people to become active participants in social support and hunger relief.</span>
                    </div>

                    <div class="feature-item">
                        <strong>Technology For Good</strong>
                        <span>Using a simple digital platform to create meaningful real-world social impact.</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- MISSION / VISION / APPROACH -->
    <section class="section" style="background:#f1f5f9;">
        <div class="container">
            <div class="section-head hidden">
                <span class="tag">What Drives Us</span>
                <h2>Built on mission, guided by compassion</h2>
                <p>Our work is centered around hunger support, responsible food sharing, and stronger community participation.</p>
            </div>

            <div class="cards">
                <div class="card hidden">
                    <div class="icon">🎯</div>
                    <h3>Our Mission</h3>
                    <p>To help reduce food wastage by connecting surplus food with people who need support through a simple, responsible, and community-driven platform.</p>
                </div>

                <div class="card hidden">
                    <div class="icon">🌍</div>
                    <h3>Our Vision</h3>
                    <p>To build a more compassionate society where good food is valued, shared responsibly, and used to support human dignity instead of being wasted.</p>
                </div>

                <div class="card hidden">
                    <div class="icon">🤝</div>
                    <h3>Our Approach</h3>
                    <p>We encourage food donors, volunteers, and support networks to work together so that available food can reach communities in a timely and meaningful way.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- WHY IT MATTERS -->
    <section class="section">
        <div class="container">
            <div class="section-head hidden">
                <span class="tag">Why It Matters</span>
                <h2>Because hunger and food waste should never exist side by side</h2>
                <p>When food is wasted while people go hungry, there is a need for thoughtful systems that bring responsibility, empathy, and action together.</p>
            </div>

            <div class="cards">
                <div class="card hidden">
                    <div class="icon">🍛</div>
                    <h3>Reducing Food Waste</h3>
                    <p>Many households, gatherings, and food outlets have usable surplus food that can still serve a meaningful purpose.</p>
                </div>

                <div class="card hidden">
                    <div class="icon">❤️</div>
                    <h3>Supporting Human Dignity</h3>
                    <p>Food support is not only about meals — it is also about care, respect, and helping people feel seen and valued.</p>
                </div>

                <div class="card hidden">
                    <div class="icon">🏘️</div>
                    <h3>Strengthening Communities</h3>
                    <p>When people participate in local support efforts, communities become more connected, responsible, and compassionate.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- IMPACT -->
    <section class="section">
        <div class="container">
            <div class="impact-wrap hidden">
                <div class="section-head">
                    <span class="tag" style="background:rgba(255,255,255,0.12); color:#fbbf24;">Our Growing Impact</span>
                    <h2>Every shared meal represents hope, care, and action</h2>
                    <p>Even small contributions can help create meaningful support for real people and real communities.</p>
                </div>

                <div class="impact-grid">
                    <div class="impact-card">
                        <h3>120+</h3>
                        <p>Meals shared through support efforts</p>
                    </div>

                    <div class="impact-card">
                        <h3>45+</h3>
                        <p>Volunteers and helpers involved</p>
                    </div>

                    <div class="impact-card">
                        <h3>30+</h3>
                        <p>Food contributors supporting the cause</p>
                    </div>

                    <div class="impact-card">
                        <h3>100%</h3>
                        <p>Purpose-driven effort focused on hunger relief</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CORE VALUES -->
    <section class="section" style="background:#f1f5f9;">
        <div class="container">
            <div class="section-head hidden">
                <span class="tag">Our Values</span>
                <h2>The principles that shape our work</h2>
                <p>Our initiative is guided by values that keep the mission human, practical, and impact-driven.</p>
            </div>

            <div class="values-grid">
                <div class="value-box hidden">
                    <div class="icon">🤍</div>
                    <h3>Compassion</h3>
                    <p>We believe food support should be rooted in empathy, dignity, and care for people.</p>
                </div>

                <div class="value-box hidden">
                    <div class="icon">🛡️</div>
                    <h3>Responsibility</h3>
                    <p>We encourage thoughtful, safe, and meaningful food contribution practices.</p>
                </div>

                <div class="value-box hidden">
                    <div class="icon">🌱</div>
                    <h3>Sustainability</h3>
                    <p>Reducing waste is an important step toward a more conscious and balanced future.</p>
                </div>

                <div class="value-box hidden">
                    <div class="icon">🤝</div>
                    <h3>Community</h3>
                    <p>Real social impact becomes stronger when people come together with shared purpose.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- PROJECT CREATOR -->
    <section class="section">
        <div class="container">
            <div class="section-head hidden">
                <span class="tag">Project Creator</span>
                <h2>Developed as a meaningful student project</h2>
                <p>This platform was conceptually designed and developed as a social impact-focused web project to address food waste and hunger support through technology.</p>
            </div>

            <div class="creator-wrap">
                <div class="creator-card hidden">
                    <img src="../images/sneha.png" alt="Sneha - Project Creator" width="200">

                    <div class="creator-content">
                        <h3>Sneha</h3>
                        <span>Concept Creator, Designer & Developer</span>
                        <p>ShareTheMeal was created as a socially meaningful web platform project with the purpose of connecting surplus food with people who need support.</p>
                        <p>This project reflects a blend of social responsibility, user-focused design, and practical web development with the aim of creating positive community impact.</p>
                        <p>Through this initiative, the focus is placed on compassion, accessibility, and the role of digital platforms in solving real-world problems.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="cta">
        <div class="container">
            <h2>Be part of a mission that turns food into hope</h2>
            <p>Whether you want to contribute food, support the mission, or take part as a volunteer, your involvement can help create meaningful change.</p>
            <a href="donate.php" class="btn btn-primary">Make a Contribution</a>
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