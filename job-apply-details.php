<?php
session_start();
require_once 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Function to get job application details from database
function getJobApplicationDetails($conn, $user_id) {
    $sql = "SELECT * FROM job_applications WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Function to delete job application
if (isset($_POST['delete_application'])) {
    $application_id = $_POST['application_id'];
    $sql = "DELETE FROM job_applications WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $application_id, $user_id);
    $stmt->execute();
    header("Location: job-apply-details.php");
    exit();
}

// Function to update job application
if (isset($_POST['update_application'])) {
    $application_id = $_POST['application_id'];
    $job_title = $_POST['job_title'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];

    $sql = "UPDATE job_applications SET job_title = ?, name = ?, email = ?, contact = ? WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssii", $job_title, $name, $email, $contact, $application_id, $user_id);
    $stmt->execute();
    header("Location: job-apply-details.php");
    exit();
}

// Get job application details
$applications = getJobApplicationDetails($conn, $user_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Application Details</title>
    <link rel="stylesheet" href="css/job-apply-details.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container">
        <h1>Job Application Details</h1>
        <a href="profile.php" class="back-button">Back to Profile</a>
        <table>
            <thead>
                <tr>
                    <th>Job Title</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Contact</th>
                    <th>CV File</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($applications as $application): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($application['job_title']); ?></td>
                        <td><?php echo htmlspecialchars($application['name']); ?></td>
                        <td><?php echo htmlspecialchars($application['email']); ?></td>
                        <td><?php echo htmlspecialchars($application['contact']); ?></td>
                        <td><a href="uploads/<?php echo htmlspecialchars($application['cv_file']); ?>" target="_blank">View CV</a></td>
                        <td>
                            <button class="edit-button" data-id="<?php echo $application['id']; ?>">Edit</button>
                            <form method="post" style="display: inline;">
                                <input type="hidden" name="application_id" value="<?php echo $application['id']; ?>">
                                <button type="submit" name="delete_application" class="delete-button" onclick="return confirm('Are you sure you want to delete this application?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div id="edit-popup" class="popup">
        <div class="popup-content">
            <h2>Edit Job Application</h2>
            <form id="edit-application-form" method="post">
                <input type="hidden" name="application_id" id="application_id">
                <label for="job_title">Job Title:</label>
                <input type="text" name="job_title" id="job_title" required>
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" required>
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required>
                <label for="contact">Contact:</label>
                <input type="tel" name="contact" id="contact" required>
                <div class="button-group">
                    <button type="submit" name="update_application">Save</button>
                    <button type="button" id="cancel-edit">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.edit-button').click(function() {
                var applicationId = $(this).data('id');
                var row = $(this).closest('tr');
                var jobTitle = row.find('td:eq(0)').text();
                var name = row.find('td:eq(1)').text();
                var email = row.find('td:eq(2)').text();
                var contact = row.find('td:eq(3)').text();

                $('#application_id').val(applicationId);
                $('#job_title').val(jobTitle);
                $('#name').val(name);
                $('#email').val(email);
                $('#contact').val(contact);
                $('#edit-popup').show();
            });

            $('#cancel-edit').click(function() {
                $('#edit-popup').hide();
            });

            $(document).mouseup(function(e) {
                var container = $(".popup-content");
                if (!container.is(e.target) && container.has(e.target).length === 0) {
                    $('#edit-popup').hide();
                }
            });
        });
    </script>
</body>
</html>
