<!-- <?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'student') {
    echo "Unauthorized access!";
    exit();
}

// هنا يمكنك جلب البيانات من قاعدة البيانات
echo '<h2>طلباتي</h2>';
echo '<ul class="list-group mb-4">';
echo '<li class="list-group-item">طلب 1</li>';
echo '<li class="list-group-item">طلب 2</li>';
echo '</ul>';
?> -->
<?php
session_start();
include '../../../config/database.php'; // Make sure to set the correct database path
$db = new Database();
$conn = $db->connect();

$user_id = $_SESSION['user_id']; // Ensure you have user_id in the session
$applications = [];

// Fetch applications submitted by the student
$stmt = $conn->prepare("
    SELECT a.*, c.company_name, o.opportunity_title 
    FROM applications a 
    JOIN opportunities o ON a.opportunity_id_fk = o.id 
    JOIN companies c ON o.company_name_fk = c.company_name 
    WHERE a.student_id_fk = ?
    ORDER BY c.company_name
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $applications[] = $row;
    }
} else {
    $msg = "No applications submitted.";
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Applications</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>My Applications</h2>
    <hr/>

    <?php if (!empty($msg)): ?>
        <div class="alert alert-danger">
            <?php echo $msg; ?>
        </div>
    <?php endif; ?>

    <?php if (count($applications) > 0): ?>
        <?php
        // Group applications by company
        $grouped_applications = [];
        foreach ($applications as $application) {
            $grouped_applications[$application['company_name']][] = $application;
        }
        ?>

        <?php foreach ($grouped_applications as $company_name => $apps): ?>
            <div class="card mb-3">
                <div class="card-header">
                    <h5><?php echo htmlspecialchars($company_name); ?></h5>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <?php foreach ($apps as $app): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong><?php echo htmlspecialchars($app['opportunity_title']); ?></strong><br>
                                    <small>Submission Date: <?php echo htmlspecialchars($app['submitted_at']); ?></small>
                                </div>
                                <span class="badge <?php echo getStatusClass($app['status']); ?> text-white"><?php echo htmlspecialchars($app['status']); ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No applications submitted.</p>
    <?php endif; ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Function to determine the status class
function getStatusClass($status) {
    switch ($status) {
        case 'accepted':
            return 'badge-success'; // Green color
        case 'rejected':
            return 'badge-danger'; // Red color
        case 'pending':
            return 'badge-warning'; // Orange color
        default:
            return 'badge-secondary'; // Default grey color
    }
}
?>
