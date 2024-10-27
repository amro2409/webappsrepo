<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'company') {
    header('Location: login.php');
    exit();
}

include '../../config/database.php';
$db = new Database();
$conn = $db->connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $applicationId = $_POST['id'];
    $status = $_POST['status'];

    // تحديث حالة الطلب في قاعدة البيانات
    $stmt = $conn->prepare("UPDATE applications SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $applicationId);

    if ($stmt->execute()) {
        echo "Application status updated successfully.";
    } else {
        echo "Error updating application status.";
    }

    $stmt->close();
}

$conn->close();
?>