<!-- /views/dashboard/add_opportunity.php -->
<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'company') {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include '../../config/database.php';
    $db = new Database();
    $conn = $db->connect();

    $opportunity_title = $_POST['opportunity_title'];
    $description = $_POST['description'];
    $specialization = $_POST['specialization'];
    $city = $_POST['city'];
    $major = $_POST['major'];
    $location = $_POST['location'];
    $duration = $_POST['duration'];
    $requirements = $_POST['requirements'];
    $students_needed = $_POST['students_needed'];
    $company_name = $_SESSION['company_name'];

    $stmt = $conn->prepare("INSERT INTO opportunities (opportunity_title, description, specialization, city, major, location, duration, requirements, students_needed, company_name_fk) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssis", $opportunity_title, $description, $specialization, $city, $major, $location, $duration, $requirements, $students_needed, $company_name);

   if ($stmt->execute()) {
        // إعادة توجيه مع رسالة النجاح
        header('Location: dashboard_company.php?message=opportunity_added');
        exit();
    } else {
        echo "Error adding opportunity: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>


<div class="container mt-5">
    <h2>Add New Training Opportunity</h2>
        <!-- عرض رسالة النجاح إذا كانت موجودة -->
    <?php if (isset($_GET['message']) && $_GET['message'] === 'opportunity_added'): ?>
        <div class="alert alert-success" role="alert">
            Opportunity added successfully!
        </div>
    <?php endif; ?>
    <hr/>
    <div class="overflow-auto" style="max-height: 600px;"> <!-- حاوية قابلة للتمرير -->
        <form action="add_opportunity.php" method="POST">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="opportunity_title" class="font-weight-bold">Opportunity Title</label>
                    <input type="text" class="form-control" id="opportunity_title" name="opportunity_title" placeholder="Opportunity Title" required>
                </div>
                <div class="col-md-6">
                    <label for="city" class="font-weight-bold">City</label>
                    <input type="text" class="form-control" id="city" name="city" placeholder="City" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="description" class="font-weight-bold">Opportunity Description</label>
                    <textarea class="form-control" id="description" name="description" placeholder="Opportunity Description" required></textarea>
                </div>
                <div class="col-md-6">
                    <label for="major" class="font-weight-bold">Major</label>
                    <input type="text" class="form-control" id="major" name="major" placeholder="Major" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="students_needed" class="font-weight-bold">Number of Students Needed</label>
                    <input type="number" class="form-control" id="students_needed" name="students_needed" placeholder="Number of Students Needed" required>
                </div>
                <div class="col-md-6">
                    <label for="specialization" class="font-weight-bold">Specialization</label>
                    <input type="text" class="form-control" id="specialization" name="specialization" placeholder="Specialization" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="location" class="font-weight-bold">Location</label>
                    <input type="text" class="form-control" id="location" name="location" placeholder="Location" required>
                </div>
                <div class="col-md-6">
                    <label for="duration" class="font-weight-bold">Duration</label>
                    <input type="text" class="form-control" id="duration" name="duration" placeholder="Duration">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <label for="requirements" class="font-weight-bold">Requirements</label>
                    <textarea class="form-control" id="requirements" name="requirements" placeholder="Requirements"></textarea>
                </div>
            </div>
             <hr/>
            <div class="d-flex justify-content-end">
                <button type="reset" class="btn btn-secondary me-4" style="margin-right:15px;">Reset</button>
                <button type="submit" class="btn btn-primary">Add Opportunity</button>
            </div>
        </form>
    </div>
</div>