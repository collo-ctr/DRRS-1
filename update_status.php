<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $report_id  = intval($_POST['report_id']);
    $new_status = $conn->real_escape_string($_POST['new_status']);

    $allowed = ['Pending', 'Acknowledged', 'In Progress', 'Resolved'];
    if (!in_array($new_status, $allowed)) {
        header("Location: dashboard.php");
        exit();
    }

    $stmt = $conn->prepare("UPDATE emergency_reports SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $new_status, $report_id);
    $stmt->execute();
}

header("Location: dashboard.php");
exit();
?>