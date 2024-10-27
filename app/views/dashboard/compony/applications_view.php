<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'company') {
    header('Location: http://alkadev.lovestoblog.com/app/views/auth/login.php');
    exit();
}

include '../../../config/database.php';
$db = new Database();
$conn = $db->connect();

$company_name = $_SESSION['company_name'];

$filter_specialization = isset($_POST['specialization']) ? $_POST['specialization'] : '';
$filter_city = isset($_POST['city']) ? $_POST['city'] : '';

// استعلام SQL مع شروط الفلترة
$sql = "
    SELECT applications.*, opportunities.opportunity_title 
    FROM applications 
    JOIN opportunities ON applications.opportunity_id_fk = opportunities.id 
    WHERE opportunities.company_name_fk = ?";

if ($filter_specialization) {
    $sql .= " AND opportunities.specialization = ?";
}
if ($filter_city) {
    $sql .= " AND applications.city = ?";
}

$stmt = $conn->prepare($sql);

// ربط المعلمات بناءً على ما إذا كانت الفلترة مستخدمة
$params = [$company_name];
if ($filter_specialization) {
    $params[] = $filter_specialization;
}
if ($filter_city) {
    $params[] = $filter_city;
}

// إعداد الربط الديناميكي
$stmt->bind_param(str_repeat('s', count($params)), ...$params);
$stmt->execute();
$applications = $stmt->get_result();
?>

<div class="container mt-5">
    <h2>Student Applications</h2>

    <!-- نموذج الفلترة -->
<form  method="POST"  onsubmit="event.preventDefault(); filterApplications();" class="mb-4">
    <div class="row">
        <div class="col-md-4">
            <input type="text" id="specialization" name="specialization" class="form-control" placeholder="Filter by Specialization" value="<?php echo htmlspecialchars($filter_specialization); ?>">
        </div>
        <div class="col-md-4">
            <input type="text"  id="city" name="city" class="form-control" placeholder="Filter by City" value="<?php echo htmlspecialchars($filter_city); ?>">
        </div>
        <div class="col-md-4">
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
    </div>
</form>

<div id="applicationsList">
    <?php if ($applications->num_rows > 0): ?>
        <ul class="list-group">
            <?php while ($application = $applications->fetch_assoc()): ?>
                <li class="list-group-item" id="application-<?php echo $application['id']; ?>">
                    <h5>Opportunity: <?php echo htmlspecialchars($application['opportunity_title']); ?></h5>
                    <p><strong>Full Name:</strong> <?php echo htmlspecialchars($application['full_name']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($application['email']); ?></p>
                    <p><strong>City:</strong> <?php echo htmlspecialchars($application['city']); ?></p>
                    <p><strong>Cover Letter:</strong> <?php echo htmlspecialchars($application['cover_letter']); ?></p>
                    <p><strong>Resume:</strong> <a href="../../uploads/resumes/<?php echo htmlspecialchars($application['resume']); ?>" download>Download Resume</a></p>
                    <p><strong>Submitted At:</strong> <?php echo htmlspecialchars($application['submitted_at']); ?></p>

                   <p><strong>Status:</strong> <span class="status <?php echo strtolower($application['status']); ?>"><?php echo htmlspecialchars($application['status']); ?></span></p>
                <!-- أزرار قبول ورفض -->
                <button onclick="updateApplicationStatus(<?php echo $application['id']; ?>, 'accepted')" class="btn btn-success btn-sm">Accept</button>
                <button onclick="updateApplicationStatus(<?php echo $application['id']; ?>, 'rejected')" class="btn btn-danger btn-sm">Reject</button>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>No applications found.</p>
    <?php endif; ?>
</div>

<script>
// function updateApplicationStatus(applicationId, status) {
//     fetch('update_application.php', {
//         method: 'POST',
//         headers: {
//             'Content-Type': 'application/x-www-form-urlencoded'
//         },
//         body: new URLSearchParams({
//             id: applicationId,
//             status: status
//         })
//     })
//     .then(response => response.text())
//     .then(data => {
//         alert(data); // يمكنك استبداله بتحديثات واجهة المستخدم إذا أردت
//         loadContent('view_applications.php'); // لإعادة تحميل المحتوى
//     })
//     .catch(error => console.error('Error:', error));
// }
</script>
