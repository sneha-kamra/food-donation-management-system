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
    $inquiry_type = trim($_POST['inquiry_type']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);
    $rating = trim($_POST['rating']);
    $hear_about = trim($_POST['hear_about']);
    $consent = isset($_POST['consent']) ? 1 : 0;

    // Insert into contact_feedback table
    $stmt = $conn->prepare("INSERT INTO contact_feedback (fullname, email, phone, inquiry_type, subject, message, rating, hear_about, consent) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("ssssssssi", $fullname, $email, $phone, $inquiry_type, $subject, $message, $rating, $hear_about, $consent);
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
    <title>Contact Us | ShareTheMeal</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

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
            min-height:50vh;
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
                url("../images/contactbg.jpg?v=3") center center / cover no-repeat;
            transform:scale(1.01);
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

        /* FORM SECTION */
        .section{
            padding:100px 20px;
        }

        .container{
            width:min(1180px, 92%);
            margin:auto;
        }

        .form-wrap{
            display:grid;
            grid-template-columns:1fr 1.2fr;
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

       .contact-info{
            margin-top:30px;
            display:flex;
            flex-wrap:wrap;
            gap:15px 20px;
            align-items:center;
        }

        .contact-link{
            display:flex;
            align-items:center;
            gap:8px;
            color:inherit;
            font-weight:500;
            font-size:16px;
            transition: all 0.3s ease;
        }

        .contact-link i{
            font-size:20px;
            color: var(--accent);
        }

        .contact-link:hover{
            color: var(--accent);
            transform: scale(1.05);
        }

        .contact-info .full-width{
            width:100%;
        }

        .social-icons{
            display:flex;
            gap:18px;
            align-items:center;
        }

        .social-icons a{
            color:inherit;
            font-size:20px;
            transition:0.3s ease;
        }

        .social-icons a:hover{
            color:var(--accent);
            transform:scale(1.15);
        }

        .map-container{
            margin-top:25px;
            border-radius:20px;
            overflow:hidden;
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

        /* STAR RATING */
        .star-rating{
            display:flex;
            flex-direction:row-reverse;
            justify-content:flex-end;
            font-size:28px;
            gap:6px;
        }

        .star-rating input{
            display:none;
        }

        .star-rating label{
            color:#d1d5db;
            cursor:pointer;
            transition:0.3s;
        }

        .star-rating input:checked ~ label,
        .star-rating label:hover,
        .star-rating label:hover ~ label{
            color:#fbbf24;
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
            .form-wrap{
                grid-template-columns:1fr;
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
                min-height:45vh;
            }

            .hero h1{
                font-size:38px;
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
            <a href="donate.php">Donate Food</a>
            <a href="viewfood.php">Available Meals</a>
            <a href="request-help.php">Request Help</a>
            <a href="volunteer.php">Join Us</a>
            <a href="contact.php" class="active">Contact</a>
        </div>
    </div>

    <!-- HERO -->
    <section class="hero">
        <div class="hero-bg"></div>
        <div class="hero-content">
            <div class="hero-badge">Connect with us, share feedback, and make impact</div>
            <h1>Contact Us</h1>
            <p>We are here to help, listen, and collaborate. Reach out to us via form or our office contacts.</p>
        </div>
    </section>

    <!-- INTRO SECTION -->
    <section style="padding:80px 20px 40px; background:#f8fafc; text-align:center;">
        <div class="container" style="max-width:980px; margin:auto;">
            <span style="display:inline-block; background:#d1fae5; color:#0f766e; padding:12px 24px; border-radius:999px; font-size:15px; font-weight:700; margin-bottom:28px;">
                Why Contact Us
            </span>

            <h2 style="font-size:52px; line-height:1.15; font-weight:800; color:#0b132b; margin:25px 0 25px;">
                Your feedback is more than a message — it helps us serve better
            </h2>

            <p style="font-size:18px; line-height:1.9; color:#64748b; max-width:900px; margin:0 auto;">
                At ShareTheMeal, every message matters. Whether you want to ask a question, share feedback, raise a concern, or connect with our team, we are here to listen with care.
                Your voice helps us improve our work, strengthen community trust, and reach more people with compassion and dignity.
            </p>
        </div>
    </section>

    <!-- FORM SECTION -->
    <section class="section">
        <div class="container form-wrap">
            <!-- LEFT PANEL: Get in Touch -->
            <div class="form-side hidden">
                <h2>Get in Touch</h2>

                <div class="contact-info">
                    <div class="contact-link full-width">
                        <i class="fas fa-map-marker-alt"></i> 123 NGO Street, Sector 17, Chandigarh, India
                    </div>

                    <a href="tel:+9162807-42680" class="contact-link">
                        <i class="fas fa-phone"></i> +91 62807-42680
                    </a>

                    <a href="mailto:info@sharethemeal.org" class="contact-link">
                        <i class="fas fa-envelope"></i> info@sharethemeal.org
                    </a>

                    <div class="social-icons full-width">
                        <a href="https://www.facebook.com/YourPage" target="_blank">
                            <i class="fab fa-facebook-f"></i>
                        </a>

                        <a href="https://www.instagram.com/YourProfile" target="_blank">
                            <i class="fab fa-instagram"></i>
                        </a>

                        <a href="https://www.linkedin.com/in/YourProfile" target="_blank">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>

                <div class="map-container">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3502.123456789!2d76.7794!3d30.7333!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390fed123456789%3A0x123456789abcdef!2sChandigarh%2C%20India!5e0!3m2!1sen!2sus!4v1600000000000" width="100%" height="220" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>

            <!-- RIGHT PANEL: Form -->
            <div class="form-card hidden">
                <h3>Contact / Feedback Form</h3>
                <p>Fill in the form below and we will get back to you promptly.</p>

                <?php if($success): ?>
                    <div class="success-message">
                        ✅ Thank you! Your message has been received successfully.
                    </div>
                <?php endif; ?>

                <?php if(!empty($error)): ?>
                    <div class="error-message">
                        ❌ <?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="">
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
                            <input type="tel" name="phone" placeholder="Enter your phone number">
                        </div>

                        <div class="form-group">
                            <label>Type of Inquiry</label>
                            <select name="inquiry_type" required>
                                <option value="">Select inquiry type</option>
                                <option value="General">General</option>
                                <option value="Volunteer">Volunteer</option>
                                <option value="Donation">Donation</option>
                                <option value="Complaint">Complaint</option>
                                <option value="Feedback">Feedback</option>
                            </select>
                        </div>

                        <div class="form-group full">
                            <label>Subject</label>
                            <input type="text" name="subject" placeholder="Enter subject" required>
                        </div>

                        <div class="form-group full">
                            <label>Message</label>
                            <textarea name="message" placeholder="Write your message here..." required></textarea>
                        </div>

                        <div class="form-group full">
                            <label>Rating</label>
                            <div class="star-rating">
                                <input type="radio" name="rating" id="star5" value="5"><label for="star5">&#9733;</label>
                                <input type="radio" name="rating" id="star4" value="4"><label for="star4">&#9733;</label>
                                <input type="radio" name="rating" id="star3" value="3"><label for="star3">&#9733;</label>
                                <input type="radio" name="rating" id="star2" value="2"><label for="star2">&#9733;</label>
                                <input type="radio" name="rating" id="star1" value="1"><label for="star1">&#9733;</label>
                            </div>
                        </div>

                        <div class="form-group full">
                            <label>How did you hear about us? (Optional)</label>
                            <input type="text" name="hear_about" placeholder="e.g., Social Media, Friend, Website">
                        </div>

                        <div class="form-group full">
                            <label>
                                <input type="checkbox" name="consent" required> I consent to have my data stored and used for NGO purposes.
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="submit-btn">Submit</button>
                </form>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer>
        <div class="footer-grid">
            <div class="footer-brand">
                <h3>ShareTheMeal</h3>
                <p>Making a difference in the lives of those in need. Join us to fight hunger and create impact.</p>
            </div>

            <div class="footer-links">
                <h4>Quick Links</h4>
                <a href="../index.php">Home</a>
                <a href="about.php">About</a>
                <a href="donate.php">Donate Food</a>
                <a href="request-help.php">Request Help</a>
                <a href="volunteer.php">Join Us</a>
                <a href="contact.php">Contact</a>
            </div>

            <div class="footer-links">
                <h4>Connect</h4>
                <a href="https://facebook.com" target="_blank">Facebook</a>
                <a href="https://instagram.com" target="_blank">Instagram</a>
                <a href="https://linkedin.com" target="_blank">LinkedIn</a>
            </div>

            <div class="footer-links">
                <h4>Contact</h4>
                <a href="https://www.google.com/maps/search/?api=1&query=123+NGO+Street+Sector+17+Chandigarh+India" target="_blank">
                    <i class="fas fa-map-marker-alt"></i> 123 NGO Street, Sector 17, Chandigarh, India
                </a>
                <a href="tel:+9162807-42680">
                    <i class="fas fa-phone"></i> +91 62807-42680
                </a>
                <a href="mailto:info@sharethemeal.org">
                    <i class="fas fa-envelope"></i> info@sharethemeal.org
                </a>
            </div>
        </div>

        <div class="footer-bottom">
            &copy; <?php echo date("Y"); ?> ShareTheMeal. All rights reserved.
        </div>
    </footer>

    <script>
        window.addEventListener("scroll", function(){
            document.getElementById("navbar").classList.toggle("scrolled", window.scrollY>20);
        });

        // Scroll animations
        const hiddenElements = document.querySelectorAll('.hidden');
        const observer = new IntersectionObserver((entries)=>{
            entries.forEach(entry=>{
                if(entry.isIntersecting){
                    entry.target.classList.add('show');
                    observer.unobserve(entry.target);
                }
            });
        },{
            threshold:0.2
        });

        hiddenElements.forEach(el=>observer.observe(el));
    </script>

</body>
</html>