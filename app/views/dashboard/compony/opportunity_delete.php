<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'company') {
    header('Location: login.php');
    exit();
}

include '../../config/database.php';
$db = new Database();
$conn = $db->connect();

// تحقق من وجود معرف الفرصة في رابط URL
if (isset($_GET['id'])) {
    $opportunity_id = $_GET['id'];

    // استعلام لحذف الفرصة
    $stmt = $conn->prepare("DELETE FROM opportunities WHERE id = ? AND company_name_fk = ?");
    $stmt->bind_param("is", $opportunity_id, $_SESSION['company_name']);

    if ($stmt->execute()) {
        header('Location: dashboard_company.php?message=opportunity_deleted');
    } else {
        echo "Error deleting opportunity: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "ID not provided.";
}

$conn->close();
?>