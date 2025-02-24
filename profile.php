<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - Recruitment Company System</title>
    <link rel="stylesheet" href="css/profile.css">
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

    <div class="container">
        <h1>User Profile</h1>
        <div class="profile-options">
            <a href="user-details.php" class="card">
                <h2>User Details</h2>
                <p>View and edit your personal information</p>
            </a>
            <a href="job-details.php" class="card">
                <h2>Job Details</h2>
                <p>Explore job listings and opportunities</p>
            </a>
            <a href="job-apply-details.php" class="card">
                <h2>Application Details</h2>
                <p>Track your job applications</p>
            </a>
            <a href="contact_messages.php" class="card">
                <h2>Review Details</h2>
                <p>See feedback and reviews</p>
            </a>
            <a href="payment-details.php" class="card">
                <h2>Payment Details</h2>
                <p>Manage your payment information</p>
            </a>
            <a href="payment.php" class="card">
                <h2>+ Pay Monthly Payment</h2>
                <p>Pay your monthly payment in here</p>
            </a>
        </div>
    </div>

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
