<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['job_id'])) {
    exit('Unauthorized access');
}

$user_id = $_SESSION['user_id'];
$job_id = $_GET['job_id'];

$sql = "SELECT * FROM jobs WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $job_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$job = $result->fetch_assoc();

echo json_encode($job);
