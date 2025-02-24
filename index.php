<?php
session_start();
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JobConnect Sri Lanka - Find & Post Jobs</title>
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

    <main>
    <section class="hero">
            <h1>Find Your Dream Job in Sri Lanka</h1>
            <p>Connect with top employers and opportunities across the island</p>
            <a href="job-list.php" class="cta-btn">Find Jobs</a>
        </section>


        <section id="featured-jobs">
            <h2>Featured Job Openings</h2>
            <div class="job-grid">
                <?php
                $featured_jobs = [
                    ['title' => 'Software Engineer', 'company' => 'Tech Solutions Ltd', 'location' => 'Colombo'],
                    ['title' => 'Marketing Manager', 'company' => 'Brand Builders', 'location' => 'Kandy'],
                    ['title' => 'Accountant', 'company' => 'Finance Pro', 'location' => 'Galle'],
                    ['title' => 'Customer Service Rep', 'company' => 'ServiceMaster', 'location' => 'Negombo'],
                ];

                foreach ($featured_jobs as $job) {
                    echo "<div class='job-card'>";
                    echo "<h3>{$job['title']}</h3>";
                    echo "<p>{$job['company']}</p>";
                    echo "<p>{$job['location']}</p>";
                    echo "<a href='#' class='btn btn-apply'>Apply Now</a>";
                    echo "</div>";
                }
                ?>
            </div>
        </section>

        <section id="post-job">
            <h2>Are you an HR Manager?</h2>
            <p>Post your job openings and find the perfect candidates</p>
            <a href="post-job.php" class="btn btn-post-job">Post a Job</a>
        </section>

        <section id="testimonials">
            <h2>What Our Users Say</h2>
            <div class="testimonial-slider">
                <div class="testimonial">
                    <p>"I found my dream job through JobConnect. The process was smooth and efficient!"</p>
                    <cite>- Priya S., Software Developer</cite>
                </div>
                <div class="testimonial">
                    <p>"As an employer, I've had great success finding talented individuals on this platform."</p>
                    <cite>- Rajith M., HR Manager</cite>
                </div>
            </div>
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
