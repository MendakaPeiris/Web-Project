<?php
session_start();
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - JobConnect Sri Lanka</title>
    <link rel="stylesheet" href="css/about.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/dropdown.css">
    <script src="https://kit.fontawesome.com/20f08145b4.js" crossorigin="anonymous"></script>
</head>
<body>
    <header>
        <nav>
            <div class="logo">JobConnect</div>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="job-list.php">Find Jobs</a></li>
                <li><a href="post-job.php">Post a Job</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
            <div class="auth-buttons">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <div class="user-dropdown">
                        <a href="#" class="dropdown-toggle"><?php echo $_SESSION['fullname']; ?></a>
                        <ul class="dropdown-menu">
                            <li><a href="profile.php">Profile</a></li>
                            <li><a href="logout.php">Logout</a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <a href="login.php" class="btn btn-login">Login</a>
                    <a href="register.php" class="btn btn-register">Register</a>
                <?php endif; ?>
            </div>
        </nav>
    </header>

    <main class="about-container">
        <section class="hero">
            <h1>About JobConnect Sri Lanka</h1>
            <p>Connecting talent with opportunities across the island</p>
        </section>

        <section class="our-mission">
            <h2>Our Mission</h2>
            <p>At JobConnect, we strive to bridge the gap between job seekers and employers in Sri Lanka, fostering economic growth and professional development across the nation.</p>
        </section>

        <section class="our-story">
            <h2>Our Story</h2>
            <p>Founded in 2024, JobConnect has quickly become Sri Lanka's leading job portal, serving thousands of job seekers and employers nationwide.</p>
        </section>

        <section class="team">
            <h2>Meet Our Team</h2>
            <div class="team-members">
                <div class="team-member">
                    <h3>Mendaka Peiris</h3>
                    <p>Founder & CEO</p>
                </div>
                <div class="team-member">
                    <h3>Nimal</h3>
                    <p>Head of Operations</p>
                </div>
                <div class="team-member">
                    <h3>Amal</h3>
                    <p>Lead Developer</p>
                </div>
            </div>
        </section>

        <section class="why-choose-us">
            <h2>Why Choose JobConnect?</h2>
            <ul>
                <li><i class="fas fa-check"></i> Largest job database in Sri Lanka</li>
                <li><i class="fas fa-check"></i> User-friendly platform</li>
                <li><i class="fas fa-check"></i> Personalized job recommendations</li>
                <li><i class="fas fa-check"></i> Dedicated customer support</li>
            </ul>
        </section>
    </main>

    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="job-list.php">Find Jobs</a></li>
                    <li><a href="post-job.php">Post a Job</a></li>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="contact.php">Contact</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Connect With Us</h3>
                <div class="social-icons">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin"></i></a>
                    <a href="#"><i class="fab fa-tiktok"></i></a>
                </div>
            </div>
            <div class="footer-section">
                <h3>Newsletter</h3>
                <form class="newsletter-form">
                    <input type="email" placeholder="Enter your email">
                    <button type="submit" class="btn btn-subscribe">Subscribe</button>
                </form>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© 2024 JobConnect Sri Lanka. All rights reserved.</p>
        </div>
    </footer>

    <script src="js/dropdown.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dropdownToggle = document.querySelector('.dropdown-toggle');
            const dropdownMenu = document.querySelector('.dropdown-menu');

            if (dropdownToggle && dropdownMenu) {
                dropdownToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    dropdownMenu.classList.toggle('show');
                });

                document.addEventListener('click', function(e) {
                    if (!dropdownToggle.contains(e.target) && !dropdownMenu.contains(e.target)) {
                        dropdownMenu.classList.remove('show');
                    }
                });
            }
        });

    </script>
</body>
</html>
