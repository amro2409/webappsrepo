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
    
    // استعلام لجلب بيانات الفرصة
    $stmt = $conn->prepare("SELECT * FROM opportunities WHERE id = ? AND company_name_fk = ?");
    $stmt->bind_param("is", $opportunity_id, $_SESSION['company_name']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
    } else {
        echo "Opportunity not found.";
        exit();
    }
} else {
    echo "ID not provided.";
    exit();
}

// معالجة الطلب POST لتحديث الفرصة
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $opportunity_title = $_POST['opportunity_title'];
    $description = $_POST['description'];
    $specialization = $_POST['specialization'];
    $city = $_POST['city'];
    $major = $_POST['major'];
    $location = $_POST['location'];
    $duration = $_POST['duration'];
    $requirements = $_POST['requirements'];
    $students_needed = $_POST['students_needed'];

    // استعلام التحديث
    $stmt = $conn->prepare("UPDATE opportunities SET opportunity_title = ?, description = ?, specialization = ?, city = ?, major = ?, location = ?, duration = ?, requirements = ?, students_needed = ? WHERE id = ?");
    $stmt->bind_param("ssssssisii", $opportunity_title, $description, $specialization, $city, $major, $location, $duration, $requirements, $students_needed, $opportunity_id);

    if ($stmt->execute()) {
        header('Location: dashboard_company.php?message=opportunity_updated');
        exit();
    } else {
        echo "Error updating opportunity: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
<?php include '../header.php'; ?>
<div class="container mt-5">
    <h2>Edit Training Opportunity</h2>
    <hr/>


    <div class="overflow-auto" style="max-height: 600px;">
        <form action="" method="POST">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="opportunity_title" class="font-weight-bold">Opportunity Title</label>
                    <input type="text" class="form-control" id="opportunity_title" name="opportunity_title" value="<?php echo htmlspecialchars($row['opportunity_title']); ?>" required>
                </div>
                <div class="col-md-6">
                    <label for="city" class="font-weight-bold">City</label>
                    <input type="text" class="form-control" id="city" name="city" value="<?php echo htmlspecialchars($row['city']); ?>" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="description" class="font-weight-bold">Opportunity Description</label>
                    <textarea class="form-control" id="description" name="description" required><?php echo htmlspecialchars($row['description']); ?></textarea>
                </div>
                <div class="col-md-6">
                    <label for="major" class="font-weight-bold">Major</label>
                    <input type="text" class="form-control" id="major" name="major" value="<?php echo htmlspecialchars($row['major']); ?>" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="students_needed" class="font-weight-bold">Number of Students Needed</label>
                    <input type="number" class="form-control" id="students_needed" name="students_needed" value="<?php echo htmlspecialchars($row['students_needed']); ?>" required>
                </div>
                <div class="col-md-6">
                    <label for="specialization" class="font-weight-bold">Specialization</label>
                    <input type="text" class="form-control" id="specialization" name="specialization" value="<?php echo htmlspecialchars($row['specialization']); ?>" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="location" class="font-weight-bold">Location</label>
                    <input type="text" class="form-control" id="location" name="location" value="<?php echo htmlspecialchars($row['location']); ?>" required>
                </div>
                <div class="col-md-6">
                    <label for="duration" class="font-weight-bold">Duration</label>
                    <input type="text" class="form-control" id="duration" name="duration" value="<?php echo htmlspecialchars($row['duration']); ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <label for="requirements" class="font-weight-bold">Requirements</label>
                    <textarea class="form-control" id="requirements" name="requirements"><?php echo htmlspecialchars($row['requirements']); ?></textarea>
                </div>
            </div>
            <hr/>
            <div class="d-flex justify-content-end">
                <button type="reset" class="btn btn-secondary me-4" style="margin-right:15px;">Reset</button>
                <button type="submit" class="btn btn-primary">Update Opportunity</button>
            </div>
        </form>
    </div>
</div>

<?php include '../footer.php'; ?>