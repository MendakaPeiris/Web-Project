<?php
session_start();
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : NULL;

    $sql = "INSERT INTO contact_messages (name, email, subject, message, user_id) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $name, $email, $subject, $message, $user_id);

    if ($stmt->execute()) {
        $success_message = "Your message has been sent successfully!";
    } else {
        $error_message = "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - JobConnect Sri Lanka</title>
    <link rel="stylesheet" href="css/contact.css">
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

    <main class="contact-container">
        <section class="contact-details">
            <h2>Contact Us</h2>
            <p>Get in touch with us for any inquiries or support.</p>
            <div class="contact-info">
                <div class="contact-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <p>123 Main Street, Colombo 01, Sri Lanka</p>
                </div>
                <div class="contact-item">
                    <i class="fas fa-phone"></i>
                    <p>+94 11 234 5678</p>
                </div>
                <div class="contact-item">
                    <i class="fas fa-envelope"></i>
                    <p>info@jobconnect.lk</p>
                </div>
            </div>
            <div class="social-links">
                <a href="#" class="social-icon"><i class="fab fa-facebook"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-linkedin"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
            </div>
        </section>

        <section class="contact-form">
            <h2>Send Us a Message</h2>
            <?php
            if (isset($success_message)) {
                echo "<p class='success-message'>$success_message</p>";
            } elseif (isset($error_message)) {
                echo "<p class='error-message'>$error_message</p>";
            }
            ?>
            <form action="contact.php" method="POST">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="subject">Subject</label>
                    <input type="text" id="subject" name="subject" required>
                </div>
                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn-submit">Send Message</button>
            </form>
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
