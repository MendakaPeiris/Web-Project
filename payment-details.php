<?php
session_start();
require_once 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Function to get payment details from database
function getPaymentDetails($conn, $user_id) {
    $sql = "SELECT * FROM monthly_payments WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Function to delete payment
if (isset($_POST['delete_payment'])) {
    $payment_id = $_POST['payment_id'];
    $sql = "DELETE FROM monthly_payments WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $payment_id, $user_id);
    $stmt->execute();
    header("Location: payment_details.php");
    exit();
}

// Function to update payment
if (isset($_POST['update_payment'])) {
    $payment_id = $_POST['payment_id'];
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $company = $_POST['company'];
    $plan = $_POST['plan'];
    $card_number = $_POST['card_number'];
    $expiry_date = $_POST['expiry_date'];
    $cvv = $_POST['cvv'];

    $sql = "UPDATE monthly_payments SET fullname = ?, email = ?, company = ?, plan = ?, card_number = ?, expiry_date = ?, cvv = ? WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssii", $fullname, $email, $company, $plan, $card_number, $expiry_date, $cvv, $payment_id, $user_id);
    $stmt->execute();
    header("Location: payment_details.php");
    exit();
}

// Get payment details
$payments = getPaymentDetails($conn, $user_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Details</title>
    <link rel="stylesheet" href="css/payment-details.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container">
        <h1>Payment Details</h1>
        <a href="profile.php" class="back-button">Back to Dashboard</a>
        <table>
            <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Company</th>
                    <th>Plan</th>
                    <th>Card Number</th>
                    <th>Expiry Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($payments as $payment): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($payment['fullname']); ?></td>
                        <td><?php echo htmlspecialchars($payment['email']); ?></td>
                        <td><?php echo htmlspecialchars($payment['company']); ?></td>
                        <td><?php echo htmlspecialchars($payment['plan']); ?></td>
                        <td><?php echo str_repeat('*', strlen($payment['card_number']) - 4) . substr($payment['card_number'], -4); ?></td>
                        <td><?php echo htmlspecialchars($payment['expiry_date']); ?></td>
                        <td>
                            <button class="edit-button" data-id="<?php echo $payment['id']; ?>">Edit</button>
                            <form method="post" style="display: inline;">
                                <input type="hidden" name="payment_id" value="<?php echo $payment['id']; ?>">
                                <button type="submit" name="delete_payment" class="delete-button" onclick="return confirm('Are you sure you want to delete this payment?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div id="edit-popup" class="popup">
        <div class="popup-content">
            <h2>Edit Payment Details</h2>
            <form id="edit-payment-form" method="post">
                <input type="hidden" name="payment_id" id="payment_id">
                <label for="fullname">Full Name:</label>
                <input type="text" name="fullname" id="fullname" required>
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required>
                <label for="company">Company:</label>
                <input type="text" name="company" id="company" required>
                <label for="plan">Plan:</label>
                <input type="text" name="plan" id="plan" required>
                <label for="card_number">Card Number:</label>
                <input type="text" name="card_number" id="card_number" required>
                <label for="expiry_date">Expiry Date:</label>
                <input type="text" name="expiry_date" id="expiry_date" required>
                <label for="cvv">CVV:</label>
                <input type="text" name="cvv" id="cvv" required>
                <div class="button-group">
                    <button type="submit" name="update_payment">Save</button>
                    <button type="button" id="cancel-edit">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.edit-button').click(function() {
                var paymentId = $(this).data('id');
                var row = $(this).closest('tr');
                var fullname = row.find('td:eq(0)').text();
                var email = row.find('td:eq(1)').text();
                var company = row.find('td:eq(2)').text();
                var plan = row.find('td:eq(3)').text();
                var cardNumber = row.find('td:eq(4)').text();
                var expiryDate = row.find('td:eq(5)').text();

                $('#payment_id').val(paymentId);
                $('#fullname').val(fullname);
                $('#email').val(email);
                $('#company').val(company);
                $('#plan').val(plan);
                $('#card_number').val(cardNumber);
                $('#expiry_date').val(expiryDate);
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
