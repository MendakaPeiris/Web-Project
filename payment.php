<?php
session_start();
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $company = $_POST['company'];
    $plan = $_POST['plan'];
    $card_number = $_POST['card_number'];
    $expiry_date = $_POST['expiry_date'];
    $cvv = $_POST['cvv'];
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : NULL;

    $sql = "INSERT INTO monthly_payments (fullname, email, company, plan, card_number, expiry_date, cvv, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssss", $fullname, $email, $company, $plan, $card_number, $expiry_date, $cvv, $user_id);

    if ($stmt->execute()) {
        $success_message = "Payment processed successfully!";
        header ("Location: profile.php");
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
    <title>Monthly Payment - JobConnect Sri Lanka</title>
    <link rel="stylesheet" href="css/payment.css">
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

    <main class="payment-container">
        <h1><i class="fas fa-credit-card"></i> Monthly Payment</h1>
        <p>Choose a plan and process your payment to start posting jobs.</p>

        <?php
        if (isset($success_message)) {
            echo "<p class='success-message'>$success_message</p>";
        } elseif (isset($error_message)) {
            echo "<p class='error-message'>$error_message</p>";
        }
        ?>

        <form action="payment.php" method="POST" class="payment-form">
            <div class="form-group">
                <label for="fullname"><i class="fas fa-user"></i> Full Name</label>
                <input type="text" id="fullname" name="fullname" required>
            </div>
            <div class="form-group">
                <label for="email"><i class="fas fa-envelope"></i> Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="company"><i class="fas fa-building"></i> Company Name</label>
                <input type="text" id="company" name="company" required>
            </div>
            <div class="form-group">
                <label for="plan"><i class="fas fa-layer-group"></i> Select Plan</label>
                <select id="plan" name="plan" required>
                    <option value="">Choose a plan</option>
                    <option value="basic">Basic - $49/month</option>
                    <option value="pro">Pro - $99/month</option>
                    <option value="enterprise">Enterprise - $199/month</option>
                </select>
            </div>

            <div class="payment-gateway">
                <h2><i class="fas fa-lock"></i> Secure Payment</h2>
                <div class="form-group">
                    <label for="card_number"><i class="fas fa-credit-card"></i> Card Number</label>
                    <input type="text" id="card_number" name="card_number" required>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="expiry_date"><i class="fas fa-calendar-alt"></i> Expiry Date</label>
                        <input type="text" id="expiry_date" name="expiry_date" placeholder="MM/YY" required>
                    </div>
                    <div class="form-group">
                        <label for="cvv"><i class="fas fa-lock"></i> CVV</label>
                        <input type="text" id="cvv" name="cvv" required>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-submit"><i class="fas fa-check-circle"></i> Process Payment</button>
        </form>
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
