<?php
session_start();
require_once 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Function to get contact messages from database
function getContactMessages($conn, $user_id) {
    $sql = "SELECT * FROM contact_messages WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Function to delete contact message
if (isset($_POST['delete_message'])) {
    $message_id = $_POST['message_id'];
    $sql = "DELETE FROM contact_messages WHERE id = ?  AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $message_id,$user_id);
    $stmt->execute();
    header("Location: contact_messages.php");
    exit();
}

// Function to update contact message
if (isset($_POST['update_message'])) {
    $message_id = $_POST['message_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    $sql = "UPDATE contact_messages SET name = ?, email = ?, subject = ?, message = ? WHERE id = ?  AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssii", $name, $email, $subject, $message, $message_id,$user_id);
    $stmt->execute();
    header("Location: contact_messages.php");
    exit();
}

// Get contact messages
$messages = getContactMessages($conn, $user_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Messages</title>
    <link rel="stylesheet" href="css/contact_messages.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container">
        <h1>Contact Messages</h1>
        <div class="timeout">
            <h4>! Note: You can't change your subbmision after 1 hour.</h4>
        </div>
        <a href="profile.php" class="back-button">Back to Dashboard</a>
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
                <?php foreach ($messages as $message): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($message['name']); ?></td>
                        <td><?php echo htmlspecialchars($message['email']); ?></td>
                        <td><?php echo htmlspecialchars($message['subject']); ?></td>
                        <td><?php echo htmlspecialchars(substr($message['message'], 0, 50)) . '...'; ?></td>
                        <td>
                            <button class="edit-button" data-id="<?php echo $message['id']; ?>">Edit</button>
                            <form method="post" style="display: inline;">
                                <input type="hidden" name="message_id" value="<?php echo $message['id']; ?>">
                                <button type="submit" name="delete_message" class="delete-button" onclick="return confirm('Are you sure you want to delete this message?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div id="edit-popup" class="popup">
        <div class="popup-content">
            <h2>Edit Contact Message</h2>
            <form id="edit-message-form" method="post">
                <input type="hidden" name="message_id" id="message_id">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" required>
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required>
                <label for="subject">Subject:</label>
                <input type="text" name="subject" id="subject" required>
                <label for="message">Message:</label>
                <textarea name="message" id="message" required></textarea>
                <div class="button-group">
                    <button type="submit" name="update_message">Save</button>
                    <button type="button" id="cancel-edit">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.edit-button').click(function() {
                var messageId = $(this).data('id');
                var row = $(this).closest('tr');
                var name = row.find('td:eq(0)').text();
                var email = row.find('td:eq(1)').text();
                var subject = row.find('td:eq(2)').text();
                var message = row.find('td:eq(3)').text();

                $('#message_id').val(messageId);
                $('#name').val(name);
                $('#email').val(email);
                $('#subject').val(subject);
                $('#message').val(message);
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
