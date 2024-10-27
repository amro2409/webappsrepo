<!-- /views/opportunities/details.php -->
<?php
include '../head.php';
include '../../config/database.php'; 

// الاتصال بقاعدة البيانات
$db = new Database();
$conn = $db->connect();

// التحقق من وجود معرف الفرصة في الرابط
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // إعداد استعلام لجلب تفاصيل الفرصة
    $stmt = $conn->prepare("SELECT * FROM opportunities WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // التحقق من وجود بيانات
    if ($result->num_rows > 0) {
        $opportunity = $result->fetch_assoc();
    } else {
        echo "<p>Opportunity not found.</p>";
        exit();
    }
} else {
    echo "<p>Invalid request.</p>";
    exit();
}

// تحقق مما إذا كان الطالب قد قدم طلبًا سابقًا
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'student') {
    header('Location: http://alkadev.lovestoblog.com/app/views/auth/login.php');
    exit();
}

$student_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM applications WHERE opportunity_id_fk = ? AND student_id_fk = ?");
$stmt->bind_param("ii", $id, $student_id);
$stmt->execute();
$appResult = $stmt->get_result();

// إذا تم العثور على طلب سابق
$isApplied = $appResult->num_rows > 0;

$stmt->close();
$conn->close();
?>

<div class="container mt-5" style="margin-bottom:40px;">
  <div class="card">
    <div class="card-body">
      <div class="row mb-2">
        <div class="col-md-6">
          <strong>Title:</strong>
        </div>
        <div class="col-md-6">
          <?php echo htmlspecialchars($opportunity['opportunity_title']); ?>
        </div>
      </div>
      <div class="row mb-2">
        <div class="col-md-6">
          <strong>Company:</strong>
        </div>
        <div class="col-md-6">
          <?php echo htmlspecialchars($opportunity['company_name_fk']); ?>
        </div>
      </div>
      <div class="row mb-2">
        <div class="col-md-6">
          <strong>Location:</strong>
        </div>
        <div class="col-md-6">
          <?php echo htmlspecialchars($opportunity['location']); ?>
        </div>
      </div>
      <div class="row mb-2">
        <div class="col-md-6">
          <strong>Duration:</strong>
        </div>
        <div class="col-md-6">
          <?php echo htmlspecialchars($opportunity['duration']); ?>
        </div>
      </div>
      <div class="row mb-2">
        <div class="col-md-6">
          <strong>Requirements:</strong>
        </div>
        <div class="col-md-6">
          <?php echo htmlspecialchars($opportunity['requirements']); ?>
        </div>
      </div>
      <div class="row mb-2">
        <div class="col-md-6">
          <strong>Number of Positions:</strong>
        </div>
        <div class="col-md-6">
          <?php echo htmlspecialchars($opportunity['students_needed']); ?>
        </div>
      </div>
      <div class="row mb-2">
        <div class="col-md-6">
          <strong>Description:</strong>
        </div>
        <div class="col-md-6">
          <?php echo htmlspecialchars($opportunity['description']); ?>
        </div>
      </div>
    </div>
    <div class="card-footer text-center">
                    <?php if ($isApplied): ?>
                        <button class="btn btn-secondary" disabled>Already Applied</button>
                    <?php else: ?>
                        <a href="apply.php?id=<?php echo $opportunity['id']; ?>" class="btn btn-primary">Apply Now</a>
                    <?php endif; ?>    </div>
  </div>
</div>

<?php include '../footer.php'; ?>
