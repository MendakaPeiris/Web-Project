<?php
session_start();
require_once 'config.php';

// Fetch data from database (replace with actual queries)
$jobs = $conn->query("SELECT * FROM jobs")->fetch_all(MYSQLI_ASSOC);
$reviews = $conn->query("SELECT * FROM contact_messages")->fetch_all(MYSQLI_ASSOC);
$payments = $conn->query("SELECT * FROM monthly_payments")->fetch_all(MYSQLI_ASSOC);
$users = $conn->query("SELECT * FROM users")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile - JobConnect Sri Lanka</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="css/admin-profile.css">
</head>
<body>
    <div class="container">
        <aside class="sidebar">
            <div class="admin-welcome">
                <h2>Welcome, Admin</h2>
            </div>
            <nav>
                <ul>
                    <li><a href="#jobs" class="active"><i class="fas fa-briefcase"></i> Jobs</a></li>
                    <li><a href="#reviews"><i class="fas fa-star"></i> Reviews</a></li>
                    <li><a href="#payments"><i class="fas fa-credit-card"></i> Payments</a></li>
                    <li><a href="#users"><i class="fas fa-users"></i> Users</a></li>
                </ul>
            </nav>
            <div class="logout-container">
                <a href="logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </aside>
        <main class="content">
            <section id="jobs" class="active">
                <h2>Jobs</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Company</th>
                            <th>Job type</th>
                            <th>Location</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($jobs as $job): ?>
                        <tr>
                            <td><?php echo $job['id']; ?></td>
                            <td><?php echo $job['job_title']; ?></td>
                            <td><?php echo $job['company']; ?></td>
                            <td><?php echo $job['job_type']; ?></td>
                            <td><?php echo $job['location']; ?></td>
                            <td>
                                <button class="btn-update">Update</button>
                                <button class="btn-delete">Delete</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </section>
            <section id="reviews">
                <h2>Reviews</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reviews as $review): ?>
                        <tr>
                            <td><?php echo $review['name']; ?></td>
                            <td><?php echo $review['email']; ?></td>
                            <td><?php echo $review['subject']; ?></td>
                            <td><?php echo $review['message']; ?></td>
                            <td>
                                <button class="btn-update">Update</button>
                                <button class="btn-delete">Delete</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </section>
            <section id="payments">
                <h2>Payments</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Email</th>
                            <th>Plan</th>
                            <th>Company</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($payments as $payment): ?>
                        <tr>
                            <td><?php echo $payment['id']; ?></td>
                            <td><?php echo $payment['fullname']; ?></td>
                            <td><?php echo $payment['email']; ?></td>
                            <td><?php echo $payment['plan']; ?></td>
                            <td><?php echo $payment['company']; ?></td>
                            <td>
                                <button class="btn-update">Update</button>
                                <button class="btn-delete">Delete</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </section>
            <section id="users">
                <h2>Users</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo $user['id']; ?></td>
                            <td><?php echo $user['fullname']; ?></td>
                            <td><?php echo $user['email']; ?></td>
                            <td><?php echo $user['user_type']; ?></td>
                            <td>
                                <button class="btn-update">Update</button>
                                <button class="btn-delete">Delete</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </section>
            
        </main>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarLinks = document.querySelectorAll('.sidebar nav ul li a');
            const contentSections = document.querySelectorAll('.content section');

            sidebarLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href').substring(1);

                    sidebarLinks.forEach(link => link.classList.remove('active'));
                    this.classList.add('active');

                    contentSections.forEach(section => {
                        section.classList.remove('active');
                        if (section.id === targetId) {
                            section.classList.add('active');
                        }
                    });
                });
            });
        });

    </script>
</body>
</html>
