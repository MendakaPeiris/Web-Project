<?php
session_start();

$_SESSION = array();

session_destroy();

session_start();
$_SESSION['success_message'] = "You have been successfully logged out.";

header("Location: login.php");
exit();
