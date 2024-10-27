<?php
session_start();

// تأكد من أن الطالب مسجل الدخول
if (!isset($_SESSION['user_id'])) {
    echo "Access denied.";
    exit();
}

include '../../../config/database.php';
$db = new Database();
$conn = $db->connect();

// جلب بيانات الطالب من قاعدة البيانات
$stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $student = $result->fetch_assoc();
} else {
    echo "Student not found.";
    exit();
}

$stmt->close();
$conn->close();
?>

<div class="container mt-5">
    <h2>Student Details</h2>
    <hr/>

    <!-- Student Information -->
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Student Information</span>
            <a href="student/edit_profile.php" class="btn btn-info btn-sm"> <i class="fas fa-edit"></i>&nbsp;   Edit</a>
        </div>
        <div class="card-body">
            <h5 class="card-title"><?php echo htmlspecialchars($student['name']); ?></h5>
            <p><i class="material-icons prefix">email</i>&nbsp;<strong>Email:</strong> <?php echo htmlspecialchars($student['email']); ?></p>
            <p><i class="material-icons prefix">phone</i>&nbsp;<strong>Phone Number:</strong> <?php echo htmlspecialchars($student['phone_number']); ?></p>
            <p><i class="material-icons prefix">event</i>&nbsp;<strong>Date of Birth:</strong> <?php echo htmlspecialchars($student['birthdate']); ?></p>
            <p><i class="material-icons prefix">school</i>&nbsp;<strong>Specialization:</strong> <?php echo htmlspecialchars($student['specialization']); ?></p>
            <p><i class="material-icons prefix">location_city</i>&nbsp;<strong>City:</strong> <?php echo htmlspecialchars($student['city']); ?></p>
            <p><i class="material-icons prefix">note</i>&nbsp;<strong>Notes:</strong> <?php echo htmlspecialchars($student['note']); ?></p>
        </div>
    </div>

    <!-- Contact Information -->
    <div class="card">
        <div class="card-header">
            Contact Information
        </div>
        <div class="card-body">
            <p><i class="material-icons prefix">home</i>&nbsp;<strong>Address:</strong> <?php echo htmlspecialchars($student['address']); ?></p>
            <p><i class="material-icons prefix">phone</i>&nbsp;<strong>Phone Number:</strong> <?php echo htmlspecialchars($student['phone_number']); ?></p>
            <p><i class="material-icons prefix">email</i>&nbsp;<strong>Email:</strong> <?php echo htmlspecialchars($student['email']); ?></p>
        </div>
    </div>
</div>