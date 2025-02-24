<?php
session_start();
require_once 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Function to get job details from database
function getJobDetails($conn, $user_id) {
    $sql = "SELECT * FROM jobs WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Function to delete job
if (isset($_POST['delete_job'])) {
    $job_id = $_POST['job_id'];
    $sql = "DELETE FROM jobs WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $job_id, $user_id);
    $stmt->execute();
    header("Location: job-details.php");
    exit();
}

// Function to update job
if (isset($_POST['update_job'])) {
    $job_id = $_POST['job_id'];
    $job_title = $_POST['job_title'];
    $company = $_POST['company'];
    $location = $_POST['location'];
    $job_type = $_POST['job_type'];
    $application_deadline = $_POST['application_deadline'];
    $salary = $_POST['salary'];
    $description = $_POST['description'];
    $requirements = $_POST['requirements'];
    $contact_name = $_POST['contact_name'];
    $contact_email = $_POST['contact_email'];
    $contact_phone = $_POST['contact_phone'];

    $sql = "UPDATE jobs SET job_title = ?, company = ?, location = ?, job_type = ?, application_deadline = ?, salary = ?, description = ?, requirements = ?, contact_name = ?, contact_email = ?, contact_phone = ? WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssssii", $job_title, $company, $location, $job_type, $application_deadline, $salary, $description, $requirements, $contact_name, $contact_email, $contact_phone, $job_id, $user_id);
    $stmt->execute();
    header("Location: job-details.php");
    exit();
}

// Get job details
$jobs = getJobDetails($conn, $user_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Details</title>
    <link rel="stylesheet" href="css/job-details.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container">
        <h1>Job Details</h1>
        <a href="profile.php" class="back-button">Back to Profile</a>
        <table>
            <thead>
                <tr>
                    <th>Job Title</th>
                    <th>Company</th>
                    <th>Location</th>
                    <th>Job Type</th>
                    <th>Application Deadline</th>
                    <th>Salary</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($jobs as $job): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($job['job_title']); ?></td>
                        <td><?php echo htmlspecialchars($job['company']); ?></td>
                        <td><?php echo htmlspecialchars($job['location']); ?></td>
                        <td><?php echo htmlspecialchars($job['job_type']); ?></td>
                        <td><?php echo htmlspecialchars($job['application_deadline']); ?></td>
                        <td><?php echo htmlspecialchars($job['salary']); ?></td>
                        <td>
                            <button class="edit-button" data-job-id="<?php echo $job['id']; ?>">Edit</button>
                            <form method="post" style="display: inline;">
                                <input type="hidden" name="job_id" value="<?php echo $job['id']; ?>">
                                <button type="submit" name="delete_job" class="delete-button" onclick="return confirm('Are you sure you want to delete this job?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
      <div id="edit-popup" class="popup">
          <div class="popup-content">
              <h2>Edit Job</h2>
              <form id="edit-job-form" method="post">
                  <input type="hidden" name="job_id" id="job_id">
                  <div class="form-row">
                      <div class="form-column">
                          <label for="job_title">Job Title:</label>
                          <input type="text" name="job_title" id="job_title" required>

                          <label for="company">Company:</label>
                          <input type="text" name="company" id="company" required>

                          <label for="location">Location:</label>
                          <input type="text" name="location" id="location" required>

                          <label for="job_type">Job Type:</label>
                          <input type="text" name="job_type" id="job_type" required>

                          <label for="application_deadline">Application Deadline:</label>
                          <input type="date" name="application_deadline" id="application_deadline" required>

                          <label for="salary">Salary:</label>
                          <input type="text" name="salary" id="salary" required>
                      </div>
                      <div class="form-column">
                          <label for="description">Description:</label>
                          <textarea name="description" id="description" required></textarea>

                          <label for="requirements">Requirements:</label>
                          <textarea name="requirements" id="requirements" required></textarea>

                          <label for="contact_name">Contact Name:</label>
                          <input type="text" name="contact_name" id="contact_name" required>

                          <label for="contact_email">Contact Email:</label>
                          <input type="email" name="contact_email" id="contact_email" required>

                          <label for="contact_phone">Contact Phone:</label>
                          <input type="tel" name="contact_phone" id="contact_phone" required>
                      </div>
                  </div>
                  <div class="button-group">
                      <button type="submit" name="update_job">Save</button>
                      <button type="button" id="cancel-edit">Cancel</button>
                  </div>
              </form>
          </div>
      </div>

      <script>
          $(document).ready(function() {
              $('.edit-button').click(function() {
                  var jobId = $(this).data('job-id');
                  $.ajax({
                      url: 'get_job_details.php',
                      method: 'GET',
                      data: { job_id: jobId },
                      dataType: 'json',
                      success: function(response) {
                          $('#job_id').val(response.id);
                          $('#job_title').val(response.job_title);
                          $('#company').val(response.company);
                          $('#location').val(response.location);
                          $('#job_type').val(response.job_type);
                          $('#application_deadline').val(response.application_deadline);
                          $('#salary').val(response.salary);
                          $('#description').val(response.description);
                          $('#requirements').val(response.requirements);
                          $('#contact_name').val(response.contact_name);
                          $('#contact_email').val(response.contact_email);
                          $('#contact_phone').val(response.contact_phone);
                          $('#edit-popup').show();
                      }
                  });
              });

              $('#cancel-edit').click(function() {
                  $('#edit-popup').hide();
              });

              // Close popup when clicking outside
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
</html>
