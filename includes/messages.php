<?php
if (isset($_SESSION['success_message'])) {
    echo '<div class="success-message">' . $_SESSION['success_message'] . '</div>';
    unset($_SESSION['success_message']);
}
if (isset($_SESSION['error_message'])) {
    echo '<div class="error-message">' . $_SESSION['error_message'] . '</div>';
    unset($_SESSION['error_message']);
}
?>
