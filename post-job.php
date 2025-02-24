<?php
session_start();
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $job_title = $_POST['job-title'];
    $company = $_POST['company'];
    $location = $_POST['location'];
    $job_type = $_POST['job-type'];
    $application_deadline = $_POST['application-deadline'];
    $salary = $_POST['salary'];
    $description = $_POST['description'];
    $requirements = $_POST['requirements'];
    $contact_name = $_POST['contact-name'];
    $contact_email = $_POST['contact-email'];
    $contact_phone = $_POST['contact-phone'];
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : NULL;

    $sql = "INSERT INTO jobs (job_title, company, location, job_type, application_deadline, salary, description, requirements, contact_name, contact_email, contact_phone, user_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    
    $stmt->bind_param("ssssssssssss", $job_title, $company, $location, $job_type, $application_deadline, $salary, $description, $requirements, $contact_name, $contact_email, $contact_phone, $user_id);
    
    if ($stmt->execute()) {
        echo "<script>alert('Job posted successfully!');</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }
    
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post a Job - JobConnect Sri Lanka</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="css/post-job.css">
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
        <div class="container">
            <h1>Post a Job</h1>
            
            <section class="job-posting-tips">
                <h2>Tips for a Great Job Posting</h2>
                <ul>
                    <li>Be clear and concise in your job description</li>
                    <li>Highlight key responsibilities and requirements</li>
                    <li>Include information about your company culture</li>
                    <li>Specify any unique benefits or perks</li>
                </ul>
            </section>

            <form  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <section class="additional-info">
                <h2>Job Information</h2>
                    <div class="form-container">
                        <div class="form-column">
                            <div class="form-group">
                                <label for="job-title"><i class="fas fa-briefcase"></i> Job Title</label>
                                <input type="text" id="job-title" name="job-title" required>
                            </div>
                            <div class="form-group">
                                <label for="company"><i class="fas fa-building"></i> Company Name</label>
                                <input type="text" id="company" name="company" required>
                            </div>
                            <div class="form-group">
                                <label for="location"><i class="fas fa-map-marker-alt"></i> Location</label>
                                <input type="text" id="location" name="location" required>
                            </div>
                            <div class="form-group">
                                <label for="job-type"><i class="fas fa-user-clock"></i> Job Type</label>
                                <select id="job-type" name="job-type" required>
                                    <option value="">Select Job Type</option>
                                    <option value="full-time">Full Time</option>
                                    <option value="part-time">Part Time</option>
                                    <option value="contract">Contract</option>
                                    <option value="internship">Internship</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="application-deadline"><i class="fas fa-calendar-alt"></i> Application Deadline</label>
                                <input type="date" id="application-deadline" name="application-deadline" required>
                            </div>
                        </div>
                        <div class="form-column">
                            <div class="form-group">
                                <label for="salary"><i class="fas fa-money-bill-wave"></i> Salary Range</label>
                                <input type="text" id="salary" name="salary" placeholder="e.g., LKR 50,000 - 80,000 per month">
                            </div>
                            <div class="form-group">
                                <label for="description"><i class="fas fa-align-left"></i> Job Description</label>
                                <textarea id="description" name="description" rows="6" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="requirements"><i class="fas fa-list-ul"></i> Requirements</label>
                                <textarea id="requirements" name="requirements" rows="4" required></textarea>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="contact-info">
                    <h2>Contact Information</h2>
                    <div class="form-group">
                        <label for="contact-name"><i class="fas fa-user"></i> Contact Person</label>
                        <input type="text" id="contact-name" name="contact-name" required>
                    </div>
                    <div class="form-group">
                        <label for="contact-email"><i class="fas fa-envelope"></i> Contact Email</label>
                        <input type="email" id="contact-email" name="contact-email" required>
                    </div>
                    <div class="form-group">
                        <label for="contact-phone"><i class="fas fa-phone"></i> Contact Phone</label>
                        <input type="tel" id="contact-phone" name="contact-phone">
                    </div>
                </section>

                <section class="job-posting-preview">
                    <h2>Job Posting Preview</h2>
                    <p>As you fill out the form, a preview of your job posting will appear here.</p>
                    <div id="job-preview"></div>
                </section>
                <button type="submit" class="btn-post-job">Post Job</button>
            </form>
        </div>
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

    <script src="js/post-job-preview.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const jobPreview = document.getElementById('job-preview');

            // Function to update the preview
            function updatePreview() {
                const jobTitle = document.getElementById('job-title').value;
                const company = document.getElementById('company').value;
                const location = document.getElementById('location').value;
                const jobType = document.getElementById('job-type').value;
                const salary = document.getElementById('salary').value;
                const description = document.getElementById('description').value;
                const requirements = document.getElementById('requirements').value;

                jobPreview.innerHTML = `
                    <h3>${jobTitle}</h3>
                    <p><strong>Company:</strong> ${company}</p>
                    <p><strong>Location:</strong> ${location}</p>
                    <p><strong>Job Type:</strong> ${jobType}</p>
                    <p><strong>Salary Range:</strong> ${salary}</p>
                    <h4>Job Description:</h4>
                    <p>${description}</p>
                    <h4>Requirements:</h4>
                    <p>${requirements}</p>
                `;
            }

            // Add event listeners to form inputs
            const formInputs = form.querySelectorAll('input, textarea, select');
            formInputs.forEach(input => {
                input.addEventListener('input', updatePreview);
            });

            // Initial preview update
            updatePreview();
        });

    </script>
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
