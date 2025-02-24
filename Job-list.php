<?php
session_start();
require_once 'config.php';

// Initialize filter variables
$job_type_filter = isset($_GET['job_type']) ? $_GET['job_type'] : '';
$location_filter = isset($_GET['location']) ? $_GET['location'] : '';
$salary_filter = isset($_GET['salary']) ? $_GET['salary'] : '';
$search_query = isset($_GET['search']) ? $_GET['search'] : '';

// Build the SQL query with filters
$sql = "SELECT * FROM jobs WHERE 1=1";
if (!empty($job_type_filter)) {
    $sql .= " AND job_type = '$job_type_filter'";
}
if (!empty($location_filter)) {
    $sql .= " AND location LIKE '%$location_filter%'";
}
if (!empty($salary_filter)) {
    $sql .= " AND salary >= '$salary_filter'";
}
if (!empty($search_query)) {
    $sql .= " AND (job_title LIKE '%$search_query%' OR company LIKE '%$search_query%' OR description LIKE '%$search_query%')";
}
$sql .= " ORDER BY id DESC";

$result = $conn->query($sql);

// Fetch unique job types and locations for filter options
$job_types = $conn->query("SELECT DISTINCT job_type FROM jobs")->fetch_all(MYSQLI_ASSOC);
$locations = $conn->query("SELECT DISTINCT location FROM jobs")->fetch_all(MYSQLI_ASSOC);

// Handle form submission
$success_message = '';


if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['form_submitted'])) {
    $_POST['form_submitted'] = true;
    $job_id = $_POST['job_id'];
    $job_title = $_POST['job_title'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : NULL;

    // Handle file upload
    $cv_file = $_FILES['cv_file'];
    $cv_filename = $cv_file['name'];
    $cv_tmp_name = $cv_file['tmp_name'];
    $upload_dir = "uploads/";
    $cv_destination = $upload_dir . $cv_filename;
    
    move_uploaded_file($cv_tmp_name, $cv_destination);
    
    // Insert application into database
    $sql = "INSERT INTO job_applications (job_id, job_title, name, email, contact, cv_file, user_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssss", $job_id, $job_title, $name, $email, $contact, $cv_filename, $user_id);
    $stmt->execute();
    
    if ($stmt->execute()) {
        $success_message = "Your application has been successfully submitted!";
    }
    $stmt->close();

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Listings - JobConnect Sri Lanka</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="css/job-list.css">
    <link rel="stylesheet" href="css/job-list-filters.css">
    <link rel="stylesheet" href="css/job-list-popup.css">
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
            <h1>Job Listings</h1>
            <div id="success-message" class="success-message" style="display: none;"></div>
            <form class="job-filters" action="" method="GET">
                <select name="job_type">
                    <option value="">All Job Types</option>
                    <?php foreach ($job_types as $type): ?>
                        <option value="<?php echo $type['job_type']; ?>" <?php echo ($job_type_filter == $type['job_type']) ? 'selected' : ''; ?>><?php echo $type['job_type']; ?></option>
                    <?php endforeach; ?>
                </select>
                
                <select name="location">
                    <option value="">All Locations</option>
                    <?php foreach ($locations as $loc): ?>
                        <option value="<?php echo $loc['location']; ?>" <?php echo ($location_filter == $loc['location']) ? 'selected' : ''; ?>><?php echo $loc['location']; ?></option>
                    <?php endforeach; ?>
                </select>
                
                <input type="number" name="salary" placeholder="Minimum Salary" value="<?php echo $salary_filter; ?>">
                
                <input type="text" name="search" placeholder="Search jobs..." value="<?php echo $search_query; ?>">
                
                <button type="submit">Filter</button>
            </form>

            <div class="job-grid">
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        ?>
                        <div class="job-card">
                            <h2><?php echo htmlspecialchars($row['job_title']); ?></h2>
                            <p class="company"><i class="fas fa-building"></i> <?php echo htmlspecialchars($row['company']); ?></p>
                            <p class="location"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($row['location']); ?></p>
                            <p class="job-type"><i class="fas fa-user-clock"></i> <?php echo htmlspecialchars($row['job_type']); ?></p>
                            <p class="salary"><i class="fas fa-money-bill-wave"></i> <?php echo htmlspecialchars($row['salary']); ?></p>
                            <p class="description"><?php echo substr(htmlspecialchars($row['description']), 0, 100) . '...'; ?></p>
                            <button class="btn-apply" data-job-id="<?php echo $row['id']; ?>" data-job-title="<?php echo htmlspecialchars($row['job_title']); ?>">Apply Now</button>
                        </div>
                        <?php
                    }
                } else {
                    echo "<p>No jobs found.</p>";
                }
                ?>
            </div>
        </div>
    </main>

    <div id="application-popup" class="popup">
        <div class="popup-content">
            <span class="close">×</span>
            <h2>Apply for <span id="popup-job-title"></span></h2>
            <form id="job-application-form" method="POST" enctype="multipart/form-data">
                <input type="hidden" id="job_id" name="job_id">
                <input type="hidden" id="job_title" name="job_title">
                <input type="text" name="name" placeholder="Full Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="tel" name="contact" placeholder="Contact Number" required>
                <input type="file" name="cv_file" accept=".pdf,.doc,.docx" required>
                <button type="submit">Submit Application</button>
            </form>
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
            const popup = document.getElementById('application-popup');
            const closeBtn = document.querySelector('.close');
            const applyButtons = document.querySelectorAll('.btn-apply');
            const jobTitleSpan = document.getElementById('popup-job-title');
            const jobIdInput = document.getElementById('job_id');
            const jobTitleInput = document.getElementById('job_title');

            applyButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const jobId = this.getAttribute('data-job-id');
                    const jobTitle = this.getAttribute('data-job-title');
                    jobTitleSpan.textContent = jobTitle;
                    jobIdInput.value = jobId;
                    jobTitleInput.value = jobTitle;
                    popup.style.display = 'block';
                });
            });

            closeBtn.addEventListener('click', function() {
                popup.style.display = 'none';
            });

            window.addEventListener('click', function(event) {
                if (event.target == popup) {
                    popup.style.display = 'none';
                }
            });
            
        });
        document.addEventListener('DOMContentLoaded', function() {
            const popup = document.getElementById('application-popup');
            const closeBtn = document.querySelector('.close');
            const applyButtons = document.querySelectorAll('.btn-apply');
            const jobTitleSpan = document.getElementById('popup-job-title');
            const jobIdInput = document.getElementById('job_id');
            const jobTitleInput = document.getElementById('job_title');
            const form = document.getElementById('job-application-form');
            const successMessage = document.getElementById('success-message');

            applyButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const jobId = this.getAttribute('data-job-id');
                    const jobTitle = this.getAttribute('data-job-title');
                    jobTitleSpan.textContent = jobTitle;
                    jobIdInput.value = jobId;
                    jobTitleInput.value = jobTitle;
                    popup.style.display = 'block';
                });
            });

            closeBtn.addEventListener('click', closePopup);

            window.addEventListener('click', function(event) {
                if (event.target == popup) {
                    closePopup();
                }
            });

            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                fetch(form.action, {
                    method: 'POST',
                    body: new FormData(form)
                })
                .then(response => response.text())
                .then(data => {
                    if (data.includes("Your application has been successfully submitted!")) {
                        successMessage.textContent = "Your application has been successfully submitted!";
                        successMessage.style.display = 'block';
                        form.reset();
                        setTimeout(closePopup, 1000);
                    }
                });
            });

            function closePopup() {
                popup.style.display = 'none';
                successMessage.style.display = 'none';
            }
        });

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
