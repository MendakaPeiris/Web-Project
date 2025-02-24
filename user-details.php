<?php
session_start();
require_once 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user details from database
$stmt = $conn->prepare("SELECT id, fullname, email, password, user_type, phone, company, location FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Handle form submission for updating user details
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $company = $_POST['company'];
    $location = $_POST['location'];

    $update_stmt = $conn->prepare("UPDATE users SET fullname = ?, email = ?, phone = ?, company = ?, location = ? WHERE id = ?");
    $update_stmt->bind_param("sssssi", $fullname, $email, $phone, $company, $location, $user_id);
    
    if ($update_stmt->execute()) {
        $success_message = "Profile updated successfully!";
        // Refresh user data
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
    } else {
        $error_message = "Error updating profile. Please try again.";
    }
}

// Handle user deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $delete_stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $delete_stmt->bind_param("i", $user_id);
    
    if ($delete_stmt->execute()) {
        session_destroy();
        header("Location: login.php");
        exit();
    } else {
        $error_message = "Error deleting profile. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - Recruitment Company System</title>
    <link rel="stylesheet" href="css/user-details.css">
</head>
<body>
    <div class="container">
        <header>
            <a href="profile.php" class="back-button">Back</a>
            <div class="action-buttons">
                <button id="editButton" class="edit-button">Edit</button>
                <form method="POST" style="display: inline;">
                    <button type="submit" name="delete" class="delete-button" onclick="return confirm('Are you sure you want to delete your profile? This action cannot be undone.')">Delete</button>
                </form>
            </div>
        </header>
        <main>
            <h1>User Profile</h1>
            <?php if (isset($success_message)): ?>
                <div class="success-message"><?php echo $success_message; ?></div>
            <?php endif; ?>
            <?php if (isset($error_message)): ?>
                <div class="error-message"><?php echo $error_message; ?></div>
            <?php endif; ?>
            <form id="userForm" method="POST" class="user-details">
                <div class="detail-item">
                    <label for="fullname" class="label">Full Name:</label>
                    <input type="text" id="fullname" name="fullname" value="<?php echo htmlspecialchars($user['fullname']); ?>" readonly>
                </div>
                <div class="detail-item">
                    <label for="email" class="label">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" readonly>
                </div>
                <div class="detail-item">
                    <label for="phone" class="label">Phone:</label>
                    <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" readonly>
                </div>
                <div class="detail-item">
                    <label for="company" class="label">Company:</label>
                    <input type="text" id="company" name="company" value="<?php echo htmlspecialchars($user['company']); ?>" readonly>
                </div>
                <div class="detail-item">
                    <label for="location" class="label">Location:</label>
                    <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($user['location']); ?>" readonly>
                </div>
                <div class="detail-item">
                    <label for="user_type" class="label">User Type:</label>
                    <input type="text" id="user_type" name="user_type" value="<?php echo htmlspecialchars($user['user_type']); ?>" readonly>
                </div>
                <div class="form-actions" style="display: none;">
                    <button type="submit" name="update" class="save-button">Save</button>
                    <button type="button" id="cancelButton" class="cancel-button">Cancel</button>
                </div>
            </form>
        </main>
    </div>
    <script>
        const editButton = document.getElementById('editButton');
        const cancelButton = document.getElementById('cancelButton');
        const userForm = document.getElementById('userForm');
        const formActions = document.querySelector('.form-actions');
        const inputs = userForm.querySelectorAll('input:not([name="noneofvalue"])');

        editButton.addEventListener('click', () => {
            inputs.forEach(input => input.removeAttribute('readonly'));
            formActions.style.display = 'block';
            editButton.style.display = 'none';
        });

        cancelButton.addEventListener('click', () => {
            inputs.forEach(input => input.setAttribute('readonly', true));
            formActions.style.display = 'none';
            editButton.style.display = 'inline-block';
        });
    </script>
</body>
</html>
