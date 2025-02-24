<?php
session_start();
require_once 'config.php';

$email = $password = '';
$errors = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email)) {
        $errors[] = "Email is required";
    }
    if (empty($password)) {
        $errors[] = "Password is required";
    }

    if (empty($errors)) {
        // Check for admin login
        if ($email === 'admin@gmail.com' && $password === 'admin') {
            $_SESSION['user_id'] = 'admin';
            $_SESSION['fullname'] = 'Admin';
            $_SESSION['success_message'] = "Welcome back, Admin!";
            header("Location: admin-profile.php");
            exit();
        }

        $sql = "SELECT id, fullname, email, password FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['fullname'] = $user['fullname'];
                $_SESSION['success_message'] = "Welcome back, " . $user['fullname'] . "!";
                header("Location: index.php");
                exit();
            }
             else {
                $errors[] = "Invalid email or password";
            }
        } else {
            $errors[] = "Invalid email or password";
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - JobConnect Sri Lanka</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://kit.fontawesome.com/20f08145b4.js" crossorigin="anonymous"></script>

</head>
<body>
<?php include 'includes/messages.php'; ?>
    <div class="login-container">
        <h1>Login to JobConnect</h1>
        <?php
        if (!empty($errors)) {
            echo '<div class="error-messages">';
            foreach ($errors as $error) {
                echo '<p>' . $error . '</p>';
            }
            echo '</div>';
        }
        ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="form-group">
                <label for="email"><i class="fas fa-envelope"></i> Email</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
            </div>
            <div class="form-group">
                <label for="password"><i class="fas fa-lock"></i> Password</label>
                <div class="password-input">
                    <input type="password" id="password" name="password" required>
                    <i class="fas fa-eye" id="togglePassword"></i>
                </div>
            </div>
            <button type="submit" class="btn-login">Login</button>
        </form>
        <p class="forgot-password"><a href="forgot_password.php">Forgot Password?</a></p>
        <p class="register-link">Don't have an account? <a href="register.php">Register here</a></p>
    </div>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function () {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('fa-eye-slash');
        });
    </script>
</body>
</html>
